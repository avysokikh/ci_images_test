<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Images_model extends CI_Model
{
	public function getAllImages()
	{
		$this->db->order_by('id');

		return $this->db->get('images')->result();
	}

	public function getImage($id)
	{
		$this->db->where('id', $id);

		return $this->db->get('images')->row();
	}

	public function addImage($imageData)
	{
		return $this->db->insert('images', $imageData);
	}
}
