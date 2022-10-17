<style>
	.v-select{
		margin-bottom: 5px;
	}
	.v-select.open .dropdown-toggle{
		border-bottom: 1px solid #ccc;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
		height: 25px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
	#products label{
		font-size:13px;
	}
	#products select{
		border-radius: 3px;
	}
	#products .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#products .add-button:hover{
		background-color: #41add6;
		color: white;
	}
	#products input[type="file"] {
		display: none;
	}
	#products .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#products .custom-file-upload:hover{
		background-color: #41add6;
	}
	#customerImage{
		height: 100%;
	}
</style>
<div id="products">
		<form @submit.prevent="saveCategory">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
			<div class="col-md-6 col-md-offset-2">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="category.ProductCategory_Name" required>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Description:</label>
					<div class="col-md-7">
						<textarea class="form-control" v-model="category.ProductCategory_Description"></textarea>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<div class="col-md-7 col-md-offset-4">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>

			</div>	

			<div class="col-md-2">
				<div class="form-group clearfix">
					<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
						<img id="customerImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
						<img id="customerImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
					</div>
					<div style="text-align:center;">
						<label class="custom-file-upload">
							<input type="file" @change="previewImage"/>
							Select Image
						</label>
					</div>
				</div>
			</div>
		</div>
		</form>

		<div class="row">
			<div class="col-sm-12 form-inline">
				<div class="form-group">
					<label for="filter" class="sr-only">Filter</label>
					<input type="text" class="form-control" v-model="filter" placeholder="Filter">
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<datatable :columns="columns" :data="categories" :filter-by="filter">
						<template scope="{ row }">
							<tr>
								<td>{{ row.ProductCategory_Name }}</td>
								<td>{{ row.ProductCategory_Description }}</td>
								<td>
									<img v-if="row.image" :src="'/uploads/categories/'+row.image" alt="" style="width: 100px; height: 100px;">
								</td>
								<td>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<button type="button" class="button edit" @click="editCategory(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteCategory(row.ProductCategory_SlNo)">
										<i class="fa fa-trash"></i>
									</button>
									<?php }?>
								</td>
							</tr>
						</template>
					</datatable>
					<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
				</div>
			</div>
		</div>


</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#products',
		data(){
			return {
				category: {
					ProductCategory_SlNo: 0,
					ProductCategory_Name: '',
					ProductCategory_Description: '',
				},
				categories: [],
				imageUrl: '',
				selectedFile: null,
				columns: [
                    { label: 'Name', field: 'ProductCategory_Name', align: 'center' },
                    { label: 'Description', field: 'ProductCategory_Description', align: 'center' },
                    { label: 'Image', field: 'image', align: 'center', filterable: false  },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: '',
				
			}
		},
		created(){
			this.getCategories();
		},
		methods:{
			previewImage(){
				if(event.target.files.length > 0){
					this.selectedFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.selectedFile);
				} else {
					this.selectedFile = null;
					this.imageUrl = null;
				}
			},
			getCategories(){
				axios.post('/get_categories', {order_by: 'desc'}).then(res => {
					this.categories = res.data;
				})
			},
			saveCategory(){

				let url = '/insertcategory';
				if(this.category.ProductCategory_SlNo != 0){
					url = '/updatecategory';
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.category));


				axios.post(url, fd)
				.then(res=>{
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.clearForm();
						this.getCategories();
					}
				})
				
			},
			editCategory(category){
				let keys = Object.keys(this.category);
				keys.forEach(key => {
					this.category[key] = category[key];
				})

				if(category.image == null || category.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/categories/'+category.image;
				}
			},
			deleteCategory(id){
				let deleteConfirm = confirm('Are you sure?');
				if(deleteConfirm == false){
					return;
				}
				axios.post('/catdelete', {id: id}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getCategories();
					}
				})
			},
			clearForm(){
				let keys = Object.keys(this.category);
				keys.forEach(key => {
					if(typeof(this.category[key]) == "string"){
						this.category[key] = '';
					} else if(typeof(this.category[key]) == "number"){
						this.category[key] = 0;
					}
				})

				this.imageUrl = '';
				this.selectedFile = null;
			}
		}
	})
</script>