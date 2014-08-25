<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    //redirect if needed, otherwise display the user list
    function index() {
        $data['title'] = 'Админка - Пользователи';

        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            //redirect them to the home page because they must be an administrator to view this
            redirect($this->config->item('base_url'), 'refresh');
        } else {
            //set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $data['user'] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
            $data['users'] = $this->ion_auth->users()->result();
            foreach ($data['users'] as $k => $user) {
                $data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            $this->load->view('auth/header', $data);
            $this->load->view('auth/index', $data);
        }
    }

    function phoneDepts() {
        $data['title'] = 'Админка - Телефонные номера';

        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            //redirect them to the home page because they must be an administrator to view this
            redirect($this->config->item('base_url'), 'refresh');
        } else {
            //set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $data['user'] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
            $data['users'] = $this->ion_auth->users()->result();
            foreach ($data['users'] as $k => $user) {
                $data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }
            $this->load->model('general_model');
            $data['phone_depts'] = $this->general_model->getPhoneDepts();

            $this->load->view('auth/header', $data);
            $this->load->view('auth/phoneDepts', $data);
        }
    }

    //log the user in
    function login() {
        $data['title'] = "Login";

        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) { //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) { //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect($this->config->item('base_url'), 'refresh');
            } else { //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {  //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );
            $this->load->view('auth/header_login');
            $this->load->view('auth/login', $data);
        }
    }

    //log the user out
    function logout() {
        $data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them back to the page they came from
        redirect('auth', 'refresh');
    }

    //change password
    function change_password() {
        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) { //display the form
            //set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
            );
            $data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
            );
            $data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            //render
            $this->load->view('auth/change_password', $data);
        } else {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) { //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    //forgot password
    function forgot_password() {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        if ($this->form_validation->run() == false) {
            //setup the input
            $data['email'] = array('name' => 'email',
                'id' => 'email',
            );
            //set any errors and display the form
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->load->view('auth/forgot_password', $data);
        } else {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

            if ($forgotten) { //if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {  //if the code is valid then display the password reset form
            $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

            if ($this->form_validation->run() == false) {//display the form
                //set the flash data error message if there is one
                $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
                );
                $data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
                );
                $data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $data['csrf'] = $this->_get_csrf_nonce();
                $data['code'] = $code;

                //render
                $this->load->view('auth/reset_password', $data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_404();
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) { //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->logout();
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else { //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false) {
        if ($code !== false)
            $activation = $this->ion_auth->activate($id, $code);
        else if ($this->ion_auth->is_admin())
            $activation = $this->ion_auth->activate($id);

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL) {
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', 'confirmation', 'required');
        $this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $data['csrf'] = $this->_get_csrf_nonce();
            $data['user'] = $this->ion_auth->user($id)->row();
            $this->load->view('auth/header');
            $this->load->view('auth/deactivate_user', $data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_404();
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //create a new user
    function create_user() {
        $data['title'] = "Create User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        //validate form input

        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'First Part of Phone', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

        if ($this->form_validation->run() == true) {
            $username = strtolower($this->input->post('login'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'phone' => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data)) { //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', "Пользователь добавлен");
            redirect("auth", 'refresh');
        } else { //display the create user form
            //set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $data['login'] = array('name' => 'login',
                'id' => 'login',
                'type' => 'text',
                'value' => $this->form_validation->set_value('login'),
            );

            $data['email'] = array('name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            );

            $data['phone'] = array('name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $data['group'] = array('name' => 'group',
                'id' => 'group',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group'),
            );

            $data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $data['password_confirm'] = array('name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
//                        $this->load->view('auth/header');
//			  $this->load->view('auth/create_user', $data);
//                        $this->load->view('auth/rightbar');
//                        $this->load->view('auth/footer');
        }
    }

    //create a new user
    function createPhoneDeptsRecord() {
        $data['title'] = "Create User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('external_number', 'Внешний номер', 'required|xss_clean');
        $this->form_validation->set_rules('contactName', 'Наименование контакта', 'required|xss_clean');

        if ($this->form_validation->run() == true) {

            $additional_data = array(
                'external_number' => $this->input->post('external_number'),
                'contactName' => $this->input->post('contactName'),
            );

            $this->load->model('general_model');
            $this->general_model->insertNewPhoneDeptsData($additional_data);

            $this->session->set_flashdata('message', "Новая запись добавлена");
            redirect("auth", 'refresh');
        } else {
            ////display the create user form
            //set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $data['external_number'] = array('name' => 'external_number',
                'id' => 'external_number',
                'type' => 'text',
                'value' => $this->form_validation->set_value('external_number'),
            );

            $data['contactName'] = array('name' => 'contactName',
                'id' => 'contactName',
                'type' => 'text',
                'value' => $this->form_validation->set_value('contactName'),
            );
//                        $this->load->view('auth/header');
//	            $this->load->view('auth/create_user', $data);
//                        $this->load->view('auth/rightbar');
//                        $this->load->view('auth/footer');
        }
    }

    function edit_user($id) {
        $data['title'] = "Редактирование профиля пользователя";

        if (!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //validate form input
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Телефон', 'required|xss_clean|min_length[2]|max_length[15]');
        $this->form_validation->set_rules('groups', 'Группа', 'xss_clean');


        if ($this->form_validation->run() === TRUE) {
            //$id = (int) $this -> input -> post('id');
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),);
            //Update the groups user belongs to
            $groupData = $this->input->post('groups');

            if (isset($groupData) && !empty($groupData)) {

                $this->ion_auth->remove_from_group('', $id);

                foreach ($groupData as $grp) {
                    $this->ion_auth->add_to_group($grp, $id);
                }
            }


            //update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

                $data['password'] = $this->input->post('password');
            }
        }
        if ($this->form_validation->run() === TRUE) {//check to see if we are editing the user
            //redirect them back to the admin page
            //EXECUTE THE RESET PASSWORD HERE IF CHECKED
            $this->session->set_flashdata('ion_message', 'User edited');
            $this->ion_auth->update($user->id, $data);
            redirect('auth/index', 'refresh');
        } else { //display the edit user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('ion_message')));
            //get posted ID if exists, else the one from uri.
            //in order to get user datas from table
            $id = (isset($id)) ? $id : (int) $this->uri->segment(3);
            //get current user datas from table and set default form values
            $user = $this->ion_auth->user($id)->row();
            //passing user id to view
            $this->data['user_id'] = $user->id;
            //process the phone number
            if (isset($user->phone) && !empty($user->phone)) {
                $user->phone = explode(' ', $user->phone);
            }

            //prepare form
            //pass the user to the view
            $this->data['user'] = $user;
            $this->data['groups'] = $groups;
            $this->data['currentGroups'] = $currentGroups;

            $this->data['username'] = array(
                'name' => 'username',
                'id' => 'username',
                'type' => 'text',
                'value' => $this->form_validation->set_value('username', $user->username),
                'readonly' => 'true',
            );

            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email', $user->email),
            );

            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'text',
                'value' => $this->form_validation->set_value('password'),
            );

            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'text',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone', $user->phone[0]),
            );

            $this->data['id'] = array(
                'name' => 'id',
                'id' => 'id',
                'type' => 'hidden',
                'value' => $this->form_validation->set_value('id', $user->id),
            );
            $data['user'] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
            $this->load->view('auth/header', $data); //Заголовок страницы
            $this->load->view('auth/edit_user', $this->data);
//            $this->load->view('auth/footer');
        }
    }

    function mailsettings() {

        $data['title'] = "Настройки параметров почтового сервера";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $data['user'] = $this->ion_auth->user($this->session->userdata('user_id'))->row();

        $this->load->model('general_model');
        $mailSettings['mailsettings'] = $this->general_model->getMailSettings();

        if (!empty($mailSettings['mailsettings'])) {
            $this->load->view('auth/header', $data); //Заголовок страницы
            $this->load->view('auth/mailsettings', $mailSettings);
        } else {
            $this->load->view('auth/header', $data); //Заголовок страницы
            $this->load->view('auth/mailsettings2');
        }
    }
    
    function updateSmtpParameters(){
        
        $id = $this->input->post('id');
        $smtp_host = $this->input->post('smtp_host');
        $smtp_port = $this->input->post('smtp_port');
        $smtp_user = $this->input->post('smtp_user');
        $smtp_pass = $this->input->post('smtp_pass');
        $smtp_timeout = $this->input->post('smtp_timeout');
        
        
        $this->load->model('general_model');
        $this->general_model->updateSmtpParameters($id,$smtp_host,$smtp_port,$smtp_user,$smtp_pass,$smtp_timeout);
    }

    function delete_user($id) {
        $this->ion_auth->delete_user($id);
        $this->session->set_flashdata('message', "Пользователь удален");
        redirect("auth", 'refresh');
    }

    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function user_check() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

}
