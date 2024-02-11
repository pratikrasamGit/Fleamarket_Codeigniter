<div class="form-group">
    <label for="">Question</label>
    <input type="text" class="form-control" name="question" id="question" aria-describedby="helpId" placeholder="">
</div>
<div class="form-group">
    <label for="">End Date</label>
    <input type="text" class="form-control" id="d_week" name="end_date" autocomplete="off" />
</div>
<div id="textoptions" style="height:300px; overflow-y:auto;"></div>
<a name="" id="addOptions" class="btn btn-primary" href="#" role="button">Add option</a>
<script>
    $(document).ready(function() {
        $('#addOptions').on('click', function() {
            $('#textoptions').append('<div class="row align-items-end"> <div class="col-md-9 mb-3"> <div class="form-group mb-0"><label for="">Option</label><input type="text" class="form-control" name="options[]" required aria-describedby="helpId" placeholder=""></div> </div> <div class="col-md-3"><a class="btn btn-danger btn-xs remove mb-3" href="#" role="button">-</a></div></div>');

            return false; //prevent form submission
        });

        $('#textoptions').on('click', '.remove', function() {
            $(this).parent().parent().remove();
            return false;
        });
        $('#d_week').datepicker({
            daysOfWeekDisabled: "2"
        });
    });
</script>