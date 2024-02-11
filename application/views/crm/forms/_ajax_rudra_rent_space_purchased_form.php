
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
} ?>
	</select>
</div>

<?php $options = $fk_rent_space_id; ?>
<!-- <div class="form-group col-sm-6">

	<label>Fk Rent Space Id</label>

	<select  id='fk_rent_space_id'  name="fk_rent_space_id" class="form-control" readonly > -->
<?php 
//  foreach($options as $dk => $dv) 
// {
// 	 $selectop = '';
// 	 if(!empty($form_data) && $form_data->fk_rent_space_id == $dv->id)
// 	{
// 		$selectop = 'selected="selected"';  
?>
		<!-- <option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->id?></option> -->
<?php
	// } 
 // } 
 ?>
	<!--</ select>
</div> -->

<?php $options = $fk_payment_method_id; ?>
<div class="form-group col-sm-6">

	<label>Fk Payment Method Id</label>

	<select  id='fk_payment_method_id'  name="fk_payment_method_id" class="form-control" readonly >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_payment_method_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
?>
		<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->name?></option>
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
} 
?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Table No</label>
 	<input type="number"  name="table_no" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_no : ''); ?>"   placeholder="Table No" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Table Price</label>
 	<input type="text"  name="table_price" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_price : ''); ?>"   placeholder="Table Price" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Table Total Price</label>
 	<input type="text"  name="table_total_price" class="form-control" value="<?= (!empty($form_data) ? $form_data->table_total_price : ''); ?>"   placeholder="Table Total Price" readonly   />
</div>
<div class="form-group col-sm-6">
	<label>Transaction Id</label>
 	<input type="text"  name="transaction_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->transaction_id : ''); ?>"   placeholder="Transaction Id" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Purchased Key</label>
 	<input type="text"  name="purchased_key" class="form-control" value="<?= (!empty($form_data) ? $form_data->purchased_key : ''); ?>"   placeholder="Purchased Key" readonly  />
</div>
<div class="form-group col-sm-6">
	<label>Purchased Date</label>
 	<input type="date"  name="purchased_date" class="form-control" value="<?= (!empty($form_data) ? $form_data->purchased_date : ''); ?>"   placeholder="Purchased Date" readonly  />
</div>


</div>
<!--Uncomment if Scroll Required div -->
