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
											<th>Nama</th>
											<th>Mata Pelajaran</th>
											<th>Guru</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(exam,index) in exams" :key="exam.id">
											<td>{{index+1}}</td>
											<td>{{exam.name}}</td>
											<td>{{exam.study ? exam.study.name : exam.study_id}}</td>
											<td>{{exam.teacher ? exam.teacher.name : exam.teacher_id}}</td>
											<td>
												<a :href="'/exams/panel/'+exam.id" class="badge badge-success">Panel Kuis</a>
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
			employees:{},
			exam_status:{},
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
            window.location = process.env.MIX_ES_URL+'/login'
        }
        this.loadEmployees()
        await this.fetchUserId()
        await this.findEmployee()
        this.loadExams()
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
        async loadExams(){
            var vm = this
            let response = await fetch('api/exam/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach(val => {
	        	let obj = vm.employees.find(o => o.id === val.teacher_id);
	        	let studyObj = vm.employee.studies.find(o => o.id === val.study_id);
				val.teacher = obj
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
            fetch('api/exam/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:exam_id,teacher_id:this.other_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadExams()
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