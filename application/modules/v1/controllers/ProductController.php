<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');
require(APPPATH . 'libraries/Format.php');

class ProductController extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct();
        $this->load->model('Product');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $products = $this->Product->getAll();

        if ($products) {
            $this->response($products, 200);
        }
        else {
            $this->response(NULL, 404);
        }
    }

    public function get($id)
    {
        $product = $this->Product->getById($id);

        if ($product) {
            $this->response($product, 200);
        }
        else {
            $this->response(NULL, 404);
        }
    }

    public function create()
    {
        $product = $this->Product;
        $validation = $this->form_validation;

        $validation->set_rules($product->rules());

        if ($validation->run()) {
            $product->create();
            $this->response([
                'code' => 200,
                'status' => 'success'
            ]);
        }
        else {
            $this->response($this->validation_errors(), 404);
        }
    }

    public function update($id)
    {
        $product = $this->Product;
        $validation = $this->form_validation;

        $validation->set_rules($product->rules());

        if ($validation->run()) {
            if ( ! $this->Product->getById($id)) {
                $this->response([
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Product can not be found'
                ]);
            }
            else {
                $product->update($id);
                $this->response([
                    'code' => 200,
                    'status' => 'success'
                ]);
            }
        }
        else {
            $this->response($this->validation_errors(), 404);
        }
    }

    public function delete($id)
    {
        if ( ! $this->Product->getById($id)) {
            $this->response([
                'code' => 404,
                'status' => 'failed',
                'message' => 'Product can not be found'
            ]);
        }
        else {
            $this->Product->delete($id);
            $this->response([
                'code' => 200,
                'status' => 'success'
            ]);
        }
    }
}
