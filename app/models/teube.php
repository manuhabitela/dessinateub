<?php
use RedBean_Facade as R;
class Model_Teube extends RedBean_SimpleModel
{
	public function open() {

		if (!file_exists($this->getDrawingPath()))
			$this->createDrawingFile();
	}

	}

	public function after_update() {
		$this->createDrawingFile();
	}

	public function after_delete() {
		$this->deleteDrawingFile();
	}

	public function getDrawingPath() {
		return WEBROOT_PATH.'/drawings/'.$this->id.'.png';
	}

	public function createDrawingFile() {
		if (empty($this->image)) return false;
		//http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
		$img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $this->image));
		$data = base64_decode($img);
		return file_put_contents($this->getDrawingPath(), $data);
	}

	public function deleteDrawingFile() {
		return unlink($this->getDrawingPath());
	}
}