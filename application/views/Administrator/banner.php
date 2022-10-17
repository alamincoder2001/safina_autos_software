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
	#suppliers label{
		font-size:13px;
	}
	#suppliers select{
		border-radius: 3px;
	}
	#suppliers .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#suppliers .add-button:hover{
		background-color: #41add6;
		color: white;
	}
	#suppliers input[type="file"] {
		display: none;
	}
	#suppliers .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#suppliers .custom-file-upload:hover{
		background-color: #41add6;
	}

	#supplierImage{
		height: 100%;
	}
    .show-image{
        height: 150px;
        width: 150px;
    }
	.banner-img{
		height: 100px;
		width: 200px;
	}
	table tr,th,td{
		border: 1px solid #ddd;
		text-align: center;
		padding: 10px;
	}
</style>
<div id="banner">
    <div class="container " style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-6">
					<div>
						<img class="show-image" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
                         <img v-else :src="this.imageUrl"  class="show-image">
					</div>
					<form action="" v-on:submit.prevent="saveBanner">
           
					<div>
						<input type="file" name="image" id="image" class="form-control" style="height:35px;" @change="previewImage">
						<input type="submit" class="btn btn-success" style="margin-top:10px">
					</div>
					
				
					</form>

                </div>
				<div class="col-md-6">
					<h3 class="text-center">banner List</h3>
					<table style="width: 100%;">
						<thead>
							<tr>
								<td>SL</td>
								<td>Image</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							
							<tr v-for="(image, index) in banners">
								<td>{{index+1}}</td>
								<td><img :src="'/uploads/banner/'+image.banner" alt="" class="banner-img"></td>
								<td>
									<a href="#" @click="bannerEdit(image)"><i class="fa fa-pencil" ></i></a>
									<a href="javascript:void();" @click="imageDelete(image.id)"><i class="fa fa-trash text-danger"></i></a>
								</td>
							</tr>
						</tbody>
					</table>
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
		el: '#banner',
		data(){
			return {
				imageUrl: '',
				selectedFile: null,
				banners:[],
				id:'',
			}
		},
		created(){
			this.getBanner();
		},
		methods: {
			previewImage(){
                if(event.target.files.length > 0){
					this.selectedFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.selectedFile);
                   
				} else {
					this.selectedFile = null;
					this.imageUrl = null;
				}
			},
			getBanner(){
				axios.get('/get_banner').then(res=>{
					this.banners = res.data;
				})
			},
			bannerEdit(image){
				this.imageUrl = '/uploads/banner/'+image.banner;
				this.id = image.id;
			},
			imageDelete(id){
				
				let url = '/banner_delete/'+id;
				axios.post(url).then(res=>{
					alert('Banner deleted');
					this.getBanner();
				})
			},
			saveBanner(){
                let id = this.id;
				let url = '/add_banner';
				if(this.id != 0){
					url = '/update_banner/'+id;
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				axios.post(url, fd).then(res=>{
						this.id = '';
						this.imageUrl = '';
						$('#image').val('');
						alert('Image upload successfully');
						this.getBanner();
					
				})
			},
		}
	})
</script>