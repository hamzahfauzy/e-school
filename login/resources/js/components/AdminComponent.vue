<template>
    <div>
        <div class="overlay" v-bind:class="{ 'd-none': loaded}">
            <div class="loader"></div>
        </div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title" style="font-size: 50px">
                    e-School Landing Page
                </div>

                <div>
                    <h2 align="center" style="margin: 0px;">Welcome, {{username}}</h2>
                </div>

                <br>

                <div class="links">
                    <a v-for="role in details.roles" :key="role.id" :href="role.application_portal.app_url">
                        {{role.application_portal.app_name}}
                    </a>
                    <a href="javascript:void(0)" @click="doLogout()">Logout</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                username:'',
                loaded:false,
                IS_URL:'',
                token:'',
                users:{},
                details:{}
            }
        },

        created(){
            this.token = window.getCookie('eschool_token_app')
            if(this.token === undefined || this.token === null || this.token === '')
            {
                window.location = "/login"
            }
            this.loadData()
            this.loadUsers()
        },

        methods: {
            loadData(){
                
                fetch('api/details', {
                    method:'post',
                    headers: {
                        'Authorization': 'Bearer '+this.token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.username = res.name
                    this.loaded = true
                    this.details = res
                })
            },
            loadUsers(){
                
                fetch('api/user',{
                    headers:{
                        'Authorization':'Bearer '+this.token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.users = res
                })
            },
            doLogout(){
                
                fetch('api/logout', {
                    method:'post',
                    headers: {
                        'Authorization': 'Bearer '+this.token
                    }
                })
                .then(res => {
                    window.deleteCookie('eschool_token_app')
                    window.location = "/login"
                })
            }
        }
    }
</script>