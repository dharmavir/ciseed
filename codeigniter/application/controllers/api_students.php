<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require (APPPATH . 'libraries/rest_controller.php');

class Api_Students extends REST_Controller {
  public function all() {
    $this->load->model('Model_Student');
    $students = $this->Model_Student->getAll();
    $this->json_response($students);
  }

  public function update($record) {
    $this->load->model('Model_Student');
    if($this->is_valid_record($record) === true) {
        $this->Model_Student->update($record);
    }
  }

  public function mass_update() {
    $records = $this->input->post('data');
    foreach($records as $record) {
      $this->update($record);
    }
  }

  private function is_valid_record($record) {
    $valid = false;
    if(empty(array_diff(array_keys($record), array("id", "user_name", "password"))) == true) {
      if($record['id'] > 0 && empty($record['user_name']) === false && empty($record['password']) === false) {
        $valid = true;
      }
    }
    return $valid;
  }
}
