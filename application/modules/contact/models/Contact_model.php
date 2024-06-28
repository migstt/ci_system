<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public function insert_contact($shared_contact_formdata, $selected_user)
    {
        $inserted_contact_id = $this->insert('contacts', $shared_contact_formdata, true);

        if (isset($inserted_contact_id)) {
            $user_contacts_data = array(
                'user_id' => $selected_user,
                'contact_id' => $inserted_contact_id
            );
            if ($this->share_contact($user_contacts_data)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_user_specific_contacts($user_id, $limit = 0, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('user_contacts');
        $this->db->where('user_contacts.user_id', $user_id);
        $this->db->join('contacts', 'user_contacts.contact_id = contacts.contact_id');
        $this->db->where('contacts.contact_is_deleted', 0);
        $this->db->order_by('contacts.contact_first_name', 'ASC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_user_specific_contacts($user_id)
    {
        $this->db->from('user_contacts');
        $this->db->where('user_contacts.user_id', $user_id);
        $this->db->join('contacts', 'user_contacts.contact_id = contacts.contact_id');
        $this->db->where('contacts.contact_is_deleted', 0);
        return $this->db->count_all_results();
    }

    public function update_contact($user_id, $contact_id, $updated_contact_formdata)
    {
        $this->db->where('contact_id', $contact_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->update('contacts', $updated_contact_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function share_contact($user_contacts_data)
    {
        if ($this->insert('user_contacts', $user_contacts_data)) {
            return true;
        }
        return false;
    }

    public function check_contact_exist($selected_user, $contact_email)
    {
        $where = 'user_id=' . $selected_user . ' AND contact_email=' . $contact_email . ' AND contact_is_deleted=0';
        $result = $this->getRow('*', 'contacts', $where);
        if ($result) {
            return true;
        }
        return false;
    }

    public function get_contact_row($field, $table, $contact_id)
    {
        $where = 'contact_id=' . $contact_id;
        $this->getRow($field, $table, $where);
    }
}
