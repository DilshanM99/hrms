<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @filesource
 *
 */

// load the MX_Loader class
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array();

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        //
        $CI = & get_instance();
    }

    /**
     * Service Loader
     *
     * Loads a service from the services directory in a module or application.
     *
     * @param string $service Service name (e.g., 'auth/auth_service')
     * @param string $name Optional object name
     * @param bool $return Whether to return the loaded service
     * @return object|bool
     */
    public function service($service, $name = '', $return = FALSE)
    {
        $CI =& get_instance();

        // Handle module-based service path
        if (strpos($service, '/') !== FALSE)
        {
            list($module, $service) = explode('/', $service, 2);
            $path = APPPATH . 'modules/' . $module . '/services/';
            $service_name = $service;
        }
        else
        {
            $path = APPPATH . 'services/';
            $service_name = $service;
        }

        // Convert service name to class name (e.g., 'auth_service' to 'Auth_service')
        $class = ucfirst($service_name);
        $file = $path . $class . '.php';

        // Check if file exists
        if (!file_exists($file))
        {
            show_error('Unable to locate the service file: ' . $file);
        }

        // Load the file
        include_once($file);

        // Check if class exists
        if (!class_exists($class, FALSE))
        {
            show_error('Service class does not exist: ' . $class);
        }

        // Instantiate the service
        $instance = new $class();

        // Assign to CI instance
        $name = ($name !== '') ? $name : strtolower($service_name);
        $CI->$name = $instance;

        if ($return)
        {
            return $instance;
        }

        return TRUE;
    }
}
