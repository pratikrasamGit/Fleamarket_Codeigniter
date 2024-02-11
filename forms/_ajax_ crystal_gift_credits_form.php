<div class='row'><input type="hidden" required name="id" value="<?= (isset($id) ? $id : 0); ?>">
<div class="form-group col-sm-6">
	<label>From User Id</label>
 	<input type="number"  name="from_user_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->from_user_id : ''); ?>"   placeholder="From User Id"   />
</div>
<div class="form-group col-sm-6">
	<label>To User Id</label>
 	<input type="number"  name="to_user_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->to_user_id : ''); ?>"   placeholder="To User Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Streaming Id</label>
 	<input type="number"  name="streaming_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->streaming_id : ''); ?>"   placeholder="Streaming Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Gift Id</label>
 	<input type="number"  name="gift_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->gift_id : ''); ?>"   placeholder="Gift Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Coin Id</label>
 	<input type="number"  name="coin_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->coin_id : ''); ?>"   placeholder="Coin Id"   />
</div>
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
<div class="form-group col-sm-6">
	<label>Added On</label>
 	<input type="text"  name="added_on" class="form-control" value="<?= (!empty($form_data) ? $form_data->added_on : ''); ?>"   placeholder="Added On"   />
</div>
<div class="form-group col-sm-6">
	<label>Sender Xp</label>
 	<input type="number"  name="sender_xp" class="form-control" value="<?= (!empty($form_data) ? $form_data->sender_xp : ''); ?>"   placeholder="Sender Xp"   />
</div>
<div class="form-group col-sm-6">
	<label>Sender Xp Before</label>
 	<input type="number"  name="sender_xp_before" class="form-control" value="<?= (!empty($form_data) ? $form_data->sender_xp_before : ''); ?>"   placeholder="Sender Xp Before"   />
</div>
<div class="form-group col-sm-6">
	<label>Sender Xp Update</label>
 	<input type="number"  name="sender_xp_update" class="form-control" value="<?= (!empty($form_data) ? $form_data->sender_xp_update : ''); ?>"   placeholder="Sender Xp Update"   />
</div>
<div class="form-group col-sm-6">
	<label>Is Sender Level Increase</label>
 	<input type="number"  name="is_sender_level_increase" class="form-control" value="<?= (!empty($form_data) ? $form_data->is_sender_level_increase : ''); ?>"   placeholder="Is Sender Level Increase"   />
</div>
<div class="form-group col-sm-6">
	<label>Reciever Xp</label>
 	<input type="number"  name="reciever_xp" class="form-control" value="<?= (!empty($form_data) ? $form_data->reciever_xp : ''); ?>"   placeholder="Reciever Xp"   />
</div>
<div class="form-group col-sm-6">
	<label>Reciever Xp Before</label>
 	<input type="number"  name="reciever_xp_before" class="form-control" value="<?= (!empty($form_data) ? $form_data->reciever_xp_before : ''); ?>"   placeholder="Reciever Xp Before"   />
</div>
<div class="form-group col-sm-6">
	<label>Reciever Xp Update</label>
 	<input type="number"  name="reciever_xp_update" class="form-control" value="<?= (!empty($form_data) ? $form_data->reciever_xp_update : ''); ?>"   placeholder="Reciever Xp Update"   />
</div>
<div class="form-group col-sm-6">
	<label>Reciever Xp Bonus</label>
 	<input type="number"  name="reciever_xp_bonus" class="form-control" value="<?= (!empty($form_data) ? $form_data->reciever_xp_bonus : ''); ?>"   placeholder="Reciever Xp Bonus"   />
</div>
<div class="form-group col-sm-6">
	<label>Is Reciever Level Increase</label>
 	<input type="number"  name="is_reciever_level_increase" class="form-control" value="<?= (!empty($form_data) ? $form_data->is_reciever_level_increase : ''); ?>"   placeholder="Is Reciever Level Increase"   />
</div>
<div class="form-group col-sm-6">
	<label>Multi Mode</label>
 	<input type="number"  name="multi_mode" class="form-control" value="<?= (!empty($form_data) ? $form_data->multi_mode : ''); ?>"   placeholder="Multi Mode"   />
</div>
<div class="form-group col-sm-6">
	<label>Multi Mode Id</label>
 	<input type="number"  name="multi_mode_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->multi_mode_id : ''); ?>"   placeholder="Multi Mode Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Pk Mode Id</label>
 	<input type="number"  name="pk_mode_id" class="form-control" value="<?= (!empty($form_data) ? $form_data->pk_mode_id : ''); ?>"   placeholder="Pk Mode Id"   />
</div>
<div class="form-group col-sm-6">
	<label>Pk Mode</label>
 	<input type="number"  name="pk_mode" class="form-control" value="<?= (!empty($form_data) ? $form_data->pk_mode : ''); ?>"   placeholder="Pk Mode"   />
</div>
<div class="form-group col-sm-6">
	<label>G Type</label>
 	<input type="text"  name="g_type" class="form-control" value="<?= (!empty($form_data) ? $form_data->g_type : ''); ?>"   placeholder="G Type"   />
</div>
<div class="form-group col-sm-6">
	<label>Old Tot</label>
 	<input type="text"  name="old_tot" class="form-control" value="<?= (!empty($form_data) ? $form_data->old_tot : ''); ?>"   placeholder="Old Tot"   />
</div>
<div class="form-group col-sm-6">
	<label>Old Quant</label>
 	<input type="text"  name="old_quant" class="form-control" value="<?= (!empty($form_data) ? $form_data->old_quant : ''); ?>"   placeholder="Old Quant"   />
</div>
</div>