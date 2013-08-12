<?php
use RedBean_Facade as R;
class Model_Teube extends RedBean_SimpleModel
{
	public function open() {
		if (!file_exists($this->getDrawingPath()))
			$this->createDrawingFile();
		if ($this->rating)
			$this->rating = round($this->rating, 1);
	}

	public function update() {
		if (empty($this->id)) {
			$this->created = date('Y-m-d H:i:s');
		}
	}

	public function after_update() {
		$this->createDrawingFile();
	}

	public function delete() {
		$this->deleteDrawingFile();
	}

	public function getVotes() {
		$votes = R::find('voteub', 'teube_id = ? AND active = 1 ORDER BY created DESC', array($this->id));
		return $votes;
	}

	public function getUserVote($fingerprint = false) {
		$query = 'active = 1 AND teube_id = ? AND ip = ? AND (ua = ? '.($fingerprint ? ' OR fingerprint = ?)' : ')');
		$bindings = array($this->id, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		if ($fingerprint) $bindings[]= $fingerprint;
		$vote = R::findOne('voteub', $query, $bindings);
		return !empty($vote->id) ? $vote : null;
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