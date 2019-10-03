<template>
    <div>
        <div class="overlay" v-bind:class="{ 'd-none': loaded}">
            <div class="loader"></div>
        </div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div>
                    <center>
                        <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar">
                        <p></p>
                        <h2 style="margin: 0px;">{{username}}</h2>
                    </center>
                </div>

                <div class="title" style="font-size: 2em">
                    Selamat datang di E-School
                </div>

                <br>

                <div class="links">
                    <div class="container">
                        <div class="row">
                            <a class="col-sm-12" v-for="role in details.roles" :key="role.id" :href="role.application_portal.app_url">
                                {{role.application_portal.app_name}}
                            </a>
                            <a class="col-sm-12" href="javascript:void(0)" @click="doLogout()">Logout</a>
                        </div>
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
                username:'',
                loaded:false,
                IS_URL:'',
                token:'',
                users:{},
                details:{},
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
            this.loadData()
            this.loadUsers()
        },
        methods: {
            loadData(){
                fetch('api/details', {
                    method:'post',
                    headers: this.headers
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
                    headers:this.headers
                })
                .then(res => res.json())
                .then(res => {
                    this.users = res
                })
            },
            doLogout(){
                fetch('api/logout', {
                    method:'post',
                    headers: this.headers
                })
                .then(res => {
                    window.deleteCookie('eschool_token_app')
                    window.location = "/login"
                })
            }
        }
    }
</script>