  <div class='col-sm-12' style='max-height:500px;overflow: auto;'>
  <div class='row'>
    <input type="hidden" required name="tbl_name" value="<?= $table?>">
<?php 
$json_data = json_decode($json);
//echo '<pre>';print_r($json_data);
if(!empty($json_data))
{
    $cnt = 0;
    foreach($json_data as $jsn)
    {
       ?>
    <div class="form-group col-sm-3">
	<label><?= $jsn->col_name ?></label>
 	<input type="text" readonly  name="pst[<?= $cnt ?>][col_name]" class="form-control" value="<?= $jsn->col_name ?>"   placeholder="<?=  $jsn->col_name?>"   />
</div>
     
<div class="form-group col-sm-3">
	<label>Display Text</label>
 	<input type="text"  name="pst[<?= $cnt ?>][list_caption]" class="form-control" value="<?= $jsn->list_caption ?>"   placeholder="<?=  $jsn->list_caption?>"   />
</div>
<input type="hidden"  name="pst[<?= $cnt ?>][form_type]" value="<?= $jsn->form_type ?>">
<input type="hidden"  name="pst[<?= $cnt ?>][p_key]" value="<?= $jsn->p_key ?>">
<?php 
//$ddl_options = json_decode($jsn->ddl_options);
 if(is_array($jsn->ddl_options) && !empty($jsn->ddl_options))
 {
     //echo 'kkll';
     foreach($jsn->ddl_options as $k =>$val)
     {
        ?>
        <input type="hidden"  name="pst[<?= $cnt ?>][ddl_options][<?= $k ?>]" value="<?= $val ?>">
        <?php 
     }

 }
 else
 {
     ?>
     
     <input type="hidden"  name="pst[<?= $cnt ?>][ddl_options]" value="<?= json_encode(array()) ?>">
     <?php
 }
?>
<div class="form-group col-sm-2">
	<label>Required</label>
 	<select class="form-control" name="pst[<?= $cnt ?>][required]" >
        <option <?= ($jsn->required != 'required' ? 'selected="selected"' : '') ?> value="">Not</option>
        <option <?= ($jsn->required == 'required' ? 'selected="selected"' : '') ?>  value="required">Yes</option>
     </select>
</div>
<div class="form-group col-sm-2">
	<label>Show in List</label>
 	<select class="form-control" name="pst[<?= $cnt ?>][list]" >
        <option <?= ($jsn->list == 1 ? 'selected="selected"' : '') ?> value="1">Yes</option>
        <option <?= ($jsn->list == 0 ? 'selected="selected"' : '') ?> value="0">No</option>
     </select>
</div>

<div class="form-group col-sm-2 divddlfk<?= $cnt?>">
	<label>Foreign Key</label>
 	<select class="form-control fk_ddl" data-unique-count="<?= $cnt?>" id="ddlfk<?= $cnt?>"  name="pst[<?= $cnt ?>][f_key]" >
        <option <?= ($jsn->f_key == 0 ? 'selected="selected"' : '') ?> value="0">No</option>
        <option <?= ($jsn->f_key == 1 ? 'selected="selected"' : '') ?> value="1">Yes</option>
     </select>
</div>
<input type="hidden"  name="pst[<?= $cnt ?>][join_type]" value="<?= json_encode($jsn->join_type) ?>">
<input type="hidden"  name="pst[<?= $cnt ?>][small_list]" value="<?= json_encode($jsn->small_list) ?>">
<?php 
//JOIN HTML Logics
if($jsn->f_key)
{
?>
<div class="form-group col-sm-3 ddlfk<?= $cnt?>">
	<label>Ref. Table</label><span class="text-danger">*</span>
 	<select class="form-control" onchange="loadRefTableCols(this)" data-serial-count="<?= $cnt?>" id="idddlfk<?= $cnt?>" data-ref-class="ddlfk<?= $cnt?>"  name="pst[<?= $cnt ?>][ref_table]" >
     <option value="">Please Select</option>
     <?php
     foreach($all_tables as $tbl)
     {
         $tbl_name = $tbl->table_name;
         ?>
         <option <?= ($jsn->ref_table == $tbl_name ? 'selected="selected"' : '') ?> value="<?= $tbl_name ?>"><?= $tbl_name ?></option>;
    <?php
     
     } 
     ?>
     </select>
</div>

<?php
     $tbl_desc = $this->db->query("SHOW FULL COLUMNS FROM ".$jsn->ref_table)->result();
     $ref_call = 'ddlfk'.$cnt;
     $ref_callch = $ref_call .' chld'.$ref_call;
     $html1 = '<div class="form-group col-sm-3 '.$ref_callch.'"><label>Display Column<span class="text-danger">*</span></label><select name="pst['.$cnt.'][disp_col]" data-serial-count="'.$cnt.'" onchange="fillColName(this)"  id="refcoldisp'.$ref_call.'" data-ref-class="'.$ref_call.'" required class="form-control reftable ref'.$ref_call.'"><option value="">Please Select</option>';
     $html2 = '<div class="form-group col-sm-3 '.$ref_callch.'"><label>Display Text<span class="text-danger">*</span></label><input value="'.(isset($jsn->disp_col_caption) ? $jsn->disp_col_caption : '').'" type="text" name="pst['.$cnt.'][disp_col_caption]" id="txtrefcoldisp'.$ref_call.'" data-ref-class="'.$ref_call.'" required class="form-control reftable ref'.$ref_call.'"></div>';
     $html = '';
     $refkey = (isset($jsn->ref_key) ? $jsn->ref_key : '');
     $dispcol = (isset($jsn->disp_col) ? $jsn->disp_col : '');
     foreach($tbl_desc as $tbd)
     {
         
         $col_name = $tbd->Field;
         $selected = ($tbd->Field == $refkey ? 'selected="selected"' : '');
         $html .= "<option $selected value='$col_name'>$col_name</option>";
         $selected_display = ($tbd->Field == $dispcol ? 'selected="selected"' : '');
         $html1 .= "<option $selected_display value='$col_name'>$col_name</option>";
     } 
     ?>

<div class="form-group col-sm-3 <?= $ref_callch?>">
	<label>Ref. Key</label><span class="text-danger">*</span>
 	<select class="form-control"  data-serial-count="<?= $cnt?>" id="refcolddlfk<?= $cnt?>" data-ref-class="ddlfk<?= $cnt?>"  name="pst[<?= $cnt ?>][ref_key]" >
     <option value="">Please Select</option>
    <?= $html ?>
     </select>
</div>
<?= $html1.'</select></div>' ?>
<?= $html2 ?>

<?php
}
?>
       <?php
       $cnt++;
    }
}
?>
</div>
</div>

