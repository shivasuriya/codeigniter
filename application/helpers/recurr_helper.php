<?php
require_once(APPPATH."../../interface/main/calendar/modules/PostCalendar/pnincludes/Date/Calc.php");
include_once(APPPATH."../../library/encounter_events.inc.php");

function recurre_events_for_mobileapp($event_row)
{
        $sdate = $event_row['pc_eventDate'];
        $edate = $event_row['pc_endDate'];
        $sy = substr($sdate,0,4);
        $sm = substr($sdate,5,2);
        $sd = substr($sdate,8,2);
        $ey = substr($edate,0,4);
        $em = substr($edate,5,2);
        $ed = substr($edate,8,2);
        $recurr =  unserialize($event_row['pc_recurrspec']);
        $repeat_freq =$recurr['event_repeat_freq'];

        $days = array();
        $sday = Date_Calc::dateToDays($sd,$sm,$sy);
        $eday = Date_Calc::dateToDays($ed,$em,$ey);
        for($cday = $sday; $cday <= $eday; $cday++) {
                $d = Date_Calc::daysToDate($cday,'%d');
                $m = Date_Calc::daysToDate($cday,'%m');
                $y = Date_Calc::daysToDate($cday,'%Y');
                $store_date = Date_Calc::dateFormat($d,$m,$y,'%Y-%m-%d');
                $days[$store_date] = array();
        }
        return $days;
}

function calculate_recurr_dates($days,$event)
{
        $date = date("Y-m-d");
        $cy = substr($date,0,4);
        $cm = substr($date,4,2);
        $cd = substr($date,6,2);
        list($esY,$esM,$esD) = explode('-',$event['pc_eventDate']);
        $event_recurrspec = @unserialize($event['pc_recurrspec']);
        if($event['pc_endDate'] == '0000-00-00') {
                $stop = $date;
        } else {
                $stop = $event['pc_endDate'];
        }
        $start_date = "$cy-$cm-$cd";
        $days_keys = array_keys($days);
        $start_date = $days_keys[0];

        $eventD = $event['pc_eventDate'];
        $eventS = $event['pc_startTime'];
        switch($event['pc_recurrtype']) {

                // Events that do not repeat only have a startday
                case 0 :
                                                                                                                                                                                                     
			if(isset($days[$event['pc_eventDate']])) {
                                array_push($days[$event['pc_eventDate']],"1");
                        }else{
                                unset($days[$event['pc_eventDate']]);
                        }
                        break;

                        //  Events that repeat at a certain frequency
                case 1 :

                        $rfreq = $event_recurrspec['event_repeat_freq'];
                        $rtype = $event_recurrspec['event_repeat_freq_type'];
                        $exdate = $event_recurrspec['exdate'];
                        $nm = $esM; $ny = $esY; $nd = $esD;
                        $occurance = Date_Calc::dateFormat($nd,$nm,$ny,'%Y-%m-%d');
                        while($occurance < $start_date) {
                                $occurance =& __increment($nd,$nm,$ny,$rfreq,$rtype);
                                list($ny,$nm,$nd) = explode('-',$occurance);
                        }
                        while($occurance <= $stop) {
                                if(isset($days[$occurance])) {
                                        $excluded = false;
                                        if (isset($exdate)) {
                                                foreach (explode(",", $exdate) as $exception) {
                                                        if (preg_replace("/-/", "", $occurance) == $exception) {
                                                                $excluded = true;
                                                                unset($days[$occurance]);
                                                        }
                                                }
                                        }
                                        if ($excluded == false){
                                                array_push($days[$occurance],"1");
                                        }else{
                                                unset($days[$occurance]);
                                        }

                                }
                                $occurance =& __increment($nd,$nm,$ny,$rfreq,$rtype);
                                list($ny,$nm,$nd) = explode('-',$occurance);
                        }
                        break;

                        //  Events that repeat on certain parameters
                case 2 :

                        $rfreq = $event_recurrspec['event_repeat_on_freq'];
                        $rnum  = $event_recurrspec['event_repeat_on_num'];
                        $rday  = $event_recurrspec['event_repeat_on_day'];
                        $exdate = $event_recurrspec['exdate'];
                        $nm = $esM; $ny = $esY; $nd = $esD;

                        while($ny < $cy) {
 $occurance = date('Y-m-d',mktime(0,0,0,$nm+$rfreq,$nd,$ny));
                                list($ny,$nm,$nd) = explode('-',$occurance);
                        }

                        while($ny <= $cy) {
                                $dnum = $rnum;
                                do {
                                        $occurance = Date_Calc::NWeekdayOfMonth($dnum--,$rday,$nm,$ny,$format="%Y-%m-%d");
                                } while($occurance === -1);

                                if(isset($days[$occurance]) && $occurance <= $stop) {
                                        $excluded = false;
                                        if (isset($exdate)) {
                                                foreach (explode(",", $exdate) as $exception) {
                                                        if (preg_replace("/-/", "", $occurance) == $exception) {
                                                                $excluded = true;
                                                        }
                                                }
                                        }
                                        if ($excluded == false){
                                                array_push($days[$occurance],"1");
            }else{
                unset($days[$occurance]);
            }

                                }
                                $occurance = date('Y-m-d',mktime(0,0,0,$nm+$rfreq,$nd,$ny));
                                list($ny,$nm,$nd) = explode('-',$occurance);
                        }

                        break;

        }
        return $days;

}
?>
                                                                                                                                                                                                     
