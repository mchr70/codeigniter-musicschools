<?php if($this->session->userdata('id')){ ?>
    <p><?php echo $this->lang->line('mschool_locate3') ?></p>
<?php }else{ ?>
    <p><?php echo $this->lang->line('mschool_locate2') . ' <a href="' . base_url() . 'registration">' . $this->lang->line('mschool_register')  . '</a>' . ' ' . $this->lang->line('mschool_or') . ' ' .  '<a href="' . base_url() . 'registration/showLogin">' . $this->lang->line('mschool_login') . '</a>.' ?></p>
<?php } ?>
<p class="text-center"><button class="btn btn-primary" id="locate" onclick="locate('<?php echo $this->config->item('language') ?>')"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_locate') ?></button></p>
<p class="text-center" id="result">
    <?php 
        if($this->session->userdata('id')){
            if($this->session->userdata('lat') && $this->session->userdata('lon') && $this->session->userdata('address')){
                echo $this->lang->line('mschool_savedloc2') . ': <span class="font-weight-bold">' . substr($this->session->userdata('address'), 1, strlen($this->session->userdata('address'))-2) . '</span>';
            }
        }
        else{
           if(isset($_COOKIE['address'])){
                echo $this->lang->line('mschool_savedloc') . ': <span class="font-weight-bold">' . substr($_COOKIE['address'], 1, strlen($_COOKIE['address'])-2) . '</span';
            } 
        } 
    ?>
</p>
<?php if($this->session->userdata('id')){ ?>
    <p class="text-center"><a id="show-closest" href="<?php echo base_url() ?>user/savePosition"><button class="btn btn-primary" id="show_close"><i class="fa fa-save" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_posval2') ?></button></a></p>
<?php }else{ ?>
    <p class="text-center"><a id="show-closest" href="<?php echo base_url() ?>mschool/posVal"><button class="btn btn-primary" id="show_close"><?php echo $this->lang->line('mschool_posval') ?></button></a></p>
<?php } ?>


 
 