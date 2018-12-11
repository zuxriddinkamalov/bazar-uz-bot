<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('announcement_model', 'announce');
        $this->load->library('pagination');
        $this->config->load('pagination', TRUE);
    }

	public function index()
	{
        $config = $this->config->item('pagination');
        $offset = $this->input->get('page');
        $limit = $config['per_page'];
        $config['total_rows'] = $this->announce->count();
        $config['base_url'] = base_url();
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->data['announces'] = $this->announce->get([], $limit, $offset);

        $this->data['scripts'] = array(
            'vendor/bootstrap-toggle/bootstrap-toggle.min.js',
        );

        $this->data['styles'] = array(
            'vendor/bootstrap-toggle/bootstrap-toggle.min.css',
        );

        $this->data['title'] = 'Bazar.uz botiga kelib tushgan e`lonlar';
        $this->data['page'] = 'pages/index';
        $this->data['body'] = 'pages/dashboard';
		$this->load->view('components/container', $this->data);
	}

	public function edit($id) {
        $this->data['announce'] = $this->announce->get_announce($id);
        $this->data['title'] = 'Tahrirlash';
        $this->data['page'] = 'pages/announce_edit';
        $this->data['body'] = 'pages/dashboard';
        $this->load->view('components/container', $this->data);
    }

    /*=========================ACTIONS==============================*/

    public function edit_action($id) {
        $this->form_validation->set_rules('product', 'Product', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $data['product'] = $this->input->post('product');
        $data['price'] = $this->input->post('price');
        $data['phone'] = $this->input->post('phone');
        $data['description'] = $this->input->post('description');
        if ($this->form_validation->run()) {
            $this->session->set_flashdata('message', 'Muvaffaqiyatli yangilandi');
            $this->announce->update($id, $data);
            redirect(base_url());
        } else {
            $this->session->set_flashdata('message', validation_errors());
            redirect(base_url('announce/edit/'.$id));
        }
    }

    public function delete_action($id) {
        $this->announce->delete($id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    /*=========================AJAX ACTIONS==============================*/

    public function ajax_toggle_status() {
        $id = $this->input->post('id');
        $data['status'] = $this->input->post('status') == 'false' ? 0 : 1;
        $response = $this->announce->update($id, $data);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('result' => $response)));
    }
}
