<?php echo form_open('user/forgPassSendToken') ?>
    <div class="form-group">
        <label for="email"><?php echo $this->lang->line('texts_email2') ?></label>
        <input type="text" name="email" class="form-control mt-2 mb-2">
    </div>
    <p><button type="submit" class="btn btn-primary mt-2"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('texts_send') ?></button></p>
<?php echo form_close() ?> 