<?

/*
** author: dh@squidcode.com
*/

class Timer {
	
	private $timeArray = Array ();
	
	private function getTime() {
		$time = microtime();
		$time = explode (' ', $time);
		$time = $time [1] + $time [0];
		return $time;
	}
	
	private function extendRecord ($label) {
		$value = &$this->timeArray [$label];
		if ($value ["stop"] > 0) {
			$value ["range"] = $value ["stop"]-$value["start"];
			$value ["status"] = "stopped";
		} else {
			$value ["range"] = $this->getTime() - $value ["start"];
			$value ["status"] = "running";
		}
		$value ["range_human"] = sprintf ("%01.2f", $value ["range"]); 
	}
	
	public function start ($label) {
		$this->timeArray[$label]["start"] = $this->getTime();
		$this->timeArray[$label]["stop"] = 0;
	}
	
	public function stop ($label) {
		if (isset ($this->timeArray[$label]["stop"])) {
			$this->timeArray[$label]["stop"] = $this->getTime();
		}
	}
	
	public function stopAll () {
		foreach ($this->timeArray as $label => $value) $this->stop ($label);
	}
	
	public function del ($label) {
		if (isset ($this->timeArray[$label])) {
			unset ($this->timeArray[$label]);
		}
	}
	
	public function delAll () {
		$this->timeArray = Array ();
	}
	
	public function get ($label) {
		if (isset ($this->timeArray[$label])) {
			$this->extendRecord ($label);
			return $this->timeArray[$label];
		} else {
			return false;
		}
	}
	
	public function getAll () {
		foreach ($this->timeArray as $label => $value) $this->extendRecord ($label);
		return $this->timeArray;
	}
	
}

?>