<template>
    <div>
        <div class="row">
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEmployee">
                Tambah Pegawai
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success" v-if="deleteStatus">delete pegawai success</p>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No Hp</th>
                                    <th>Status Pegawai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(employee,index) in employees" :key="employee.id">
                                    <td>{{index+1}}</td>
                                    <td>{{employee.NIP}}</td>
                                    <td>{{employee.name}}</td>
                                    <td>{{employee.address}}</td>
                                    <td>{{employee.gender}}</td>
                                    <td>{{employee.phone_number}}</td>
                                    <td>{{employee.employee_status}}</td>
                                    <td>
                                        <a :href="'/employees/'+employee.name" class="badge badge-success">view</a>
                                        <a href="#editEmployee" data-toggle="modal" class="badge badge-primary" @click="findEmployee(employee.id)">edit</a>
                                        <a href="#" @click="deleteEmployee(employee.id)" class="badge badge-danger">delete</a>
                                    </td>
                                </tr>
                                <tr  v-if="!employees.length" >
                                    <td colspan="8">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="addEmployee">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">tambah pegawai sukses</p>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" class="form-control" v-model="data.NIP">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" v-model="data.gender" value="Laki-Laki" class="form-check-input">
                                    Laki - Laki
                                <i class="input-helper"></i>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" v-model="data.gender" value="Perempuan" class="form-check-input">
                                    Perempuan
                                <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No Hp</label>
                            <input type="text" class="form-control" v-model="data.phone_number">
                        </div>
                        <div class="form-group">
                            <label>Status Pegawai</label>
                            <input type="text" class="form-control" v-model="data.employee_status">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea v-model="data.address" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" @click="addEmployee()">Tambah Pegawai</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editEmployee">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="status" class="alert alert-success">edit pegawai sukses</p>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" class="form-control" v-model="data.NIP">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" v-model="data.gender" value="Laki-Laki" class="form-check-input">
                                    Laki - Laki
                                <i class="input-helper"></i>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" v-model="data.gender" value="Perempuan" class="form-check-input">
                                    Perempuan
                                <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No Hp</label>
                            <input type="text" class="form-control" v-model="data.phone_number">
                        </div>
                        <div class="form-group">
                            <label>Status Pegawai</label>
                            <input type="text" class="form-control" v-model="data.employee_status">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea v-model="data.address" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  @click="data = {}">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateEmployee()">Edit Pegawai</button>
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
            employees:{},
            data:{},
            token:'',
            headers:'',
            status:false,
            deleteStatus:false,
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
        this.loadEmployees()
    },
    methods:{
        loadEmployees(){
            fetch('api/employee',{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.employees = res
            })
        },
        findEmployee(id){
            fetch('api/employee/'+id,{
                headers:this.headers,
            })
            .then(res => res.json())
            .then(res=>{
                this.data = res
            })
        },
        addEmployee(){
            fetch('api/employee/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadEmployees()
            })
        },
        updateEmployee(){
            fetch('api/employee/update',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.loadEmployees()
            })
        },
        deleteEmployee(employee_id){
            fetch('api/employee/delete',{
                method:'delete',
                headers:this.headers,
                body:JSON.stringify({id:employee_id})
            })
            .then(res=>res.json())
            .then(res=>{
                this.deleteStatus = true
                this.loadEmployees()
            })
        }
    }
}
</script>