<?php

class About extends Controller {
    public function index($nama = 'Kiki', $kelas = 'X PPLG 1', $umur = 16) {
      $data['nama'] = $nama;
      $data['kelas'] = $kelas;
      $data['umur'] = $umur;

        $data['judul'] = 'About';
        $this->view('templates/navbar', $data);
        $this->view('about/landing', $data);
        $this->view('templates/footer');
    
    }
    public function page()
    {
        $data['judul'] = 'Page';
        $this->view('templates/navb', $data);
        $this->view( 'About/page', $data);
        $this->view('templates/footer');
    }
}