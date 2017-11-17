<?php
namespace Core;

/**
  * Request - the request params handler
  *
  * PHP version 7.0.10
  *
  * @author    Genadijs Aleksejenko <agenadij@gmail.com>
  * @copyright 2017 Genadijs Aleksejenko
  */
 
class Request {

    private $_request = array();
    public  $method = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->getRequestMethod();
        $this->_getInput();
    }

    /**
     * Get request method
     *
     * @return string request method
     */
    public function getRequestMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            }
            else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            }
            else {
                new ECore('405 Method Not Allowed');
            }
        }
        return $this->method;
    }

    /**
     * Get input
     *
     * @return void
     */
    private function _getInput()
    {
        switch($this->method) {
            case 'POST':
                $this->_request = $this->_cleanInput($_POST);
                break;
            case 'GET':
                $this->_request = $this->_cleanInput($_GET);
                break;
            case 'DELETE':
                $this->_request = $this->_cleanInput($_GET);
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $this->_request);
                $this->_request = $this->cleanInputs($this->_request);
                break;
            default:
                new ECore('405 Method Not Allowed');
            break;
        }
    }

    /**
     * Clean input
     *
     * @return mixed array
     */
    private function _cleanInput($data)
    {
        $input = array();
        if(is_array($data)) {
            foreach($data as $k => $v) {
                $input[$k] = $this->_cleanInput($v);
            }
        } else {
            $input = get_magic_quotes_gpc() ? stripslashes($data) : $data;
        }

        return $input;
    }

    /**
     * Allows to access request params as a class properties
     *
     * @param string $name The requested get key
     * @return mixed the requested value
      */

    public function __get($name)
    {
        if (array_key_exists($name, $this->_request)) {
            return $this->_request[$name];
        }
    return null;
    }

    /**
     * Allows to set request params
     *
     * @param string $name  The requested key
     * @param string $value The requested key
     * @return void
    */
    public function __set($name, $value)
    {
        $this->_request[$name] = $value;
    }

    /**
     * Display all request params
     *
     *@return void
    */
    public function getAll()
    {
        echo '<pre>';
        print_r($this->_request);
        echo '</pre>';
    }

    /**
     * Getting a whole request
     *
     * @param string $name name of parameter
     * @param bool   $html if true use htmlspecialchars
     * @return mixed the $this->request value
     */
    public function get($name = NULL, $html = true)
    {
        if ($html) {
            return (array_key_exists($name, $this->_request)) ? htmlspecialchars($this->_request[$name]) : NULL;
        }
        else {
            return (array_key_exists($name, $this->_request)) ? $this->_request[$name][1] : NULL;
        }
    }

    /**
     * Check if variable is set
     *
     * @param string $name name of parameter
     * @return mixed the $this->request value
     */
    public function is_set($name = NULL)
    {
        return (array_key_exists($name, $this->_request)) ? true : false;
    }

}
