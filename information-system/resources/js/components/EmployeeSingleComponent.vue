<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEmployee">
                Tambah Mata Pelajaran dan Ruang Kelas
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="deleteStatus">delete mata pelajaran dan ruang kelas success</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(study,index) in employeeStudies" :key="study.id">
                                    <td>{{index+1}}</td>
                                    <td>{{study.name}}</td>
                                    <td>{{employeeClassRooms[index].name}}</td>
                                    <td>
                                        <a href="#" class="badge badge-danger" @click="deleteStudy(study.id,employeeClassRooms[index].id)">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!employeeStudies.length" >
                                    <td colspan="8">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addEmployee">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <form @submit.prevent="addStudy">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Mata Pelajaran dan Ruang Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p v-if="status" class="alert alert-success">tambah mata pelajaran dan ruang kelas sukses</p>
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select v-model="data.study_id" class="form-control">
                                    <option v-for="study in studies" :key="study.id" :value="study.id">{{study.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ruang Kelas</label>
                                <select v-model="data.classroom_id" class="form-control">
                                    <option v-for="class_room in class_rooms" :key="class_room.id" :value="class_room.id">{{class_room.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Mata Pelajaran dan Ruang Kelas</button>
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
        employee:{}
    },
    data(){
        return{
            data:{},
            token:'',
            headers:'',
            status:false,
            deleteStatus:false,
            studies:{},
            class_rooms:{},
            employeeStudies:{},
            employeeClassRooms:{},
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
        this.loadEmployee()
        this.getStudies()
        this.getClassRooms()
    },
    methods:{
        loadEmployee(){
            fetch('../api/employee/'+this.employee.id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.employeeStudies = res.studies
                this.employeeClassRooms = res.class_rooms
            })
        },
        addStudy(){
            this.data.id = this.employee.id
            fetch('../api/employee/addStudy',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadEmployee()
            })
        },
        deleteStudy(study_id,classroom_id){
            this.data.id = this.employee.id
            this.data.study_id = study_id
            this.data.classroom_id = classroom_id
            fetch('../api/employee/deleteStudy',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadEmployee()
            })
        },    
        getStudies(){
            fetch('../api/study',{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.studies = res
            })
        },
        getClassRooms(){
            fetch('../api/class_room',{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.class_rooms = res
            })
        }
    }
}
</script>