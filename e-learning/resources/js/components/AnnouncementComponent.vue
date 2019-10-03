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
								<p class="alert alert-success" v-if="deleteStatus">Hapus Pengumunan Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Kelas</th>
											<th>Pesan</th>
											<th>Batas Pengumuman</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(announcement,index) in announcements" :key="announcement.id">
											<td>{{index+1}}</td>
											<td>{{announcement.classroom ? announcement.classroom.name : announcement.classroom_id}}</td>
											<td>{{announcement.messages}}</td>
											<td>{{announcement.expired_at}}</td>
											<td>
												<!-- <a href="#editannouncement" data-toggle="modal" data-target="#addAnnouncement"class="badge badge-primary" @click="findAnnouncement(announcement.id)">edit</a> -->
												<a href="#" @click="deleteAnnouncement(announcement.id)" class="badge badge-danger">Hapus</a>
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
								<p v-if="status" class="alert alert-success">Tambah Pengumuman Berhasil</p>
								<div class="form-group">
									<label>Kelas</label>
									<select v-model="data.classroom_id" class="form-control">
										<option v-for="class_room in employee.class_rooms" :key="class_room.id" :value="class_room.id">{{class_room.name}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Pesan</label>
									<textarea class="form-control" v-model="data.messages" cols="30" rows="10"></textarea>
								</div>
								<div class="form-group">
									<label>Batas Pengumuman</label>
									<input type="datetime-local" class="form-control" v-model="data.expired_at" />
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
            window.location = window.config.MIX_ES_URL+'/login'
        }
        await this.fetchUserId()
        await this.findEmployee()
        this.loadAnnouncements()
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
        async loadAnnouncements(){
            var vm = this
            let response = await fetch('api/announcement/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach(val => {
	        	let obj = vm.employee.class_rooms.find(o => o.id === val.classroom_id);
				val.classroom = obj
	        })
	        this.announcements = await data

	        setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
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
        	this.data.teacher_id = this.other_id
            fetch('api/announcement/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadAnnouncements()
            })
        },
        updateAnnouncement(){
        	this.data.teacher_id = this.other_id
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
			  	fetch('api/announcement/delete',{
	                method:'delete',
	                headers:vm.headers,
	                body:JSON.stringify({id:announcement_id,teacher_id:vm.other_id})
	            })
	            .then(res=>res.json())
	            .then(res=>{
	                vm.deleteStatus = true
	                vm.loadAnnouncements()
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