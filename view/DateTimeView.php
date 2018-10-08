<?php

namespace View;
class DateTimeView {


	public function show() 
	{

		$timeString = date("l") . ', the ' . date("jS") . ' of ' . date("F") . ' ' . date("Y") .', The time is ' . date("h:i:s");

		return '<p>' . $timeString . '</p>';
	}	
}