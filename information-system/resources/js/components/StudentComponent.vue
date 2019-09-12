<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRole">
                <i class="ti-plus"></i> Tambah Siswa
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

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
            students:{},
            token:''
        }
    },
    created(){
        this.token = window.getCookie('eschool_token_app')
        if(this.token === undefined || this.token === null || this.token === '' ){
            window.href = process.env.MIX_ES_URL+'/login'
        }
    },
    methods:{
        loadStudents(){
            fetch('api/student')
        }
    }
}
</script>