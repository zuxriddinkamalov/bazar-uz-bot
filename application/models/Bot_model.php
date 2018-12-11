<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Zuxriddin
 * Date: 08.07.2018
 * Time: 23:05
 */
class Bot_model extends CI_Model
{
    public function set_session($data)
    {
        return $this->db->replace('session', $data);
    }

    public function get_session($user_id)
    {
        $this->db->where('user_id', $user_id);
        $session = $this->db->get('session');
        return $session->row();
    }

    public function add_announcement($data)
    {
        return $this->db->insert('announcement', $data);
    }

    public function get_unpublished_announcement()
    {
        $this->db->where(array
            (
                'date <=' => 'DATE_SUB(NOW(), INTERVAL 1 hour)',
                'published' => '0',
                'status' => '1'
            )
        );
        $anouncements = $this->db->get('announcement');
        return $anouncements->result();
    }

    public function inactive_announcement($id)
    {
        return $this->db->replace('announcement', array(
            'id' => $id,
            'published' => '1'
        ));
    }
}