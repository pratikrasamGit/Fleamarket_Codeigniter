<div class="row">

<div class="col-md-6">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id">
                <?php foreach ($categories as $c) { ?>
                    <option value="<?= $c->id; ?>" <?= (isset($gift) ? ($c->id == $gift->category_id ? "selected" : ""):'' ); ?>> <?= $c->name; ?> </option>
                <?php } ?>
            </select>
        </div>
</div>
<div class="form-group col-md-6">
    <label>Name</label>
    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo (isset($gift) && $gift->name) ? $gift->name : ""; ?>" required />
</div>


</div>

<div class="row">
    
    <div class="col-md-4">
        <div class="form-group">
            <label>Price</label>
            <input type="number" name="gift_id" class="form-control" placeholder="Amount" value="<?php echo (isset($gift) && $gift->g_cost) ? $gift->g_cost : ""; ?>" onkeyup="if(parseInt(this.value) <= 0){ this.value = 1; return false; }" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Diamonds</label>
            <input type="number" name="diamonds" class="form-control" placeholder="Amount" value="<?php echo (isset($gift) && $gift->credit) ? $gift->credit : ""; ?>" onkeyup="if(parseInt(this.value) <= 0){ this.value = 1; return false; }" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="Status">Status</label>
            <select class="form-control" id="Status" name="status">
                <?php foreach ($options as $key => $opt) { ?>
                    <option value="<?= $key; ?>" <?= (isset($gift) ? ($gift->status == $key ? "selected" : "") : ''); ?>><?= $opt; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="">Animation File<?= (isset($gift) ? ($gift->animUrl != NULL ?  '<span class="text-success"> '.$gift->animUrl.'</span>':'') : '') ?></label>
            <input type="file" class="form-control-file" name="json_file" id="json_file" placeholder=" " aria-describedby="fileHelpId">
        </div>
    </div>
    
    <div class="form-group col-md-4">
    <label>Activate Animation</label>
    <select name="ddlAnimation" class="form-control" >
        <option  <?= (isset($gift) ? ($gift->isAnim == 'false' ? "selected" : "") : ''); ?> value="false">OFF Animation</option>
        <option  <?= (isset($gift) ? ($gift->isAnim == 'true' ? "selected" : "") : ''); ?> value="true">ON Animation</option>
    </select>
</div>
</div>



<div class="row">
    <div class="col-md-9">
        <div class="form-group">
            <label for="">Dispaly Image</label>
            <input type="file" class="form-control-file" name="image" id="image" placeholder="" aria-describedby="fileHelpId">
        </div>
    </div>

    <?php if (isset($gift) && $gift->file != "") { ?>
        <div class="col-md-3">
            <img src="<?php echo base_url('uploads/gifts/' . $gift->file); ?>" height="60px" alt="Image" />
        </div>
    <?php } ?>
</div>

<input type="hidden" name="id" value="<?php echo (isset($gift) && $gift->id) ? $gift->id : ""; ?>">