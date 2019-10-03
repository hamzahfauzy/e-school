<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">
			<!-- CONTENT -->
	        <div class="content-wrapper">
				<!-- TABLE -->
				<div class="row">
					<div class="col-sm-12 col-md-8 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<h2>{{question.question ? question.question.title : ''}}</h2>
								<p>{{question.question ? question.question.description : ''}}</p>
								<div class="">
									<div class="row">
										<div class="col-sm-12 col-md-6" v-if="question.question && question.question.question_type == 'Pilihan Berganda'" v-for="(ans,i) in answer">
											<div class="inputGroup">
											    <input :id="'radio'+i" name="radio" type="radio" :value="ans.id" :disabled="exam_status == 1" v-model="answers[index]"/>
											    <label :for="'radio'+i">{{ans.title}}</label>
											</div>
										</div>
										<div class="col-sm-12" v-if="question.question && question.question.question_type=='Essay'">
											<textarea placeholder="Jawab disini" class="form-control" rows="10" cols="7" v-model="answers[index]" :readonly="exam_status == 1"></textarea>
											<p></p>
										</div>
									</div>
								</div>
                <div class="d-flex justify-content-between align-items-center">
                  <div>
  								  <button class="btn btn-primary" v-if="index > 0" @click="prev()"><i class="ti ti-arrow-left"></i> Soal Sebelumnya</button>
                  </div>
                  <div>
    								<button class="btn btn-success" v-if="index < items.length-1 && exam_status == 0" @click="next()"><i class="ti ti-arrow-right"></i> Jawab</button>
    								<button class="btn btn-primary" v-if="index < items.length-1 && exam_status == 1" @click="next()"><i class="ti ti-arrow-right"></i> Soal Berikutnya</button>
    								<button class="btn btn-warning" v-if="index == items.length-1 && exam_status == 0" @click="finish()">Selesai</button>
                  </div>
                </div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<h4>Navigasi Soal</h4>
                  <div class="navigasi-grid-container">
                    <div class="navigasi-grid" v-for="(item,idx) in items">
                      <center>
                        <a href="javascript:void(0)" @click="jumpQuestion(idx)" class="btn-me" :class="idx == index ? 'active' : (isAnswered(idx) ? 'answered' : '')">
                          {{idx+1}}
                        </a>
                      </center>
                    </div>
                  </div>
							</div>
						</div>
					</div>
				</div>
				<!-- /TABLE -->
	        </div>

				<!-- /CONTENT -->
	        
			<footer-component></footer-component>
	    </div>
	</div>
