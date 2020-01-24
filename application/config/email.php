<?php defined('BASEPATH') OR exit('No direct script access allowed');

//setup email
$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'mchr70@gmail.com', // change it to yours
    'smtp_pass' => 'mar051731', // change it to yours
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'wordwrap' => TRUE
);