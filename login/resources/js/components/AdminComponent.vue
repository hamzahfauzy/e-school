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
                    <a href="/users">Users Management</a>
                    <a href="/clouds">Cloud APPS</a>
                    <a href="/setting">Setting</a>
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
                users:{}
            }
        },

        created(){
            var token = window.localStorage.getItem('eschool_token_app')
            this.IS_URL = process.env.MIX_IS_URL
            if(token === undefined || token === null)
            {
                window.location = "/login"
            }
            this.loadData()
            this.loadUsers()
        },

        methods: {
            loadData(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/details', {
                    method:'post',
                    headers: {
                        'Authorization': 'Bearer '+token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.username = res.success.name
                    this.loaded = true
                })
            },
            loadUsers(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/user',{
                    headers:{
                        'Authorization':'Bearer '+token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.users = res
                })
            },
            doLogout(){
                var token = window.localStorage.getItem('eschool_token_app')
                fetch('api/logout', {
                    method:'post',
                    headers: {
                        'Authorization': 'Bearer '+token
                    }
                })
                .then(res => {
                    window.localStorage.removeItem('eschool_token_app')
                    window.location = "/login"
                })
            }
        }
    }
</script>