<div class="row">
    <div class="col-12 form-group">
        <label>Document Title</label>
        <input type="text" class="form-control" name="doctitle" placeholder="Please Enter Title" required >
    </div>
    <div class="col-12">
    <h5>Select Agencies</h5>
        <div class="form-group d-inline">
            <div class="radio radio-success d-inline">
                <input type="radio" name="rdbtype" class="rdbtype_cls" id="rdbtype_all" checked="checked">
                <label for="rdbtype_all" class="cr">All</label>
            </div>
        </div>

        <div class="form-group d-inline">
            <div class="radio radio-success d-inline">
                <input type="radio" name="rdbtype" class="rdbtype_cls" id="rdbtype_selected" >
                <label for="rdbtype_selected" class="cr">Selected</label>
            </div>
        </div>
    </div>
    <div class="col-12" id="divAgencyList" style="display:none;border:1px dotted #c0c0c0;padding:10px;">
        <strong>Select Agency</strong><br><br>
        <?php 
        if(!empty($agency_list))
        {
            foreach($agency_list as $ag)
            {
                ?>
                 <div class="form-group d-inline col-3" style="padding:5px;">
                    <div class="checkbox checkbox-fill d-inline">
                        <input type="checkbox" name="chkagency[]" value="<?= $ag->id ?>" id="<?= $ag->id ?>" >
                        <label for="<?= $ag->id ?>" class="cr"><?= ($ag->agency_code == '' ?$ag->name : $ag->agency_code) ?></label>
                    </div>
                </div>

                <?php

            }

        }
        ?>
           
    </div>
    <div class="col-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Document</span>
            </div>
            <div class="custom-file">
                <input type="file" required class="custom-file-input" name="agencydoc" id="agencydoc">
                <label class="custom-file-label" for="agencydoc">Choose document</label>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".rdbtype_cls").change(function(){
        rdb = this;
        $("#divAgencyList").slideUp();
        if(rdb.id == "rdbtype_selected")
        {
            $("#divAgencyList").slideDown();
        }
        //alert($(this).id);
    });
});
</script>