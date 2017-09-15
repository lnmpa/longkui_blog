<?php 
class Time{
 
	function get_nickname($rule=null){
		
			//构建日期
			$today1=date('Y-m-d',time());
			$n=intval($rule['cycle'])-1;
			//if($n<0){$n=0;}
			if(strstr($rule['cycle'],'day'))
			{
				$day=date("Y-m-d",strtotime("$today1 -$n day"));
			}
			elseif(strstr($rule['cycle'],'week'))
			{
				$weekday=date("w");
				$thisweek1=date("Y-m-d",strtotime("$today1 -$weekday day"));
				$n=7*$n;
				$day=date("Y-m-d",strtotime("$thisweek1 -$n day"));
			}
			elseif(strstr($rule['cycle'],'month'))
			{
				$thismonth1 = date('Y-m',time()).'-01';
				$day=date("Y-m-d",strtotime("$thismonth1 -$n month"));
			}
			elseif(strstr($rule['cycle'],'season'))
			{
				$thisseason1 =date("Y-m-d",strtotime(date('Y',time()).'-'.((intval(date("m",time())/3)*3+1)).'-01')); // 本季度开始
				$n=$n*3;
				$day=date("Y-m-d",strtotime("$thisseason1 -$n month"));
			}
			elseif(strstr($rule['cycle'],'year'))
			{
				$thisyear1=date('Y',time()).'-01-01';
				$day=date("Y-m-d",strtotime("$thisyear1 -$n year"));
			}
			else 
			{
				$day=NOW_TIME - intval($rule['cycle']) * 3600;
				$day=date("Y-m-d H:i:s",$day);
			}
			$day=strtotime($day);
//			$tomorrow1=date("Y-m-d",strtotime("$today1 +1 day"));
//			//$yesterday1=date("Y-m-d",strtotime("$today1 -1 day"));
//			$thismonth1 = date('Y-m',time()).'-01';
//			$nextmonth1 = date("Y-m-d",strtotime("$thismonth1 +1 month"));
//			//$lastmonth1 = date("Y-m-d",strtotime("$thismonth1 -1 month"));
//			$thisyear1=date('Y',time()).'-01-01';
//			$nextyear1=(date('Y',time())+1).'-01-01';
//			//$lastyear1=(date('Y',time())-1).'-01-01';
//			$n=date("w");
//			$thisweek1=date("Y-m-d",strtotime("$today1 -$n day"));
//			$nextweek1=date("Y-m-d",strtotime("$thisweek1 +7 day"));//周日
//			//$lastweek1=date("Y-m-d",strtotime("$thisweek1 -7 day"));//周日			
//			$thisseason1 =date("Y-m-d",strtotime(date('Y',time()).'-'.((intval(date("m",time())/3)*3+1)).'-01')); // 本季度开始 
//			$nextseason1 = date("Y-m-d",strtotime("$thisseason1  +3 month"));// 下季度开始 
//			//$lastseason1 = date("Y-m-d",strtotime("$thisseason1  -3 month"));// 上季度开始
	 
	}
}