<style>

</style>
<div id="message">

		<div class="row">
			<div class="col-sm-12 form-inline">
				<div class="form-group">
					<label for="filter" class="sr-only">Filter</label>
					<input type="text" class="form-control" v-model="filter" placeholder="Filter">
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<datatable :columns="columns" :data="messages" :filter-by="filter" style="margin-bottom: 5px;">
						<template scope="{ row }">
							<tr>
								<td width="3%">{{ row.AddTime | dateOnly('DD-MM-YYYY') }}</td>
								<td>{{ row.name }}</td>
								<td>{{ row.mobile }}</td>
								<td>{{ row.email }}</td>
								<td>{{ row.subject }}</td>
								<td width="25%">{{ row.message }}</td>
								<td>
									<?php if($this->session->userdata('accountType') != 'u'){?>
								
									<button type="button" class="button" @click="deleteMessage(row.id)">
										<i class="fa fa-trash"></i>
									</button>
									<?php }?>
								</td>
							</tr>
						</template>
					</datatable>
					<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
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

	new Vue({
		el: '#message',
		data(){
			return {
				messages: [],
				columns: [
                    { label: 'Send Date', field: 'created_at', align: 'center', filterable: false },
                    { label: 'Name', field: 'name', align: 'center', filterable: false },
                    { label: 'Mobile', field: 'mobile', align: 'center' },
                    { label: 'Email', field: 'email', align: 'center' },
                    { label: 'Subject', field: 'subject', align: 'center' },
                    { label: 'Message', field: 'message', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		filters: {
			dateOnly(datetime, format){
				return moment(datetime).format(format);
			}
		},
		created(){
			this.getMessage();
		},
		methods: {
			getMessage(){
				axios.get('/get_message').then(res => {
					this.messages = res.data;
				})
			},
            deleteMessage(id){
                if(confirm("Do you really want to delete message?")){
                        axios.post('/delete_message/'+id).then(res => {
                        this.getMessage()
                    })
                }
                
            }
		
		
		}
	})
</script>