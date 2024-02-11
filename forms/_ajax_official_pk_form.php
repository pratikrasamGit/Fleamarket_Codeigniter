<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Pk Id</label>
 	<input type="number"  name="pk_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->pk_id : ''); ?>"   placeholder="Pk Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Status</label>
 	<input type="number"  name="status" class="form-control" value="<?= (!empty($form_data) ? $form_data->status : ''); ?>"   placeholder="Status"   />
</div>
<div class="form-group col-sm-6">
	<label>First User Id</label>
 	<input type="number"  name="first_user_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->first_user_id : ''); ?>"   placeholder="First User Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Second User Id</label>
 	<input type="number"  name="second_user_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->second_user_id : ''); ?>"   placeholder="Second User Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Winner Id</label>
 	<input type="number"  name="winner_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->winner_id : ''); ?>"   placeholder="Winner Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Bonus Amount</label>
 	<input type="text"  name="bonus_amount" class="form-control" value="<?= (!empty($form_data) ? $form_data->bonus_amount : ''); ?>"   placeholder="Bonus Amount"   />
</div>
<div class="form-group col-sm-6">
	<label>Added On</label>
 	<input type="datetime"  name="added_on" class="form-control" value="<?= (!empty($form_data) ? $form_data->added_on : ''); ?>"   placeholder="Added On"   />
</div>
</div>