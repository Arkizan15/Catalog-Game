<?php

class Catalog extends Controller{
    public function  index()
    {
        $data['judul'] = 'Catalog';
        $this->view('templates/navbar', $data);
        $this->view('catalog/index', $data);
        $this->view('templates/footer');
       
    }

   
}