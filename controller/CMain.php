<?php
namespace Controller;

/**
  * CMain controller
  *
  * PHP version 7.0.10
  *
  * @author    Genadijs Aleksejenko <agenadij@gmail.com>
  * @copyright 2017 Genadijs Aleksejenko
  */
class CMain extends Base
{
    private $_data;

    /**
     * Constructor
     *
     * @param object $App App object
     * @return void
     */
    public function __construct($App)
    {
        parent::__construct($App);
    }

    /**
     * Main action
     *
     * @return void
     */
    public function main()
    {
        $this->_data = '';

        if (!$this->App->session->is_set('user_id')) {
            $this->render(\Core\App::view_path() . 'login');
        } else {
            $this->render(\Core\App::view_path() . 'main', $this->_data);
        }
    }
}
