
<!--UNComment if SCROLL BAR required div class='col-sm-12' style='max-height:500px;overflow: auto;'-->
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Name</label>
 	<input type="text"  name="name" class="form-control" value="<?= (!empty($form_data) ? $form_data->name : ''); ?>"   placeholder="Name"   />
</div>
<div class="form-group col-sm-6">
	<label>Pic</label>
 	<input type="text"  name="pic" class="form-control" value="<?= (!empty($form_data) ? $form_data->pic : ''); ?>"   placeholder="Pic"   />
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
</div>
<!--Uncomment if Scroll Required div -->
