<div class="form-group">
    <label>Status</label>
    <select name="ddlStatus" class="form-control">
   <option <?= (!empty($not) ? ($not->status == '1' ? 'selected="selected"' : '') : ''); ?> value="1">Active</option>
   <option <?= (!empty($not) ? ($not->status == '0' ? 'selected="selected"' : '') : ''); ?> value="0">De-Activate</option>
   </select>
</div>

<div class="form-group">
    <label>URL</label>
    <input type="text" name="txtUrl" class="form-control" placeholder="Leave Empty for download"  <?= (!empty($not) ? '' : 'required'); ?> />
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="">Banner Image</label>
            <input type="file" <?= (!empty($not) ? '' : 'required'); ?> class="form-control-file" name="banner_pic" id="banner_pic" placeholder="" aria-describedby="banner_pic">
        </div>
    </div>
    <?php if (!empty($not)) { ?>
        <div class="col-md-4">
            <img src="<?php echo base_url('uploads/admin/' . $not->image); ?>" height="60px" alt="Image" />
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">File</label>
            <input type="file" class="form-control-file" name="download_file" id="download_file" placeholder="" aria-describedby="download_file">
        </div>
    </div>

    <?php if (!empty($not)) { ?>
        <div class="col-md-4" style="margin-top:20px;">
            <a href="<?php echo base_url('uploads/admin/' . $not->link); ?>">View/Download</a>
        </div>
    <?php } ?>
   
</div>




<input type="hidden" name="id" value="<?= (!empty($not) ? $not->id : 0); ?>">