<template>
    <div>
        <div class="row">
            <div class="col-6 grid-margin stretch-card">
                <button v-if="es_env=='local'" type="button" class="btn btn-success" data-toggle="modal" data-target="#addMenu">
                <i class="ti ti-plus"></i> Add Menu
                </button>
                &nbsp;
                <a href="/roles" class="btn btn-warning"><i class="ti ti-arrow-left"></i> Kembali</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="delSuccess">Delete Menu Success</p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>URL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="menus.length" v-for="(menu,index) in menus" :key="menu.id">
                                        <td>{{index+1}}</td>
                                        <td>{{menu.name}}</td>
                                        <td>{{menu.url}}</td>
                                        <td>
                                            <a v-if="es_env=='local'" href="#editMenu" @click="findMenu(menu.id)" data-toggle="modal" class="badge badge-primary"><i class="ti ti-pencil"></i> Edit</a>
                                            <a v-if="es_env=='local'" href="#deleteMenu" @click="deleteMenu(menu.id)" class="badge badge-danger"><i class="ti ti-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <tr v-if="!menus.length">
                                        <td colspan="4"><i>Data is empty!</i></td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addMenu">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Add Menu Success</p>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <p class="alert alert-warning" v-if="errors.url">{{errors.url[0]}}</p>
                            <input type="text" class="form-control" v-model="data.url">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addMenu()"><i class="ti ti-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editMenu">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Menu {{menu.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p class="alert alert-success" v-if="success">Edit Menu Success</p>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="alert alert-warning" v-if="errors.name">{{errors.name[0]}}</p>
                            <input type="text" class="form-control" v-model="menu.name">
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <p class="alert alert-warning" v-if="errors.url">{{errors.url[0]}}</p>
                            <input type="text" class="form-control" v-model="menu.url">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateMenu()"><i class="ti ti-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        

    </div>
</template>

<script>
    export default {
        props:{
            role_id:0
        },
        data(){
            return {
                loaded:false,
                menus:{},
                menu:{},
                data:{},
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
            this.es_env = window.config.MIX_ES_ENV
            this.loadMenus();
        },

        methods: {
            loadMenus(){
                fetch('/api/role/'+this.role_id+'/menu', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.menus = res
                })

                var vm = this
                setTimeout(()=>{
                    vm.success = false
                    vm.delSuccess = false
                },2500)
            },
            findMenu(id){
                fetch('/api/role/'+this.role_id+'/menu/find/'+id, {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.menu = res
                })
            },
            addMenu(){
                fetch('/api/role/'+this.role_id+'/menu/create',{
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
                            url:'',
                        }
                        this.loadMenus()
                    }
                })
            },
            updateMenu(){
                fetch('/api/role/'+this.role_id+'/menu/update',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify(this.menu)
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                        setTimeout(function(){
                                this.errors = {}
                            },2000)
                    }else{
                        this.success = true
                        this.loadMenus()
                    }
                })
            },
            deleteMenu(id){
                if(confirm("Are you sure ?")){
                    fetch('/api/role/'+this.role_id+'/menu/delete',{
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
                            this.loadMenus()
                        }
                    })   
                }
            }
        }
    }
</script>