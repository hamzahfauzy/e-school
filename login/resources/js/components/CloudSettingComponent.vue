<template>
    <div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="updatedStatus">Quota Updated</p>
                        <div class="form-group">
                            <label>Maximum Storage Quota per User (Kb)</label>
                            <input type="text" class="form-control" v-model="quota">
                        </div>
                        <button type="button" class="btn btn-success" @click="updateQuota()">
                            <i class="ti ti-save"></i> Update
                        </button>
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
                loaded:false,
                token:'',
                headers:'',
                quota:0,
                updatedStatus:false
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
            this.loadQuota();
        },

        methods: {
            loadQuota(){
                fetch('/api/cloud/index', {
                    headers:this.headers,
                })
                .then(res => res.json())
                .then(res => {
                    this.quota = res.max_disk_quota ? res.max_disk_quota : 0
                })

                var vm = this
                setTimeout(()=>{
                    vm.updatedStatus = false
                },2500)
            },
            updateQuota(){
                fetch('/api/cloud/update',{
                    method:'post',
                    headers:this.headers,
                    body:JSON.stringify({quota:this.quota})
                }).then(res=>res.json()).then(res=>{
                    if(res.error){
                        this.errors = res.error
                    }else{
                        this.updatedStatus = true
                        this.loadQuota()
                    }
                })
            }
        }
    }
</script>