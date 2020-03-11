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

function notifyRedirect($link, $message, $status){
  return redirect($link)->with(['status' => $status, 'message' => $message]);
}
