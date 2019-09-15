<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStudy">
                Tambah Mata Pelajaran
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
                                <tr v-for="(study,index) in studies" :key="study.id">
                                    <td>{{index+1}}</td>
                                    <td>{{study.name}}</td>
                                    <td>
                                        <a href="#editStudy" data-toggle="modal" class="badge badge-primary" @click="findStudy(study.id)">edit</a>
                                        <a href="#" @click="deleteStudy(study.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!studies.length" >
                                    <td colspan="3">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addStudy">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">tambah mata pelajaran sukses</p>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addStudy()">Tambah Mata Pelajaran</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editStudy">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Mata Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">edit mata pelajaran sukses</p>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  @click="data = {}">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateStudy()">Edit Mata Pelajaran</button>
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
            studies:{},
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
        this.loadStudies()
    },
    methods:{
        loadStudies(){
            fetch('api/study',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.studies = res
            })
        },
        findStudy(id){
            fetch('api/study/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addStudy(){
            fetch('api/study/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadStudies()
            })
        },
        updateStudy(){
            fetch('api/study/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadStudies()
            })
        },
        deleteStudy(study_id){
            fetch('api/study/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:study_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadStudies()
            })
        }
    }
}
</script>