<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Zuxriddin
 * Date: 24.08.2018
 * Time: 15:42
 */

class Announcement_model extends CI_Model
{
    public function get($condition, $limit, $offset) {
        $this->db->select('announcement.*, session.login');
        $this->db->join('session', 'announcement.id_user=session.user_id', 'LEFT');
        $this->db->where($condition);
        $this->db->order_by('date', 'DESC');
        $announcement = $this->db->get('announcement', $limit, $offset);
        return $announcement->result();
    }

    public function get_announce($id) {
        $this->db->select('announcement.*, session.login');
        $this->db->where('id', $id);
        $this->db->join('session', 'announcement.id_user=session.user_id', 'LEFT');
        $announcement = $this->db->get('announcement');
        return $announcement->row();
    }

    public function count($condition = []) {
        $this->db->select('count(*) as count');
        $this->db->where($condition);
        $count = $this->db->get('announcement');
        $count = $count->row();
        return $count->count;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('announcement');
    }

    public function update($id, $data)
    {
        $announce = $this->get_announce($id);
        if ($announce) {
            @unlink( "./uploads/{$announce->picture}" );
        }
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('announcement');
    }
}