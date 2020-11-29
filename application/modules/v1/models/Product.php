<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model
{
    private $_table = 'products';

    public function rules()
    {
        return [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            [
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'required|min_length[5]|max_length[255]'
            ],
            [
                'field' => 'price',
                'label' => 'Price',
                'rules' => 'required|decimal|greater_than_equal_to[0]'
            ]
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }

    public function create()
    {
        $post = $this->input->post();
        $data = [
            'name' => $post["name"],
            'description' => $post["description"],
            'price' => $post['price']
        ];

        return $this->db->insert($this->_table, $data);
    }

    public function update($id)
    {
        $post = $this->input->post();
        $data = [
            'name' => $post["name"],
            'description' => $post["description"],
            'price' => $post['price']
        ];

        return $this->db->update($this->_table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ['id' => $id]);
    }
}