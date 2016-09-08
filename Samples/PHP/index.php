<?php

require_once( 'tinyMonitor.php' );

function ToSize( $value )
{
	static $sizeUnits = array( ' B', ' KB', ' MB', ' GB', ' TB', ' PB' );
	$unitIndex = 0;

	while ( $value > 1024 )
	{
		$value /= 1024;
		$unitIndex++;
	}

	return number_format( $value, 0, '', '' ).$sizeUnits[ $unitIndex ];
}

$tinyMonitor = new tinyMonitor( 'PHP Sample' );

switch ( $tinyMonitor->GetAction() )
{
	case 'sampleAction':
	{
		$tinyMonitor->AddMessage( 'The sample action was requested. Refresh the client to get the monitor data again.' );
		break;
	}

	default:
	{
		$totalSpace = disk_total_space( __DIR__ );
		$usedSpace = round( $totalSpace - disk_free_space( __DIR__ ) );
		$diskUsage = round( ( $usedSpace * 100 ) / $totalSpace );

		$tinyMonitor->AddMessage( date( 'Y-m-d @ H:i' ) );
		$tinyMonitor->AddText( 'Server OS', php_uname() );
		$tinyMonitor->AddText( 'PHP Version', phpversion() );
		$tinyMonitor->AddStatus( 'Status #1', 'Unknown', TinyMonitor::Unknown );
		$tinyMonitor->AddStatus( 'Status #2', 'All OK', TinyMonitor::OK );
		$tinyMonitor->AddStatus( 'Status #3', 'Warning!', TinyMonitor::Warning );
		$tinyMonitor->AddStatus( 'Status #4', 'Error!!!', TinyMonitor::Error );
		$tinyMonitor->AddProgress( 'Used Space', ToSize( $usedSpace ).' of '.ToSize( $totalSpace ), $diskUsage );
		$tinyMonitor->AddAction( 'Sample Action', 'sampleAction' );			
		break;
	}
}

$tinyMonitor->Send();
