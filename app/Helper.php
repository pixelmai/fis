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


function timeAgo($tm,$rcs = 0) {
  $cur_tm = time(); $dif = $cur_tm-$tm;
  $pds = array('second','minute','hour','day','week','month','year','decade');
  $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
  for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

  $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
  if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
  return $x . " ago";
}

function dateOnly($d) {
  return date("F jS, Y", strtotime($d));
}

function dateShortOnly($d) {
  return date("M j, Y", strtotime($d));
}

function notifyRedirect($link, $message, $status){
  return redirect($link)->with(['status' => $status, 'message' => $message]);
}

function sessionSetter($status, $message){
  session(['status' => $status, 'message' => $message]);
}





function dateDatabase($d) {
  return date('Y-m-d',strtotime($d));
}

function datetoDpicker($d) {
  return date('m/d/Y',strtotime($d));
}

function dateTimeFormat($d) {
  return date('M d, Y h:i A', strtotime($d));
}

function dateTimeFormatSimple($d) {
  return date('m/d/Y h:i A',strtotime($d));
}


function priceFormat($p){
  return round($p, 2);
}

function priceFormatFancy($p){
  return number_format(round($p, 2), 2);
}

function pricesInvoiceForm($p){
  return number_format($p, 2, '.', ''); //prints "2 013,00"
}


function priceFormatSaving($p){
  return round($p, 4);
}

function validateDate($date, $format = 'm/d/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}


function shortenText($t, $n){
  return substr($t, 0, $n). " ... ";
}

