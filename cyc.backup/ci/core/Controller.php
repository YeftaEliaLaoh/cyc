<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
  public function _env($error_code = 0, $payload = [], $message = '') {
    header("Content-Type: application/json");
        //0:success
        //1:error
        //2:success_with_custom_message
        //3:error_with_custom_message
    switch ($error_code) {
      case 0:
      if($message == '') {
        $message = 'Success.';
      }
      echo json_encode(['error_code' => $error_code, 'message' => $message, 'payload' => $payload]);
      break;
      case 1:
      $message = 'Unknown error.';
      echo json_encode(['error_code' => $error_code, 'message' => $message]);
      break;
      case 2:
      echo json_encode(['error_code' => $error_code, 'message' => $message, 'payload' => $payload]);
      break;
      case 3:
      echo json_encode(['error_code' => $error_code, 'message' => $message]);
      break;
    }
    die;
  }
  public function _env_datatables($error_code = 0, $payload = [], $message = '') {
    header("Content-Type: application/json");
        //0:success
        //1:error
        //2:success_with_custom_message
        //3:error_with_custom_message
    switch ($error_code) {
      case 0:
      $message = 'Success.';
      break;
      case 1:
      $message = 'Unknown error.';
      break;
    }
    echo json_encode($payload);
    die;
  }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */