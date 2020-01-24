<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailcustom {

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->lang->load('user', $this->CI->config->item('language'));
    }

    public function sendEmail($email, $subject, $message, $successMessage)
    {
         $this->CI->email->set_newline("\r\n");
         $this->CI->email->from($this->CI->config->item('smtp_user'), $this->CI->lang->line('texts_emails_sender'));
         $this->CI->email->to($email);
         $this->CI->email->subject($subject);
         $this->CI->email->message($message);

         //sending email
         if($this->CI->email->send()){
             $this->CI->session->set_flashdata('message', $successMessage);
         }
         else{
             $this->CI->session->set_flashdata('problem_message', $this->CI->email->print_debugger());
         }  
    }
}