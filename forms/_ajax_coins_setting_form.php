<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Coin Type</label>
 	<input type="number"  name="coin_type" class="form-control" value="<?= (!empty($form_data) ? $form_data->coin_type : ''); ?>"   placeholder="Coin Type"   />
</div>
<div class="form-group col-sm-6">
	<label>Coins</label>
 	<input type="number"  name="coins" class="form-control" value="<?= (!empty($form_data) ? $form_data->coins : ''); ?>"   placeholder="Coins"   />
</div>
<div class="form-group col-sm-6">
	<label>Base Price</label>
 	<input type="text"  name="base_price" class="form-control" value="<?= (!empty($form_data) ? $form_data->base_price : ''); ?>"   placeholder="Base Price"   />
</div>
<div class="form-group col-sm-6">
	<label>Coin Price</label>
 	<input type="number"  name="coin_price" class="form-control" value="<?= (!empty($form_data) ? $form_data->coin_price : ''); ?>"   placeholder="Coin Price"   />
</div>
<div class="form-group col-sm-6">
	<label>Discount Coins</label>
 	<input type="number"  name="discount_coins" class="form-control" value="<?= (!empty($form_data) ? $form_data->discount_coins : ''); ?>"   placeholder="Discount Coins"   />
</div>
<div class="form-group col-sm-6">
	<label>Google Console Id</label>
 	<input type="text"  name="google_console_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->google_console_id : ''); ?>"   placeholder="Google Console Id"   />
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
<div class="form-group col-sm-6">
	<label>Coin Image</label>
 	<input type="text"  name="coin_image" class="form-control" value="<?= (!empty($form_data) ? $form_data->coin_image : ''); ?>"   placeholder="Coin Image"   />
</div>
<div class="form-group col-sm-6">
	<label>Created At</label>
 	<input type="datetime"  name="created_at" class="form-control" value="<?= (!empty($form_data) ? $form_data->created_at : ''); ?>"   placeholder="Created At"   />
</div>
<div class="form-group col-sm-6">
	<label>Updated At</label>
 	<input type="datetime"  name="updated_at" class="form-control" value="<?= (!empty($form_data) ? $form_data->updated_at : ''); ?>"   placeholder="Updated At"   />
</div>
</div>