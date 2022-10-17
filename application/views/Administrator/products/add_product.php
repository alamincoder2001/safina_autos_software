<style>
	div.sticky {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		background-color: #fbfbfb;
		padding-top: 50px;
		font-size: 20px;
		z-index: 10;
	}

	.v-select {
		margin-bottom: 5px;
	}

	.v-select.open .dropdown-toggle {
		border-bottom: 1px solid #ccc;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	#products label {
		font-size: 13px;
	}

	#products select {
		border-radius: 3px;
	}

	#products .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#products .add-button:hover {
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

	#products .custom-file-upload:hover {
		background-color: #41add6;
	}

	#customerImage {
		height: 100%;
	}

	.sticky {
		position: -webkit-sticky;
		/* Safari */
		position: sticky;
		top: 0;
	}
</style>
<div id="products">
	<div class="row sticky" style="margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
		<form @submit.prevent="saveProduct">
			<div class="col-md-5">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Product Id:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.Product_Code">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Category:</label>
					<div class="col-md-7">
						<v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name" @input="getSubCategories"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/category" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Sub Category:</label>
					<div class="col-md-7">
						<v-select v-bind:options="sub_categories" v-model="selectedSubCategory" label="name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/sub_category" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>


				<div class="form-group clearfix">
					<label class="control-label col-md-4">Product Name:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.Product_Name" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Is Brand:</label>
					<div class="col-md-8">
						<input type="checkbox" v-model="product.is_brand">
					</div>
				</div>

				<div class="form-group clearfix" :style="{display: product.is_brand ? '' : 'none'}">
					<label class="control-label col-md-4">Brand:</label>
					<div class="col-md-7">
						<v-select v-bind:options="brands" v-model="selectedBrand" label="brand_name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/brand" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix" :style="{display: product.is_brand ? '' : 'none'}">
					<label class="control-label col-md-4">MRP:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.mrp_rate" :required="product.is_brand ? true : false">
					</div>
				</div>


				<div class="form-group clearfix">
					<label class="control-label col-md-4">Unit:</label>
					<div class="col-md-7">
						<select class="form-control" v-if="units.length == 0"></select>
						<v-select v-bind:options="units" v-model="selectedUnit" label="Unit_Name" v-if="units.length > 0"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/unit" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Part No:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.part_no">
					</div>
				</div>
				<div class="form-group clearfix" style="margin-top: 20px;">
					<label class="control-label col-md-4">Image(multiple):</label>
					<div class="col-md-8">
						<input type="file" multiple id="multi_image" style="display: block;">
					</div>
				</div>
			</div>

			<div class="col-md-5">

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Net Weight:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.net_weight">
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">VAT:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.vat">
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Re-order level:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.Product_ReOrederLevel" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Purchase Rate:</label>
					<div class="col-md-8">
						<input type="text" id="purchase_rate" class="form-control" v-model="product.Product_Purchase_Rate" required v-bind:disabled="product.is_service ? true : false">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Sales Rate:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.Product_SellingPrice" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Wholesale Rate:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="product.Product_WholesaleRate" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Description:</label>
					<div class="col-md-8">
						<textarea class="form-control" v-model="product.description"></textarea>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4"></label>
					<div class="col-md-4">
						<input type="checkbox" v-model="product.is_website" id="isWebsite"> <label for="isWebsite">Is Website</label>
					</div>
					<!-- <label class="control-label col-md-4">Is Service:</label> -->
					<div class="col-md-4">
						<input type="checkbox" v-model="product.is_service" @change="changeIsService" id="isService"> <label for="isService">Is Service</label>
					</div>
				</div>
				<div class="form-group clearfix">


				</div>


				<div class="form-group clearfix">
					<div class="col-md-8 col-md-offset-4">
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
							<input type="file" ref="productImage" @change="previewImage" />
							Select Image
						</label>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="products" :filter-by="filter">
					<template scope="{ row }">
						<tr>
							<td>{{ row.Product_Code }}</td>
							<td>{{ row.Product_Name }}</td>
							<td>{{ row.part_no }}</td>
							<td>{{ row.ProductCategory_Name }}</td>
							<td>{{ row.sub_category_name }}</td>
							<td>{{ row.brand_name }}</td>
							<td>{{ row.mrp_rate }}</td>
							<td>{{ row.Product_Purchase_Rate }}</td>
							<td>{{ row.Product_SellingPrice }}</td>
							<td>{{ row.Product_WholesaleRate }}</td>
							<td>{{ row.vat }}</td>
							<td>{{ row.net_weight }}</td>
							<td>{{ row.is_service }}</td>
							<td>{{ row.is_website }}</td>
							<td>{{ row.Unit_Name }}</td>
							<td>
								<img v-if="row.image" :src="'/uploads/products/' + row.image" style="width: 100px;height: 100px;">
								<img v-else src="/assets/no_image.gif" style="width: 100px;height: 100px;">
							</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editProduct(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteProduct(row.Product_SlNo)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
								<button type="button" class="button" @click="window.location = `/Administrator/products/barcodeGenerate/${row.Product_SlNo}`">
									<i class="fa fa-barcode"></i>
								</button>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#products',
		data() {
			return {
				product: {
					Product_SlNo: '',
					Product_Code: "<?php echo $productCode; ?>",
					Product_Name: '',
					ProductCategory_ID: '',
					brand: '',
					mrp_rate: '',
					Product_ReOrederLevel: '',
					Product_Purchase_Rate: '',
					Product_SellingPrice: '',
					Product_WholesaleRate: 0,
					Unit_ID: '',
					vat: 0,
					net_weight: '',
					part_no: '',
					is_service: false,
					is_website: false,
					is_brand: false,
					description: '',
				},
				products: [],
				categories: [],
				selectedCategory: null,
				sub_categories: [],
				selectedSubCategory: null,
				brands: [],
				selectedBrand: null,
				units: [],
				selectedUnit: null,
				imageUrl: '',
				selectedFile: null,
				multiple_image_url: '',
				selectedMultipleImage: null,
				columns: [{
						label: 'Product Id',
						field: 'Product_Code',
						align: 'center',
						filterable: false
					},
					{
						label: 'Product Name',
						field: 'Product_Name',
						align: 'center'
					},
					{
						label: 'Part No',
						field: 'part_no',
						align: 'center'
					},
					{
						label: 'Category',
						field: 'ProductCategory_Name',
						align: 'center'
					},
					{
						label: 'Sub Category',
						field: 'sub_category_name',
						align: 'center'
					},
					{
						label: 'Brand',
						field: 'brand_name',
						align: 'center'
					},
					{
						label: 'MRP',
						field: 'mrp_rate',
						align: 'center'
					},
					{
						label: 'Purchase Price',
						field: 'Product_Purchase_Rate',
						align: 'center'
					},
					{
						label: 'Sales Price',
						field: 'Product_SellingPrice',
						align: 'center'
					},
					{
						label: 'Wholesale Price',
						field: 'Product_WholesaleRate',
						align: 'center'
					},
					{
						label: 'VAT',
						field: 'vat',
						align: 'center'
					},
					{
						label: 'Net Weight',
						field: 'net_weight',
						align: 'center'
					},
					{
						label: 'Is Service',
						field: 'is_service',
						align: 'center'
					},
					{
						label: 'Is Website',
						field: 'is_website',
						align: 'center'
					},
					{
						label: 'Unit',
						field: 'Unit_Name',
						align: 'center'
					},
					{
						label: 'Image',
						align: 'center',
						filterable: false
					},
					{
						label: 'Action',
						align: 'center',
						filterable: false
					}
				],
				page: 1,
				per_page: 10,
				filter: ''
			}
		},
		created() {
			this.getCategories();
			this.getBrands();
			this.getUnits();
			this.getProducts();

			setInterval(() => {
				this.getCategories();
				this.getBrands();
				this.getUnits();
			}, 5000);
		},
		methods: {
			previewImage() {
				if (event.target.files.length > 0) {
					this.selectedFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.selectedFile);
				} else {
					this.selectedFile = null;
					this.imageUrl = null;
				}
			},
			getSubCategories() {
				this.sub_categories = [];
				this.selectedSubCategory = null;
				if (this.selectedCategory != null) {
					axios.post('/get_sub_categories', {
						category_id: this.selectedCategory.ProductCategory_SlNo
					}).then(res => {
						this.sub_categories = res.data;
					})
				}
			},
			changeIsService() {
				if (this.product.is_service) {
					this.product.Product_Purchase_Rate = 0;
				}
			},

			getCategories() {
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},
			getBrands() {
				axios.get('/get_brands').then(res => {
					this.brands = res.data;
				})
			},
			getUnits() {
				axios.get('/get_units').then(res => {
					this.units = res.data;
				})
			},
			getProducts() {
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			saveProduct() {
				if (this.selectedCategory == null) {
					alert('Select category');
					return;
				}
				if (this.selectedUnit == null) {
					alert('Select unit');
					return;
				}
				if (this.product.is_brand) {
					if (this.selectedBrand == null) {
						alert("Select Brand");
						return;
					}
					this.product.brand = this.selectedBrand.brand_SiNo;
				} else {
					this.product.brand = null;
					this.product.mrp_rate = null;
				}

				if (this.selectedSubCategory != null) {
					this.product.sub_category_id = this.selectedSubCategory.id;
				}

				// if(this.imageUrl == ''){
				// 	alert('Upload Image');
				// 	return;
				// }

				if (this.selectedFile != null) {
					let image_name = this.selectedFile.name;
					let image_ext = image_name.substring(image_name.lastIndexOf('.') + 1);

					if (!["png", "jpeg", "jpg", "gif"].includes(image_ext)) {
						alert('Image format ' + image_ext + ' not support!');
						return;
					}
				}

				if (this.selectedBoxImage != null) {
					const image_name = this.selectedBoxImage.name;
					const image_ext = image_name.substring(image_name.lastIndexOf('.') + 1);

					if (!["png", "jpeg", "jpg", "gif"].includes(image_ext)) {
						alert('Box Image format ' + image_ext + ' not support!. (Support only png, jpeg, jpg, gif format)');
						return;
					}
				}
				let fd = new FormData();

				let files = $('#multi_image')[0].files;

				for (let i = 0; i < files.length; i++) {
					let image_name = files[i].name;
					let image_ext = image_name.substring(image_name.lastIndexOf('.') + 1);

					if (!["png", "jpeg", "jpg", "gif"].includes(image_ext)) {
						alert('Image format ' + image_ext + ' not support!');
						return;
					}
					fd.append("images[]", files[i]);
				}

				this.product.ProductCategory_ID = this.selectedCategory.ProductCategory_SlNo;
				this.product.Unit_ID = this.selectedUnit.Unit_SlNo;

				let url = '/add_product';
				if (this.product.Product_SlNo != 0) {
					url = '/update_product';
				}


				fd.append('userfile', this.selectedFile);
				fd.append('product', JSON.stringify(this.product));

				axios.post(url, fd)
					.then(res => {
						let r = res.data;
						alert(r.message);
						if (r.success) {
							this.clearForm();
							this.product.Product_Code = r.productId;
							this.getProducts();
						}
					})

			},
			editProduct(product) {
				let keys = Object.keys(this.product);
				keys.forEach(key => {
					this.product[key] = product[key];
				})

				this.product.is_service = product.is_service == 'true' ? true : false;
				this.product.is_website = product.is_website == 'true' ? true : false;

				this.selectedCategory = {
					ProductCategory_SlNo: product.ProductCategory_ID,
					ProductCategory_Name: product.ProductCategory_Name
				}

				this.selectedUnit = {
					Unit_SlNo: product.Unit_ID,
					Unit_Name: product.Unit_Name
				}

				if (product.brand) {
					this.product.is_brand = true;
					this.selectedBrand = {
						brand_SiNo: product.brand,
						brand_name: product.brand_name
					}
				} else {
					this.product.is_brand = false;
					this.selectedBrand = null;
				}

				if (product.sub_category_id) {
					this.selectedSubCategory = {
						id: product.sub_category_id,
						name: product.sub_category_name
					}
				} else {
					this.selectedSubCategory = null
				}

				if (product.image == null || product.image == '') {
					this.imageUrl = '';
				} else {
					this.imageUrl = '/uploads/products/' + product.image;
				}

			},
			deleteProduct(productId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_product', {
					productId: productId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getProducts();
					}
				})
			},
			clearForm() {
				let keys = Object.keys(this.product);
				keys.forEach(key => {
					if (typeof(this.product[key]) == "string") {
						this.product[key] = '';
					} else if (typeof(this.product[key]) == "number") {
						this.product[key] = 0;
					}
				})

				this.imageUrl = '';
				this.selectedFile = null;
			}
		}
	})
</script>