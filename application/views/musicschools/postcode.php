<?php echo form_open('mschool/showByPostcode/1') ?>

    <!-- accpv -->
    <div class="form-group">
        <label for="code_postal"><?php echo $this->lang->line('mschool_zipcode2') ?></label>
        <input class="form-control mb-2" id="code_postal" type="text" name="postcode" onclick="GenerateParam(this.value)" onkeyup="GenerateParam(this.value)" onblur="closeSuggestBox();" autocomplete="off">
    </div> 
    <p><div style="visibility:hidden;overflow-y:auto;overflow-x:hidden;" id="suggestBoxElement"></div></p>
    <div class="form-group">
        <label for="ville"><?php echo $this->lang->line('mschool_city2') ?></label>
        <input class="form-control mb-2" id="ville" type="text" name="cityname">
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_validate') ?></button>
<?php echo form_close() ?> 
 

