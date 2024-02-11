

<div class="form-group">
    <label>App Version</label>
    <input type="text" name="appv" class="form-control" placeholder="App Version" value="<?=  (!empty($appv)  ? $appv->meta_value : '') ?>" required />
</div>

<input type="hidden" name="id" value="<?=  (!empty($appv)  ? $appv->s_id : 0) ?>">