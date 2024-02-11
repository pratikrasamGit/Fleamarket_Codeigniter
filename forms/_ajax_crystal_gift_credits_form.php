<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">


<div class="form-group col-sm-6">
	<label>Quantity</label>
 	<input type="number"  name="quantity" class="form-control" value="<?= (!empty($form_data) ? $form_data->quantity : ''); ?>"   placeholder="Quantity"   />
</div>
<div class="form-group col-sm-6">
	<label>Credits</label>
 	<input type="number"  name="credits" class="form-control" value="<?= (!empty($form_data) ? $form_data->credits : ''); ?>"   placeholder="Credits"   />
</div>
<div class="form-group col-sm-6">
	<label>Total Credits</label>
 	<input type="number"  name="total_credits" class="form-control" value="<?= (!empty($form_data) ? $form_data->total_credits : ''); ?>"   placeholder="Total Credits"   />
</div>


</div>