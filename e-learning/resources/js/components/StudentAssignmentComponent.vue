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
								<p class="alert alert-success" v-if="deleteStatus">Hapus Tugas Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Guru</th>
											<th>Mata Pelajaran</th>
											<th>File</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(assignment,index) in assignments" :key="assignment.id">
											<td>{{index+1}}</td>
											<td>{{assignment.teacher ? assignment.teacher.name : assignment.teacher_id}}</td>
											<td>{{assignment.study ? assignment.study.name : assignment.study_id}}</td>
											<td><a :href="assignment.file_url">Download</a></td>
											<td>
												<a href="javascript:void(0)" v-if="!assignment.answered" data-toggle="modal" data-target="#addAnnouncement" @click="setAssignmentId(assignment.id)" class="badge badge-success">Jawab</a>
												<a v-if="assignment.answered" :href="assignment.answered.file_url">File Jawaban</a>
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
								<h5 class="modal-title">Jawab Tugas</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Jawab Tugas Berhasil</p>
								<div class="form-group">
									<label>File URL</label>
									<input class="form-control" v-model="data.file_url">
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="answerAssignment()">Jawab Tugas</button>
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
            assignment_id:0,
            answered_assignments:{},
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
        this.loadEmployees()
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
        	await this.loadAnsweredAssignments()
            var vm = this
            let response = await fetch('api/assignment/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        data.forEach(val => {
	        	let obj = vm.employees.find(o => o.id === val.teacher_id);
	        	let studyObj = vm.employee.studies.find(o => o.id === val.study_id);
	        	let answered = vm.answered_assignments.find(o=>o.assignment_id === val.id)
				val.teacher = obj
				val.answered = answered
				val.study = studyObj
	        })
	        this.assignments = await data

            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        async loadAnsweredAssignments(){
            var vm = this
            let response = await fetch('api/assignment-answer/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.answered_assignments = await data
	        return data
        },
        setAssignmentId(assignment_id){
        	this.assignment_id = assignment_id
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
        answerAssignment(){
        	this.data.student_id = this.other_id
        	this.data.assignment_id = this.assignment_id
            fetch('api/assignment-answer/create',{
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