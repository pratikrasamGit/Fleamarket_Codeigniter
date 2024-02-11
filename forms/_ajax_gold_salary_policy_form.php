
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Talent Level</label>
 	<input type="text"  name="talent_level" class="form-control" value="<?= (!empty($form_data) ? $form_data->talent_level : ''); ?>"   placeholder="Talent Level"   />
</div>
<div class="form-group col-sm-6">
	<label>Days In Month</label>
 	<input type="number"  name="days_in_month" class="form-control" value="<?= (!empty($form_data) ? $form_data->days_in_month : ''); ?>"   placeholder="Days In Month"   />
</div>
<div class="form-group col-sm-6">
	<label>Hours</label>
 	<input type="number"  name="hours" class="form-control" value="<?= (!empty($form_data) ? $form_data->hours : ''); ?>"   placeholder="Hours"   />
</div>
<div class="form-group col-sm-6">
	<label>Completed Target</label>
 	<input type="number"  name="completed_target" class="form-control" value="<?= (!empty($form_data) ? $form_data->completed_target : ''); ?>"   placeholder="Completed Target"   />
</div>
<div class="form-group col-sm-6">
	<label>Basic Salary In Inr</label>
 	<input type="text"  name="basic_salary_in_inr" class="form-control" value="<?= (!empty($form_data) ? $form_data->basic_salary_in_inr : ''); ?>"   placeholder="Basic Salary In Inr"   />
</div>
<div class="form-group col-sm-6">
	<label>Agency Fee Inr</label>
 	<input type="text"  name="agency_fee_inr" class="form-control" value="<?= (!empty($form_data) ? $form_data->agency_fee_inr : ''); ?>"   placeholder="Agency Fee Inr"   />
</div>
<div class="form-group col-sm-6">
	<label>Basic Salary In Dollars</label>
 	<input type="text"  name="basic_salary_in_dollars" class="form-control" value="<?= (!empty($form_data) ? $form_data->basic_salary_in_dollars : ''); ?>"   placeholder="Basic Salary In Dollars"   />
</div>
<div class="form-group col-sm-6">
	<label>Agency Fee Usd</label>
 	<input type="text"  name="agency_fee_usd" class="form-control" value="<?= (!empty($form_data) ? $form_data->agency_fee_usd : ''); ?>"   placeholder="Agency Fee Usd"   />
</div>
<div class="form-group col-sm-6">
	<label>Threshold</label>
 	<input type="number"  name="threshold" class="form-control" value="<?= (!empty($form_data) ? $form_data->threshold : ''); ?>"   placeholder="Threshold"   />
</div>
<div class="form-group col-sm-6">
	<label>Agency Group Id</label>
 	<input type="number"  name="agency_group_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->agency_group_id : ''); ?>"   placeholder="Agency Group Id"   />
</div>
</div>
