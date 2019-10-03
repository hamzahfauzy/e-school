<template>
	<div>
    <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
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
                                        <a :href="cloud_url+file.file.storage_url" target="_blank">{{file.file.name}}</a>
                                        <p></p>
                                        <a :href="cloud_url+file.file.storage_url" target="_blank" class="text-success"><i class="ti ti-cloud-down"></i> Download</a> &nbsp;
                                    </td>
                                  <td>{{(file.file.size/1024).toLocaleString(undefined,{ maximumFractionDigits: 1 })}} kb</td>
                                </tr>
                                <tr v-if="!files.length">
                                  <td colspan="2">Tidak ada data!</td>
                                </tr>
                            </tbody>
                        </table>
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
      files:'',
      headers:'',
      token:'',
      cloud_url:'',
      user:{}
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
      fetch('api/share',{
        method:'post',
        headers:this.headers,
        body:JSON.stringify({user_id:this.user.id})
      })
      .then(res=>res.json())
      .then(res=>{
        this.files = res
      })
    },
  },
}
</script>