<template>
	<div>
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h4 class="font-weight-bold mb-0">Cloud Dashboard</h4>
          </div>
          <div>
            <button type="button" class="btn btn-primary btn-icon-text btn-rounded">
              <i class="ti-clipboard btn-icon-prepend"></i>Report
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p>{{allSize}} kb of {{max_disk_quota}} kb</p>
            <div class="progress" style="height:50px">
              <div class="progress-bar" role="progressbar" :style="{width:value+'%'}">
                {{value}} %
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
            <div class="col-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header bg-primary text-light">
                    File anda
                  </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="file in files" :key="file.id">
                                  <td>
                                        <a :href="cloud_url+file.storage_url" target="_blank">{{file.name}}</a>
                                        <p></p>
                                        <a :href="cloud_url+file.storage_url" target="_blank" class="text-success"><i class="ti ti-cloud-down"></i> Download</a> &nbsp;
                                        <a href="#share" class="text-primary" data-toggle="modal" @click="findFile(file.id)"><i class="ti ti-share"></i> Share</a> &nbsp;
                                        <a href="javascript:void(0)" @click="deleteFile(file.id)" class="text-danger"><i class="ti ti-trash"></i> Delete</a>
                                    </td>
                                  <td>{{(file.size/1024).toLocaleString(undefined,{ maximumFractionDigits: 1 })}} kb</td>
                                </tr>
                                <tr v-if="!files.length">
                                  <td colspan="2">Tidak ada data!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header bg-success text-light">
                    File bersama
                  </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="file in fileShares" :key="file.id">
                                  <td>
                                        <a :href="cloud_url+file.file.storage_url" target="_blank">{{file.file.name}}</a>
                                        <p></p>
                                        <a :href="cloud_url+file.file.storage_url" target="_blank" class="text-success"><i class="ti ti-cloud-down"></i> Download</a> &nbsp;
                                    </td>
                                  <td>{{(file.file.size/1024).toLocaleString(undefined,{ maximumFractionDigits: 1 })}} kb</td>
                                </tr>
                                <tr v-if="!fileShares.length">
                                  <td colspan="2">Tidak ada data!</td>
                                </tr>
                            </tbody>
                        </table>
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
  data(){
    return{
      files:{},
      headers:'',
      token:'',
      max_disk_quota:'',
      allSize:0,
      value:'',
      cloud_url:'',
      user:{},
      fileShares:{},
      folder_id:0,
      file:{},
      users:{},
      data:{},
      statusShare:false
    }
  },
  async created(){
    this.token = window.getCookie('eschool_token_app')
    this.cloud_url = window.config.MIX_CLOUD_URL
    this.headers = {
      'Authorization': 'Bearer '+this.token,
      'Content-Type':'application/json'
    }
    await this.fetchUserId()
    this.loadFiles()
    this.loadSize()
    this.loadFileShares()
    this.loadUsers()
  },
  methods:{
    async fetchUserId(){
      let response = await fetch(window.config.MIX_ES_URL+'/api/details',{
        method:'post',
        headers:this.headers
      });
      let data = await response.json()
      this.user = data
      return data;
    },
    loadFiles(){
      fetch('api/files/all',{
        method:'post',
        headers:this.headers,
        body:JSON.stringify({user_id:this.user.id})
      })
      .then(res=>res.json())
      .then(res=>{
        this.files = res
        res.map(r=>{
          this.allSize += r.size/1024
        })

      })
    },
    loadSize(){
      fetch(window.config.MIX_ES_URL+'/api/cloud/index',{
        headers:this.headers,
      })
      .then(res=>res.json())
      .then(res=>{
        this.max_disk_quota = res.max_disk_quota
        this.value = (this.allSize / this.max_disk_quota*100).toLocaleString(undefined,{maximumFractionDigits:1})
        this.allSize = this.allSize.toLocaleString(undefined,{maximumFractionDigits:1})
      })
    },
    loadFileShares(){
      fetch('api/share',{
        method:'post',
        headers:this.headers,
        body:JSON.stringify({user_id:this.user.id})
      })
      .then(res=>res.json())
      .then(res=>{
        this.fileShares = res
      })
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
  }
}
</script>