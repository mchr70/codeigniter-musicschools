<?php
    if($this->session->userdata('lat') && $this->session->userdata('lon') && $this->session->userdata('address')){
        echo '<p>' . substr($this->session->userdata('address'), 1, strlen($this->session->userdata('address'))-2) . '</p>';
        echo '<a href="' . base_url() . 'user/removePosition" data-confirm="' . $this->lang->line('mschool_delpos_confirm') . '">';
            echo '<button class="btn btn-primary"><i class="fa fa-remove" aria-hidden="true"></i> ' . $this->lang->line('mschool_remove') . '</button>';
        echo '</a>';
    }
    else{
        echo '<p>' . $this->lang->line('mschool_nopos') . '</p>';
    }
?>



