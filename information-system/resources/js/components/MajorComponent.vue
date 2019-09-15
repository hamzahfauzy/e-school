<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addMajor">
                Tambah Jurusan
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="deleteStatus">delete jurusan success</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(major,index) in majors" :key="major.id">
                                    <td>{{index+1}}</td>
                                    <td>{{major.name}}</td>
                                    <td>
                                        <a href="#editMajor" data-toggle="modal" class="badge badge-primary" @click="findMajor(major.id)">edit</a>
                                        <a href="#" @click="deleteMajor(major.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!majors.length" >
                                    <td colspan="3">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addMajor">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jurusan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">tambah jurusan sukses</p>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addMajor()">Tambah Jurusan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editMajor">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Jurusan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">edit jurusan sukses</p>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  @click="data = {}">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateMajor()">Edit Jurusan</button>
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
            majors:{},
            data:{},
            token:'',
            headers:'',
            status:false,
            deleteStatus:false
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
        this.loadMajors()
    },
    methods:{
        loadMajors(){
            fetch('api/major',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.majors = res
            })
        },
        findMajor(id){
            fetch('api/major/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addMajor(){
            fetch('api/major/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadMajors()
            })
        },
        updateMajor(){
            fetch('api/major/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadMajors()
            })
        },
        deleteMajor(major_id){
            fetch('api/major/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:major_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadMajors()
            })
        }
    }
}
</script>