
<div class='col-sm-12' style='max-height:500px;overflow: auto;'>
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">

<?php $options = $fk_user_id; ?>
<div class="form-group col-sm-6">

	<label>Fk User Id</label>

	<select  id='fk_user_id'  name="fk_user_id" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_user_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->id?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Market Name</label>
 	<input type="text"  name="market_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->market_name : ''); ?>"   placeholder="Market Name"   />
</div>
<div class="form-group col-sm-6">
	<label>Categories</label>
 	<input type="text"  name="categories" class="form-control" value="<?= (!empty($form_data) ? $form_data->categories : ''); ?>"   placeholder="Categories"   />
</div>

<?php $options = $recurring_type; ?>
<div class="form-group col-sm-6">

	<label>Recurring Type</label>

	<select  id='recurring_type'  name="recurring_type" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->recurring_type == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Start Date</label>
 	<input type="date"  name="start_date" class="form-control" value="<?= (!empty($form_data) ? $form_data->start_date : ''); ?>"   placeholder="Start Date"   />
</div>
<div class="form-group col-sm-6">
	<label>End Date</label>
 	<input type="date"  name="end_date" class="form-control" value="<?= (!empty($form_data) ? $form_data->end_date : ''); ?>"   placeholder="End Date"   />
</div>
<div class="form-group col-sm-6">
	<label>Start Time</label>
 	<input type="text"  name="start_time" class="form-control" value="<?= (!empty($form_data) ? $form_data->start_time : ''); ?>"   placeholder="Start Time"   />
</div>
<div class="form-group col-sm-6">
	<label>End Time</label>
 	<input type="text"  name="end_time" class="form-control" value="<?= (!empty($form_data) ? $form_data->end_time : ''); ?>"   placeholder="End Time"   />
</div>
<div class="form-group col-sm-6">
	<label>Description</label>
 	<input type="text"  name="description" class="form-control" value="<?= (!empty($form_data) ? $form_data->description : ''); ?>"   placeholder="Description"   />
</div>
<div class="form-group col-sm-6">
	<label>Address</label>
 	<input type="text"  name="address" class="form-control" value="<?= (!empty($form_data) ? $form_data->address : ''); ?>"   placeholder="Address"   />
</div>
<div class="form-group col-sm-6">
	<label>Landmark</label>
 	<input type="text"  name="landmark" class="form-control" value="<?= (!empty($form_data) ? $form_data->landmark : ''); ?>"   placeholder="Landmark"   />
</div>
<div class="form-group col-sm-6">
	<label>Zipcode</label>
 	<input type="text"  name="zipcode" class="form-control" value="<?= (!empty($form_data) ? $form_data->zipcode : ''); ?>"   placeholder="Zipcode"   />
</div>
<div class="form-group col-sm-6">
	<label>City</label>
 	<input type="text"  name="city" class="form-control" value="<?= (!empty($form_data) ? $form_data->city : ''); ?>"   placeholder="City"   />
</div>
<div class="form-group col-sm-6">
	<label>Contact Person</label>
 	<input type="text"  name="contact_person" class="form-control" value="<?= (!empty($form_data) ? $form_data->contact_person : ''); ?>"   placeholder="Contact Person"   />
</div>
<div class="form-group col-sm-6">
	<label>Contact Number</label>
 	<input type="text"  name="contact_number" class="form-control" value="<?= (!empty($form_data) ? $form_data->contact_number : ''); ?>"   placeholder="Contact Number"   />
</div>
<div class="form-group col-sm-6">
	<label>Contact Email</label>
 	<input type="text"  name="contact_email" class="form-control" value="<?= (!empty($form_data) ? $form_data->contact_email : ''); ?>"   placeholder="Contact Email"   />
</div>
<div class="form-group col-sm-6">
	<label>Total Shares</label>
 	<input type="text"  name="total_shares" class="form-control" value="<?= (!empty($form_data) ? $form_data->total_shares : ''); ?>"   placeholder="Total Shares"   />
</div>

<?php $options = $status; ?>
<div class="form-group col-sm-6">

	<label>Status</label>

	<select  id='status'  name="status" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->status == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>

<?php $options = $is_deleted; ?>
<div class="form-group col-sm-6">

	<label>Is Deleted</label>

	<select  id='is_deleted'  name="is_deleted" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->is_deleted == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>

<?php $options = $is_feature; ?>
<div class="form-group col-sm-6">

	<label>Is Feature</label>

	<select  id='is_feature'  name="is_feature" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->is_feature == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Is Main</label>
 	<input type="text"  name="is_main" class="form-control" value="<?= (!empty($form_data) ? $form_data->is_main : ''); ?>"   placeholder="Is Main"   />
</div>

<?php $options = $is_open; ?>
<div class="form-group col-sm-6">

	<label>Is Open</label>

	<select  id='is_open'  name="is_open" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->is_open == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Market Long</label>
 	<input type="text"  name="market_long" class="form-control" value="<?= (!empty($form_data) ? $form_data->market_long : ''); ?>"   placeholder="Market Long"   />
</div>
<div class="form-group col-sm-6">
	<label>Market Lat</label>
 	<input type="text"  name="market_lat" class="form-control" value="<?= (!empty($form_data) ? $form_data->market_lat : ''); ?>"   placeholder="Market Lat"   />
</div>
</div>
</div>
