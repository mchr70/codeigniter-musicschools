<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->model('UserModel');
        $this->load->model('MschoolModel');

        // Load texts by language
        $this->lang->load('user', $this->config->item('language'));
        $this->lang->load('mschool', $this->config->item('language'));

        //get all users and set the page title
        $this->data = array(
            'users' => $this->UserModel->getAllUsers(),
            'pageTitle' => $this->lang->line('texts_register')
        );
	}

	public function index()
	{
        $this->data['headerIcon'] = 'fa fa-user-plus';

		$this->load->view('templates/header', $this->data);
		$this->load->view('user/signup_form', $this->data);
		$this->load->view('templates/footer', $this->data);
    }
    
    public function register(){

        $this->form_validation->set_rules('email', $this->lang->line('texts_email3'), 'valid_email|required|is_unique[user.email]',
            array(
                'is_unique' => $this->lang->line('texts_email_exists')              
            )
        );
        $this->form_validation->set_rules('pass', $this->lang->line('texts_pass2'), 'required|min_length[7]|max_length[15]');
        $this->form_validation->set_rules('pass_conf', $this->lang->line('texts_conf_pass2'), 'required|matches[pass]');
 
        if ($this->form_validation->run() == FALSE) { 
            $this->session->set_flashdata('problem_message', validation_errors());
       }
       else{
            //get user inputs and hash the password
            $email = $this->input->post('email');
            $password = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);

            //generate simple random code
            $code = bin2hex(random_bytes(64));
            
            $regDate = new DateTime('', new DateTimeZone('Europe/Paris'));

            //insert user to users table and get id
			$user['email'] = $email;
            $user['password'] = $password;
            $user['reg_date'] = $regDate->format('Y-m-d H:i:s');
            $user['active'] = false;
            
            $id = $this->UserModel->insert($user);
 
            $date = $regDate->modify('+ 1 hour');
            $tokenId = $this->UserModel->insertToken($code, $id, $date->format('Y-m-d H:i:s'));

            $message = array();
            $message[] = '<html>';
            $message[] = '  <head> ';
            $message[] = '      <title>' . $this->lang->line('texts_act_email_title') . '</title>';
            $message[] = '  </head>';
            $message[] = '  <body>';     
            $message[] = '      <h2>' . $this->lang->line('texts_reg_thanks') . '</h2>';           
            $message[] = '      <p>' . $this->lang->line('texts_act_click_link') . '</p>';  
            $message[] = '      <h4><a href="'.base_url().'index.php/registration/activate/'.$code.'">' . $this->lang->line('texts_act_link') . '</a></h4>';    
            $message[] = '  </body>';      
            $message[] = '</html>';        
                        
            $messageStr = implode('', $message);

            $this->emailcustom->sendEmail($email, $this->lang->line('texts_act_email_title'), $messageStr, $this->lang->line('texts_act_email'));
       }

        $this->session->keep_flashdata('message');
        $this->session->keep_flashdata('problem_message');
        redirect('registration/index');
    }

    public function activate($code){
        
        $date = new DateTime('', new DateTimeZone('Europe/Paris'));
        $date = $date->format('Y-m-d H:i:s');

        $token = $this->UserModel->getTokenByKey($code);
        
        if($token){
            if($date <= $token->exp_time){
                $this->UserModel->activate($token->user_id);
                $this->session->set_flashdata('message', $this->lang->line('texts_act_success'));

                $this->UserModel->deleteToken($token->id);
            }
            else{
                $this->session->set_flashdata('problem_message', $this->lang->line('texts_link_exp'));
            }
        }
        else{
            $this->session->set_flashdata('problem_message', $this->lang->line('texts_act_active'));
        }
 
        $this->session->keep_flashdata('message');
        $this->session->keep_flashdata('problem_message');
		redirect('registration/showActivated');
    }

    public function showActivated(){
        $this->data['headerIcon'] = "fa fa-user";
        $this->data['pageTitle'] = $this->lang->line('texts_act_email_title');

        $this->load->view('templates/header', $this->data);
        $this->load->view('user/activation', $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function showLogin(){
        $this->data['headerIcon'] = 'fa fa-sign-in';
        $this->data['pageTitle'] = $this->lang->line('texts_login');

        $this->load->view('templates/header', $this->data);
        $this->load->view('user/login_form', $this->data);
        $this->load->view('templates/footer', $this->data);
    }

}