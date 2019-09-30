<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">
	        <div class="content-wrapper">
	          <div class="row">
			      <div class="col-md-12 grid-margin">
			        <div class="d-flex justify-content-between align-items-center">
			          <div>
			            <h4 class="font-weight-bold mb-0">Dashboard</h4>
			          </div>
			          <div>
			            <button type="button" class="btn btn-primary btn-icon-text btn-rounded">
			              <i class="ti-clipboard btn-icon-prepend"></i>Report
			            </button>
			          </div>
			        </div>
			      </div>
			    </div>
			    <div class="row" v-if="this.user_status == 1">
			      <div class="col-12 grid-margin stretch-card">
			        <div class="card">
			          <div class="card-body">
			            <p>Pengumuman</p>
			            <p class="alert alert-success" v-for="announcement in announcements">
			            	<b>{{announcement.employee.name}}</b><br>
				            {{announcement.messages}}
				            <br>
				            <span>{{announcement.created_at}}</span>
				        </p>
			          </div>
			        </div>
			      </div>
			    </div>
	        </div>
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
    		employees:{},
    		user:{},
    		userIS:{},
    		other_id:0,
    		user_status:0,
    	}
    },
    async created(){
	    this.token = window.getCookie('eschool_token_app')
	    this.headers = {
	      'Authorization': 'Bearer '+this.token,
	      'Content-Type':'application/json'
	    }
	    this.loadEmployees()
	    await this.fetchUserId()
	    await this.loadUserFromIS()
	    if(this.user_status == 1)
	    	await this.loadAnnouncements()
    },
    methods:{
	    async fetchUserId(){
	      let response = await fetch(process.env.MIX_ES_URL+'/api/details',{
	        method:'post',
	        headers:this.headers
	      });
	      let data = await response.json()
	      data.roles.forEach(val => {
	      	if(process.env.MIX_EL_STUDENT_ROLE_ID == val.id)
	      	{
	      		this.user_status = 1
	      	}
	      	else if(process.env.MIX_EL_TEACHER_ROLE_ID == val.id)
	      	{
	      		this.user_status = 2
	      	}
	      })
	      this.user = await data
	      this.other_id = await data.other_id
	      return data;
	    },
	    async loadAnnouncements(){
	    	var vm = this
	    	let response = await fetch('/api/announcement/get-by-classroom/'+this.userIS.class_room[0].id,{
	            headers:this.headers,
	        });
	        let data = await response.json()
	        data.forEach(async val => {
	        	let employee = vm.employees.find(o => o.id === val.teacher_id)
	        	val.employee = employee
	        })
	        this.announcements = await data
	        return data
	    },
	    async loadUserFromIS(){
	    	if(this.user_status == 2)
	    	{
		    	let response = await fetch(process.env.MIX_IS_URL+'/api/employee/'+this.other_id,{
	                headers:this.headers,
	            });
	            let data = await response.json()
	            this.userIS = data
	            return data
	    	}

	    	if(this.user_status == 1)
	    	{
		    	let response = await fetch(process.env.MIX_IS_URL+'/api/student/'+this.other_id,{
	                headers:this.headers,
	            });
	            let data = await response.json()
	            this.userIS = data
	            return data
	    	}
	    },
	    loadEmployees(){
			fetch(process.env.MIX_IS_URL+'/api/employee',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.employees = res
            })
		},
	    async findEmployee(id){
			let response = await fetch(process.env.MIX_IS_URL+'/api/employee/'+id,{
                headers:this.headers,
            });
            let data = await response.json()
            return data
		}

	}
}
</script>