<?php if (isset($module) && $module == "update-endtime") { ?>
    <div class="d-flex justify-content-between">
        <p>Liebe Id: <?php echo (isset($stream) && isset($stream->random_unique_id) && $stream->random_unique_id != "") ? $stream->random_unique_id : "-"; ?></p>
        <p>Name: <?php echo (isset($stream) && isset($stream->name) && $stream->name != "") ? $stream->name : "-"; ?></p>
    </div>
    <div class="d-flex justify-content-between">
        <p>Current EndTime: <?php echo $end_date = (isset($stream) && isset($stream->end_date) && $stream->end_date != "") ? date('d-M-Y h:i:s A', strtotime($stream->end_date)) :  date('d-M-Y h:i:s A', strtotime($stream->end_date)); ?></p>
        <p>Current Time: <?php $broad_time = (isset($stream) && isset($stream->broad_time) && $stream->broad_time != "") ? $stream->broad_time : "";
                            echo ($broad_time != "") ? sprintf('%02d', floor($broad_time / 3600)) . gmdate(":i:s", $broad_time % 3600) : "00:00:00";  ?></p>
    </div>
    <div class="form-group">
        <label for="">Choose End date & time</label>
        <?php $last_activity = (isset($stream) && isset($stream->last_activity) && $stream->last_activity != "") ? $stream->last_activity : "";
        $end_date1 = (isset($stream) && isset($stream->end_date) && $stream->end_date != "") ? date('d-M-Y h:i:s A', strtotime($stream->end_date)) :  "";
        $dates = ($end_date1 != "") ? $end_date1 : $last_activity;
        $dt_min = date_create($dates);
        $date = $dt_min->format('Y-m-d\TH:i:s'); ?>
        <input type="datetime-local" class="form-control" name="endate" value="<?php echo $date; ?>" id="endate">
    </div>
    <input type="hidden" value="<?php echo (isset($stream) && isset($stream->id) && $stream->id != "") ? $stream->id : ""; ?>" name="up_id">
<?php } else { ?>
<?php } ?>