<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">

	          	<div class="row">
					<div class="col-md-4 col-sm-12 grid-margin stretch-card">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnnouncement">
						Tambah Jawaban
						</button>
						&nbsp;
						<a href="/questions" class="btn btn-warning"><i class="ti ti-arrow-left"></i> Kembali</a>
					</div>
				</div>

				<!-- TABLE -->

				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<p class="alert alert-success" v-if="deleteStatus">Hapus Jawaban Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Deskripsi</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(answer,index) in answers" :key="answer.id">
											<td>{{index+1}}</td>
											<td>
												{{answer.title}}
												<br><span class="badge badge-success" v-if="key_answer==answer.id">Jawaban Benar</span>
											</td>
											<td>
												<a href="javascript:void(0)" v-if="key_answer!=answer.id" class="badge badge-success" @click="setCorrectAnswer(answer.id)">Jadikan Jawaban Benar</a>
												<a href="javascript:void(0)" data-toggle="modal" data-target="#editSoal" class="badge badge-primary" @click="findAnswer(answer.id)">Edit</a>
												<a href="javascript:void(0)" @click="deleteAnswer(answer.id)" class="badge badge-danger">Hapus</a>
											</td>
										</tr>
										<tr  v-if="!answers.length" >
											<td colspan="5">Tidak ada data</td>
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

				<div class="modal fade" id="addAnnouncement">
					<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Tambah Jawaban</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Tambah Jawaban Berhasil</p>
								<div class="form-group">
									<label>Deskripsi</label>
									<textarea class="form-control" v-model="data.title"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="addAnswer()">Tambah Jawaban</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="editSoal">
					<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Edit Jawaban</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Edit Jawaban Berhasil</p>
								<div class="form-group">
									<label>Deskripsi</label>
									<textarea class="form-control" v-model="data.title"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Close</button>
								<button type="button" class="btn btn-primary" @click="updateAnswer()">Update Jawaban</button>
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
		question_id:0,
		key_answer_id:0,
	},
	data(){
        return{
        	key_answer:0,
            answers:{},
            data:{},
            token:'',
            headers:'',
            status:false,
			deleteStatus:false,
			employees:{},
			user_id:0,
			other_id:0,
			answer_id:0,
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
        this.key_answer = this.key_answer_id
        await this.fetchUserId()
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
        async loadAnswers(){
            var vm = this
            let response = await fetch('/api/answer/'+vm.question_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.answers = await data

            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        findAnswer(id){
            fetch('/api/answer/get/'+id,{
                headers:this.headers,
            })
            .then(res => res.json()) 
            .then(res=>{
                this.data = res
            })
        },
        addAnswer(){
        	this.data.question_id = this.question_id
        	console.log(this.data)
            fetch('/api/answer/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadAnswers()
            })
        },
        resetForm(){
        	this.data = {}
        },
        setCorrectAnswer(answer_id){
            fetch('/api/question/set-correct-answer',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify({key_answer_id:answer_id,id:this.question_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.key_answer = answer_id
                this.loadAnswers()
            })
        },
        updateAnswer(){
        	this.data.question_id = this.question_id
            fetch('/api/answer/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadAnswers()
            })
        },
        deleteAnswer(answer_id){
        	var vm = this
        	Swal.fire({
			  title: 'Apakah anda yakin akan menghapus data ini?',
			  text: "Tindakan ini tidak dapat dikembalikan!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  cancelButtonText: 'Tidak',
			  confirmButtonText: 'Ya, Hapus data ini!'
			}).then((result) => {
			  if (result.value) {
			  	fetch('/api/answer/delete',{
	                method:'delete',
	                headers:vm.headers,
	                body:JSON.stringify({id:answer_id,question_id:vm.question_id})
	            })
	            .then(res=>res.json())
	            .then(res=>{
	                vm.deleteStatus = true
	                vm.loadAnswers()
	                Swal.fire(
				      'Terhapus!',
				      'Data berhasil dihapus.',
				      'success'
				    )
	            })
			  }
			})
		},
    }
}
</script>