
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

<?php $options = $fk_purchased_id; ?>
<div class="form-group col-sm-6">

	<label>Fk Purchased Id</label>

	<select  id='fk_purchased_id'  name="fk_purchased_id" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_purchased_id == $dv->id)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv->id ?>"  ><?= $dv->id?></option>
<?php  } ?>
	</select>
</div>

<?php $options = $fk_type; ?>
<div class="form-group col-sm-6">

	<label>Fk Type</label>

	<select  id='fk_type'  name="fk_type" class="form-control" >
<?php 
 foreach($options as $dk => $dv) 
{
	 $selectop = '';
	 if(!empty($form_data) && $form_data->fk_type == $dv)
	{
		$selectop = 'selected="selected"';  
	} ?> 
	<option <?= $selectop ?> value="<?= $dv ?>"  ><?= $dv?></option>
<?php  } ?>
	</select>
</div>
</div>
<!--Uncomment if Scroll Required div -->
