<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUser">
                <i class="ti ti-plus"></i> Add User
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">Delete Success</p>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user,index) in users" :key="user.id">
                                    <td>{{index+1}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>
                                        <div v-if="user.roles.length">
                                        <span v-for="role in user.roles" :key="role.id"><a href="#" class="badge badge-info">{{role.name}}</a><a href="javascript:void(0)" @click="deleteRole(user.id,role.id)" class="badge badge-danger"><i class="ti ti-trash"></i></a> &nbsp;</span>
                                        </div>
                                        <p></p>
                                        <a href="#addRole" @click="findUser(user.id)" data-toggle="modal" class="badge badge-success"><i class="ti ti-plus"></i> Add Role</a>
                                    </td>
                                    <td>
                                        <a href="#editUser" @click="findUser(user.id)" data-toggle="modal" class="badge badge-primary"><i class="ti ti-pencil"></i> Edit</a>
                                        <a href="#deleteUser" @click="deleteUser(user.id)" class="badge badge-danger"><i class="ti ti-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <tr v-if="!users.length">
                                    <td colspan="6"><i>Data is empty!</i></td>
                                </tr>   
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addUser">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Add User Success</p>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <p class="alert alert-warning" v-if="errors.email">{{errors.email[0]}}</p>
                            <input type="text" class="form-control" v-model="data.email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <p class="alert alert-warning" v-if="errors.password">{{errors.password[0]}}</p>
                            <input type="password" class="form-control" v-model="data.password">
                        </div>
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <p class="alert alert-warning" v-if="errors.c_password">{{errors.c_password[0]}}</p>
                            <input type="password" class="form-control" v-model="data.c_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addUser()"><i class="ti ti-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editUser">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User {{user.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Edit User success</p>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="user.name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <p class="alert alert-warning" v-if="errors.email">{{errors.email[0]}}</p>
                            <input type="text" class="form-control" v-model="user.email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <p class="alert alert-warning" v-if="errors.password">{{errors.password[0]}}</p>
                            <input type="password" class="form-control" v-model="user.password">
                        </div>
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <p class="alert alert-warning" v-if="errors.c_password">{{errors.c_password[0]}}</p>
                            <input type="password" class="form-control" v-model="user.c_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="updateUser()"><i class="ti ti-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addRole">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role {{user.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Tambah Role {{user.name}}</p>
                        <div class="form-group">
                            <label>Role</label>
                            <select v-model="user_role.role_id" class="form-control" @change="changeRoleEvent($event)">
                                <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
                            </select>
                        </div>

                        <div class="form-group role-teacher" v-if="roleTeacherShow">
                            <label>Role Teacher</label>
                            <select v-model="teacher_id" class="form-control">
                                <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{teacher.name}}</option>
                            </select>
                        </div>

                        <div class="form-group role-student" v-if="roleStudentShow">
                            <label>Role Student</label>
                            <select v-model="student_id" class="form-control">
                                <option v-for="student in students" :key="student.id" :value="student.id">{{student.name}}</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addRole(user.id)">add role</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                loaded:false,
                roles:{},
                users:{},
                user:{
                    id:'',
                    email:'',
                    name:'',
                    password:'',
                    c_password:'',
                },
                token:'',
                headers:'',
                data:{
                    name:'',
                    email:'',
                    password:'',
                    c_password:'',
                },
                teacher_id:0,
                student_id:0,
                user_role_id:0,
                user_role:{},
                teachers:{},
                students:{},
                errors:{},
                roleTeacherShow:false,
                roleStudentShow:false,
                success:false,
                delSuccess:false
            } 
        },

        created(){
            this.token = window.getCookie('eschool_token_app')
            this.headers = {
                'Authorization': 'Bearer '+this.token,
                'Content-Type':'application/json'
            }
            if(this.token === undefined || this.token === null || this.token === '')
            {
                window.location = "/login"
            }
            this.loadUsers();
        },

        methods: {
            loadUsers(){
                fetch('api/user', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.users = res
                })

                var vm = this
                setTimeout(()=>{
                    vm.success = false
                    vm.delSuccess = false
                },2500)
            },
            getRoles(){
                fetch('api/role', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.roles = res
                })
            },
            findUser(id){
                fetch('api/user/'+id, {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.user.id = res.id
                    this.user.email = res.email
                    this.user.name = res.name
                    this.getRoles()
                })
            },
            addUser(){
                fetch('api/user/create',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify(this.data)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                    }else{
                        this.success = true
                        this.data = {
                            name:'',
                            email:'',
                            password:'',
                            c_password:'',
                        }
                        this.loadUsers()
                    }
                })
            },
            addRole(user_id){
                if(this.roleTeacherShow)
                    this.user_role.other_id = this.teacher_id
                if(this.roleStudentShow)
                    this.user_role.other_id = this.student_id

                this.user_role.user_id = user_id
                fetch('api/user/addRole',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify(this.user_role)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                    }else{
                        this.success = true
                        this.roleTeacherShow = false
                        this.roleStudentShow = false
                        this.user_role.role_id = 0
                        this.loadUsers()
                    }
                })
            },
            updateUser(){
                fetch('api/user/update',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify(this.user)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                    }else{
                        this.success = true
                        this.loadUsers()
                    }
                })
            },
            deleteUser(id){
                if(confirm("Are you sure ?")){
                    fetch('api/user/delete',{
                        method:'delete',
                        headers:this.headers,
                        body:JSON.stringify({'id':id})
                    }).then(res=>res.json()).then(res=>{
                        if(res.error){
                            this.errors = res.error
                        }else{
                            this.delSuccess = true
                            this.loadUsers()
                        }
                    })   
                }
            },
            deleteRole(user_id,role_id){
                if(confirm('Are you sure ?')){
                    this.user_role.user_id = user_id
                    this.user_role.role_id = role_id
                    fetch('api/user/deleteRole',{
                        method:'delete',
                        headers:this.headers,
                        body:JSON.stringify(this.user_role)
                    }).then(res=>res.json()).then(res=>{
                        if(res.error){
                            this.errors = res.error
                        }else{
                            this.delSuccess = true
                            this.loadUsers()
                        }
                    })
                }
            },
            changeRoleEvent(event){
                var val = event.target.value
                this.roleTeacherShow = false
                this.roleStudentShow = false
                if(val == window.config.MIX_EL_TEACHER_ROLE_ID)
                {
                    this.roleTeacherShow = true
                    fetch(window.config.MIX_IS_URL+'/api/employee', {
                        headers:this.headers,
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.teachers = res
                    })
                }

                if(val == window.config.MIX_EL_STUDENT_ROLE_ID)
                {
                    this.roleStudentShow = true
                    fetch(window.config.MIX_IS_URL+'/api/student', {
                        headers:this.headers,
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.students = res
                    })
                }
            }
        }
    }
</script>