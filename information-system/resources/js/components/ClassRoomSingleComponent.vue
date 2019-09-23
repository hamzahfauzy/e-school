<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>Kelas {{class_room.name}} - {{class_room.major.name}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addClassRoom">
                Tambah Siswa
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="deleteStatus">delete ruang kelas success</p>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(student,index) in classRoomStudents" :key="student.id">
                                    <td>{{index+1}}</td>
                                    <td>{{student.name}}</td>
                                    <td>
                                        <a href="#" @click="deleteClassRoomStudent(student.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!classRoomStudents.length" >
                                    <td colspan="5">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addClassRoom">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <form @submit.prevent="addClassRoomStudent">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p v-if="status" class="alert alert-success">tambah siswa sukses</p>
                            <div class="form-group">
                                <label>Siswa</label>
                                <select class="form-control" v-model="data.student_id">
                                    <option v-for="student in students" :key="student.id" :value="student.id">{{student.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Ruang Kelas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    props:{
        class_room:{},
    },
    data(){
        return{
            data:{},
            students:{},
            classRoomStudents:{},
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
        this.loadStudents()
        this.getStudents()
        console.log(this.class_room)
    },
    methods:{
        loadStudents(){
            fetch('../api/class_room/'+this.class_room.id,{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.classRoomStudents = res.students 
            })
        },
        addClassRoomStudent(){
            this.data.id = this.class_room.id
            fetch('../api/class_room/addStudent',{
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
        deleteClassRoomStudent(student_id){
            fetch('../api/class_room/deleteStudent',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:this.class_room.id,student_id:student_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadStudents()
            })
        },
        getStudents(){
            fetch('../api/student',{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.students = res 
            })
        }
    }
}
</script>