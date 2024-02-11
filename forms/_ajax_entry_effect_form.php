<?php if ($module == "add") { ?>
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" placeholder="Title" value="" required />
    </div>
<?php } ?>

<div class="form-group">
    <label>Coins</label>
    <input type="text" name="coins" class="form-control" placeholder="Coins" value="<?php echo (isset($ee) && $ee->coins) ? $ee->coins : ""; ?>" required />
</div>

<?php if ($module == "add") { ?>
    <div class="form-group">
        <label for="">GIF</label>
        <input type="file" class="form-control-file" name="gifimage" id="gifimage" placeholder="" aria-describedby="fileHelpId" required>
    </div>
<?php } ?>

<div class="form-group">
    <label>Valid Days</label>
    <input type="number" name="valid_days" class="form-control" placeholder="Valid Days" value="<?php echo (isset($ee) && $ee->valid_days) ? $ee->valid_days : ""; ?>" required />
</div>

<div class="form-group">
    <label for="Status">Status</label>
    <select class="form-control" id="Status" name="status" required>
        <?php foreach ($options as $key => $opt) { ?>
            <option value="<?= $key; ?>" <?php echo ($ee->status == $key) ? "selected" : ""; ?>><?= $opt; ?></option>
        <?php } ?>
    </select>
</div>

<?php if ($module == "add") { ?>
    <div class="form-group">
        <label for="">Image</label>
        <input type="file" class="form-control-file" name="image" id="v" placeholder="" aria-describedby="fileHelpId" required>
    </div>
<?php } ?>

<input type="hidden" name="id" value="<?php echo (isset($ee) && $ee->id) ? $ee->id : ""; ?>">