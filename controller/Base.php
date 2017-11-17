<?php
namespace Controller;

/**
  * Controller base class
  *
  * PHP version 7.0.10
  *
  * @author    Genadijs Aleksejenko <agenadij@gmail.com>
  * @copyright 2017 Genadijs Aleksejenko
  */
class Base
{
    private $model;
    public  $App;

    /**
     * Constructor
     *
     * @param obj $App App object
     * @return void
     */
    public function __construct($App)
    {
        $this->App = $App;
    }

    public function run()
    {
        $this->render();
    }

    public function render($view_name = null, $data = null)
    {
        if ($data instanceof stdClass) {
            $data = (array) $data;
        }

        require_once BASE_DIR . 'views' . DS . $view_name . '.php';
    }
}
