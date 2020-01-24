<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mschool extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->model('MschoolModel');

        // Load texts by language
        $this->lang->load('user', $this->config->item('language'));
        $this->lang->load('mschool', $this->config->item('language'));

        $this->data['lastSchool'] = 9;
        $this->data['schoolsByDistance'] = array();
        $this->data['distanceValues'] = array();
	}

	public function index()
	{
        $this->data['headerIcon'] = 'fa fa-map-marker';
        $this->data['pageTitle'] = $this->lang->line('mschool_locate');

		$this->load->view('templates/header', $this->data);
		$this->load->view('musicschools/locate', $this->data);
		$this->load->view('templates/footer2', $this->data);
    }

    public function findClosest(){
        if($this->session->userdata('id')){
            $userLat = $this->session->userdata('lat');
            $userLon = $this->session->userdata('lon');
        }
        else{
            $userLat= floatval($_COOKIE['lat']);
            $userLon = floatval($_COOKIE['lon']);
        }

        $_SESSION['schoolsByDistance'] = $this->schoolsByDistance($userLat, $userLon);

        redirect('mschool/showClosest/1');
    }

    public function showClosest($page){

        $_SESSION['sort'] = array(
            'order' => 'closest',
            'page' => $page
        );

        $this->data['schoolsByDistance'] = $_SESSION['schoolsByDistance'];

        $this->data['pagesNum'] = ceil(count($this->data['schoolsByDistance']) / 10);
        $this->data['firstId'] = ($page-1) * 10;
        $this->data['lastId'] = $this->data['firstId'] + 9;
        if($this->data['lastId'] > count($this->data['schoolsByDistance'])){
            $this->data['lastId'] = count($this->data['schoolsByDistance']) - 1;
        }

        $this->data['activeClasses'] = array();
        for($i=1; $i<=$this->data['pagesNum']; $i++){
            if($i == $page){
                $this->data['activeClasses'][] = 'active';
            }
            else{
                $this->data['activeClasses'][] = '';
            }
        }
        
        $this->data['headerIcon'] = 'fa fa-map-marker';
        $this->data['pageTitle'] = $this->lang->line('texts_closest');

        $this->load->view('templates/header', $this->data);
		$this->load->view('musicschools/closest', $this->data);
		$this->load->view('templates/footer_alpha', $this->data);
    }

    public function showSchool($id){

        $this->data['school'] = $this->MschoolModel->getOneById($id);

        $_SESSION['schoolId'] = $this->data['school']->id;

        $this->data['pageTitle'] = $this->data['school']->name;

        $this->load->view('templates/header', $this->data);
		$this->load->view('musicschools/school', $this->data);
		$this->load->view('templates/footer', $this->data);
    }
    
    public function posVal(){
        $_SESSION['lat'] = $_COOKIE['lat'];
        $_SESSION['lon'] = $_COOKIE['lon'];

        $this->session->set_flashdata('message', $this->lang->line('mschool_savedpos'));

        $this->session->keep_flashdata('message'); 

        redirect('home');
    }

    public function showAlpha($letter){
        $this->data['schools'] = $this->MschoolModel->getByLetter($letter);

        $_SESSION['sort'] = array(
            'order' => 'alpha',
            'letter' => $letter
        );

        $alphabet = '3ABDEFGHIKLMNOPRSUVW';
        $this->data['letters'] = str_split($alphabet);

        $this->data['activeClasses'] = array();
        foreach($this->data['letters'] as $letterElem){
            if($letterElem == $letter){
                $this->data['activeClasses'][] = 'active';
            }
            else{
                $this->data['activeClasses'][] = '';
            }
        }

        $this->data['headerIcon'] = 'fa fa-sort-alpha-asc';
        $this->data['pageTitle'] = $this->lang->line('mschool_order_alpha');

        $this->load->view('templates/header', $this->data);
		$this->load->view('musicschools/alpha', $this->data);
		$this->load->view('templates/footer_alpha', $this->data);
    }

    public function initPostcodeSearch(){
        $_SESSION['postcodeSearchOk'] = false;

        redirect('mschool/showByPostCode/1');
    }

    public function showByPostcode($page){

        $this->form_validation->set_rules('postcode', $this->lang->line('mschool_zipcode'), 'required|numeric|exact_length[5]|trim');
        $this->form_validation->set_rules('cityname', $this->lang->line('mschool_city'), 'required|trim');

        if($this->form_validation->run()){
            $postcode = $this->input->post('postcode');
            $cityname = $this->input->post('cityname');

            // Create a stream
            $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
            $context = stream_context_create($opts);

            $cityname = urlencode($cityname);

            $url = "https://nominatim.openstreetmap.org/search?q=" . $postcode . "+"  . $cityname . "&format=json&polygon=0&addressdetails=0";
        
            // get the json response
            $resp_json = file_get_contents($url, false, $context);
        
            // decode the json
            $resp = json_decode($resp_json, true);

            $keys = array_keys($resp);
        
            if(isset($resp[0])){
                $searchLat = $resp[0]['lat'];
                $searchLon = $resp[0]['lon'];

                $_SESSION['postcodeSearchOk'] = true;
            }
            else{
                $this->session->set_flashdata('problem_message', $this->lang->line('mschool_error'));

                $_SESSION['postcodeSearchOk'] = false;
            }

            if(isset($searchLat) && isset($searchLon)){
                $_SESSION['schoolsByDistance'] = $this->schoolsByDistance($searchLat, $searchLon);
            }

            $_SESSION['searchCoords'] = array(
                'postcode' => $postcode,
                'cityname' => $cityname
            );
             
        }

        $_SESSION['sort'] = array(
            'order' => 'postcode',
            'page' => $page 
        );

        $this->data['page'] = $page;

        $this->data['headerIcon'] = 'fa fa-building-o';
        $this->data['pageTitle'] = $this->lang->line('mschool_bypostcode');

        $this->load->view('templates/header', $this->data);
        $this->load->view('musicschools/postcode', $this->data);
        if($_SESSION['postcodeSearchOk']){
            $this->load->view('musicschools/closest_postcode', $this->data);
        }
		$this->load->view('templates/footer_accpv', $this->data);
    }

    public function setCookiesConsent(){
        $expire = time() + 6 * 60 * 60 * 24 * 30; // expires in one month
        setcookie('cookies_consent','ok', $expire, '/');

        $date = new DateTime('', new DateTimeZone('Europe/Paris'));
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->MschoolModel->insertCookiesConsent($ip, $date->format('Y-m-d H:i:s'));

        $this->session->set_flashdata('message', $this->lang->line('texts_cookiesok'));
        $this->session->keep_flashdata('message');

        redirect('home');
    }

    public function cookiesInfo(){
        $this->data['headerIcon'] = 'fa fa-info-circle';
        $this->data['pageTitle'] = $this->lang->line('mschool_cookies');

		$this->load->view('templates/header', $this->data);
		$this->load->view('musicschools/cookies', $this->data);
		$this->load->view('templates/footer', $this->data);
    }

    public function contact(){

        $this->form_validation->set_rules('email', $this->lang->line('texts_email3'), 'required|trim|valid_email');
        $this->form_validation->set_rules('name', $this->lang->line('mschool_name2'), 'trim');
        $this->form_validation->set_rules('message', $this->lang->line('mschool_message2'), 'required|trim');
        $this->form_validation->set_rules('consent', $this->lang->line('mschool_consent2'), 'required|trim',
            array('required' => $this->lang->line('mschool_consent_message'))
        );


        if($this->form_validation->run()){

            $userMail = $this->input->post('email');
            $userName = $this->input->post('name');
            $messageText = $this->input->post('message');
            $hid = $this->input->post('hid');
            $receiveCopy = $this->input->post('receive_copy');

            $blocked = $this->MschoolModel->getBlockedEmail($userMail);

            if(!empty($hid)){
                $this->session->set_flashdata('problem_message', 'Le message n\'a pas été envoyé');
            }
            elseif($blocked){
                $this->session->set_flashdata('problem_message', 'Cette adresse mail est bloquée');
            }
            else{
                $date = new DateTime('', new DateTimeZone('Europe/Paris'));
                $this->MschoolModel->insertConsent($userMail, $date->format('Y-m-d H:i:s'));

                $message = array();
                $message[] = '<html>';
                $message[] = '  <head> ';
                $message[] = '      <title>' . 'Formulaire de contact: nouveau message' . '</title>';
                $message[] = '  </head>';
                $message[] = '  <body>';              
                $message[] = '      <p>' . 'Vous venez de recevoir un nouveau message via votre formulaire de contact.' . '</p>';  
                $message[] = '      <p>mail: ' . $userMail . '</p>';
                $message[] = '      <p>nom: ' . $userName . '</p>';
                $message[] = '      <p>message: ' . $messageText . '</p>';
                $message[] = '  </body>';      
                $message[] = '</html>';        
                        
                $messageStr = implode('', $message);

                $this->emailcustom->sendEmail('mchr70@gmail.com', 'Formulaire de contact: nouveau message', $messageStr, 'Votre message a été envoyé. Nous vous répondrons le plus rapidement possible.');

                if($receiveCopy == 'ok'){

                    $messageCopy = array();
                    $messageCopy[] = '<html>';
                    $messageCopy[] = '  <head> ';
                    $messageCopy[] = '      <title>' . 'Votre message' . '</title>';
                    $messageCopy[] = '  </head>';
                    $messageCopy[] = '  <body>';              
                    $messageCopy[] = '      <p>' . 'Vous venez de laisser un nouveau message via notre formulaire de contact.' . '</p>';  
                    $messageCopy[] = '      <p>mail: ' . $userMail . '</p>';
                    $messageCopy[] = '      <p>nom: ' . $userName . '</p>';
                    $messageCopy[] = '      <p>message: ' . $messageText . '</p>';
                    $messageCopy[] = '  </body>';      
                    $messageCopy[] = '</html>';        
                        
                    $messageCopyStr = implode('', $messageCopy);

                    $this->emailcustom->sendEmail($userMail, 'Votre message', $messageCopyStr, 'Votre message a été envoyé. Nous vous répondrons le plus rapidement possible.');
                }

                $this->session->keep_flashdata('message');
                redirect('home');
            }
        }
        else{

        }

        $this->data['pageTitle'] = $this->lang->line('mschool_contact');
        $this->data['headerIcon'] = 'fa fa-envelope';

        $this->load->view('templates/header', $this->data);
		$this->load->view('musicschools/contact', $this->data);
		$this->load->view('templates/footer', $this->data);
    }

    public function schoolsByDistance($lat, $lon){
        $schools = $this->MschoolModel->getAllSchools();

        $distances = array();
        foreach($schools as $school){
            $distances += [$school->id => round($this->geoloc->distance($lat, $lon, floatval($school->latitude),  floatval($school->longitude)), 1)];
        }
        asort($distances);

        $distanceKeys = array_keys($distances);
        $distanceValues = array_values($distances);

        $schoolsByDistance = array();
        foreach($distanceKeys as $key){
            $schoolsByDistance[] = $this->MschoolModel->getOneById($key);
        }

        for($i=0; $i<count($distanceValues); $i++){
            $schoolsByDistance[$i]->distance = $distanceValues[$i];
        }


        return $schoolsByDistance;
    }

}