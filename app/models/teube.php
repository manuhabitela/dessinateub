<?php
use RedBean_Facade as R;
class Model_Teube extends RedBean_SimpleModel
{
	public function open() {
		if (!file_exists($this->getDrawingPath()))
			$this->createDrawingFile();
		if (!file_exists($this->getDrawingPath('preview')))
			$this->createThumbnail();
		if (empty($this->views))
			$this->views = 0;
	}

	public function update() {
		if (empty($this->id)) {
			$this->created = date('Y-m-d H:i:s');
			$this->active = 1;
		}
	}

	public function after_update() {
		if ($this->createDrawingFile())
			$this->createThumbnail();
	}

	public function delete() {
		$this->deleteDrawingFile();
		$this->deleteThumbnail();
	}

	public function getVotes() {
		$votes = R::find('voteub', 'teube_id = ? AND active = 1 ORDER BY created DESC', array($this->id));
		return $votes;
	}

	public function getSibling($field = 'id', $direction = 'next') {
		$query = "";
		//c'est pas terrible mais c'est déjà ça...
		//en faisant comme ça on choppe pas les items qui ont une valeur égale
		//mais si on prend les trucs avec valeur égale ça peut tourner en rond facilement ensuite, donc tant pis
		//pour l'instant on laisse comme ça
		if ($direction === "next")
			$query = $field.' = (SELECT MIN('.$field.') FROM teube WHERE active = 1 AND '.$field.' > ?) AND id <> ? AND active = 1';
		elseif ($direction === "prev")
			$query = $field.' = (SELECT MAX('.$field.') FROM teube WHERE active = 1 AND '.$field.' < ?) AND id <> ? AND active = 1';
		else
			return null;
		$teu = R::findOne('teube', $query, array($this->{$field}, $this->id));
		return $teu && $teu->id ? $teu : null;
	}

	public function report() {
		if (empty($this->reports))
			$this->reports = 0;
		$this->reports++;
		if ($this->reports > 5) {
			$message = "La teube ".$this->name." (n°".$this->id.") créée le ".date("d/m/Y", strtotime($this->created))." par ".$this->artist." a été signalée pour la ".$this->reports.($this->reports > 1 ? "ème" : "ère")." fois";
			$message .= "\n\nhttp://jaiunegrosseteu.be/regarder/".$this->id;
			mail(APP_ADMIN_MAIL, "jaiunegrosseteu.be : ".$this->name." signalée", $message, 'From:bot@jaiunegrosseteu.be');
		}
		return R::store($this);
	}

	public function updatePageViews() {
		$piwikXMLFile = file_get_contents("http://".APP_PIWIK_SERVER."/index.php?module=API&method=CustomVariables.getCustomVariables&idSite=".APP_PIWIK_ID."&period=year&date=2013-09-01&format=xml&token_auth=".APP_PIWIK_API."&segment=customVariablePageName1==teubeView;customVariablePageValue1==".$this->id);
		if ($piwikXMLFile) {
			$piwikXML = simplexml_load_string($piwikXMLFile);
			$this->views = (int) $piwikXML->row->nb_actions;
			return R::store($this);
		}
		return false;
	}

	public function updateRatings() {
		$teubeVotes = $this->getVotes();
		$teubeVotesCount = count($teubeVotes);
		$voteValues = array();
		if (!$teubeVotesCount)
			return false;
		foreach ($teubeVotes as $vote)
			$voteValues[]= $vote->value;
		$this->avg_rating = array_sum($voteValues)/$teubeVotesCount;

		//http://masanjin.net/blog/bayesian-average
		$allTeubesAvgRating = R::getCell('SELECT AVG(avg_rating) FROM teube WHERE active = 1 AND avg_rating IS NOT NULL');
		if (empty($allTeubesAvgRating)) $allTeubesAvgRating = 3;
		// $allTeubesAvgRating = 3;

		$minVotesNumber = R::getCell('SELECT COUNT(id) FROM voteub WHERE active = 1');
		$minVotesNumber = empty($minVotesNumber) || ceil($minVotesNumber/10) < 5 ? 5 : ceil($minVotesNumber/10);
		$this->w_rating = (($teubeVotesCount / ($teubeVotesCount + $minVotesNumber)) * $this->avg_rating) + (($minVotesNumber / ($teubeVotesCount+$minVotesNumber)) * $allTeubesAvgRating);

		$this->ratings_count = $teubeVotesCount;
		R::store($this);
	}

	public function getUserVote($fingerprint = false) {
		$query = 'active = 1 AND teube_id = ? AND ip = ? AND (ua = ? '.($fingerprint ? ' OR fingerprint = ?)' : ')');
		$bindings = array($this->id, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		if ($fingerprint) $bindings[]= $fingerprint;
		$vote = R::findOne('voteub', $query, $bindings);
		return !empty($vote->id) ? $vote : null;
	}

	public function getDrawingPath($thumb = '') {
		return WEBROOT_PATH.'/drawings/'.$this->id.'.'.$thumb.'.png';
	}

	public function createDrawingFile() {
		if (empty($this->image)) return false;
		//http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
		$img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $this->image));
		$data = base64_decode($img);
		return file_put_contents($this->getDrawingPath(), $data);
	}

	public function createThumbnail() {
		if (!file_exists($this->getDrawingPath())) return false;
		$thumb = new PHPThumb\GD($this->getDrawingPath());
		$thumb->adaptiveResize(200, 200);
		$thumb->save($this->getDrawingPath('preview'));
	}

	public function deleteDrawingFile() {
		return unlink($this->getDrawingPath());
	}

	public function deleleThumbnail() {
		return unlink($this->getDrawingPath('preview'));
	}
}