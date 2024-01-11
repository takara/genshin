<?php

class Resin
{
	protected $targetResin = 40;

	public static function getInstance()
	{
		return new self();
	}

	public function setTarget(int $target)
	{
		$this->targetResin = $target;
		return $this;
	}

	public function calcTime(int $resin)
	{
		$rest = $this->targetResin - $resin;
		if ($rest < 0) {
			$rest = 0;
		}
		$rest *= 8;
		$now = time();
		$time = $now + $rest * 60;
		return date('Y/m/d H:i:s', $time);
	}
}
