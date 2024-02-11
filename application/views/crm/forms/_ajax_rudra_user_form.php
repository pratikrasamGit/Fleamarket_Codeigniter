
<div class='col-sm-12' style='max-height:500px;overflow: auto;'>
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Name</label>
 	<input type="text"  name="first_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->first_name : ''); ?>"   placeholder="Name" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Birth Date</label>
 	<input type="date"  name="birth_date" class="form-control" value="<?= (!empty($form_data) ? $form_data->birth_date : ''); ?>"   placeholder="Birth Date" readonly  />
</div>

<?php $options = $gender; ?>
<div class="form-group col-sm-6">

	<label>Gender</label>

	<select  id='gender'  name="gender" class="form-control" readonly >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->gender == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Location</label>
 	<input type="text"  name="location" class="form-control" value="<?= (!empty($form_data) ? $form_data->location : ''); ?>"   placeholder="Location" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Email Id</label>
 	<input type="text"  name="email_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->email_id : ''); ?>"   placeholder="Email Id"  readonly />
</div>

<?php $options = $social_type; ?>
<div class="form-group col-sm-6">

	<label>Social Type</label>

	<select  id='social_type'  name="social_type" class="form-control" readonly >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->social_type == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Profile Pic</label>
	<div>
		<img src="<?=base_url()?><?= (!empty($form_data) ? $form_data->profile_pic : ''); ?>">
	</div>
</div>
<div class="form-group col-sm-6">
	<label>Is Social Image</label>
 	<input type="number"  name="is_social_image" class="form-control" value="<?= (!empty($form_data) ? $form_data->is_social_image : ''); ?>"   placeholder="Is Social Image" readonly  />
</div>

<div class="form-group col-sm-6">
	<label>Mobile</label>
 	<input type="text"  name="mobile" class="form-control" value="<?= (!empty($form_data) ? $form_data->mobile : ''); ?>"   placeholder="Mobile" readonly  />
</div>

<div class="form-group col-sm-6">
	<label>User Long</label>
 	<input type="text"  name="user_long" class="form-control" value="<?= (!empty($form_data) ? $form_data->user_long : ''); ?>"   placeholder="User Long"  readonly />
</div>
<div class="form-group col-sm-6">
	<label>User Lat</label>
 	<input type="text"  name="user_lat" class="form-control" value="<?= (!empty($form_data) ? $form_data->user_lat : ''); ?>"   placeholder="User Lat"  readonly />
</div>
<div class="form-group col-sm-6">
	<label>Zip Code</label>
 	<input type="text"  name="zip_code" class="form-control" value="<?= (!empty($form_data) ? $form_data->zip_code : ''); ?>"   placeholder="Zip Code" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>City</label>
 	<input type="text"  name="city" class="form-control" value="<?= (!empty($form_data) ? $form_data->city : ''); ?>"   placeholder="City" readonly  />
</div>
</div>
</div>