</template>
<script>
export default {
    props:{
  		role_id:0,
  		exam_id:0,
  		study_id:0,
  	},
  	data(){
      return{
        items:{},
        exam:{},
        exam_status:0,
        answers:{},
        answered:{},
        answer:{},
        questions:{},
        data:{},
        index:0,
        question:{},
        token:'',
        headers:'',
  			employees:{},
  			user_id:0,
  			other_id:0,
  			item_id:0,
  			employee:{},
  			eS:false
      }
    },
    async created(){
        this.token = window.getCookie('eschool_token_app')
        this.headers = {
            'Authorization': 'Bearer '+this.token,
            'Content-Type':'application/json'
        }
        if(this.token === undefined || this.token === null || this.token === ''){
            window.location = window.config.MIX_ES_URL+'/login'
        }
        await this.fetchUserId()
        await this.loadItems()
        await this.loadAnswers()
    },
    methods:{
		    // ANNOUNCEMENT
		    async fetchUserId(){
            let response = await fetch(window.config.MIX_ES_URL+'/api/details',{
                method:'post',
                headers:this.headers
            });
            let data = await response.json()
            this.user_id = data.id
            this.other_id = data.other_id
            return data;
        },
        async loadItems(){
            var vm = this
            let response = await fetch('/api/exam_item/'+vm.exam_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.items = await data
	        this.exam = this.items ? this.items[0].exam : {}
	        this.question = this.items[this.index]
	        this.loadExamStatus()
            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        async loadQuestions(){
        	var vm = this
            let response = await fetch('/api/question/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.questions = await data
	        this.loadAnswer()
	        return data
        },
        async prev(){
        	var item = this.items[this.index]
        	this.answered[this.index] = {exam_item_id:item.id,student_id:this.other_id,question_type:item.question.question_type,answer:this.answers[this.index] ? this.answers[this.index] : ''}
          if(!this.exam_status)
        	 await this.sendAnswers()
        	this.index--
        	this.question = this.items[this.index]
        	this.loadAnswer()
        },
        async next(){
        	var item = this.items[this.index]
        	this.answered[this.index] = {exam_item_id:item.id,student_id:this.other_id,question_type:item.question.question_type,answer:this.answers[this.index] ? this.answers[this.index] : ''}
          if(!this.exam_status)
        	 await this.sendAnswers()
        	this.index++
        	this.question = this.items[this.index]
        	this.loadAnswer()
        },
        async jumpQuestion(index){
          this.question = this.items[index]
          this.index = index
          this.loadAnswer()
        },
        isAnswered(index){
          return this.answers[index]
        },
        async sendAnswers(){
        	var vm = this
            let response = await fetch('/api/exam_item/answer',{
	            method:'post',
                headers:this.headers,
                body:JSON.stringify(this.answered)
	        })
	        let data = await response.json()
	        await this.loadAnswers()
	        return data
        },
        async loadAnswer(){
        	var vm = this
            let response = await fetch('/api/answer/'+vm.question.question.id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.answer = data
	        return data
        },
        async loadAnswers(){
        	var vm = this
            let response = await fetch('/api/exam/get/'+vm.exam.id+'/answers/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.answers = data
	        return data
        },
        async loadExamStatus(){
        	var vm = this
            let response = await fetch('/api/exam/get-status/'+vm.exam.id+'/answers/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.exam_status = data.status ? data.status : 0
	        return data
        },
        async finish(){
        	var item = this.items[this.index]
        	this.answered[this.index] = {exam_item_id:item.id,student_id:this.other_id,question_type:item.question.question_type,answer:this.answers[this.index] ? this.answers[this.index] : ''}
        	await this.sendAnswers()
          var vm = this
          Swal.fire({
            title: 'Apakah anda yakin menyelesaikan kuis ini?',
            text: "Tindakan ini tidak dapat dikembalikan!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya'
          }).then(async result => {
            if (result.value) {
              var data = {exam_id:vm.exam_id,student_id:vm.other_id}
              fetch('/api/exam/finish',{
                  method:'post',
                  headers:vm.headers,
                  body:JSON.stringify(data)
              })
              .then(res=>res.json())
              .then(res=>{
                  vm.loadItems()
                  Swal.fire(
                    'Selesai!',
                    'Anda telah menyelesaikan kuis ini.',
                    'success'
                  )
              })
            }
          })
        	
        },
        findAnswer(id){
            fetch('/api/exam_item/get/'+id,{
                headers:this.headers,
            })
            .then(res => res.json()) 
            .then(res=>{
                this.data = res
            })
        }
    }
}
</script>

<style type="text/css">
.navigasi-grid-container {
  width: 100%;
}
.navigasi-grid {
  width: 33%;
  float: left;
}
a.btn-me {
  width: 100%;
  height: 100%;
  border:1px solid #eaeaea;
  text-decoration:none;
  padding: 10px;
  display: inline-block;
}
.btn-me.active {
  background-color: red;
}
.btn-me.answered {
  background-color: #5562eb;
}
.btn-me.active, .btn-me.answered {
  color: #FFF;
}
/*.btn-me {
  background-color: transparent;
  border:0px;
  padding: 10px;
  display: inline-block;
  text-decoration: none;
}*/
.inputGroup {
  background-color: #fff;
  display: block;
  margin: 10px 0;
  position: relative;
}
.inputGroup label {
  padding: 12px 30px;
  width: 100%;
  display: block;
  text-align: left;
  color: #3C454C;
  cursor: pointer;
  position: relative;
  z-index: 2;
  transition: color 200ms ease-in;
  overflow: hidden;
}
.inputGroup label:before {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  content: '';
  background-color: #5562eb;
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%) scale3d(1, 1, 1);
          transform: translate(-50%, -50%) scale3d(1, 1, 1);
  transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
  opacity: 0;
  z-index: -1;
}
.inputGroup label:after {
  width: 32px;
  height: 32px;
  content: '';
  border: 2px solid #D1D7DC;
  background-color: #fff;
  background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
  background-repeat: no-repeat;
  background-position: 2px 3px;
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  cursor: pointer;
  transition: all 200ms ease-in;
}
.inputGroup input:checked ~ label {
  color: #fff;
}
.inputGroup input:checked ~ label:before {
  -webkit-transform: translate(-50%, -50%) scale3d(56, 56, 1);
          transform: translate(-50%, -50%) scale3d(56, 56, 1);
  opacity: 1;
  width: 100%;
}
.inputGroup input:checked ~ label:after {
  background-color: #54E0C7;
  border-color: #54E0C7;
}
.inputGroup input {
  width: 32px;
  height: 32px;
  order: 1;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  cursor: pointer;
  visibility: hidden;
}
</style>