<?php
    include( "./net_funcs.php" );
        include( "./cache.php" );
?>
<html>
<head>
	<title>Network Monitor Tools</title>
	<META http-equiv="REFRESH" content="120">
</head>

<body>
<?php
//debug mode:
error_reporting(1);

//echo "Izaberi mapu:" ;
if (!$mapa) {
$mapa="etf";
	print "<a href=\"$fajl?crtaj=1\">crtaj</a>";  //link za rucno skeniranje
}

// ImageMagic path
$put="/usr/local/bin/";
$fajl= "index.php";

// Mysql data
$mysql_host = "localhost";
$mysql_user = "milan";
$mysql_pass = "urukalo";
$db = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
mysql_select_db("milan");


if (!$d) {
if ($crtaj!=1){
$cache = $mapa.".jpg";

//kesiranje
//debug:
//error_reporting( E_ALL & ~E_NOTICE );

    if ( $aResult = DumpCacheFile( $cache, 3 * 60 ) )
    {
        // ok, ucitali smo kesiranu stranicu, prekidamo
        exit;
    }
    ob_start(); //funkcija koja skuplja izlaz
}

// generisanje mape:

print ("<MAP NAME=phmap>\n");

$obrisi = $put."convert -size 700x550 xc:skyblue map/".$mapa.".jpg ";
 echo exec($obrisi); //resetovanje slike

	//kupimo podatke iz baze:
	    $query = mysql_query(" SELECT naziv,ip,x,y,a,b,tip,servis,status from $mapa ORDER BY `id` DESC ");

            while ($row = mysql_fetch_array($query))
            {
                $ime = $row["naziv"];
                $host = $row["ip"];
                $poz1 = $row["x"];
                $poz2 = $row["y"];
                $link1 = $row["a"];
                $link2 = $row["b"];
		$servis = $row ["servis"]; //niz servisa koji se prate (monitor trenutno ne podrzava sve ove servise)
		$status = $row ["status"]; 
		list($icmp,$http,$smtp,$pop3,$ssh,$dns) = split("/",$servis);
		list($sicmp,$shttp,$ssmtp,$spop3,$sssh,$sdns) = split("/",$status);
		$tip = $row["tip"];
//		echo $ime,$icmp,$http,$smtp,$pop3,$ssh,$dns,"<br>";

	//odabir slike:
		if($tip == "AP") $slika="bridge.jpg";
		elseif ($tip == "Ruter") $slika="ruter.jpg";
		else $slika="server.gif";

	//odabir boje:
		$boja="LawnGreen";
		if ($icmp==1){

			if ($shttp==0 && $http==1) $boja = "Plum";
			if ($ssmtp==0 && $smtp==1) $boja = "Plum";
			if ($spop3==0 && $pop3==1) $boja = "Plum";
			if ($sssh==0 && $ssh==1) $boja = "Plum";
			if ($sdns==0 && $dns==1) $boja = "Plum";
			if ($sicmp==0 && $icmp==1) $boja = "Tomato";
		} else $boja = "Silver";

    $potpis = $put."montage -frame 2 -geometry '50x40+0+0>' -pointsize 9  -mattecolor ". $boja ." -label '". $ime . "' slike/".$slika." 'slike/".$ime.".jpg'" ;
    $dodaj  = $put."composite  -geometry  +".$poz1."+".$poz2." 'slike/". $ime .".jpg' map/".$mapa.".jpg map/".$mapa.".jpg";
    $linija = $put."convert  -stroke black -linewidth 3 -draw \"line ".($poz1+25).",".($poz2+30)." ".($link1+25).",".($link2+30)."\" map/".$mapa.".jpg map/".$mapa.".jpg";

//echo $dodaj."<br>".$obrisi."<br>".$linija."<br>".$potpis."<br>";
print ("<AREA onMouseOver=\"showtext('$ime ip: $host')\" onMouseOut=\"showtext('')\" HREF=\"$file?d=$ime&amp;mapa=$mapa\" ALT=\"$ime\" COORDS=\"$poz1,$poz2,".($poz1+54).",".($poz2+60)."\">\n");
 echo exec ($potpis);
 echo exec($linija);
 echo exec($dodaj);

	    }


print "</MAP>\n";

print "<img src=\"map/".$mapa.".jpg\" alt=\"\" USEMAP=\"#phmap\" WIDTH=700 HEIGHT=550 align=\"left\">";



}
else {

	 $aSQL="SELECT naziv,ip,mac,tip, servis, status from $mapa WHERE `naziv` = '$d'";
//echo "$d $aSQL<br>";
	    $query = mysql_query($aSQL);

            $row = mysql_fetch_array($query);

                $ime = $row["naziv"];
                $host = $row["ip"];
                $mac = $row["mac"];
                $tip = $row["tip"];
		$servis = $row ["servis"];
		$status = $row ["status"];
		list($icmp,$http,$smtp,$pop3,$ssh,$dns) = split("/",$servis);
		list($sicmp,$shttp,$ssmtp,$spop3,$sssh,$sdns) = split("/",$status);

if (!$edit){
	print "Naziv: $ime <br> IP: $host <br> MAC: $mac <br> TIP: $tip <br>";

	print "<br>Servisi koji se provjeravaju:
	<br>ICMP:$icmp status: $sicmp
	<br>HTTP:$http status: $shttp
	<br>SMTP:$smtp status: $ssmtp
	<br>POP3:$pop3 status: $spop3
	<br>SSH:$ssh status: $sssh
	<br>DNS:$dns status: $sdns
	<br>";

	print "<a href=\"$fajl?d=$d&amp;mapa=$mapa&amp;edit=1\">Promjeni</a>";
}
else {
	print "U izradi !!!";

}



}


?>
</body>
</html>
<?
if ($crtaj!=1){
    SaveCacheFile( $cache, ob_get_contents() );
}

?>
