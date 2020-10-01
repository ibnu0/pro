<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('model_blog');
		$this->load->helper(array('text'));
		$this->load->library('form_validation');
		
    }

	public function index(){
	
		$data['sidebar'] = $this->model_blog->get_where();
		$data['berita'] = $this->model_blog->get('berita');
		$data['title'] = 'Blog';
		$data['content'] = 'page/blog.php';
		$this->load->view('index',$data);
	}

	public function detail($id,$slug){
		$data['komentar'] = $this->db->query("SELECT * FROM komentar WHERE fk_berita = $id ")->result();
		$data['detail'] = $this->model_blog->get_detail('berita','id_berita',$id);  	
		$data['sidebar'] = $this->model_blog->get_where();
		$data['content']='page/detail';
		$this->form_validation->set_rules('email','email','required|valid_email');
		$this->form_validation->set_rules('komentar','komentar','required');
		if ($this->form_validation->run()== FALSE) {
		}else if (isset($_POST['kirim'])) {
			$email = $this->input->post('email');
			$komentar = $this->input->post('komentar');
			$fk_berita = $id;
			$dt = array(
                'email' => $email,
                'komentar' => $komentar,
                'fk_berita' => $fk_berita
			);
			$this->model_blog->insert('komentar',$dt);
		}
		$this->load->view('index',$data);
	}

}