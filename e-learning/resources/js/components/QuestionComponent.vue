<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">

	          	<div class="row">
					<div class="col-md-4 col-sm-12 grid-margin stretch-card">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnnouncement">
						Tambah Soal
						</button>
					</div>
				</div>

				<!-- TABLE -->

				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<p class="alert alert-success" v-if="deleteStatus">Hapus Soal Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Mata Pelajaran</th>
											<th>Judul</th>
											<th>Jenis Soal</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(question,index) in questions" :key="question.id">
											<td>{{index+1}}</td>
											<td>{{question.study ? question.study.name : question.study_id}}</td>
											<td>{{question.title}}</td>
											<td>{{question.question_type}}</td>
											<td>
												<a :href="'/questions/'+question.id" v-if="question.question_type=='Pilihan Berganda'" class="badge badge-success">Jawaban</a>
												<a href="javascript:void(0)"  data-toggle="modal" data-target="#editSoal" class="badge badge-primary" @click="findQuestion(question.id)">Edit</a>
												<a href="javascript:void(0)" @click="deleteQuestion(question.id)" class="badge badge-danger">Hapus</a>
											</td>
										</tr>
										<tr  v-if="!questions.length" >
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
								<h5 class="modal-title">Tambah Soal</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Tambah Soal Berhasil</p>
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select v-model="data.study_id" class="form-control">
										<option v-for="study in employee.studies" :key="study.id" :value="study.id">{{study.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Judul</label>
									<input class="form-control" v-model="data.title">
								</div>
								<div class="form-group">
									<label>Deskripsi</label>
									<textarea class="form-control" v-model="data.description"></textarea>
								</div>
								<div class="form-group">
									<label>Jenis Soal</label>
									<select v-model="data.question_type" class="form-control">
										<option v-for="qtype in ['Pilihan Berganda','Essay']" :key="qtype" :value="qtype">{{qtype}}</option>
									</select>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="addQuestion()">Tambah Tugas</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="editSoal">
					<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Edit Soal</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Edit Soal Berhasil</p>
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select v-model="data.study_id" class="form-control">
										<option v-for="study in employee.studies" :key="study.id" :value="study.id">{{study.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Judul</label>
									<input class="form-control" v-model="data.title">
								</div>
								<div class="form-group">
									<label>Deskripsi</label>
									<textarea class="form-control" v-model="data.description"></textarea>
								</div>
								<div class="form-group">
									<label>Jenis Soal</label>
									<select v-model="data.question_type" class="form-control">
										<option v-for="qtype in ['Pilihan Berganda','Essay']" :key="qtype" :value="qtype">{{qtype}}</option>
									</select>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Close</button>
								<button type="button" class="btn btn-primary" @click="updateQuestion()">Update Soal</button>
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
	},
	data(){
        return{
            questions:{},
            data:{},
            token:'',
            headers:'',
            status:false,
			deleteStatus:false,
			employees:{},
			user_id:0,
			other_id:0,
			question_id:0,
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
        await this.findEmployee()
        this.loadQuestions()
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
        async loadQuestions(){
            var vm = this
            let response = await fetch('api/question/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach(val => {
	        	let obj = vm.employee.class_rooms.find(o => o.id === val.classroom_id);
	        	let studyObj = vm.employee.studies.find(o => o.id === val.study_id);
				val.classroom = obj
				val.study = studyObj
	        })
	        this.questions = await data

            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        findQuestion(id){
            fetch('api/question/get/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addQuestion(){
        	this.data.teacher_id = this.other_id
        	console.log(this.data)
            fetch('api/question/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadQuestions()
            })
        },
        resetForm(){
        	this.data = {}
        },
        updateQuestion(){
        	this.data.teacher_id = this.other_id
            fetch('api/question/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadQuestions()
            })
        },
        deleteQuestion(question_id){
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
			  	fetch('api/question/delete',{
	                method:'delete',
	                headers:vm.headers,
	                body:JSON.stringify({id:question_id,teacher_id:vm.other_id})
	            })
	            .then(res=>res.json())
	            .then(res=>{
	                vm.deleteStatus = true
                	vm.loadQuestions()
	                Swal.fire(
				      'Terhapus!',
				      'Data berhasil dihapus.',
				      'success'
				    )
	            })
			  }
			})
		},

		// /ANNOUNCEMENT
		loadEmployees(){
			fetch(window.config.MIX_IS_URL+'/api/employee',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.employees = res
            })
		},
		async findEmployee(){
			let response = await fetch(window.config.MIX_IS_URL+'/api/employee/'+this.other_id,{
                headers:this.headers,
            });
            let data = await response.json()
            this.employee = data
            return data
		}
    }
}
</script>