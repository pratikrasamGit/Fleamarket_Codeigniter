
<!--UNComment if SCROLL BAR required --><div class='col-sm-12' style='max-height:500px;overflow: auto;'>
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>St Key</label>
 	<input type="text"  name="st_key" class="form-control" value="<?= (!empty($form_data) ? $form_data->st_key : ''); ?>"   placeholder="St Key"   />
</div>
<div class="form-group col-sm-12">
	<label>St Meta</label>
 	<!-- <input type="text"  name="st_meta" class="form-control" value="<?= (!empty($form_data) ? $form_data->st_meta : ''); ?>"   placeholder="St Meta"   /> -->
	 <textarea  name="st_meta" class="form-control ckeditor" id="st_meta" ><?= (!empty($form_data) ? html_entity_decode($form_data->st_meta) : ''); ?></textarea>

</div>
<div class="form-group col-sm-12">
	<label>Dnk Meta</label>
 	<!-- <input type="text"  name="dnk_meta" class="form-control" value="<?= (!empty($form_data) ? $form_data->dnk_meta : ''); ?>"   placeholder="Dnk Meta"   /> -->
	 <textarea  name="dnk_meta" class="form-control ckeditor" id="dnk_meta" ><?= (!empty($form_data) ? html_entity_decode($form_data->dnk_meta) : ''); ?></textarea>

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
</div>
<script> 
	CKEDITOR.replace( 'st_meta' );
	CKEDITOR.replace( 'dnk_meta' );
</script>
