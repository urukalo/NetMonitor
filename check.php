<?php
    include( "./net_funcs.php" );

    function updatestatus( $ime, $status,$mapa )
{ $datum = date("Y-m-d H:i:s");
if ($mapa == log )    $aSQL  = "INSERT INTO `log` (`datum`, `status`, `naziv`) VALUES ( '$datum' ,'$status', '$ime')" ;
   else $aSQL  = "UPDATE $mapa SET  status = '$status' WHERE naziv = '$ime' " ;
//echo $aSQL;
    $aDBLink = @mysql_connect( "localhost", "milan", "urukalo" );
    if ( !empty( $aDBLink ) )
    {
        if ( mysql_select_db( "milan", $aDBLink ) == True )
        {
            $aQResult = mysql_query( $aSQL, $aDBLink );
            if ( $aQResult == True )
            {
                $aResult = mysql_insert_id( $aDBLink );
            }   
            else
            {
                $aResult = -1;
            }
        }
        else
        {
            $aResult = -2;
        }
    }
    else
    {
        $aResult = -3;
    }
    return $aResult;
}


error_reporting(1);
if (!$mapa) $mapa="etf";

// Mysql data
$mysql_host = "localhost";
$mysql_user = "milan";
$mysql_pass = "urukalo";
$db = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
mysql_select_db("milan");
//while (TRUE){
	    $query = mysql_query(" SELECT naziv,ip,x,y,a,b,tip,servis from $mapa ORDER BY `id` DESC ");

            while ($row = mysql_fetch_array($query))
            {
                $ime = $row["naziv"];
                $host = $row["ip"];
		$servis = $row ["servis"];
		list($icmp,$http,$smtp,$pop3,$ssh,$dns) = split("/",$servis);
//		echo $ime,$icmp,$http,$smtp,$pop3,$ssh,$dns,"<br>";

		$sicmp = "0";
		$shttp= "0";
		$ssmtp= "0";
		$spop3= "0";
		$sssh= "0";
		$sdns= "0";

		if ($icmp==1){
		if (phpPing($host) < 0) $sicmp = "0";
		else { $sicmp = "1";
			if ($http==1) $shttp = phpPageCheck( 'http://'.$host.'/') ? "1" : "0";
			if ($smtp==1) $smtp = phpSMTP( $host )? "1" : "0";
		}
		}

			$status = "$sicmp/$shttp/$ssmtp/$spop3/$sssh/$sdns";
//			echo "  --  ".$status."<br/>";
			//echo
			updatestatus($ime,$status,$mapa);
			updatestatus($ime,$status,'log');
}
//sleep(60);
//}

?>
