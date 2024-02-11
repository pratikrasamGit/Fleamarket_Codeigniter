
<!--UNComment if SCROLL BAR required  -->
<div class='col-sm-12' style='max-height:500px;overflow: auto;'>
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
} 
?>
	</select>
</div>

<?php $options = $fk_market_id; ?>
<div class="form-group col-sm-6">

	<label>Fk Market Id</label>

	<select  id='fk_market_id'  name="fk_market_id" class="form-control" readonly >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_market_id == $dv->id)
	{
		$selectop = 'selected="selected"';
?>
		<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->market_name?></option>
<?php
	} 
} ?>
	</select>
</div>

<?php $options = $table_type; ?>
<div class="form-group col-sm-6">

	<label>Table Type</label>

	<select  id='table_type'  name="table_type" class="form-control" readonly >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->table_type == $dv)
	{
		$selectop = 'selected="selected"';  
?>
		<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php
	} 
} ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Table No</label>
 	<input type="number"  name="table_no" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_no : ''); ?>"   placeholder="Table No" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Table Rent Price</label>
 	<input type="text"  name="table_rent_price" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_rent_price : ''); ?>"   placeholder="Table Rent Price"   readonly />
</div>
<div class="form-group col-sm-6">
	<label>Table Rent Receive</label>
 	<input type="text"  name="table_rent_receive" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_rent_receive : ''); ?>"   placeholder="Table Rent Receive"   readonly />
</div>
<div class="form-group col-sm-6">
	<label>Table Rent Comission</label>
 	<input type="text"  name="table_rent_comission" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_rent_comission : ''); ?>"   placeholder="Table Rent Comission" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Table Rent Comission Percentage</label>
 	<input type="text"  name="table_rent_comission_percentage" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_rent_comission_percentage : ''); ?>"   placeholder="Table Rent Comission Percentage"  readonly />
</div>

<div class="form-group col-sm-6">
	<label>Image</label>
	<div>
		<img width="300" height="260" src="<?=base_url()?><?= (!empty($form_data) ? $form_data->file_path : ''); ?>/<?= (!empty($form_data) ? $form_data->file_name : ''); ?>">
	</div>
</div>
</div>
<!--Uncomment if Scroll Required div -->
