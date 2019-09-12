<template>
	<div>
		<div class="overlay" v-bind:class="{ 'd-none': loaded}">
	        <div class="loader"></div>
	    </div>
		<div class="limiter">
	        <div class="container-login100" style="background-image: url('/template/images/img-01.jpg');">
	            <div class="wrap-login100 p-t-50 p-b-30">
	                <form class="login100-form validate-form" @submit.prevent="doLogin">
	                    <span class="login100-form-title p-t-20 p-b-45">
	                        e-School Login Service
	                    </span>

	                    <div class="wrap-input100 m-b-10">
	                        <div class="alert alert-success" v-bind:class="{ 'd-none': !loginSuccess}" role="alert" style="font-size: 12px">
	                            Login Success. You will redirect to landing page
	                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                                <span aria-hidden="true">&times;</span>
	                            </button>
	                        </div>

	                        <div class="alert alert-danger" v-bind:class="{ 'd-none': !loginFail}" role="alert" style="font-size: 12px">
	                            Login Fail. Please enter the correct email and password
	                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                                <span aria-hidden="true">&times;</span>
	                            </button>
	                        </div>
	                    </div>

	                    <div class="wrap-input100 validate-input m-b-10" v-bind:class="{ 'alert-validate': alertEmail}" data-validate="E-Mail is Required">
	                        <input class="input100" type="email" name="email" placeholder="E-Mail" v-model="authDetail.email">
	                        <span class="focus-input100"></span>
	                        <span class="symbol-input100">
	                            <i class="fa fa-user"></i>
	                        </span>
	                    </div>

	                    <div class="wrap-input100 validate-input m-b-10" v-bind:class="{ 'alert-validate': alertPassword}" data-validate="Password is Required">
	                        <input class="input100" type="password" name="password" placeholder="Password" v-model="authDetail.password">
	                        <span class="focus-input100"></span>
	                        <span class="symbol-input100">
	                            <i class="fa fa-lock"></i>
	                        </span>
	                    </div>

	                    <div class="container-login100-form-btn p-t-10">
	                        <button class="login100-form-btn">
	                            Login
	                        </button>
	                    </div>

	                    <div class="text-center w-full p-t-25 p-b-50">
	                        <span class="txt1">
	                            Copyright &copy; 2019 . <a href="https://z-techno.com" class="txt1">Z-Techno</a>
	                        </span>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				authDetail: {
					email:'',
					password:''
				},
				token:'',
				alertEmail:false,
				alertPassword:false,
				loginSuccess:false,
				loaded:false,
				loginFail:false
			}
		},

		created(){
			this.token = window.getCookie('eschool_token_app')
            if(!(this.token === undefined || this.token === null || this.token === ""))
            {
                window.location = "/"
            }
            else
            {
            	this.loaded=true
            }
        },

		methods: {
			doLogin(){
				this.alertPassword = false
				this.alertEmail = false
				this.loginSuccess = false
				this.loginFail = false
				if(this.authDetail.email === '' || this.authDetail.password === '')
				{
					this.alertPassword = true
					this.alertEmail = true
					return
				}
				fetch('api/login',{
					method:'post',
					body: JSON.stringify(this.authDetail),
					headers: {
						'content-type':'application/json'
					}
				})
				.then(res => res.json())
				.then(data => {
					if(data.success)
					{
						this.loginSuccess = true
						this.authDetail.email = ""
						this.authDetail.password = ""
						window.setCookie('eschool_token_app',data.success.token)
						window.location="/"
					}

					if(data.error)
					{
						this.loginFail = true
					}
					
				})
			}
		}
	}
</script>