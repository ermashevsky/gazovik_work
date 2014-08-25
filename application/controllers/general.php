<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL);

class General extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();

        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url', 'form', 'text', 'file');
    }

    public function index() {

        $data['title'] = 'Звонки онлайн';

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {

            $data['user'] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
            $data['group'] = $this->ion_auth->get_users_groups($this->session->userdata('user_id'))->row();

            $this->load->view('header', $data);
            $this->load->view('general', $data);
        }
    }

    public function statistic() {

        $data['title'] = 'Статистика';

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {

            $data['user'] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
            $data['group'] = $this->ion_auth->get_users_groups($this->session->userdata('user_id'))->row();

            $this->load->view('header4stat', $data);
            $this->load->view('statistic');
        }
    }

    public function getCallData() {
        $phone = $this->input->post('phone');
        $group = $this->input->post('group');
        $this->load->model('general_model');
        return $this->general_model->getCallDataForTable($phone, $group);
    }

    function getContactGroup() {
        $external_number = $this->input->post('external_number');

        $this->load->model('general_model');
        $data = $this->general_model->getContactGroup($external_number);
        echo json_encode($data);
    }

    function deletePhoneDeptsRecord() {
        $id = $this->input->post('id');
        $this->load->model('general_model');
        $this->general_model->deletePhoneDeptsRecord($id);
        $this->session->set_flashdata('message', "Запись удалена");
    }

    function delete_user() {
        $id = $this->input->post('id');
        $this->load->model('general_model');
        $this->general_model->deleteUserRecord($id);
        $this->session->set_flashdata('message', "Пользователь удален");
    }
    
    function getPhoneDeptsRecord(){
        $id = $this->input->post('id');
        $this->load->model('general_model');
        $data = $this->general_model->getPhoneDeptsRecord($id);
        echo json_encode($data);
        
    }
    
    function updatePhoneDeptsRecord(){
        
        $id = $this->input->post('id');
        $external_number = $this->input->post('edit_external_number');
        $contactName = $this->input->post('edit_contactName');
        
        $this->load->model('general_model');
        $this->general_model->updatePhoneDeptsRecord($id, $external_number, $contactName);
        
    }
    
    public function sendMail() {
        $this->load->library('email');
        
        $call_id = $this->input->post('call_id');
        $internal_number = $this->input->post('internal_number');
        $call_date = $this->input->post('call_date');
        $call_time = $this->input->post('call_time');
        $duration = $this->input->post('duration');
        $call_type = $this->input->post('call_type');
        $dst = $this->input->post('dst');
        $src = $this->input->post('src');
        $email = $this->input->post('email');
        
        foreach($this->getMailSettings() as $settings){
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = $settings->smtp_host;
            $config['smtp_user'] = $settings->smtp_user;
            $config['smtp_pass'] = $settings->smtp_pass;
            $config['smtp_port'] = $settings->smtp_port;
            $config['smtp_timeout'] = $settings->smtp_timeout;

            $config['charset'] = 'utf-8';
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n";
            $config['wordwrap'] = TRUE;

            $this->email->initialize($config);
        
            $this->email->from($settings->user, 'Автоинформатор');
        }
        
        $this->email->to($email);
        $this->email->subject('Пропущен входящий звонок');
        $message = "Вам звонили ".$call_date." в ".$call_time." c номера ".$src." на номер ".$dst." (внутр.номер ".$internal_number.")";
        $this->email->message('Здравствуйте! Вы пропустили входящий звонок.'.$message." И поэтому Вам на адрес ".$email." пришло это письмо.");
        
        $this->email->send();
        
        $this->updateToSendCalls($call_id);
                
//        if (!$this->email->send()) {
//            echo ('Не удалось выполнить отправку письма!');
//        } else {
//            echo ('Письмо было успешно отправлено!');
//        }

        echo $this->email->print_debugger();
    }
    
    function getMailSettings(){
        $this->load->model('general_model');
        $settings = $this->general_model->getMailSettings();
        return $settings;
    }
    
    function updateToSendCalls($call_id){

        $this->load->model('general_model');
        $this->general_model->updateSendCalls($call_id);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/general.php */