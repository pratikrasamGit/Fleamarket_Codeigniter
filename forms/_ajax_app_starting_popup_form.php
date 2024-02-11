
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">

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
	<label>Display Time</label>
 	<input type="number"  name="display_time" required min="3" class="form-control" value="<?= (!empty($form_data) ? $form_data->display_time : ''); ?>"   placeholder="Display Time"   />
</div>
<div class="form-group col-sm-6">
	<label>Image </label>
 	<input type="file"  name="image_url" class="form-control" <?= (!empty($form_data) ? '' : 'required') ?>    placeholder="Image Url"   />
</div>
<?php
if(!empty($form_data)) 
{
?>
<div class="form-group col-sm-6">
	<img src="<?= base_url('uploads/admin').'/'.$form_data->image_url ?>" height="60" >
</div>
<?php 
}
?>

</div>
