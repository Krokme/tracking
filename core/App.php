<?php
namespace Core;

/**
  * App - base application class
  *
  * PHP version 7.0.10
  *
  * @author    Genadijs Aleksejenko <agenadij@gmail.com>
  * @copyright 2017 Genadijs Aleksejenko
  */
 
class App
{
    public $request;
    public $controller;
    public static $action = 'main';
    public static $views_path;
    private $_session_id = null;

    /**
     * Initialization
     *
     * @param string $agent
     * @return void
     */
    public function __construct()
    {
        require_once(BASE_DIR . CORE_PATH . DS . 'ECore.php');
        require_once(BASE_DIR . 'controller/Base.php');

        foreach ($GLOBALS['CORE_CLASSES'] as $var => $class) {
            $path = explode('\\', $class);

            require_once  BASE_DIR . $path[0] . DS . $path[1] .'.php';
            $this->$var = new $class($this);
        }
    }

    /**
     * Application autolod
     *
     * @return void
     */
    private function autoload()
    {

    }

    /**
     * Application rout
     *
     * @return void
     */
    private function _rout($path)
    {
        $controller = '';
        $path = str_replace('?' . $_SERVER['QUERY_STRING'], '', $path);

        if ($path != '/') {
            $path = substr($path, 1);
            $a = explode('/', $path);
            $url = strtolower(array_shift($a));

            $pattern = '/^[a-z][a-z-]+/i';
            if (preg_match_all($pattern, $url)) {
                self::$views_path = ucfirst($url) . DS;
                $b = explode('-', $url);

                foreach ($b as $v) {
                    $controller .= ucfirst(strtolower($v));
                }
                if (isset($a[0]) && preg_match_all($pattern, $a[0])) {
                    self::$action = array_shift($a);
                }
                $this->request->args = $a;
            } else {
                $this->request->args = explode('/', $path);
            }
        }
        $this->controller = !empty($controller) ? 'C'.$controller : 'CMain';
    }

    public function run()
    {
        $script_name = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $url = str_replace($script_name, '', $_SERVER['REQUEST_URI']);

        $this->_rout($url);

        if (file_exists(BASE_DIR . 'controller' . DS . $this->controller . '.php')) {
            require_once BASE_DIR . 'controller' . DS . $this->controller . '.php';
            $controller = '\Controller\\' . $this->controller;
            $controller = new $controller($this);
            $action = self::$action;
            $controller->$action();
        } else {
           new \ECore('Can\'t load controller ' . $this->controller);
        }
    }

    /**
     * Get current action
     *
     * @return string
     */
    private static function action()
    {
        return self::$action;
    }

    /**
     * Get current path
     *
     * @return string
     */
    public static function view_path()
    {
        return self::$views_path;
    }

    /**
     * Set session id
     *
     * @param string $session_id
     * @return void
     */
    public function setSessionId($session_id)
    {
        $this->_session_id = $session_id;
    }

    /**
     * Geet session id
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->_session_id;
    }

    /**
     * Dump App
     *
     * @return void
     */
    public function dump()
    {
        echo '<pre>';
        print_r($this);
        echo '</pre>';
    }
}
