
<!--UNComment if SCROLL BAR required div class='col-sm-12' style='max-height:500px;overflow: auto;'-->
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

<?php $options = $fk_package_id; ?>
<div class="form-group col-sm-6">

	<label>Fk Package Id</label>

	<select  id='fk_package_id'  name="fk_package_id" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_package_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->id?></option>
<?php  } ?>
	</select>
</div>

<?php $options = $fk_payment_method_id; ?>
<div class="form-group col-sm-6">

	<label>Fk Payment Method Id</label>

	<select  id='fk_payment_method_id'  name="fk_payment_method_id" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_payment_method_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->id?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Transaction Method</label>
 	<input type="text"  name="transaction_method" class="form-control" value="<?= (!empty($form_data) ? $form_data->transaction_method : ''); ?>"   placeholder="Transaction Method"   />
</div>
<div class="form-group col-sm-6">
	<label>Transaction Id</label>
 	<input type="text"  name="transaction_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->transaction_id : ''); ?>"   placeholder="Transaction Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Token</label>
 	<input type="text"  name="token" class="form-control" value="<?= (!empty($form_data) ? $form_data->token : ''); ?>"   placeholder="Token"   />
</div>
<div class="form-group col-sm-6">
	<label>Purchased Key</label>
 	<input type="text"  name="purchased_key" class="form-control" value="<?= (!empty($form_data) ? $form_data->purchased_key : ''); ?>"   placeholder="Purchased Key"   />
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
<div class="form-group col-sm-6">
	<label>Purchased Date</label>
 	<input type="date"  name="purchased_date" class="form-control" value="<?= (!empty($form_data) ? $form_data->purchased_date : ''); ?>"   placeholder="Purchased Date"   />
</div>

<?php $options = $is_auto; ?>
<div class="form-group col-sm-6">

	<label>Is Auto</label>

	<select  id='is_auto'  name="is_auto" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->is_auto == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Expire Date</label>
 	<input type="date"  name="expire_date" class="form-control" value="<?= (!empty($form_data) ? $form_data->expire_date : ''); ?>"   placeholder="Expire Date"   />
</div>
</div>
<!--Uncomment if Scroll Required div -->
