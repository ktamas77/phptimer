<?

/*
** author: dh@squidcode.com
*/

class Timer {

	// --- private ---
	var $privateTime = Array ();
	var $timeArray = Array ();
	
	// --- private ---
	function getTime() {
		$time = microtime();
		$time = explode (' ', $time);
		$time = $time [1] + $time [0];
		return $time;
	}
	
	// --- private ---
	function extendRecord ($label) {
		$value = &$this->timeArray [$label];
		if ($value ["stop"] > 0) {
			$value ["range"] = $this->privateTime [$label]["allranges"];
			$value ["status"] = "stopped";
		} else {
			$value ["range"] = ($this->getTime() - $value ["start"]) + $this->privateTime [$label]["allranges"];
			$value ["status"] = "running";
		}
		$value ["average"] = $value["range"]/$value["starts"];
		$value ["average_human"] = sprintf ("%01.2f", $value ["average"]); 
		$value ["range_human"] = sprintf ("%01.2f", $value ["range"]); 
	}
	
	// === public ===
	function start ($label) {
		$this->timeArray[$label]["start"] = $this->getTime();
		$this->timeArray[$label]["stop"] = 0;
		if (! isset ($this->timeArray[$label]["starts"])) $this->timeArray[$label]["starts"] = 1; else $this->timeArray[$label]["starts"]++;
		if (! isset ($this->privateTime [$label]["allranges"])) $this->privateTime [$label]["allranges"] = 0;
	}
	
	// === public ===
	function stop ($label) {
		if (isset ($this->timeArray[$label]["stop"])) {
			$this->timeArray[$label]["stop"] = $this->getTime();
			$this->privateTime [$label]["allranges"] += $this->timeArray[$label]["stop"]-$this->timeArray[$label]["start"];
		}
	}
	
	// === public ===	
	function restart ($label) {
		if (isset ($this->timeArray[$label]["stop"]))	unset ($this->privateTime [$label]["allranges"]);
		$this->start ($label);
	}

	// === public ===
	function stopAll () {
		foreach ($this->timeArray as $label => $value) $this->stop ($label);
	}
	
	// === public ===
	function del ($label) {
		if (isset ($this->timeArray[$label])) {
			unset ($this->timeArray[$label]);
		}
	}
	
	// === public ===
	function delAll () {
		$this->timeArray = Array ();
	}
	
	// === public ===
	function get ($label) {
		if (isset ($this->timeArray[$label])) {
			$this->extendRecord ($label);
			return $this->timeArray[$label];
		} else {
			return false;
		}
	}
	
	// === public ===
	function getAll () {
		foreach ($this->timeArray as $label => $value) $this->extendRecord ($label);
		return $this->timeArray;
	}
	
}

?>