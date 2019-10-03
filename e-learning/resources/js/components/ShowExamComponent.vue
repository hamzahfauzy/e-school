<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">

			<!-- CONTENT -->

	        <div class="content-wrapper">

	          	<div class="row">
					<div class="col-md-6 col-sm-12 grid-margin stretch-card">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnnouncement">
						Tambah Item Soal
						</button>
						&nbsp;
						<a href="/exams" class="btn btn-warning"><i class="ti ti-arrow-left"></i> Kembali</a>
					</div>
				</div>

				<!-- TABLE -->

				<div class="row">
					<div class="col-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<p class="alert alert-success" v-if="deleteStatus">Hapus Item Soal Berhasil</p>
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Judul</th>
											<th>Deskripsi</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(item,index) in items" :key="item.id">
											<td>{{index+1}}</td>
											<td>{{item.question.title}}</td>
											<td>{{item.question.description}}</td>
											<td>
												<a href="javascript:void(0)" @click="deleteItem(item.id)" class="badge badge-danger">Hapus</a>
											</td>
										</tr>
										<tr  v-if="!items.length" >
											<td colspan="4">Tidak ada data</td>
										</tr>
									</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- /TABLE -->

				<!-- ADD MODAL -->

				<div class="modal fade" id="addAnnouncement">
					<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Tambah Item Soal</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p v-if="status" class="alert alert-success">Tambah Item Soal Berhasil</p>
								<div class="form-group">
									<label>Soal</label>
									<select v-model="data.question_id" class="form-control">
										<option v-for="question in questions" :key="question.id" :value="question.id">{{question.title}}</option>
									</select>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" class="btn btn-primary" @click="addItem()">Tambah Item Soal</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /ADD MODAL -->

	        </div>

				<!-- /CONTENT -->
	        
			<footer-component></footer-component>
	    </div>
	</div>
</template>
<script>
export default {
    props:{
		role_id:0,
		exam_id:0,
		study_id:0,
	},
	data(){
        return{
            items:{},
            questions:{},
            data:{},
            token:'',
            headers:'',
            status:false,
			deleteStatus:false,
			employees:{},
			user_id:0,
			other_id:0,
			item_id:0,
			employee:{},
			eS:false
        }
    },
    async created(){
        this.token = window.getCookie('eschool_token_app')
        this.headers = {
            'Authorization': 'Bearer '+this.token,
            'Content-Type':'application/json'
        }
        if(this.token === undefined || this.token === null || this.token === '' ){
            window.location = window.config.MIX_ES_URL+'/login'
        }
        await this.fetchUserId()
        await this.loadItems()
        await this.loadQuestions()
    },
    methods:{

		// ANNOUNCEMENT
		async fetchUserId(){
            let response = await fetch(window.config.MIX_ES_URL+'/api/details',{
                method:'post',
                headers:this.headers
            });
            let data = await response.json()
            this.user_id = data.id
            this.other_id = data.other_id
            return data;
        },
        async loadItems(){
            var vm = this
            let response = await fetch('/api/exam_item/'+vm.exam_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.items = await data

            setTimeout(()=>{
                vm.status = false
                vm.deleteStatus = false
            },2500)
	        return data
        },
        async loadQuestions(){
        	var vm = this
            let response = await fetch('/api/question/'+vm.other_id,{
	            headers:vm.headers,
	        })
	        let data = await response.json()
	        this.questions = await data
	        return data
        },
        findAnswer(id){
            fetch('/api/exam_item/get/'+id,{
                headers:this.headers,
            })
            .then(res => res.json()) 
            .then(res=>{
                this.data = res
            })
        },
        addItem(){
        	this.data.exam_id = this.exam_id
            fetch('/api/exam_item/create',{
                method:'post',
                headers:this.headers,
                body:JSON.stringify(this.data)
            })
            .then(res=>res.json())
            .then(res=>{
                this.status = true
                this.data = {}
                this.loadItems()
            })
        },
        deleteItem(item_id){
        	var vm = this
        	Swal.fire({
			  title: 'Apakah anda yakin akan menghapus data ini?',
			  text: "Tindakan ini tidak dapat dikembalikan!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  cancelButtonText: 'Tidak',
			  confirmButtonText: 'Ya, Hapus data ini!'
			}).then((result) => {
			  if (result.value) {
			  	fetch('/api/exam_item/delete',{
	                method:'delete',
	                headers:vm.headers,
	                body:JSON.stringify({id:item_id,exam_id:vm.exam_id})
	            })
	            .then(res=>res.json())
	            .then(res=>{
	                vm.deleteStatus = true
	                vm.loadItems()
	                Swal.fire(
				      'Terhapus!',
				      'Data berhasil dihapus.',
				      'success'
				    )
	            })
			  }
			})
		},
    }
}
</script>