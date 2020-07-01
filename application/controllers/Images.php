<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Images extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'form']);
		$this->load->model('images_model');
	}

	public function index()
	{
		if ($this->input->post('upload')) {
			$this->doUpload();
		}

		$data['images'] = $this->images_model->getAllImages();

		$this->load->view('images', $data);
	}

	public function getImage($id)
	{
		if ($image = $this->images_model->getImage($id)) {
			header("Content-type: " . $image->mime);
			header('Content-Length: ' . strlen($image->image_raw));
			echo $image->image_raw;
		} else {
			show_404();
		}
	}

	public function doUpload()
	{
		$this->load->library(['upload']);

		$images = [];
		$files = $_FILES;

		$filesCount = count($_FILES['images']['name']);

		for ($i = 0; $i < $filesCount; $i++) {
			$_FILES['userfile']['name'] = $files['images']['name'][$i];
			$_FILES['userfile']['type'] = $files['images']['type'][$i];
			$_FILES['userfile']['tmp_name'] = $files['images']['tmp_name'][$i];
			$_FILES['userfile']['error'] = $files['images']['error'][$i];
			$_FILES['userfile']['size'] = $files['images']['size'][$i];

			$this->upload->initialize([
				'upload_path' => './uploads/',
				'overwrite' => true,
				'max_filename' => 255,
				'remove_spaces' => true,
				'allowed_types' => 'gif|jpg|png',
				'max_size' => 1024,
				'xss_clean' => true,
			]);

			if ($this->upload->do_upload()) {
				$images[] = $this->upload->data();
			} else {
				echo $this->upload->display_errors();
			}
		}

		foreach ($images as $image) {
			if ($image['is_image']) {
				$imagesData = [
					'filename' => $image['file_name'],
					'mime' => $image['file_type'],
					'image_raw' => file_get_contents($image['full_path'])
				];

				$this->images_model->addImage($imagesData);
			}
		}
	}
}
