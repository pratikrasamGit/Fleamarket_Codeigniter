<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Level</label>
 	<input type="text" required name="level_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->level_name : ''); ?>"   placeholder="Level"   />
</div>
<div class="form-group col-sm-6">
	<label>Pearl Target</label>
 	<input type="text" required name="pearl_required" class="form-control" value="<?= (!empty($form_data) ? $form_data->pearl_required : ''); ?>"   placeholder="Pearl Target"   />
</div>
<div class="form-group col-sm-6">
	<label>Salary INR</label>
 	<input type="text" required name="inr_salary" class="form-control" value="<?= (!empty($form_data) ? $form_data->inr_salary : ''); ?>"   placeholder="Salary INR"   />
</div>
<div class="form-group col-sm-6">
	<label>Salary USD</label>
 	<input type="text" required name="usd_salary" class="form-control" value="<?= (!empty($form_data) ? $form_data->usd_salary : ''); ?>"   placeholder="Salary USD"   />
</div>
<div class="form-group col-sm-6">
	<label>Pear Days</label>
 	<input type="text" required name="p_valid_days" class="form-control" value="<?= (!empty($form_data) ? $form_data->p_valid_days : ''); ?>"   placeholder="Pear Days"   />
</div>
<div class="form-group col-sm-6">
	<label>Pearl Hours</label>
 	<input type="text" required name="p_valid_hours" class="form-control" value="<?= (!empty($form_data) ? $form_data->p_valid_hours : ''); ?>"   placeholder="Pearl Hours"   />
</div>
<div class="form-group col-sm-6">
	<label>PD Days</label>
 	<input type="text" required name="pd_valid_days" class="form-control" value="<?= (!empty($form_data) ? $form_data->pd_valid_days : ''); ?>"   placeholder="PD Days"   />
</div>
<div class="form-group col-sm-6">
	<label>PD Hours</label>
 	<input type="text" required name="pd_valid_hours" class="form-control" value="<?= (!empty($form_data) ? $form_data->pd_valid_hours : ''); ?>"   placeholder="PD Hours"   />
</div>
</div>