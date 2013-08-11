<?php
use RedBean_Facade as R;
class Model_Voteub extends RedBean_SimpleModel
{

	public function update() {
		if (empty($this->id)) {
			$this->created = date('Y-m-d H:i:s');
			$this->active = 1;
		}
	}

	public function after_update() {
		R::exec(
			'UPDATE voteub SET active = 0 WHERE
				ip = ? AND
				(ua = ? OR fingerprint = ?) AND
				id != ?',
			array($this->ip, $this->ua, $this->fingerprint, $this->id)
		);

		$teube = $this->teube;

		$allVotes = $teube->getVotes();
		$voteValues = array();
		foreach ($allVotes as $vote)
			$voteValues[]= $vote->value;
		$teube->rating = array_sum($voteValues)/count($voteValues);
		R::store($teube);
	}
}