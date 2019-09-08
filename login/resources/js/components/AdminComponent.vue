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
                    <a href="#">Users</a>
                    <a href="#">Roles</a>
                    <a href="#">Cloud</a>
                    <a href="#">Profile</a>
                    <a href="#">Setting</a>
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
                token:''
            }
        },

        created(){
            var token = window.localStorage.getItem('eschool_token_app')
            if(token === undefined || token === null)
            {
                window.location = "/login"
            }
            this.loadData()
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