<?php echo form_open('user/changePass') ?>
    <div class="form-group">
        <label for="old_pass"><?php echo $this->lang->line('texts_curr_pass') ?></label>
        <input type="password" name="old_pass" id="old_pass" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="new_pass"><?php echo $this->lang->line('texts_sel_pass_new') ?></label>
        <input type="password" name="new_pass" id="new_pass" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="new_pass_conf"><?php echo $this->lang->line('texts_conf_pass_new') ?></label>
    <input type="password" name="new_pass_conf" id="new_pass_conf" class="form-control mb-2">  
    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('texts_send') ?></button>
<?php echo form_close() ?>  