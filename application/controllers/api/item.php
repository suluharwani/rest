<?php

require APPPATH . 'libraries/REST_Controller.php';

class Item extends REST_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }
  public function index_get()
  {
    $id = $this->input->get('id');
    if(!empty($id)){
      $data = $this->db->get_where("items", ['id' => $id])->row_array();
    }else{
      $data = $this->db->get("items")->result();
    }

    $this->response($data, REST_Controller::HTTP_OK);
  }
  public function index_post()
  {
    $input = $this->input->post();
    $this->db->insert_batch('items',$input);

    $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
  }
  public function index_put()
  {
    $id = $this->put('id');
    $data = [
      'title' => $this->put('title'),
      'description' => $this->put('description')
    ];
    $this->db->where('id', $id);
    $this->db->update('items', $data);
    $aff = $this->db->affected_rows();
    if ($aff>0) {
      $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }else {
      $this->response(['Item not updated successfully.'], REST_Controller::HTTP_BAD_REQUEST);
    }
  }
  public function index_delete()
  {
    $id = $this->delete('id');
    $this->db->delete('items', array('id'=>$id));
    $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
  }

}
