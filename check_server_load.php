<?php

	/**
	 * Returns boolean if the current server
	 * is over a given percentage load
	 *
	 * Linux servers only
	 */
	function check_server_load($percent = 75)
	{      
		// get number of processors
		$result = exec(escapeshellcmd('mpstat -P ALL'), $ot);
		
		if(is_array($ot) and count($ot) > 4)
		{
			$num_proc = count($ot) - 4;
			
			$loadresult = exec(escapeshellcmd('uptime'));
			preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/", $loadresult, $avgs);
			
			// check the 5 minute average
			$load = floatval($avgs[1]);
			$thres = ($num_proc * ($percent / 100));
			
			if($load < $thres){return TRUE;}
		}
		
		return FALSE;
	}
	
?>
