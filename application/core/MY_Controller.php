<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_controller
 */
class MY_Controller extends CI_Controller
{
	/**
	 * Redirect if needed
	 */
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect(base_url('login'), 'refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
	}

}
