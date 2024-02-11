<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Host Id</label>
 	<input type="number"  name="host_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->host_id : ''); ?>"   placeholder="Host Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Game Id</label>
 	<input type="text"  name="game_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->game_id : ''); ?>"   placeholder="Game Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Wheel Id</label>
 	<input type="number"  name="wheel_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->wheel_id : ''); ?>"   placeholder="Wheel Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Amount</label>
 	<input type="number"  name="amount" class="form-control" value="<?= (!empty($form_data) ? $form_data->amount : ''); ?>"   placeholder="Amount"   />
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
	<label>Is Winner</label>
 	<input type="number"  name="is_winner" class="form-control" value="<?= (!empty($form_data) ? $form_data->is_winner : ''); ?>"   placeholder="Is Winner"   />
</div>
<div class="form-group col-sm-6">
	<label>Win Amount</label>
 	<input type="number"  name="win_amount" class="form-control" value="<?= (!empty($form_data) ? $form_data->win_amount : ''); ?>"   placeholder="Win Amount"   />
</div>
<div class="form-group col-sm-6">
	<label>Is Host</label>
 	<input type="number"  name="is_host" class="form-control" value="<?= (!empty($form_data) ? $form_data->is_host : ''); ?>"   placeholder="Is Host"   />
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