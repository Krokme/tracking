<?php
namespace Controller;

/**
  * CLogin controller
  *
  * PHP version 7.0.10
  *
  * @author    Genadijs Aleksejenko <agenadij@gmail.com>
  * @copyright 2017 Genadijs Aleksejenko
  */
class CLogin extends Base
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
        if ($this->App->request->is_set('user_name') &&
            $this->App->request->is_set('password') &&
            $this->App->request->method == 'POST') {

            $rs = $this->App->db->getRow('SELECT id, name, user_name FROM ' . USERS_TBL . ' WHERE user_name = :user_name AND psw = :psw',
                                          array('user_name' => $this->App->request->get('user_name'),
                                                'psw' => md5($this->App->request->get('password'))));

            if ($rs) {
                $this->App->db->update(USERS_TBL, array('expires' => (int) $this->App->session->life_time,
                                                        'tocken' => $this->App->getSessionId()),
                                                  ' id = ' . $rs['id']);

                $this->App->session->set('user_id', $rs['id']);
                $this->App->session->set('user_name', $rs['name']);
                $this->App->session->set('user_uname', $rs['user_name']);
                exit(json_encode(['success' => true]));
            }
            exit(json_encode(['success' => false, 'error' => 'Incorrect Username or Password!']));

        } else {
            exit(json_encode(['success' => false, 'error' => 'Incorrect Username or Password!']));
        }
    }

    /**
     * Logout action
     *
     * @return void
     */
    public function logout()
    {
        $this->App->session->destroy(session_id());
        Header('Location: http://' . FULL_PATH);
        exit;
    }
}
