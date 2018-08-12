<?php
	function fetch_date($posted)
	{
		date_default_timezone_set('Asia/Kolkata');
        if (date('Y')-date('Y',$posted) != 0) 
        {
            $date = date('Y')-date('Y',$posted).' year(s) ago'; 
        }
        elseif (date('m')-date('m',$posted) != 0) 
        {
            $date = date('m')-date('m',$posted).' month(s) ago';
        } 
        elseif (date('d')-date('d',$posted) != 0) 
        {
            $date = date('d')-date('d',$posted).' day(s) ago';
        }
        elseif (date('H')-date('H',$posted) != 0) 
        {	
        	$date = date('H')-date('H',$posted).' hour(s) ago';
        }
        elseif (date('i')-date('i',$posted) != 0) 
        {
        	$date = date('i')-date('i',$posted).' min(s) ago';
        }
        else
        {
        	$date = date('s')-date('s',$posted).' second(s) ago';
        }

      	return $date;   
	}
?>