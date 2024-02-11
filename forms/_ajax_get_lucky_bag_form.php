<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Lucky Id</label>
 	<input type="number"  name="lucky_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->lucky_id : ''); ?>"   placeholder="Lucky Id"   />
</div>
<div class="form-group col-sm-6">
	<label>User Id</label>
 	<input type="number"  name="user_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->user_id : ''); ?>"   placeholder="User Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Coins</label>
 	<input type="number"  name="coins" class="form-control" value="<?= (!empty($form_data) ? $form_data->coins : ''); ?>"   placeholder="Coins"   />
</div>
<div class="form-group col-sm-6">
	<label>Added On</label>
 	<input type="datetime"  name="added_on" class="form-control" value="<?= (!empty($form_data) ? $form_data->added_on : ''); ?>"   placeholder="Added On"   />
</div>
<div class="form-group col-sm-6">
	<label>Updated On</label>
 	<input type="datetime"  name="updated_on" class="form-control" value="<?= (!empty($form_data) ? $form_data->updated_on : ''); ?>"   placeholder="Updated On"   />
</div>
</div>