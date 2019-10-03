<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">
				
				<a href="/exams" class="btn btn-warning"><i class="ti ti-arrow-left"></i> Kembali</a>
				<p></p>
				<!-- TABLE -->
				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<h3>{{exam.name}}</h3>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Siswa</th>
											<th>Total Nilai</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(student,index) in exam.students" :key="student.student_id">
											<td>{{index+1}}</td>
											<td>
												{{student.data ? student.data.name : student.student_id}}
											</td>
											<td>{{student.totalScore}}</td>
											<td>
												<a href="javascript:void(0)" class="badge badge-success" @click="loadAnswers(student.student_id,student.data.name)" data-toggle="modal" data-target="#assesmentModal">Periksa</a>
											</td>
										</tr>
										<tr  v-if="!exam.students || !exam.students.length" >
											<td colspan="3">Tidak ada data</td>
										</tr>
									</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- /TABLE -->

				<!-- ADD MODAL -->

				<div class="modal fade" id="assesmentModal">
					<div class="modal-dialog modal-lg" >
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">{{assesment_title}}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th width="10%">#</th>
												<th width="50%">Soal</th>
												<th>Nilai</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(answer,index) in answers" :key="answer.id">
												<td>{{index+1}}</td>
												<td>
													{{answer.question.title}}
													<br><br>
													<b>Jawaban :</b>
													<p>{{answer.question.question_type == 'Essay' ? answer.question_answer_text : answer.answer.title}}</p>
												</td>
												<td>
													<div v-if="answer.score == null && answer.question.question_type == 'Essay'" class="form-group">
														<select class="form-control" v-model="answer_scores[answer.id]">
															<option v-for="val in [0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0]" :value="val">{{val}}</option>
														</select>
													</div>
													<div v-else>
														{{answer.score ? answer.score : 0}}
													</div>
												</td>
											</tr>
											<tr  v-if="!exam.students || !exam.students.length" >
												<td colspan="3">Tidak ada data</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button class="btn btn-success" @click="saveScores()">Simpan Nilai</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /ADD MODAL -->

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
            item_ids:{},
            total_scores:{},
            answer_scores:{},
            exam:{},
            student_id:0,
            student_name:0,
            questions:{},
            answers:{},
            data:{},
            token:'',
            headers:'',
            assesment_title:'',
            status:false,
			deleteStatus:false,
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
        if(this.token === undefined || this.token === null || this.token === '' ){
            window.location = window.config.MIX_ES_URL+'/login'
        }
        await this.fetchUserId()
        await this.loadStudents()
        await this.loadExam()
        await this.loadItems()
        // await this.loadQuestions()
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
        async loadExam(){
            var vm = this
            let response = await fetch('/api/exam/get/'+vm.exam_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.students.forEach(async val => {
	        	var student = this.students.find(o => o.id == val.student_id)
	        	val.data = student
	        })
	        this.exam = await data
	        console.log(this.exam)
	        return data
        },
        async loadStudents(){
            var vm = this
            let response = await fetch(window.config.MIX_IS_URL+'/api/student',{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.students = await data
	        return data
        },
        async loadItems(){
            var vm = this
            let response = await fetch('/api/exam_item/'+vm.exam_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach((val,index) => {
	        	this.item_ids[index] = val.id
	        })
	        this.items = await data
	        return data
        },
        async loadAnswers(student_id,student_name){
        	this.student_id = student_id
        	this.student_name = student_name
        	this.assesment_title = "Periksa Jawaban "+student_name
        	var vm = this
            let response = await fetch('/api/exam/get-student-answer',{
            	method:'post',
	            headers:vm.headers,
	            body:JSON.stringify({item_ids:this.item_ids,student_id:student_id})
	        })
	        let data = await response.json()
	        this.answers = await data
	        return data
        },
        saveScores(){
        	var vm = this
        	Swal.fire({
			  title: 'Apakah anda yakin menyimpan nilai ini?',
			  text: "Tindakan ini tidak dapat dikembalikan!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  cancelButtonText: 'Tidak',
			  confirmButtonText: 'Ya, Simpan nilai ini!'
			}).then((result) => {
			  if (result.value) {
			  	fetch('/api/exam/set-student-score',{
	            	method:'post',
		            headers:vm.headers,
		            body:JSON.stringify({answer_scores:vm.answer_scores})
		        })
		        vm.loadAnswers(vm.student_id,vm.student_name)
	        	vm.student_id = 0
	        	vm.student_name = ''
	        	vm.answer_scores = {}
	        	Swal.fire(
				    'Tersimpan!',
				    'Data berhasil dihapus.',
				    'success'
				)
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