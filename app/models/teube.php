<?php
class Model_Teube extends RedBean_SimpleModel
{
	protected $folder;

	public function __construct() {
		$this->folder = WEBROOT_PATH.'/drawings/';
	}

	public function after_update() {
		//http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
		$img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $this->bean->image));
		$data = base64_decode($img);
		$file = $this->folder . $this->bean->id . '.png';
		file_put_contents($file, $data);
	}

	public function after_delete() {
		unlink($this->folder . $this->bean->id . '.png');
	}
}