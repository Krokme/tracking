<?php
namespace Controller;

/**
  * CTickets controller
  *
  * PHP version 7.0.10
  *
  * @author    Genadijs Aleksejenko <agenadij@gmail.com>
  * @copyright 2017 Genadijs Aleksejenko
  */
class CTickets extends Base
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
        $data = [];
        $rows = $this->App->db->getAll('SELECT t.id, t.name, t.created, t.updated, t.priority, t.status, 
                                        p.name AS project_name FROM ' . TICKETS_TBL . ' AS t 
                                        LEFT JOIN ' . PROJECTS_TBL . ' AS p 
                                        ON t.project_id = p.id WHERE user_id = :user_id ORDER BY id',
                                        array('user_id' => (int) $this->App->session->get('user_id')));

        foreach ($rows as $row) {
            if ($row['priority'] == 0) {
                $row['priority'] = 'Normal';
            }
            if ($row['priority'] == 1) {
                $row['priority'] = 'Low';
            }
            if ($row['priority'] == 2) {
                $row['priority'] = 'Hight';
            }
            if ($row['status'] == 0) {
                $row['status'] = 'Open';
            } else {
                $row['status'] = 'Finished';
            }
            $row['edit'] = '<a data-toggle="modal" href="' . PROJECT_PATH . 'tickets/edit?id=' . $row['id'] .
                           '&refresh=' . md5($row['id']) . '" data-target="#editTicket">Edit</a>';
            $data[] = $row;
        }

        exit(json_encode(['data' => $data]));
    }

    /**
     * Edit action
     *
     * @return void
     */
    public function edit()
    {
        $this->_data = ['id' => '', 'projects' => []];

        $rs = $this->App->db->getAll('SELECT * FROM ' . PROJECTS_TBL . ' ORDER BY name');
        $this->_data['projects'] = $rs;

        if ($this->App->request->method != 'POST' && $this->App->request->is_set('id')) {
            $rs = $this->App->db->getRow('SELECT * FROM ' . TICKETS_TBL . ' WHERE id = :id',
                                         array('id' => $this->App->request->get('id')));

            if ($rs) {
                $this->App->request->name = $rs['name'];
                $this->App->request->project = $rs['project_id'];
                $this->App->request->priority = $rs['priority'];
                $this->App->request->status = $rs['status'];
            }
        }

        if ($this->App->request->method == 'POST') {
            $error = '';
            if (empty($this->App->request->get('name'))) {
                $error = 'Incorrect name!';
            }
            if (empty($error)) {
                if (!empty($this->App->request->get('id'))) {
                    // update
                    $this->App->db->update(TICKETS_TBL, array('name' => $this->App->request->get('name'),
                                                              'project_id' => (int) $this->App->request->get('project'),
                                                              'priority' => (int) $this->App->request->get('priority'),
                                                              'status' => (int) $this->App->request->get('status'),
                                                              'updated' => (string) date('Y-m-d H:i:s')),
                                                              ' id = ' . (int) $this->App->request->get('id'));
                } else {
                    // insert
                    $this->App->db->insert(TICKETS_TBL, array('name' => $this->App->request->get('name'),
                                                              'project_id' => (int) $this->App->request->get('project'),
                                                              'priority' => (int) $this->App->request->get('priority'),
                                                              'status' => (int) $this->App->request->get('status'),
                                                              'user_id' => (int) $this->App->session->get('user_id')));
                }
                exit(json_encode(['success' => true]));
                exit;
            } else {
                exit(json_encode(['success' => false, 'error' => $error]));
                exit;
            }
        }

        $this->render(\Core\App::view_path() . 'ticket_edit', $this->_data);
    }
}
