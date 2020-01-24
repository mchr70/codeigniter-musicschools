<?php echo form_open('user/login') ?>
    <div class="form-group">
        <label for="email"><?php echo $this->lang->line('texts_email') ?></label>
        <input type="text" id="email" name="email" class="form-control mt-2 mb-2">
    </div>
    
    <div class="form-group">
        <label for="pass"><?php echo $this->lang->line('texts_pass') ?></label>
        <input type="password" id="pass" name="pass" class="form-control mb-2">
    </div>
    <div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" name="remember_me" id="customCheck1">
        <label class="custom-control-label" for="customCheck1"><?php echo $this->lang->line('texts_rememberme') ?></label>
    </div>
    <a href="<?php echo base_url() ?>index.php/user/showForgPass"><?php echo $this->lang->line('texts_forg_pass') ?></a>
    <p><button type="submit" class="btn btn-primary mt-2"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('texts_send') ?></button></p>
<?php echo form_close() ?> 