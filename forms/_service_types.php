<link rel="stylesheet" href="<?= base_url('app_') ?>assets/plugins/data-tables/css/datatables.min.css" /> <link rel="stylesheet" href="<?= base_url('app_') ?>assets/css/style.css" />
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [Total-user section] start -->
            <!--div class="col-sm-12">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="col-sm-3 float-right">
                            <div class="input-daterange input-group " id="datepicker_range">
                                <input type="text" class="form-control text-left" placeholder="Start date" id="start_date_stat" name="start">
                                <input type="text" class="form-control text-right" placeholder="End date" id="end_date_stat" name="end">
                            </div>
                        </div>
                    </div>
                </div>
            </div-->
            <div class="clear-fix clearfix"></div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    <div class="row">
                        <div class="col-sm-5">
                        <h5><?= $page_header ?></h5>
                        </div>
                            <div class="col-sm-7 text-right">
                                <button onclick="form_modal('service_types/post_actions/get_data?id=0','service_types/post_actions/insert_data','md','Update Details')" type="button" class="btn btn-glow-success btn-info" title="" data-toggle="tooltip" data-original-title="Add New Item" aria-describedby="tooltip651610">New</button>&nbsp;
                                <a href="service_types/post_actions/export_data" type="button" class="btn btn-glow-danger btn-warning" title="" data-toggle="tooltip" data-original-title="Export CSV" aria-describedby="tooltip651610">CSV</a>
                            
                                </div> 
                            </div> 
                        </div>

                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="responsive-table-modeldddd" class="display table dt-responsive nowrap table-striped table-hover user_post" style="width:100%">
                                <thead><tr>
<th>Id</th>
<th>Parent Id</th>
<th>Name</th>
<th>Status</th>
<th>Abc</th>
<th>Actions</th>
</tr>
 </thead>
  </table>
</div>
</div>
</div>
</div>
</div>
 <script src="<?= base_url('app_') ?>assets/plugins/data-tables/js/datatables.min.js"></script>
<script type="text/javascript">
var load_type = '<?= $load_type ?>';
var search_json = new Object();
search_json.load_type = load_type;
$('#ddlAgencyFilter').change(function() {
	$('.user_post').DataTable().ajax.reload();
});
 $('#start_date_stat').change(function() {
 if($(this).val() != '')
	{
	$('.user_post').DataTable().ajax.reload();
	}
 });
 $('#end_date_stat').change(function() {
 if($(this).val() != '')
	{	 $('.user_post').DataTable().ajax.reload()
};
 });
 $.fn.dataTable.ext.errMode = 'throw';
var usrTable;
fill_server_data_table(search_json);
function fill_server_data_table(search_json) {
	usrTable = $('.user_post').DataTable({
"processing": true,
"serverSide": true,
 fixedHeader: true,
responsive: true,
"ajax": {
	"url": "<?php echo base_url('service_types/list') ?>",
	"dataType": "json",
	"type": "POST",
	"data": {
	search_json: search_json,
	 start_date: function() {
	return $('#start_date_stat').val()
 },
	end_date: function() {
return $('#end_date_stat').val()
 	},
  }
 },	 "columns": [
{
		 "data": "id"
 },
{
		 "data": "parent_id"
 },
{
		 "data": "name"
 },
{
		 "data": "status"
 },
{
		 "data": "abc"
 },
	 {
		 "data": "actions"
},
 ],
 "columnDefs": [{
 targets: "_all",
 orderable: false
 }]
  });
 }
</script>
