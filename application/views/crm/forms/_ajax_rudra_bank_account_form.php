
<!--UNComment if SCROLL BAR required div class='col-sm-12' style='max-height:500px;overflow: auto;'-->
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">

<?php $options = $fk_user_id; ?>
<div class="form-group col-sm-6">

	<label>Fk User Id</label>

	<select  id='fk_user_id'  name="fk_user_id" class="form-control" readonly >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_user_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
?>
		<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->first_name?></option>
<?php
	} 
?> 
	
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Bank Holder Name</label>
 	<input type="text"  name="bank_holder_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->bank_holder_name : ''); ?>"   placeholder="Bank Holder Name" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Bank Name</label>
 	<input type="text"  name="bank_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->bank_name : ''); ?>"   placeholder="Bank Name" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Account Number</label>
 	<input type="text"  name="account_number" class="form-control" value="<?= (!empty($form_data) ? $form_data->account_number : ''); ?>"   placeholder="Account Number"  readonly />
</div>
<div class="form-group col-sm-6">
	<label>Registration Number</label>
 	<input type="text"  name="registration_number" class="form-control" value="<?= (!empty($form_data) ? $form_data->registration_number : ''); ?>"   placeholder="Registration Number"  readonly />
</div>

<?php $options = $status; ?>
<!-- <div class="form-group col-sm-6">

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
</div> -->
</div>
<!--Uncomment if Scroll Required div -->
