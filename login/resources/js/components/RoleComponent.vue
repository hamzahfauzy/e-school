<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRole">
                add role
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">delete role success</p>
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(role,index) in roles" :key="role.id">
                                    <td>{{index+1}}</td>
                                    <td>{{role.name}}</td>
                                    <td>{{role.description}}</td>
                                    <td>
                                        <a href="#editRole" @click="findRole(role.id)" data-toggle="modal" class="badge badge-primary">edit</a>
                                        <a href="#deleteRole" @click="deleteRole(role.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr v-if="!roles.length">
                                    <td colspan="4">Tidak ada data</td>
                                </tr>   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addRole">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">add role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">add role success</p>
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="data.name">
                            <label>Description</label>
                            <p class="alert alert-warning" v-if="errors.email">{{errors.email[0]}}</p>
                            <textarea cols="30" rows="10" class="form-control" v-model="data.description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addRole()">add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editRole">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">edit role {{role.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">add role success</p>
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="role.name">
                            <label>Description</label>
                            <p class="alert alert-warning" v-if="errors.description">{{errors.description[0]}}</p>
                            <textarea cols="30" rows="10" class="form-control" v-model="role.description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="editRole(role.id)">edit</button>
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
                role:{
                    id:'',
                    name:'',
                    description:'',
                },
                token:'',
                data:{
                    name:'',
                    description:'',
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
            this.loadRoles();
        },

        methods: {
            loadRoles(){
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
            findRole(id){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/role/'+id, {
                    headers: {
                        'Authorization': 'Bearer '+token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.role.id = res.id
                    this.role.name = res.name
                    this.role.description = res.description
                })
            },
            addRole(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/role/create',{
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
                            description:'',
                        }
                        this.loadRoles()
                        setTimeout(function(){
                                this.success = false
                            },2000)
                    }
                })
            },
            updateRole(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/role/update',{
                    method:'post',
                    headers:{
                        'Authorization': 'Bearer '+token,
                        'content-type':'application/json'
                    },
                    body:JSON.stringify(this.role)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                        setTimeout(function(){
                                this.errors = {}
                            },2000)
                    }else{
                        this.success = true
                        this.loadRoles()
                        setTimeout(function(){
                                this.success = false
                            },2000)
                    }
                })
            },
            deleteRole(id){
                if(confirm("Are you sure ?")){
                    var token = window.localStorage.getItem('eschool_token_app')
                    fetch('api/role/delete',{
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
                            this.loadRoles()
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