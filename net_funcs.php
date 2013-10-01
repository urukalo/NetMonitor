<?php
    $aPingCmd  = '/sbin/ping -c 2 ';           // *nix
    $aTraceCmd = '/usr/sbin/traceroute -n';  // *nix
    
    // returns the average ping time
    function phpPing( $aAddress )
    {
        global $aPingCmd;
        
        $aTotalTime = 0.0001;
        $aPingCount = -0.1;
        echo $aPingCmd, $aAddress;
        if ( $aFile = popen( "$aPingCmd $aAddress", "r" ) )
        {
            // now read all of the data from the pipe
            while ( !feof( $aFile ) )
            {
                $aLine = fgets ( $aFile, 1024 );
                // locate the time information
                $aPos  = strpos( $aLine, "time=" );
                if ( $aPos > 0 )
                {
                    // use PHP's variable coersion to convert the time to a number
                    $aTime = substr( $aLine, $aPos + 5 ) * 1.0;
                    $aTotalTime += $aTime;
                    $aPingCount++;
                }
            }
            pclose( $aFile );
        }

        return $aTotalTime / $aPingCount;
    }

    function phpTrace( $aAddress )
    {
        global $aTraceCmd;

        $aTraceResults = "";        
        if ( $aFile = popen( "$aTraceCmd $aAddress", "r" ) ) 
        {
            // now read all of the data from the pipe
            while ( !feof( $aFile ) ) 
            {
                $aLine = fgets ( $aFile, 1024 );
                $aTraceResults .= $aLine . "<br>";                
            }
            pclose( $aFile );
        }
        
        return $aTraceResults;
    }
    
    function phpPageCheck( $aWebPage )
    {
        $aURL = parse_url( $aWebPage );
        $aResult = False;
        if ( $aURL["scheme"] == "http" )
        {
            $aRequest  = "HEAD {$aURL['path']} HTTP/1.0\r\n\r\n";
            $aSocket = fsockopen( $aURL["host"], 80 ,$a,$b,10);
            if ( $aSocket )
            {
                fputs( $aSocket, $aRequest );
                while( !feof( $aSocket ) )
                {
                    $aLine = fgets( $aSocket, 1024 );
                    if ( substr( $aLine, 0, 4 ) == "HTTP" )
                    { echo $aLine;
                        $aArray = explode( " ", $aLine );
                        if ( ( $aArray[1] >= 200 ) && ( $aArray[1] < 300 ) )
                        {
                            $aResult = True;
                        }
                    }
                }
            }
        }

        return $aResult;
    }


        function phpSMTP( $aWebPage )
    {
        $aURL =  $aWebPage;
        $aResult = False;
            $aRequest  = "HELO milan\r\nQUIT\r\n";
            $aSocket = fsockopen( $aURL, 25 ,$a,$b,10);
            if ( $aSocket )
            {
                fputs( $aSocket, $aRequest );
                while( !feof( $aSocket ) )
                {
                    $aLine = fgets( $aSocket, 1024 );
echo $aLine;
                    if ( substr( $aLine, 4, 3 ) == "Bye" )
                    {
                            $aResult = True;

                    }
                }
            }


        return $aResult;
    }
?>
