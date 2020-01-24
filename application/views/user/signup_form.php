<?php echo form_open('registration/register') ?>
    <div class="form-group">
        <label for="email"><?php echo $this->lang->line('texts_email') ?></label>
        <input type="text" name="email" id="email" class="form-control mt-2 mb-2">
    </div>
    <div class="form-group">
        <label for="pass"><?php echo $this->lang->line('texts_sel_pass') ?></label>
        <input type="password" name="pass" id="pass" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="pass_conf"><?php echo $this->lang->line('texts_conf_pass') ?></label>
        <input type="password" id="pass_conf" name="pass_conf" class="form-control mb-2">  
    </div>
    
    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('texts_send') ?></button>
<?php echo form_close() ?>    
    
