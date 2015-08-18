<?php


class StudentsApiControllerTest extends CIUnit_Framework_TestCase
{
    private $user;

    protected function setUp()
    {
      // Load the controller to be tested
      // TODO: set_controller method does not exist; gotta fix it.
      $this->CI = set_controller('api_students');//$this->get_instance()->load->library('../controllers/api_students');

      // Load the model to compare data
      $this->get_instance()->load->model('Model_Student', 'student');
      $this->student = $this->get_instance()->student;
    }

    public function testAll()
    {
        // Compare database data with data returned from a model call
        $students = $this->CI->all();

    }
}

?>
