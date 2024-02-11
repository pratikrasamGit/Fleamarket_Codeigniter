
<!--UNComment if SCROLL BAR required div class='col-sm-12' style='max-height:500px;overflow: auto;'-->
<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Category Name</label>
 	<input type="text"  name="category_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->category_name : ''); ?>"   placeholder="Category Name" required  />
</div>
<div class="form-group col-sm-6">
	<label>Dnk Name</label>
 	<input type="text"  name="dnk_name" class="form-control" value="<?= (!empty($form_data) ? $form_data->dnk_name : ''); ?>"   placeholder="Dnk Name" required  />
</div>


</div>
<!--Uncomment if Scroll Required div -->
