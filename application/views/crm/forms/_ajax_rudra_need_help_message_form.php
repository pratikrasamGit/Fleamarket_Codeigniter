
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
<div class="form-group col-sm-6">
	<label>Parent Id</label>
 	<input type="number"  name="parent_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->parent_id : ''); ?>"   placeholder="Parent Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Fk Admin Id</label>
 	<input type="number"  name="fk_admin_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->fk_admin_id : ''); ?>"   placeholder="Fk Admin Id"   />
</div>

<?php $options = $fk_help_type_id; ?>
<div class="form-group col-sm-6">

	<label>Fk Help Type Id</label>

	<select  id='fk_help_type_id'  name="fk_help_type_id" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_help_type_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->id?></option>
<?php  } ?>
	</select>
</div>
<div class="form-group col-sm-6">
	<label>Message</label>
 	<input type="text"  name="message" class="form-control" value="<?= (!empty($form_data) ? $form_data->message : ''); ?>"   placeholder="Message"   />
</div>
<div class="form-group col-sm-6">
	<label>File</label>
 	<input type="text"  name="file" class="form-control" value="<?= (!empty($form_data) ? $form_data->file : ''); ?>"   placeholder="File"   />
</div>
<div class="form-group col-sm-6">
	<label>Path</label>
 	<input type="text"  name="path" class="form-control" value="<?= (!empty($form_data) ? $form_data->path : ''); ?>"   placeholder="Path"   />
</div>
<div class="form-group col-sm-6">
	<label>Fullpath</label>
 	<input type="text"  name="fullpath" class="form-control" value="<?= (!empty($form_data) ? $form_data->fullpath : ''); ?>"   placeholder="Fullpath"   />
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
