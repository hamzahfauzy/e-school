<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">

	          	<div class="row">
					<div class="col-md-4 col-sm-12 grid-margin stretch-card">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnnouncement">
						Tambah Pengumuman
						</button>
					</div>
				</div>

				<!-- TABLE -->

				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<p class="alert alert-success" v-if="deleteStatus">delete pengumuman success</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Guru</th>
											<th>Kelas</th>
											<th>Pesan</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(announcement,index) in announcements" :key="announcement.id">
											<td>{{index+1}}</td>
											<td>{{announcement.teacher_id}}</td>
											<td>{{announcement.classroom_id}}</td>
											<td>{{announcement.messages}}</td>
											<td>
												<a href="#editannouncement" data-toggle="modal" class="badge badge-primary" @click="findAnnouncement(announcement.id)">edit</a>
												<a href="#" @click="deleteAnnouncement(announcement.id)" class="badge badge-danger">delete</a>
											</td>
										</tr>
										<tr  v-if="!announcements.length" >
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
								<h5 class="modal-title">Tambah Pengumuman</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">tambah pengumuman sukses</p>
								<div class="form-group">
									<label>Pegawai</label>
									<select v-model="data.teacher_id" class="form-control" @change="findEmployee">
										<option v-for="employee in employees" :key="employee.id" :value="employee.id">{{employee.name}}</option>
									</select>
								</div>
								<div class="form-group" v-if="eS">
									<label>Kelas</label>
									<select v-model="data.classroom_id" class="form-control">
										<option v-for="class_room in employee.class_rooms" :key="class_room.id" :value="class_room.id">{{class_room.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Pesan</label>
									<textarea class="form-control" v-model="data.messages" cols="30" rows="10"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="addAnnouncement()">Tambah Pengumuman</button>
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
            announcements:{},
            data:{},
            token:'',
            headers:'',
            status:false,
			deleteStatus:false,
			employees:{},
			employee:{},
			eS:false
        }
    },
    created(){
        this.token = window.getCookie('eschool_token_app')
        this.headers = {
            'Authorization': 'Bearer '+this.token,
            'Content-Type':'application/json'
        }
        if(this.token === undefined || this.token === null || this.token === '' ){
            window.location = process.env.MIX_ES_URL+'/login'
        }
        this.loadAnnouncements()
        this.loadEmployees()
    },
    methods:{

		// ANNOUNCEMENT

        loadAnnouncements(){
            fetch('api/announcement',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.announcements = res
            })
        },
        findAnnouncement(id){
            fetch('api/announcement/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addAnnouncement(){
            fetch('api/announcement/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
				console.log(this.data)
                this.status = true
                this.data = {}
                this.loadAnnouncements()
            })
        },
        updateAnnouncement(){
            fetch('api/announcement/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadAnnouncements()
            })
        },
        deleteAnnouncement(announcement_id){
            fetch('api/announcement/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:announcement_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadAnnouncements()
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
		findEmployee(e){
			fetch(process.env.MIX_IS_URL+'/api/employee/'+e.target.value,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
				this.eS = true
                this.employee = res
            })
		}
    }
}
</script>