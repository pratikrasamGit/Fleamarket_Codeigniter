<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>Abs Words</label>
 	<input type="text"  name="abs_words" class="form-control" value="<?= (!empty($form_data) ? $form_data->abs_words : ''); ?>"   placeholder="Abs Words"   />
</div>
</div>