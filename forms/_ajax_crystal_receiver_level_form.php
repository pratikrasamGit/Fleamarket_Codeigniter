<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Name</label>
 	<input type="text" required name="name" class="form-control" value="<?= (!empty($form_data) ? $form_data->name : ''); ?>"   placeholder="Name"   />
</div>
<div class="form-group col-sm-6">
	<label>Xp Range</label>
 	<input type="number" required name="xp_range" class="form-control" value="<?= (!empty($form_data) ? $form_data->xp_range : ''); ?>"   placeholder="Xp Range"   />
</div>
<div class="form-group col-sm-6">
	<label>Xp Earned</label>
 	<input type="number" required name="xp_earned" class="form-control" value="<?= (!empty($form_data) ? $form_data->xp_earned : ''); ?>"   placeholder="Xp Earned"   />
</div>
<div class="form-group col-sm-6">
	<label>Crystal Spent</label>
 	<input type="number" required name="crystal_spent" class="form-control" value="<?= (!empty($form_data) ? $form_data->crystal_spent : ''); ?>"   placeholder="Crystal Spent"   />
</div>
</div>