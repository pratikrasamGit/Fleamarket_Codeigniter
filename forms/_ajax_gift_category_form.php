<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo (isset($category) && $category->name) ? $category->name : ""; ?>" required />
</div>
<div class="form-group">
    <label>Position</label>
    <input type="number" name="position" class="form-control" placeholder="Position" value="<?php echo (isset($category) && $category->position) ? $category->position : ""; ?>" onkeyup="if(parseInt(this.value) <= 0){ this.value = 1; return false; }" required />
</div>
<div class="form-group">
    <label for="Status">Status</label>
    <select class="form-control" id="Status" name="status">
        <?php foreach ($options as $key => $opt) { ?>
            <option value="<?= $key; ?>" <?php echo ($category->status == $key) ? "selected" : ""; ?>><?= $opt; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label for="is_default">Is Default</label>
    <select class="form-control" id="is_default" name="is_default">
        <?php foreach ($default_options as $dkey => $dopt) { ?>
            <option value="<?= $dkey; ?>" <?php echo ($category->is_default == $key) ? "selected" : ""; ?>><?= $dopt; ?></option>
        <?php } ?>
    </select>
</div>
<input type="hidden" name="id" value="<?php echo (isset($category) && $category->id) ? $category->id : ""; ?>">