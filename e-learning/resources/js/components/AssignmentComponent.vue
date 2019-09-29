<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">

	          	<div class="row">
					<div class="col-md-4 col-sm-12 grid-margin stretch-card">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnnouncement">
						Tambah Tugas
						</button>
					</div>
				</div>

				<!-- TABLE -->

				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<p class="alert alert-success" v-if="deleteStatus">Hapus Tugas Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Kelas</th>
											<th>Mata Pelajaran</th>
											<th>File</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(assignment,index) in assignments" :key="assignment.id">
											<td>{{index+1}}</td>
											<td>{{assignment.classroom ? assignment.classroom.name : assignment.classroom_id}}</td>
											<td>{{assignment.study ? assignment.study.name : assignment.study_id}}</td>
											<td><a :href="assignment.file_url">Download</a></td>
											<td>
												<!-- <a href="#editannouncement" data-toggle="modal" data-target="#addAnnouncement"class="badge badge-primary" @click="findAnnouncement(announcement.id)">edit</a> -->
												<a href="javascript:void(0)" @click="deleteAssignment(assignment.id)" class="badge badge-danger">Hapus</a>
											</td>
										</tr>
										<tr  v-if="!assignments.length" >
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
								<h5 class="modal-title">Tambah Tugas</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Tambah Tugas Berhasil</p>
								<div class="form-group">
									<label>Kelas</label>
									<select v-model="data.classroom_id" class="form-control">
										<option v-for="class_room in employee.class_rooms" :key="class_room.id" :value="class_room.id">{{class_room.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select v-model="data.study_id" class="form-control">
										<option v-for="study in employee.studies" :key="study.id" :value="study.id">{{study.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>File URL</label>
									<input class="form-control" v-model="data.file_url">
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="addAssignment()">Tambah Tugas</button>
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
            assignments:{},
            data:{},
            token:'',
            headers:'',
            status:false,
			deleteStatus:false,
			employees:{},
			user_id:0,
			other_id:0,
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
            window.location = process.env.MIX_ES_URL+'/login'
        }
        await this.fetchUserId()
        await this.findEmployee()
        this.loadAssignments()
    },
    methods:{

		// ANNOUNCEMENT
		async fetchUserId(){
            let response = await fetch(process.env.MIX_ES_URL+'/api/details',{
                method:'post',
                headers:this.headers
            });
            let data = await response.json()
            this.user_id = data.id
            this.other_id = data.other_id
            return data;
        },
        async loadAssignments(){
            var vm = this
            let response = await fetch('api/assignment/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach(val => {
	        	let obj = vm.employee.class_rooms.find(o => o.id === val.classroom_id);
	        	let studyObj = vm.employee.studies.find(o => o.id === val.study_id);
				val.classroom = obj
				val.study = studyObj
	        })
	        this.assignments = await data

            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        findAssignment(id){
            fetch('api/assignment/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addAssignment(){
        	this.data.teacher_id = this.other_id
            fetch('api/assignment/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadAssignments()
            })
        },
        updateAssignment(){
        	this.data.teacher_id = this.other_id
            fetch('api/assignment/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadAssignments()
            })
        },
        deleteAssignment(assignment_id){
            fetch('api/assignment/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:assignment_id,teacher_id:this.other_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadAssignments()
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