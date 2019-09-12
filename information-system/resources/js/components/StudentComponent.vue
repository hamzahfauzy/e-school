<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStudent">
                Tambah Siswa
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
                                <tr v-for="(student,index) in students" :key="student.id">
                                    <td>{{index+1}}</td>
                                    <td>{{student.name}}</td>
                                    <td>{{student.NISN}}</td>
                                    <td>{{student.name}}</td>
                                    <td>{{student.gender}}</td>
                                    <td>
                                        <a href="" class="badge badge-primary">edit</a>
                                        <a href="" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!students.length" >
                                    <td colspan="6">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addStudent">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">tambah siswa sukses</p>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" class="form-control" v-model="data.NISN">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" class="form-control" v-model="data.gender">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea v-model="data.address" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addStudent()">Tambah Siswa</button>
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
            data:{},
            token:'',
            headers:'',
            status:false
        }
    },
    created(){
        this.token = window.getCookie('eschool_token_app')
        this.headers = {
            'Authorization': 'Bearer '+this.token,
            'Content-Type':'application/json'
        }
        if(this.token === undefined || this.token === null || this.token === '' ){
            window.location = process.env.MIX_ES_URL+'/login'
        }
        this.loadStudents()
    },
    methods:{
        loadStudents(){
            fetch('api/student',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.students = res
            })
        },
        addStudent(){
            fetch('api/student/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadStudents()
            })
        },
        updateStudent(){
            fetch('api/student/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                
            })
        }
    }
}
</script>