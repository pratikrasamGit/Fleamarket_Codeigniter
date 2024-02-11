<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Parent Id</label>
 	<input type="number"  name="parent_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->parent_id : ''); ?>"   placeholder="Parent Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Name</label>
 	<input type="text"  name="name" class="form-control" value="<?= (!empty($form_data) ? $form_data->name : ''); ?>"   placeholder="Name"   />
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
	<label>Abc</label>
 	<input type="number"  name="abc" class="form-control" value="<?= (!empty($form_data) ? $form_data->abc : ''); ?>"   placeholder="Abc"   />
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