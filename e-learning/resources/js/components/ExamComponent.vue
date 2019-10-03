<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">

	          	<div class="row">
					<div class="col-md-4 col-sm-12 grid-margin stretch-card">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnnouncement">
						Buat Sesi Kuis
						</button>
					</div>
				</div>

				<!-- TABLE -->

				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<p class="alert alert-success" v-if="deleteStatus">Hapus Sesi Kuis Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Nama</th>
											<th>Mata Pelajaran</th>
											<th>Kelas</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(exam,index) in exams" :key="exam.id">
											<td>{{index+1}}</td>
											<td>
												<a :href="'/exams/answered/'+exam.id">
												{{exam.name}}
												</a>
											</td>
											<td>{{exam.study ? exam.study.name : exam.study_id}}</td>
											<td>{{exam.classroom ? exam.classroom.name : exam.classroom_id}}</td>
											<td>
												<a :href="'/exams/answers/'+exam.id" class="badge badge-success">Soal Kuis</a>
												<a href="javascript:void(0)" data-toggle="modal" data-target="#editSoal" class="badge badge-primary" @click="findExam(exam.id)">Edit</a>
												<a href="javascript:void(0)" @click="deleteExam(exam.id)" class="badge badge-danger">Hapus</a>
											</td>
										</tr>
										<tr  v-if="!exams.length" >
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
								<h5 class="modal-title">Tambah Sesi Kuis</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Tambah Sesi Kuis Berhasil</p>
								<div class="form-group">
									<label>Kelas</label>
									<select v-model="data.classroom_id" class="form-control">
										<option v-for="classroom in employee.class_rooms" :key="classroom.id" :value="classroom.id">{{classroom.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select v-model="data.study_id" class="form-control">
										<option v-for="study in employee.studies" :key="study.id" :value="study.id">{{study.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Nama Sesi</label>
									<input type="text" class="form-control" v-model="data.name" />
								</div>
								<div class="form-group">
									<label>Jenis Kuis</label>
									<select v-model="data.exam_type" class="form-control">
										<option v-for="qtype in ['Ulangan Harian','UTS','UAS']" :key="qtype" :value="qtype">{{qtype}}</option>
									</select>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="addExam()">Tambah Sesi Kuis</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="editSoal">
					<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Edit Sesi</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Edit Sesi Kuis Berhasil</p>
								<div class="form-group">
									<label>Kelas</label>
									<select v-model="data.classroom_id" class="form-control">
										<option v-for="classroom in employee.class_rooms" :key="classroom.id" :value="classroom.id">{{classroom.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select v-model="data.study_id" class="form-control">
										<option v-for="study in employee.studies" :key="study.id" :value="study.id">{{study.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Nama Sesi</label>
									<input type="text" class="form-control" v-model="data.name" />
								</div>
								<div class="form-group">
									<label>Jenis Kuis</label>
									<select v-model="data.exam_type" class="form-control">
										<option v-for="qtype in ['Ulangan Harian','UTS','UAS']" :key="qtype" :value="qtype">{{qtype}}</option>
									</select>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Close</button>
								<button type="button" class="btn btn-primary" @click="updateExam()">Update Sesi Kuis</button>
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
            exams:{},
            data:{},
            token:'',
            headers:'',
            status:false,
			deleteStatus:false,
			employees:{},
			user_id:0,
			other_id:0,
			exam_id:0,
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
        this.loadExams()
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
        async loadExams(){
            var vm = this
            let response = await fetch('api/exam/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach(val => {
	        	let obj = vm.employee.class_rooms.find(o => o.id === val.classroom_id);
	        	let studyObj = vm.employee.studies.find(o => o.id === val.study_id);
				val.classroom = obj
				val.study = studyObj
	        })
	        this.exams = await data

            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        findExam(id){
            fetch('api/exam/get/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addExam(){
        	this.data.teacher_id = this.other_id
        	console.log(this.data)
            fetch('api/exam/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadExams()
            })
        },
        resetForm(){
        	this.data = {}
        },
        updateExam(){
        	this.data.teacher_id = this.other_id
            fetch('api/exam/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadExams()
            })
        },
        deleteExam(exam_id){
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
			  	fetch('api/exam/delete',{
	                method:'delete',
	                headers:vm.headers,
	                body:JSON.stringify({id:exam_id,teacher_id:vm.other_id})
	            })
	            .then(res=>res.json())
	            .then(res=>{
	                vm.deleteStatus = true
	                vm.loadExams()
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
			fetch(process.env.MIX_IS_URL+'/api/employee',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.employees = res
            })
		},
		async findEmployee(){
			let response = await fetch(process.env.MIX_IS_URL+'/api/employee/'+this.other_id,{
                headers:this.headers,
            });
            let data = await response.json()
            this.employee = data
            return data
		}
    }
}
</script>