<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">
				<!-- TABLE -->
				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Kelas</th>
											<th>Pesan</th>
											<th>Muncul Sampai</th>
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