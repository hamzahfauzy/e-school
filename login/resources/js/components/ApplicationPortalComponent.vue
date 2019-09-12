<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addApplicationPortal">
                add application portal
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">delete application portal success</p>
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>App Name</th>
                                    <th>App Url</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(application_portal,index) in application_portals" :key="application_portal.id">
                                    <td>{{index+1}}</td>
                                    <td>{{application_portal.app_name}}</td>
                                    <td>{{application_portal.app_url}}</td>
                                    <td>
                                        <a href="#editApplicationPortal" @click="findApplicationPortal(application_portal.id)" data-toggle="modal" class="badge badge-primary">edit</a>
                                        <a href="#deleteApplicationPortal" @click="deleteApplicationPortal(application_portal.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr v-if="!application_portals.length">
                                    <td colspan="4">Tidak ada data</td>
                                </tr>   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addApplicationPortal">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">add application portal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">add application portal success</p>
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
                        <button type="button" class="btn btn-primary" @click="addApplicationPortal()">add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editApplicationPortal">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">edit application portal {{application_portal.app_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">edit application portal success</p>
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
                        <button type="button" class="btn btn-primary" @click="updateApplicationPortal(application_portal.id)">edit</button>
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