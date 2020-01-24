<?php echo form_open('user/setNewPass/' . $code) ?>
    <div class="form-group">
        <label for="pass"><?php echo $this->lang->line('texts_sel_pass_new') ?></label>
        <input type="password" name="pass" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="pass_conf"><?php echo $this->lang->line('texts_conf_pass_new') ?></label>
        <input type="password" name="pass_conf" class="form-control mb-2">  
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('texts_send') ?></button>
<?php echo form_close() ?>  