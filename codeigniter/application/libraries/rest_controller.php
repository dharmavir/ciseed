<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class REST_Controller extends CI_Controller {

  var $content_type;

  public function __construct() {
    parent::__construct();
    // optional, one can override this in REST controller you extend;
    $this->content_type = 'plain/text';
  }

  public function response($data = NULL, $http_code = NULL) {
    if(($http_code > 0) != true) {
      $http_code = 200;
    }

    return $this->output
            ->set_content_type($this->content_type)
            ->set_status_header($http_code)
            ->set_output($data);
    
  }

  public function json_response($data = NULL, $http_code = NULL) {
    $data = json_encode(array("data" => $data));
    $this->content_type = 'application/json';
    return $this->response($data, $http_code);
  }
}
