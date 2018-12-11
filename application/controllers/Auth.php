<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/auth
	 *	- or -
	 * 		http://example.com/index.php/auth/login
	 */
	public function __construct()
	{
		parent::__construct();
	}

    public function _remap($method, $params = array()) {
        switch ($method) {
            case 'index':
                $this->index();
                break;
            case 'signIn':
                $this->signIn();
                break;
            case 'logout':
                $this->logout();
                break;
        }
    }

	private function index()
	{
        if ($this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect(base_url(), 'refresh');
        }
		$this->data['body'] = 'auth/login';
        $this->data['title'] = 'Autentifikatsiya';
		$this->load->view('components/container', $this->data);
	}

	private function signIn()
	{
		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect(base_url(), 'refresh');
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(base_url('login'), 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->session->set_flashdata('message', validation_errors());
            redirect(base_url('login'), 'refresh');
		}
	}

    private function logout()
    {
        // log the user out
        $this->ion_auth->logout();
        redirect(base_url('login'), 'refresh');
    }
}