<script type="text/javascript">
    $('.fk_ddl').change(function(){
        var did = $(this).attr('id');
        var serialCount = $("#"+did).attr('data-unique-count');
        var selectedVal = $(this).val();
        if(selectedVal == '1')
        {
            $.ajax({
			type: 'POST',
			url: '<?= base_url() ?>crudmaster/post_actions/get_fk_table?ref_class='+did+'&serial_count='+serialCount,
			data: {},
			success: function(data) {
				response = JSON.parse(data);
				if (response.status) {
					jsonData = JSON.parse(JSON.stringify(response.data));
					//console.log(jsonData);
                    $(".div"+did).after(jsonData.form_data);
					//$("#modal_form_data").html(jsonData.form_data);
					//$(".btn-modal-form").prop("disabled", false);
				} else {
					$(".btnlogin").prop('disabled', false);
					$(".btnlogin").addClass('btn-success');
					$(".btnlogin").removeClass('btn-warning');
					$(".btnlogin").html('Login');
				}
			}
		    });
            //alert(did);
            // $(".div"+did).after("<div class='form-group col-sm-2'><label>Ref Table</label><input type='text' class='form-control' name='txtg'></div>");
        }
        else
        {
            if (confirm('Sure to Proceed') == true)
            {
                $("."+did).remove();
            }
            else
            {
                $(this).val('1');
            }
            
        }
    });

    function loadRefTableCols(id)
    {
        var refTId = id.id;
        var selectedRefTable = $("#"+refTId).val();
        var parentRefClass = $("#"+refTId).attr('data-ref-class');
        var parentRefClass = $("#"+refTId).attr('data-ref-class');
        var serialCount = $("#"+refTId).attr('data-serial-count');
        $('.chld'+parentRefClass).remove();
       // alert(serialCount);
        //alert(parentRefClass);
        $.ajax({
			type: 'POST',
			url: '<?= base_url() ?>crudmaster/post_actions/get_fk_cols?ref_class='+parentRefClass+'&ref_table='+selectedRefTable+'&serial_count='+serialCount,
			data: {},
			success: function(data) {
				response = JSON.parse(data);
				if (response.status) {
					jsonData = JSON.parse(JSON.stringify(response.data));
					//console.log(jsonData);
                    $("."+parentRefClass).after(jsonData.form_data);
					//$("#modal_form_data").html(jsonData.form_data);
					//$(".btn-modal-form").prop("disabled", false);
				} else {
					$(".btnlogin").prop('disabled', false);
					$(".btnlogin").addClass('btn-success');
					$(".btnlogin").removeClass('btn-warning');
					$(".btnlogin").html('Login');
				}
			}
		});
    }

    function fillColName(id)
    {
        var did = id.id;
        var selectedCol = $("#"+did).val();
        var textID = 'txt'+did;
        //alert(selectedCol);
        $("#"+textID).val(selectedCol);
    }
</script>