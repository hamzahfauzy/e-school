<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addApplicationPortal" v-if="es_env=='local'">
                <i class="ti ti-plus"></i> Add Application Portal
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">Delete Application Portal Success</p>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>App Name</th>
                                    <th>App Url</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(application_portal,index) in application_portals" :key="application_portal.id">
                                    <td>{{index+1}}</td>
                                    <td>
                                    {{application_portal.app_name}}
                                    <p></p>
                                    <span class="badge badge-secondary">App ID : {{application_portal.id}}</span>
                                    </td>
                                    <td>{{application_portal.app_url}}</td>
                                    <td>
                                        <a v-if="es_env=='local'" href="#editApplicationPortal" @click="findApplicationPortal(application_portal.id)" data-toggle="modal" class="badge badge-primary"><i class="ti ti-pencil"></i> Edit</a>
                                        <a v-if="es_env=='local'" href="#deleteApplicationPortal" @click="deleteApplicationPortal(application_portal.id)" class="badge badge-danger"><i class="ti ti-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <tr v-if="!application_portals.length">
                                    <td colspan="4"><i>Data is empty!</i></td>
                                </tr>   
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addApplicationPortal">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Application Portal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Add Application Portal Success</p>
                            <div class="form-group">
                                <label>App Name</label>
                                <p class="alert alert-warning" v-if="errors.app_name">{{errors.app_name[0]}}</p>
                                <input type="text" class="form-control" v-model="data.app_name">
                            </div>
                            <div class="form-group">
                                <label>App Url</label>
                                <p class="alert alert-warning" v-if="errors.app_url">{{errors.app_url[0]}}</p>
                                <input type="text" class="form-control" v-model="data.app_url">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addApplicationPortal()"><i class="ti ti-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editApplicationPortal">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Application Portal {{application_portal.app_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Edit Application Portal Success</p>
                        <div class="form-group">
                            <label>App Name</label>
                            <p class="alert alert-warning" v-if="errors.app_name">{{errors.app_name[0]}}</p>
                            <input type="text" class="form-control" v-model="application_portal.app_name">
                        </div>
                        <div class="form-group">
                            <label>App Url</label>
                            <p class="alert alert-warning" v-if="errors.app_url">{{errors.app_url[0]}}</p>
                            <input type="text" class="form-control" v-model="application_portal.app_url">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateApplicationPortal(application_portal.id)"><i class="ti ti-save"></i> Save</button>
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
                application_portals:{},
                application_portal:{},
                token:'',
                data:{
                    app_name:'',
                    app_url:'',
                },
                errors:{},
                success:false,
                delSuccess:false,
                es_env:'',
                headers:''
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
            this.es_env = window.config.MIX_ES_ENV
            this.loadApplicationPortals();
        },

        methods: {
            loadApplicationPortals(){
                fetch('api/application_portal', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.application_portals = res
                })

                var vm = this
                setTimeout(()=>{
                    vm.success = false
                    vm.delSuccess = false
                },2500)
            },
            findApplicationPortal(id){
                fetch('api/application_portal/'+id, {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.application_portal = res
                })
            },
            addApplicationPortal(){
                fetch('api/application_portal/create',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify(this.data)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                    }else{
                        this.success = true
                        this.data = {
                            app_name:'',
                            app_url:'',
                        }
                        this.loadApplicationPortals()
                    }
                })
            },
            updateApplicationPortal(){
                fetch('api/application_portal/update',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify(this.application_portal)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                        setTimeout(function(){
                                this.errors = {}
                            },2000)
                    }else{
                        this.success = true
                        this.loadApplicationPortals()
                    }
                })
            },
            deleteApplicationPortal(id){
                if(confirm("Are you sure ?")){
                    fetch('api/application_portal/delete',{
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
                            this.loadApplicationPortals()
                        }
                    })   
                }
            }
        }
    }
</script>