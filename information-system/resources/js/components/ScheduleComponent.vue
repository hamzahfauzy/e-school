<template>
    <div>
        <div class="row">
            <div class="col-4 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addSchedule">
                Tambah Jadwal
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="deleteStatus">delete jadwal success</p>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pegawai</th>
                                    <th>Kelas ( Jurusan )</th>
                                    <th>Waktu</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(schedule,index) in schedules" :key="schedule.id">
                                    <td>{{index+1}}</td>
                                    <td>{{schedule.employee_study.employee.name}}</td>
                                    <td>{{schedule.employee_study.class_room.name}} ( {{schedule.employee_study.class_room.major.name}} )</td>
                                    <td>{{schedule.day}} , {{schedule.time_start}} - {{schedule.time_finish}}</td>
                                    <td>
                                        <!-- <a href="#editSchedule" data-toggle="modal" class="badge badge-primary" @click="findSchedule(schedule.id)">edit</a> -->
                                        <a href="#" @click="deleteSchedule(schedule.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!schedules.length" >
                                    <td colspan="5">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addSchedule">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jadwal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">tambah jadwal sukses</p>
                        <div class="form-group">
                            <label>Pegawai</label>
                            <select v-model="data.employee_id" @change="findEmployee" class="form-control">
                                <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{employee.name}}</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="eStatus">
                            <label>Mata Pelajaran ( Kelas )</label>
                            <select v-model="data.study_class" class="form-control">
                                <option v-for="(study,index) in employee.studies" :key="index" :value="{study_id:study.id , classroom_id:employee.class_rooms[index].id}">{{study.name}} ( {{employee.class_rooms[index].name}} )</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="eStatus">
                            <label>Hari</label>
                            <select v-model="data.day" class="form-control">
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jum'at">Jum'at</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="eStatus">
                            <label>Waktu</label>
                            <select v-model="data.time" class="form-control">
                                <option value="7.15-8.00">7.15-8.00</option>
                                <option value="8.00-8.45">8.00-8.45</option>
                                <option value="8.45-9.15">8.45-9.15</option>
                                <option value="9.15-10.00">9.15-10.00</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addSchedule()">Tambah Jadwal</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editSchedule">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Jadwal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">edit jadwal sukses</p>
                        <div class="form-group">
                            <label>Pegawai</label>
                            <select v-model="data.employee_id" @change="findEmployee" class="form-control">
                                <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{employee.name}}</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="eStatus">
                            <label>Mata Pelajaran ( Kelas )</label>
                            <select v-model="data.study_class" class="form-control">
                                <option v-for="(study,index) in employee.studies" :key="index" :value="{study_id:study.id , classroom_id:employee.class_rooms[index].id}">{{study.name}} ( {{employee.class_rooms[index].name}} )</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="eStatus">
                            <label>Hari</label>
                            <select v-model="data.day" class="form-control">
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jum'at">Jum'at</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="eStatus">
                            <label>Waktu</label>
                            <select v-model="data.time" class="form-control">
                                <option value="7.15-8.00">7.15-8.00</option>
                                <option value="8.00-8.45">8.00-8.45</option>
                                <option value="8.45-9.15">8.45-9.15</option>
                                <option value="9.15-10.00">9.15-10.00</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addSchedule()">Tambah Jadwal</button>
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
            schedules:{},
            data:{},
            token:'',
            headers:'',
            status:false,
            deleteStatus:false,
            employees:{},
            employee:{},
            eStatus:false,
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
        this.loadSchedules()
        this.getEmployees()
    },
    methods:{
        loadSchedules(){
            fetch('api/schedule',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.schedules = res
            })
        },
        findSchedule(id){
            fetch('api/schedule/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addSchedule(){
            this.data.study_id = this.data.study_class.study_id
            this.data.classroom_id = this.data.study_class.classroom_id
            fetch('api/schedule/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadSchedules()
            })
        },
        updateSchedule(){
            this.data.study_id = this.data.study_class.study_id
            this.data.classroom_id = this.data.study_class.classroom_id
            fetch('api/schedule/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadSchedules()
            })
        },
        deleteSchedule(schedule_id){
            fetch('api/schedule/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:schedule_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadSchedules()
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
        },
        findEmployee(e){
            fetch('api/employee/'+e.target.value,{
                headers:this.headers
            })
            .then(res=>res.json())
            .then(res=>{
                this.employee = res
                this.eStatus = true
            })
        }
    }
}
</script>