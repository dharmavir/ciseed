<?php

class StudentModelTest extends CIUnit_Framework_TestCase
{
    private $user;

    protected function setUp()
    {
      // Load the model to be tested
      $this->get_instance()->load->model('Model_Student', 'student');
      $this->student = $this->get_instance()->student;
      // Load database to compare result fetched from model to actual data
      $this->get_instance()->load->database();
    }

    public function testGetAll()
    {
        // Compare database data with data returned from a model call
        $rs = $this->get_instance()->db->get('student');
        $ds = array();

        foreach($rs->result() as $row) {
          $ds[] = $row;
        }
        $this->assertEquals($ds, $this->student->getAll());
    }

    public function testUpdate()
    {
      $student = array(
        "id" => 1,
        "user_name" => 'user_updated_' . mktime(),
        "password" => 'super-secret' . mktime()
      );

      if($this->student->update($student) == true) {
        $this->assertEquals((object)$student, $this->student->getById(1));
      }
    }
}

?>
