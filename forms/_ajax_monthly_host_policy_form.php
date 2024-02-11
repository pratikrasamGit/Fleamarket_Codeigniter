<div class="form-group">
    <label>Talent Level</label>
    <input type="text" name="talent_level" class="form-control" placeholder="Talent Level" value="<?php echo (isset($hmp) && $hmp->talent_level) ? $hmp->talent_level : ""; ?>" required />
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Days in Month</label>
            <input type="text" name="days_in_month" class="form-control" placeholder="Days in Month" value="<?php echo (isset($hmp) && $hmp->days_in_month) ? $hmp->days_in_month : ""; ?>" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Hours</label>
            <input type="text" name="hours" class="form-control" placeholder="Hours" value="<?php echo (isset($hmp) && $hmp->hours) ? $hmp->hours : ""; ?>" required />
        </div>
    </div>
</div>

<div class="form-group">
    <label>Completed Target</label>
    <input type="text" name="completed_target" class="form-control" placeholder="Completed Target" value="<?php echo (isset($hmp) && $hmp->completed_target) ? $hmp->completed_target : ""; ?>" required />
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Basic Salary In Dollars($)</label>
            <input type="number" name="basic_salary_in_dollars" class="form-control" step=".01" placeholder="Basic Salary In Dollars" value="<?php echo (isset($hmp) && $hmp->basic_salary_in_dollars) ? floatval(preg_replace("/[^-0-9\.]/", "", $hmp->basic_salary_in_dollars)) : "0"; ?>" required />
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Basic Salary In INR(&#8377;)</label>
            <input type="number" name="basic_salary_in_inr" class="form-control" step=".01" placeholder="Basic Salary In INR" value="<?php echo (isset($hmp) && $hmp->basic_salary_in_inr) ? floatval(preg_replace("/[^-0-9\.]/", "", $hmp->basic_salary_in_inr)) : "0"; ?>" required />
        </div>
    </div>
</div>

<div class="form-group">
    <label for="threshold">Threshold</label>
    <select class="form-control" id="threshold" name="threshold">
        <?php foreach ($options as $key => $opt) { ?>
            <option value="<?= $key; ?>" <?php echo ($hmp->threshold == $key) ? "selected" : ""; ?>><?= $opt; ?></option>
        <?php } ?>
    </select>
</div>




<input type="hidden" name="id" value="<?php echo (isset($hmp) && $hmp->id) ? $hmp->id : ""; ?>">