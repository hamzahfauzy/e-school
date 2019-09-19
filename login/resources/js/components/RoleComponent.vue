<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button v-if="es_env=='local'" type="button" class="btn btn-success" data-toggle="modal" data-target="#addRole">
                <i class="ti ti-plus"></i> Add Role
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">Delete Role Success</p>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Application Portal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(role,index) in roles" :key="role.id">
                                    <td>{{index+1}}</td>
                                    <td>
                                    {{role.name}}
                                    <!-- <p></p>
                                    <span class="badge badge-secondary">Role ID : {{role.id}}</span> -->
                                    </td>
                                    <td>{{role.description}}</td>
                                    <td v-if="role.application_portal">{{role.application_portal.app_name}}</td>
                                    <td v-else>Tidak ada Portal</td>
                                    <td>
                                        <a v-if="es_env=='local'" :href="'/roles/'+role.id+'/menu'" class="badge badge-success"><i class="ti ti-list"></i> Menu</a>
                                        <a v-if="es_env=='local'" href="#editRole" @click="findRole(role.id)" data-toggle="modal" class="badge badge-primary"><i class="ti ti-pencil"></i> Edit</a>
                                        <a v-if="es_env=='local'" href="#deleteRole" @click="deleteRole(role.id)" class="badge badge-danger"><i class="ti ti-trash"></i>Delete </a>
                                    </td>
                                </tr>
                                <tr v-if="!roles.length">
                                    <td colspan="5"><i>Data is empty!</i></td>
                                </tr>   
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addRole">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Add Role Success</p>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <p class="alert alert-warning" v-if="errors.description">{{errors.description[0]}}</p>
                            <textarea cols="30" rows="10" class="form-control" v-model="data.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Application Portal</label>
                            <select class="form-control" v-model="data.app_id">
                                <option v-for="app in application_portals" :key="app.id" :value="app.id">{{app.app_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addRole()"><i class="ti ti-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editRole">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role {{role.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Edit Role Success</p>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="role.name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <p class="alert alert-warning" v-if="errors.description">{{errors.description[0]}}</p>
                            <textarea cols="30" rows="10" class="form-control" v-model="role.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Application Portal</label>
                            <select class="form-control" v-model="role.app_id">
                                <option v-for="app in application_portals" :key="app.id" :value="app.id">{{app.app_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateRole()"><i class="ti ti-save"></i> Save</button>
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
                role:{},
                data:{},
                application_portals:{},
                errors:{},
                token:'',
                headers:'',
                success:false,
                es_env:'',
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
            this.es_env = process.env.MIX_ES_ENV
            this.loadRoles();
        },

        methods: {
            loadRoles(){
                fetch('api/role', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.roles = res
                    this.loadApplicationPortals()
                })

                var vm = this
                setTimeout(()=>{
                    vm.success = false
                    vm.delSuccess = false
                },2500)
            },
            loadApplicationPortals(){
                fetch('api/application_portal', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.application_portals = res
                })
            },
            findRole(id){
                fetch('api/role/'+id, {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.role = res
                })
            },
            addRole(){
                fetch('api/role/create',{
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
                            description:'',
                        }
                        this.loadRoles()
                    }
                })
            },
            updateRole(){
                fetch('api/role/update',{
                    method:'post',
                    headers:this.headers,
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
                    }
                })
            },
            deleteRole(id){
                if(confirm("Are you sure ?")){
                    fetch('api/role/delete',{
                        method:'delete',
                        headers:this.headers,
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
                        }
                    })   
                }
            }
        }
    }
</script>