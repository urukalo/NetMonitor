<?php
    function GetCacheFileName( $aFileName )
    {
        return $aFileName . ".cache";
    }
    
    function DumpCacheFile( $aFileName, $aExpire = 3600 )
    {
        $aCacheFile = GetCacheFileName( $aFileName );
        if ( is_file( $aCacheFile ) == True )
        {
            $aModTime = filemtime( $aCacheFile );
            $aCurTime = time();
            
            if ( ( $aCurTime - $aModTime ) > $aExpire )
            {
                return False;
            }
            else
            {
                readfile( $aCacheFile );
                return True;
            }
        }
    }
    
    function SaveCacheFile( $aFileName, $aContents )
    {
        $aCacheFile = GetCacheFileName( $aFileName );
        $aFile = fopen( $aCacheFile, "w" );
        fwrite( $aFile, $aContents );
        fclose( $aFile );
    }
?>