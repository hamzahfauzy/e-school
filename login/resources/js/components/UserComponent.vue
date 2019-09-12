<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUser">
                add user
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">delete user success</p>
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user,index) in users" :key="user.id">
                                    <td>{{index+1}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td v-if="!user.roles.length">
                                        <a href="#addRole" @click="findUser(user.id)" data-toggle="modal" class="badge badge-success">Add Role</a>
                                    </td>
                                    <td v-if="user.roles.length">
                                        <a href="" class="badge badge-info" v-for="role in user.roles" :key="role.id">{{role.name}}</a>
                                        <a href="#addRole" @click="findUser(user.id)" data-toggle="modal" class="badge badge-success">Add Role</a>
                                    </td>
                                    <td>
                                        <a href="#editUser" @click="findUser(user.id)" data-toggle="modal" class="badge badge-primary">edit</a>
                                        <a href="#deleteUser" @click="deleteUser(user.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr v-if="!users.length">
                                    <td colspan="4">Tidak ada data</td>
                                </tr>   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addUser">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">add user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">add user success</p>
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="data.name">
                            <label>Email</label>
                            <p class="alert alert-warning" v-if="errors.email">{{errors.email[0]}}</p>
                            <input type="text" class="form-control" v-model="data.email">
                            <label>Password</label>
                            <p class="alert alert-warning" v-if="errors.password">{{errors.password[0]}}</p>
                            <input type="password" class="form-control" v-model="data.password">
                            <label>Password Confirmation</label>
                            <p class="alert alert-warning" v-if="errors.c_password">{{errors.c_password[0]}}</p>
                            <input type="password" class="form-control" v-model="data.c_password">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addUser()">add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editUser">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">edit user {{user.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">edit user success</p>
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="user.name">
                            <label>Email</label>
                            <p class="alert alert-warning" v-if="errors.email">{{errors.email[0]}}</p>
                            <input type="text" class="form-control" v-model="user.email">
                            <label>Password</label>
                            <p class="alert alert-warning" v-if="errors.password">{{errors.password[0]}}</p>
                            <input type="password" class="form-control" v-model="user.password">
                            <label>Password Confirmation</label>
                            <p class="alert alert-warning" v-if="errors.c_password">{{errors.c_password[0]}}</p>
                            <input type="password" class="form-control" v-model="user.c_password">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="updateUser(user.id)">edit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addRole">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">add role {{user.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">add role {{user.name}}</p>
                            <label>Role</label>
                            <select v-model="user_role.role_id">
                                <option v-for="role in roles" :key="role.id">{{role.id}}</option>
                            </select>
                        
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
                data:{
                    name:'',
                    email:'',
                    password:'',
                    c_password:'',
                },
                user_role:{
                    user_id:'',
                    role_id:'',
                },
                errors:{},
                success:false,
                delSuccess:false
            } 
        },

        created(){
            var token = window.localStorage.getItem('eschool_token_app')
            if(token === undefined || token === null)
            {
                window.location = "/login"
            }
            this.loadUsers();
        },

        methods: {
            loadUsers(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/user', {
                    headers: {
                        'Authorization': 'Bearer '+token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.users = res
                })
            },
            getRoles(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/role', {
                    headers: {
                        'Authorization': 'Bearer '+token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.roles = res
                })
            },
            findUser(id){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/user/'+id, {
                    headers: {
                        'Authorization': 'Bearer '+token
                    }
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
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/user/create',{
                    method:'post',
                    headers:{
                        'Authorization': 'Bearer '+token,
                        'content-type':'application/json'
                    },
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
                        setTimeout(function(){
                                this.success = false
                            },2000)
                    }
                })
            },
            addRole(user_id){
                var token = window.localStorage.getItem('eschool_token_app')
                this.user_role.user_id = user_id
                fetch('api/user/addRole',{
                    method:'post',
                    headers:{
                        'Authorization': 'Bearer '+token,
                        'content-type':'application/json'
                    },
                    body:JSON.stringify(this.user_role)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                    }else{
                        this.success = true
                        this.loadUsers()
                        setTimeout(function(){
                                this.success = false
                            },2000)
                    }
                })
            },
            updateUser(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/user/update',{
                    method:'post',
                    headers:{
                        'Authorization': 'Bearer '+token,
                        'content-type':'application/json'
                    },
                    body:JSON.stringify(this.user)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                        setTimeout(function(){
                                this.errors = {}
                            },2000)
                    }else{
                        this.success = true
                        this.loadUsers()
                        setTimeout(function(){
                                this.success = false
                            },2000)
                    }
                })
            },
            deleteUser(id){
                if(confirm("Are you sure ?")){
                    var token = window.localStorage.getItem('eschool_token_app')
                    fetch('api/user/delete',{
                        method:'delete',
                        headers:{
                            'Authorization': 'Bearer '+token,
                            'content-type':'application/json'
                        },
                        body:JSON.stringify({'id':id})
                    }).then(res=>res.json()).then(res=>{
                        if(res.error){
                            this.errors = res.error
                            setTimeout(function(){
                                this.errors = {}
                            },2000)
                        }else{
                            this.delSuccess = true
                            this.loadUsers()
                            setTimeout(function(){
                                this.delSuccess = false
                            },2000)
                        }
                    })   
                }
            }
        }
    }
</script>