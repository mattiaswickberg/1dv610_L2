<?php

namespace View;
class DateTimeView {

	// Create and return string with current date and time
	public function show() : string
	{
		$timeString = date("l") . ', the ' . date("jS") . ' of ' . date("F") . ' ' . date("Y") .', The time is ' . date("h:i:s");

		return '<p>' . $timeString . '</p>';
	}	
}