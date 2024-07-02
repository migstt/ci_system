<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Team_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_all_teams()
    {
        return $this->getRows('*', 'team', '', 'team_name ASC');
    }

    public function get_team_row_by_id($team_id)
    {
        return $this->getRow('*', 'team', array('team_id' => $team_id));
    }
}
