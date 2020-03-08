<?php

/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
function gmtDate($timezone = '8')
{
	$gmt_date = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
	return $gmt_date;
}