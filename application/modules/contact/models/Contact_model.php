<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function insert_contact($contact_data)
    {
        $inserted_contact_id = $this->insert('contacts', $contact_data, true);

        if (isset($inserted_contact_id)) {
            $user_contacts_data = array(
                'user_id' => $_SESSION['user_id'],
                'contact_id' => $inserted_contact_id
            );
            if ($this->insert('user_contacts', $user_contacts_data)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_user_specific_contacts($user_id)
    {
        $this->db->select('*');
        $this->db->from('user_contacts');
        $this->db->where('user_contacts.user_id', $user_id);
        $this->db->join('contacts', 'user_contacts.contact_id = contacts.contact_id');
        $this->db->where('contacts.contact_is_deleted', 0);
        $this->db->order_by('contacts.contact_first_name', 'ASC');
        return $this->db->get()->result();
    }

    public function update_contact($contact_id, $updated_contact_formdata)
    {
        $this->db->where('contact_id', $contact_id);
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
}
