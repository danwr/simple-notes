<?php

function relativeDate($datetime) {
	$todayStart = new DateTime();
	$hoursBeforeNow = ($todayStart->getTimestamp() - $datetime->getTimestamp()) / 3600.0;
	$todayStart->setTime(0, 0, 0); // midnight
	$hoursBeforeToday = ($todayStart->getTimestamp() - $datetime->getTimestamp()) / 3600.0;
	
	$isToday = ($todayStart->format('Y-m-d') == $datetime->format('Y-m-d'));
	$yesterday = new DateTime("yesterday");
	$isYesterday = ($yesterday->format('Y-m-d') == $datetime->format('Y-m-d'));
	
	if ($hoursBeforeNow < 0) {
		return $datetime->format('Y-m-d');
	} else if ($hoursBeforeNow < 1.5) {
		$minutesBeforeNow = $hoursBeforeNow * 60.0;
		if ($minutesBeforeNow < 10.0) {
			return "just now";
		} else if ($minutesBeforeNow < 45.0) {
			return "minutes ago";
		} else {
			return "an hour ago";
		}
	} else if ($hoursBeforeNow < 3.0) {
		return "a couple hours ago";
	} else if ($hoursBeforeNow < 8.0 && !$isToday) {
		return "several hours ago";
	} else if ($isToday) {
		return "today";
	} else if ($isYesterday) {
		return "yesterday";
	} else if ($hoursBeforeNow <= 24.0*28.5) {
		return sprintf("%d days ago", (int)ceil($hoursBeforeNow / 24.0));
	} else if ($hoursBeforeNow <= 24.0*7.0*10.0) {
		return sprintf("%d weeks ago", (int)ceil($hoursBeforeNow / (24.0*7.0)));
	} else {
		return $datetime->format('F Y');
	}
}

?>
