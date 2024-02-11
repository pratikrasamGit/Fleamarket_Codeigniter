<div class='row'><div class="form-group col-sm-6">
	<label>Tx Id</label>
 	<input type="number"  name="tx_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->tx_id : ''); ?>"   placeholder="Tx Id"   />
</div>
<div class="form-group col-sm-6">
	<label>User Id</label>
 	<input type="number"  name="user_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->user_id : ''); ?>"   placeholder="User Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Amount</label>
 	<input type="text"  name="amount" class="form-control" value="<?= (!empty($form_data) ? $form_data->amount : ''); ?>"   placeholder="Amount"   />
</div>
<div class="form-group col-sm-6">
	<label>Prev Balance</label>
 	<input type="text"  name="prev_balance" class="form-control" value="<?= (!empty($form_data) ? $form_data->prev_balance : ''); ?>"   placeholder="Prev Balance"   />
</div>
<div class="form-group col-sm-6">
	<label>New Balance</label>
 	<input type="text"  name="new_balance" class="form-control" value="<?= (!empty($form_data) ? $form_data->new_balance : ''); ?>"   placeholder="New Balance"   />
</div>
<div class="form-group col-sm-6">
	<label>Tx Type</label>
 	<input type="text"  name="tx_type" class="form-control" value="<?= (!empty($form_data) ? $form_data->tx_type : ''); ?>"   placeholder="Tx Type"   />
</div>
<div class="form-group col-sm-6">
	<label>Method Name</label>
 	<input type="text"  name="method_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->method_name : ''); ?>"   placeholder="Method Name"   />
</div>
<div class="form-group col-sm-6">
	<label>Tx Extra</label>
 	<input type="text"  name="tx_extra" class="form-control" value="<?= (!empty($form_data) ? $form_data->tx_extra : ''); ?>"   placeholder="Tx Extra"   />
</div>
<div class="form-group col-sm-6">
	<label>Added On</label>
 	<input type="datetime"  name="added_on" class="form-control" value="<?= (!empty($form_data) ? $form_data->added_on : ''); ?>"   placeholder="Added On"   />
</div>
</div>