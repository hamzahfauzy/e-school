<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addClassRoom">
                Tambah Ruang Kelas
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="deleteStatus">delete ruang kelas success</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Wali Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(class_room,index) in class_rooms" :key="class_room.id">
                                    <td>{{index+1}}</td>
                                    <td>{{class_room.name}}</td>
                                    <td>{{class_room.major.name}}</td>
                                    <td>{{class_room.employee.name}}</td>
                                    <td>
                                        <a href="#editClassRoom" data-toggle="modal" class="badge badge-primary" @click="findClassRoom(class_room.id)">edit</a>
                                        <a href="#" @click="deleteClassRoom(class_room.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!class_rooms.length" >
                                    <td colspan="5">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addClassRoom">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <form @submit.prevent="addClassRoom">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Ruang Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p v-if="status" class="alert alert-success">tambah ruang kelas sukses</p>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" v-model="data.name">
                            </div>
                            <div class="form-group">
                                <label>Jurusan</label>
                                <select class="form-control" v-model="data.major_id">
                                    <option v-for="major in majors" :key="major.id" :value="major.id">{{major.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pegawai</label>
                                <select class="form-control" v-model="data.employee_id">
                                    <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{employee.name}}</option>
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

        <div class="modal fade" id="editClassRoom">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <form @submit.prevent="updateClassRoom">
                        <div class="modal-header">
                            <h5 class="modal-title">edit Ruang Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p v-if="status" class="alert alert-success">edit ruang kelas sukses</p>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" v-model="data.name">
                            </div>
                            <div class="form-group">
                                <label>Jurusan</label>
                                <select class="form-control" v-model="data.major_id">
                                    <option v-for="major in majors" :key="major.id" :value="major.id">{{major.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pegawai</label>
                                <select class="form-control" v-model="data.employee_id">
                                    <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{employee.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-primary">Edit Ruang Kelas</button>
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
        return{
            class_rooms:{},
            majors:{},
            employees:{},
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
        this.loadClassRooms()
        this.getMajors()
        this.getEmployees()
    },
    methods:{
        loadClassRooms(){
            fetch('api/class_room',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.class_rooms = res
            })
        },
        findClassRoom(id){
            fetch('api/class_room/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addClassRoom(){
            fetch('api/class_room/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadClassRooms()
            })
        },
        updateClassRoom(){
            fetch('api/class_room/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadClassRooms()
            })
        },
        deleteClassRoom(class_room_id){
            fetch('api/class_room/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:class_room_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadClassRooms()
            })
        },
        getMajors(){
            fetch('api/major',{
                headers:this.headers,
            })
            .then(res=>res.json())
            .then(res=>{
                this.majors = res
            })
        },
        getEmployees(){
            fetch('api/employee',{
                headers:this.headers,
            })
            .then(res=>res.json())
            .then(res=>{
                this.employees = res
            })
        }
    }
}
</script>