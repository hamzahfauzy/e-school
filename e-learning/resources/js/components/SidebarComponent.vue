<template>
	<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item" v-for="menu in menus" :key="menu.id">
            <a class="nav-link" :href="menu.url">
              <i class="ti-layout-list-post menu-icon"></i>
              <span class="menu-title">{{menu.name}}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:doLogout()">
              <i class="ti-power-off menu-icon"></i>
              <span class="menu-title">Log Out</span>
            </a>
          </li>
        </ul>
    </nav>
</template>

<script>
export default {
  props: {
  	role_id:0
  },
  data(){
    return{
      headers:'',
      user:[],
      menus:[],
      success:false,
      delSuccess:false,
      token:''
    }
  },
  async created(){
    this.token = window.getCookie('eschool_token_app')
    this.cloud_url = process.env.MIX_CLOUD_URL
    this.headers = {
      'Authorization': 'Bearer '+this.token,
      'Content-Type':'application/json'
    }
    await this.fetchUserId()
    this.loadMenus()
  },
  methods:{
    async fetchUserId(){
      let response = await fetch(process.env.MIX_ES_URL+'/api/details',{
        method:'post',
        headers:this.headers
      });
      let data = await response.json()
      this.user = data
      return data;
    },
    loadMenus(){
        fetch(process.env.MIX_ES_URL+'/api/role/'+this.role_id+'/menu', {
            headers:this.headers,
        })
        .then(res => res.json())
        .then(res => {
        	console.log(res)
            this.menus = res
        })

        var vm = this
        setTimeout(()=>{
            vm.success = false
            vm.delSuccess = false
        },2500)
    }
  }
}
</script>