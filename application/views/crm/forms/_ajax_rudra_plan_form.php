
<!--UNComment if SCROLL BAR required div class='col-sm-12' style='max-height:500px;overflow: auto;'-->
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Plan Name</label>
 	<input type="text"  name="plan_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->plan_name : ''); ?>"   placeholder="Plan Name" required />
</div>
<div class="form-group col-sm-6">
	<label>Dnk Name</label>
 	<input type="text"  name="dnk_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->dnk_name : ''); ?>"   placeholder="Dnk Name" required />
</div>
<div class="form-group col-sm-6">
	<label>Price</label>
 	<input type="number"  name="price" class="form-control" value="<?= (!empty($form_data) ? $form_data->price : ''); ?>"   placeholder="Price" required />
</div>
<div class="form-group col-sm-6">
	<label>Discount Price</label>
 	<input type="number"  name="discount_price" class="form-control" value="<?= (!empty($form_data) ? $form_data->discount_price : ''); ?>"   placeholder="Discount Price"   />
</div>
<!-- <div class="form-group col-sm-6">
	<label>Picture Count</label>
 	<input type="number"  name="picture_count" class="form-control" value="<?= (!empty($form_data) ? $form_data->picture_count : ''); ?>"   placeholder="Picture Count"   />
</div> -->
<div class="form-group col-sm-12">
	<label>Plan Description</label>
 	<textarea name="plan_description" class="form-control" placeholder="Plan Description" required ><?= (!empty($form_data) ? $form_data->plan_description : ''); ?></textarea>
</div>
<div class="form-group col-sm-12">
	<label>Dnk Description</label>
 	<textarea name="dnk_description" class="form-control" placeholder="Dnk Description" required ><?= (!empty($form_data) ? $form_data->dnk_description : ''); ?></textarea>
</div>
</div>
<!--Uncomment if Scroll Required div -->
