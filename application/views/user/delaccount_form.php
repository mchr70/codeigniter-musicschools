<?php echo form_open('user/delAccount') ?>
    <div class="form-group">
        <label for="pass"><?php echo $this->lang->line('texts_curr_pass2') ?></label>
        <input type="password" name="pass" class="form-control mb-2"> 
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('texts_send') ?></button>
<?php echo form_close() ?>  