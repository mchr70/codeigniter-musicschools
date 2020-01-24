<p><?php echo $this->lang->line('mschool_contact_intro') ?></p>
<p><?php echo $this->lang->line('mschool_mandatory') ?></p>
<?php echo form_open('mschool/contact') ?>
    <input type="text" name="email" placeholder="<?php echo $this->lang->line('mschool_email2') ?> *" class="form-control mt-2 mb-2" value="<?php echo set_value('email'); ?>">
    <input type="text" name="name" placeholder="<?php echo $this->lang->line('mschool_name') ?>" class="form-control mt-2 mb-2" value="<?php echo set_value('name'); ?>">
    <textarea name="message" class="form-control mb-2" placeholder="<?php echo $this->lang->line('mschool_message') ?> *" rows="3"><?php echo set_value('message'); ?></textarea>
    <input name="hid" type="hidden" value="">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="receive_copy" value="ok" class="custom-control-input" id="check-copy">
      <label class="custom-control-label" for="check-copy"><?php echo $this->lang->line('mschool_receive_copy') ?></label>
    </div>
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="consent" value="ok" class="custom-control-input" id="consent">
      <label class="custom-control-label" for="consent"><?php echo $this->lang->line('mschool_consent') ?></label>
    </div>
    <button type="submit" class="btn btn-primary m-2"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_send') ?></button>
<?php echo form_close() ?> 