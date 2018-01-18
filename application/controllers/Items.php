<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {


    public $item;

    public function __construct() {
        parent::__construct();
        $this->load->model('ItemModel','itemsmodel');
    }


    public function index()
	{
        $data['data'] = $this->itemsmodel->get_itemCRUD();
        $this->load->view('theme/header');
        $this->load->view('items/list',$data);
        $this->load->view('theme/footer');
	}

    public function show($id)
    {
        $item = $this->itemsmodel->find_item($id);
        $this->load->view('theme/header');
        $this->load->view('items/show',array('item'=>$item));
        $this->load->view('theme/footer');
    }

    public function create()
    {
        $this->load->view('theme/header');
        $this->load->view('items/create');
        $this->load->view('theme/footer');
    }


    public function store()
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');


        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('items/create'));
        }else{
            $this->itemsmodel->insert_item();
            redirect(base_url('Items'));
        }
    }



    public function edit($id)
    {
        $item = $this->itemsmodel->find_item($id);
        $this->load->view('theme/header');
        $this->load->view('items/update',array('item'=>$item));
        $this->load->view('theme/footer');
    }


    public function update($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('Items/edit/'.$id));
        }else{
            $this->itemsmodel->update_item($id);
            redirect(base_url('Items'));
        }
    }

    public function delete($id)
    {
        $item = $this->itemsmodel->delete_item($id);
        redirect(base_url('Items'));
    }
}
