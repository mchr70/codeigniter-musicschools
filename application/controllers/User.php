<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
         
    }
    
    public function login(){
        $this->form_validation->set_rules('email', $this->lang->line('texts_email3'), 'required|trim|valid_email');
        $this->form_validation->set_rules('pass', $this->lang->line('texts_pass2'), 'required');

        if($this->form_validation->run()){
            $email = $this->input->post('email');
            $password = $this->input->post('pass');
            $rememberMe = $this->input->post('remember_me');

            $user = $this->UserModel->getUserByEmail($email);
            if($user  && password_verify($password, $user->password) && $user->active){
                $userElems = array(
                    'id' => $user->id,
                    'email' => $user->email,
                    'lat' => $user->latitude,
                    'lon' => $user->longitude,
                    'address' => $user->address
                );

                // Set expiration time for connection
                if($rememberMe){
                    $expTime = 2592000;
                }
                else{
                    $expTime = 0;
                }
                $cookie = $this->input->cookie('ci_session'); // we get the cookie
                $this->input->set_cookie('ci_session', $cookie, $expTime); // and add two hours to its expiration

                $this->session->set_userdata($userElems);
                $this->session->set_userdata('schoolsIds', $this->userSchoolsIds());
                redirect('home');    
            }
            else{
                $this->session->set_flashdata('problem_message', $this->lang->line('texts_login_failed'));
            }
        }
        else{
            $this->session->set_flashdata('problem_message', validation_errors());
        }

        $this->session->keep_flashdata('message');
        $this->session->keep_flashdata('problem_message');
        redirect('registration/showLogin');
    }

    public function logout(){
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('lat');
        $this->session->unset_userdata('lon');
        $this->session->unset_userdata('address');
        $this->session->unset_userdata('schoolsIds');

        redirect('home');
    }

    public function showForgPass(){
        $this->data['pageTitle'] = $this->lang->line('texts_forg_pass2');
        $this->data['headerIcon'] = "fa fa-key";

        $this->load->view('templates/header', $this->data);
        $this->load->view('user/forgpass_form', $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function forgPassSendToken(){
        $this->form_validation->set_rules('email', $this->lang->line('texts_email3'), 'required|trim|valid_email');

        $email = $this->input->post('email');

        if($this->form_validation->run()){
            $user = $this->UserModel->getUserByEmail($email);

            if($user){
                //generate simple random code
                $code = bin2hex(random_bytes(64));
                 
                $date = new DateTime('', new DateTimeZone('Europe/Paris'));
                $date->modify('+ 1 hour');
                $tokenId = $this->UserModel->insertToken($code, $user->id, $date->format('Y-m-d H:i:s'));

                $message = array();
                $message[] = '<html>';
                $message[] = '  <head> ';
                $message[] = '      <title>' . $this->lang->line('texts_forg_pass2') . '</title>';
                $message[] = '  </head>';
                $message[] = '  <body>';              
                $message[] = '      <p>' . $this->lang->line('texts_forg_pass_click_link') . '</p>';  
                $message[] = '      <h4><a href="'.base_url().'index.php/user/showCreatePassForm/'.$code.'">' . $this->lang->line('texts_forg_pass_link') . '</a></h4>';    
                $message[] = '  </body>';      
                $message[] = '</html>';        
                        
            $messageStr = implode('', $message);

                $this->emailcustom->sendEmail($email, $this->lang->line('texts_forg_pass2'), $messageStr, $this->lang->line('texts_forg_pass_mail_sent'));
            }
            else{
                $this->session->set_flashdata('problem_message', $this->lang->line('texts_no_account'));
            }
        }
        else{
            $this->session->set_flashdata('problem_message', validation_errors());
        }

        $this->session->keep_flashdata('message');
        $this->session->keep_flashdata('problem_message');
        redirect('user/showForgPass');

    }

    public function showCreatePassForm($code){
        
        $this->data['headerIcon'] = "fa fa-key";
        $this->data['pageTitle'] = $this->lang->line('texts_sel_pass_new2');
        $this->data['code'] = $code;

        $date = new DateTime('', new DateTimeZone('Europe/Paris'));
        $date = $date->format('Y-m-d H:i:s');

        $token = $this->UserModel->getTokenByKey($code);

        if($date <= $token->exp_time){
            $this->load->view('templates/header', $this->data);
            $this->load->view('user/createpass_form', $this->data);
            $this->load->view('templates/footer', $this->data);
        }
        else{
            $this->UserModel->deleteToken($token->id);

            $this->session->set_flashdata('problem_message', $this->lang->line('texts_link_exp'));
            $this->session->keep_flashdata('problem_message');
            redirect('home');
        }  
    }

    public function setNewPass($code){
        $this->form_validation->set_rules('pass', $this->lang->line('texts_pass2'), 'required|min_length[7]|max_length[15]');
        $this->form_validation->set_rules('pass_conf', $this->lang->line('texts_conf_pass2'), 'required|matches[pass]');

        if ($this->form_validation->run()){ 
            $password = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);

            $token = $this->UserModel->getTokenByKey($code);

            $passUpdate = $this->UserModel->setPassword($password, $token->user_id);
 
            if($passUpdate){
                $this->session->set_flashdata('message', $this->lang->line('texts_new_pass_stored'));
                $this->UserModel->deleteToken($token->id);
            }
            else{
                $this->session->set_flashdata('problem_message', $this->lang->line('texts_new_pass_problem'));
            }

            $this->session->keep_flashdata('message');
            redirect('home');          
       }
       else{
            $this->session->set_flashdata('problem_message', validation_errors());
            $this->session->keep_flashdata('problem_message');
            $addrRedirect = 'user/showCreatePassForm/' . $code;
            redirect($addrRedirect);
       }
    }

    public function showChangePass(){
        if(!$this->session->userdata('id')){
            redirect('home');
        }
        else{
            $this->data['headerIcon'] = "fa fa-key";
            $this->data['pageTitle'] = $this->lang->line('texts_sel_pass_new2');

            $this->load->view('templates/header', $this->data);
            $this->load->view('user/changepass_form', $this->data);
            $this->load->view('templates/footer', $this->data);
        }
    }

    public function changePass(){
        $this->form_validation->set_rules('old_pass', $this->lang->line('texts_old_pass'), 'required');
        $this->form_validation->set_rules('new_pass', $this->lang->line('texts_new_pass'), 'required|min_length[7]|max_length[15]');
        $this->form_validation->set_rules('new_pass_conf', $this->lang->line('texts_new_pass_conf'), 'required|matches[new_pass]');

        if($this->form_validation->run()){
            $oldPass = $this->input->post('old_pass');
            $newPassHash = password_hash($this->input->post('new_pass'), PASSWORD_DEFAULT);

            $user = $this->UserModel->getUser($this->session->userdata('id'));
            
            if(password_verify($oldPass, $user['password'])){
                 $this->UserModel->setPassword($newPassHash, $this->session->userdata('id'));

                 $this->session->set_flashdata('message', $this->lang->line('texts_pass_changed'));
            }
            else{
                $this->session->set_flashdata('problem_message', $this->lang->line('texts_old_pass_problem'));
            }
        }
        else{
            $this->session->set_flashdata('problem_message', validation_errors());
        }

        $this->session->keep_flashdata('message');
        $this->session->keep_flashdata('problem_message');
        redirect('user/showChangePass');
    }

    public function showDelAccount(){
        if(!$this->session->userdata('id')){
            redirect('home');
        }
        else{
            $this->data['headerIcon'] = "fa fa-trash";
            $this->data['pageTitle'] = $this->lang->line('texts_del_acc');

            $this->load->view('templates/header', $this->data);
            $this->load->view('user/delaccount_form', $this->data);
            $this->load->view('templates/footer', $this->data);
        }
    }

    public function delAccount(){
        $this->form_validation->set_rules('pass', $this->lang->line('texts_old_pass'), 'required');

        if($this->form_validation->run()){
            $pass = $this->input->post('pass');

            $user = $this->UserModel->getUser($this->session->userdata('id'));

            if(password_verify($pass, $user['password'])){

                // Delete all remaining token of this user
                $delTokens = $this->UserModel->delToken($this->session->userdata('id'));

                // Delete all schools of this user's list
                $schools = $this->MschoolModel->getAllSchools($this->session->userdata('id'));

                $schoolIds = array();
                foreach($schools as $school){
                    $schoolIds[] = $school->id;
                }

                foreach($schoolIds as $schoolId){
                    $delSchool = $this->UserModel->delUserSchool($this->session->userdata('id'), $schoolId);
                }

                $this->UserModel->delUser($this->session->userdata('id'));

                $this->session->set_flashdata('message', $this->lang->line('texts_del_acc_success'));
                $this->session->keep_flashdata('message');

                $this->session->unset_userdata('id');
                $this->session->unset_userdata('lat');
                $this->session->unset_userdata('lon');
                $this->session->unset_userdata('address');
                $this->session->unset_userdata('schoolsIds');

                redirect('home');
           }
           else{
               $this->session->set_flashdata('problem_message', $this->lang->line('texts_pass_problem'));
           }
        }
        else{
            $this->session->set_flashdata('problem_message', validation_errors());
        }

        $this->session->keep_flashdata('problem_message');
        redirect('user/showDelAccount');
    }

    public function myPosition(){
        if(!$this->session->userdata('id')){
            redirect('home');
        }
        else{
            $this->data['headerIcon'] = "fa fa-map-marker";
            $this->data['pageTitle'] = $this->lang->line('mschool_mylocation');

            $this->load->view('templates/header', $this->data);
            $this->load->view('user/myposition', $this->data);
            $this->load->view('templates/footer3', $this->data);
        }
    }

    public function savePosition(){

        $savePos = $this->UserModel->setUserLatAndLon($_COOKIE['lat'], $_COOKIE['lon'], $_COOKIE['address'], $this->session->userdata('id'));

        $this->session->set_userdata('lat', $_COOKIE['lat']);
        $this->session->set_userdata('lon', $_COOKIE['lon']);
        $this->session->set_userdata('address', $_COOKIE['address']);
        
        $this->session->set_flashdata('message', $this->lang->line('mschool_savedpos2'));
        $this->session->keep_flashdata('message');

        redirect('home');
    }

    public function removePosition(){

        $removePos = $this->UserModel->setUserLatAndLon(NULL, NULL, NULL, $this->session->userdata('id'));

        $this->session->unset_userdata('lat');
        $this->session->unset_userdata('lon');
        $this->session->unset_userdata('address');
        
        $this->session->set_flashdata('message', $this->lang->line('mschool_possuppr'));
        $this->session->keep_flashdata('message');

        redirect('user/myPosition');
    }

    public function mySchoolsList($page){
        if(!$this->session->userdata('id')){
            redirect('home');
        }
        else{
            if(!empty($this->session->userdata('schoolsIds'))){
                $this->data['schools'] = $this->MschoolModel->getSchoolsByList($this->session->userdata('schoolsIds'));

                $emails = array();
                foreach($this->data['schools'] as $school){
                    $emails[] = $school->email;
                }
                $this->data['emailStr'] = implode(';', $emails);
            }
            else{
                $this->data['schools'] = array();
                $this->data['emailStr'] = '';
            }

            $_SESSION['sort'] = array(
                'order' => 'userSchoolsList',
                'page' => $page
            );

            $this->data['page'] = $page;
    
            $this->data['headerIcon'] = 'fa fa-list';
            $this->data['pageTitle'] = $this->lang->line('mschool_list');

            $this->load->view('templates/header', $this->data);
            $this->load->view('user/schoolslist', $this->data);
            $this->load->view('templates/footer_schoolslist', $this->data);
        }
    }

    public function addSchool($schoolId){
        $userSchool = $this->UserModel->getOneUserSchool($this->session->userdata('id'), $schoolId);

        if($userSchool == false){
            $insertNew = $this->UserModel->insertUserSchool($this->session->userdata('id'), $schoolId);
        }

        if($insertNew){
            $this->session->set_userdata('schoolsIds', $this->userSchoolsIds());
            $school = $this->MschoolModel->getOneById($schoolId);

            $this->session->set_flashdata('message', $school->name . ' ' . $this->lang->line('mschool_added'));
            $this->session->keep_flashdata('message');

            redirect('mschool/showSchool/' . $_SESSION['schoolId']);
        }

    }

    public function addSelSchools(){
        $schoolIds = json_decode($_COOKIE['selSchools']);

        foreach($schoolIds as $schoolId){
            $userSchool = $this->UserModel->getOneUserSchool($this->session->userdata('id'), $schoolId);

            if($userSchool == false){
                $insertNew = $this->UserModel->insertUserSchool($this->session->userdata('id'), $schoolId);
            }
        }

        $this->session->set_userdata('schoolsIds', $this->userSchoolsIds());

        $this->session->set_flashdata('message', $this->lang->line('mschool_addedsel'));
        $this->session->keep_flashdata('message');

        if($_SESSION['sort']['order'] == 'alpha'){
            $rediradd = 'mschool/showAlpha/' . $_SESSION['sort']['letter'];
        }
        elseif($_SESSION['sort']['order'] == 'closest'){
            $rediradd = 'mschool/showClosest/' . $_SESSION['sort']['page'];
        }
        else{
            $rediradd = 'mschool/showByPostCode/' . $_SESSION['sort']['page'];
        }

        redirect($rediradd);
    }

    public function addAllSchools(){

        $schools = $this->MschoolModel->getAllSchools();

        $schoolIds = array();
        foreach($schools as $school){
            $schoolIds[] = $school->id;
        }

        foreach($schoolIds as $schoolId){
            $insertNew = $this->UserModel->insertUserSchool($this->session->userdata('id'), $schoolId);
        }

        $this->session->set_userdata('schoolsIds', $this->userSchoolsIds());

        $this->session->set_flashdata('message', $this->lang->line('mschool_addedall'));
        $this->session->keep_flashdata('message');

        if($_SESSION['sort']['order'] == 'alpha'){
            $rediradd = 'mschool/showAlpha/' . $_SESSION['sort']['letter'];
        }
        elseif($_SESSION['sort']['order'] == 'closest'){
            $rediradd = 'mschool/showClosest/' . $_SESSION['sort']['page'];
        }
        else{
            $rediradd = 'mschool/showByPostCode/' . $_SESSION['sort']['page'];
        }

        redirect($rediradd);

    }

    public function confirmCopiedEmails(){
        $this->session->set_flashdata('message', $this->lang->line('mschool_copiedclip'));
        $this->session->keep_flashdata('message');

        redirect('user/mySchoolsList/' . $_SESSION['sort']['page']);
    }

    public function removeSelSchools(){
 
        $schoolIds = json_decode($_COOKIE['selSchools']);

        foreach($schoolIds as $schoolId){
            $delSchool = $this->UserModel->delUserSchool($this->session->userdata('id'), $schoolId);
        }

        $this->session->set_userdata('schoolsIds', $this->userSchoolsIds());

        $this->session->set_flashdata('message', $this->lang->line('mschool_removed'));
        $this->session->keep_flashdata('message');

        redirect('user/mySchoolsList/1');
    }

    public function removeAllSchools(){

        $schools = $this->MschoolModel->getAllSchools();

        $schoolIds = array();
        foreach($schools as $school){
            $schoolIds[] = $school->id;
        }

        foreach($schoolIds as $schoolId){
            $delSchool = $this->UserModel->delUserSchool($this->session->userdata('id'), $schoolId);
        }

        $this->session->set_userdata('schoolsIds', $this->userSchoolsIds());

        $this->session->set_flashdata('message', $this->lang->line('mschool_removed_all'));
        $this->session->keep_flashdata('message');

        redirect('user/mySchoolsList/1');
    }

    public function userSchoolsIds(){
        if($this->session->userdata('id')){
            $schoolsByUser = $this->UserModel->getSchoolsByUser($this->session->userdata('id'));

            $schoolsIds = array();
            foreach($schoolsByUser as $school){
                $schoolsIds[] = $school->school_id;
            }

            return $schoolsIds;
            
        }
        else{
            $this->session->set_flashdata('problem_message', $this->lang->line('texts_mustlogin'));
            $this->session->keep_flashdata('problem_message');

            redirect('home');
        }
    }


 
} 