<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Student extends CI_Model {
  var $id;
  var $user_name;
  var $password;
  var $table;

  function __construct() {
    // call the model constructor
    parent::__construct();
    $this->table = "student";
    $this->load->database();
  }

  function getAll() {
      $rs = $this->db->get($this->table);
      $ds = array();
      if($rs->num_rows() > 0) {
        foreach($rs->result() as $row) {
          $ds[] = $row;
        }
        return $ds;
      }
      return false;
  }

  function getById($id) {
    $this->db->where("id", $id);
    $rs = $this->db->get($this->table);
    if($rs->num_rows() > 0) {
        return $rs->result()[0];
    }
    return false;
  }

  function update($record) {
    $this->db->update($this->table, $record, array("id" => $record['id']));
    if($this->db->affected_rows() > 0) {
      return true;
    }
    else false;
  }
}
