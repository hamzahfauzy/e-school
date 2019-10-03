<template>
    <div>
        <div class="row">
            <div class="col-6 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createFolder">
                Buat Folder
                </button>
                &nbsp;
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload">
                Upload File
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-warning" v-bind:href="'/files/'+parent" v-if="parent > 0">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>

                        <a class="btn btn-warning" href="/files" v-if="parent == 0">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="folder in folders" v-bind:key="folder.id">
                                    <td>
                                        <a v-bind:href="'/files/'+folder.id">{{folder.name}}</a>
                                        <p></p>
                                        <a href="javascript:void(0)" @click="deleteFolder(folder.id)" class="text-danger"><i class="ti ti-trash"></i> Delete</a>
                                    </td>
                                    <td>-</td>
                                </tr>
                                <tr v-for="file in files" :key="file.id">
                                    <td>
                                        <a v-bind:href="cloud_url+file.storage_url" target="_blank">{{file.name}}</a>
                                        <p></p>
                                        <a v-bind:href="cloud_url+file.storage_url" target="_blank" class="text-success"><i class="ti ti-cloud-down"></i> Download</a> &nbsp;
                                        <a href="#share" class="text-primary" data-toggle="modal" @click="findFile(file.id)"><i class="ti ti-share"></i> Share</a> &nbsp;
                                        <a href="javascript:void(0)" @click="deleteFile(file.id)" class="text-danger"><i class="ti ti-trash"></i> Delete</a>
                                    </td>
                                    <td>{{(file.size/1024).toLocaleString(undefined,{ maximumFractionDigits: 1 })}} kb</td>
                                </tr>
                                <tr v-if="!files.length && !folders.length">
                                    <td colspan="3">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createFolder">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buat Foler</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">buat folder sukses</p>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addFolder()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="upload">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="statusUpload" class="alert alert-success">upload file sukses</p>
                        <div class="form-group">
                            <label>Pilih File</label>
                            <input type="file" ref="file" class="form-control" multiple="" v-on:change="handleFileUpload()">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="submitUpload()">Upload</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="share">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Share File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="statusShare" class="alert alert-success">share file sukses</p>
                        <div class="form-group">
                            <label>Pilih User</label>
                            <select v-model="data.user_id" class="form-control">
                                <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="shareFile(file.id)">Share</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props:{
        folder:0,
        parent:0,
    },
    data(){
        return{
            files:{},
            folders:{},
            data:{},
            fileUploads:{},
            token:'',
            folder_id:0,
            headers:'',
            user_id:0,
            status:false,
            cloud_url:'',
            statusUpload:false,
            statusShare:false,
            file:{},
            users:{},
        }
    },
    async created(){
        this.token = window.getCookie('eschool_token_app')
        this.cloud_url = window.config.MIX_CLOUD_URL
        this.headers = {
            'Authorization': 'Bearer '+this.token,
            'Content-Type':'application/json'
        }
        if(this.token === undefined || this.token === null || this.token === '' ){
            window.location = window.config.MIX_ES_URL+'/login'
        }
        await this.fetchUserId()
        this.loadFiles()
        this.loadUsers()
    },
    methods:{
        async fetchUserId(){
            let response = await fetch(window.config.MIX_ES_URL+'/api/details',{
                method:'post',
                headers:this.headers
            });
            let data = await response.json()
            this.user_id = data.id
            this.data.user_id = data.id
            this.data.parent_id = this.folder
            return data;
        },
        loadFiles(){
            fetch('/api/files/index/'+this.folder_id,{
                method:'post',
                headers:this.headers,
                body:JSON.stringify({user_id:this.user_id})
            })
            .then(res => res.json())
            .then(res=>{
                this.files = res.files
                this.folders = res.folders
            })

            var vm = this
            setTimeout(()=>{
                vm.status = false
                vm.statusUpload = false
            },2500)
        },
        addFolder(){
            fetch('/api/folder/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.data.user_id = this.user_id
                this.data.parent_id = this.folder
                this.loadFiles()
            })
        },
        deleteFolder(id){
            var n = window.confirm('Apakah anda yakin akan menghapus folder ini ?');
            if(!n)
                return;
            this.data.id = id
            fetch('/api/folder/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.data.user_id = this.user_id
                this.data.parent_id = this.folder
                this.loadFiles()
            })
        },
        deleteFile(id){
            var n = window.confirm('Apakah anda yakin akan menghapus file ini ?');
            if(!n)
                return;
            this.data.id = id
            fetch('/api/files/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.data.user_id = this.user_id
                this.data.parent_id = this.folder
                this.loadFiles()
            })
        },
        handleFileUpload(){
            this.fileUploads = this.$refs.file.files;
        },
        loadUsers(){
            fetch(window.config.MIX_ES_URL+"/api/user",{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.users = res
            })
        },
        findFile(id){
            fetch('api/files/'+id,{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.file = res
            })
        },
        shareFile(id){
            this.data.file_id = id
            fetch('api/files/share',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.statusShare = true
                this.data = {}
                this.file = {}
                this.loadFiles()
            })
        },
        submitUpload(){
            var formData = new FormData();
            Object.keys(this.fileUploads).forEach(index => {
                formData.append('file['+index+']', this.fileUploads[index]);
            })
            formData.append('user_id',this.data.user_id)
            formData.append('parent_id',this.data.parent_id)

            fetch('/api/files/upload',{
                method:'post',
                headers: {
                    'Authorization': 'Bearer '+this.token
                },
                body:formData
            })
            .then(res=>res.json())
            .then(res=>{
                this.statusUpload = true
                this.data = {}
                this.data.user_id = this.user_id
                this.data.parent_id = this.folder
                this.fileUploads = {}
                const input = this.$refs.file
                input.type = 'text'
                input.type = 'file'
                this.loadFiles()
            })
        }
    }
}
</script>