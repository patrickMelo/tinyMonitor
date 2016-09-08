<?php

class tinyMonitor
{
	// Constants
	
	const Version	= 1;
	
	const Message	= 1;
	const Text		= 2;
	const Status	= 3;
	const Progress	= 4;

	const Unknown	= 0;
	const OK		= 1;
	const Warning	= 2;
	const Error		= 3;

	// General
	
	public function __construct( $pTitle )
	{
		$this->mTitle = $pTitle;
	}
	
	// Items

	public function AddMessage( $pMessage )
	{
		$this->mItems[] = array(
			'type' => self::Message,
			'message' => $pMessage,
		);
	}
	
	public function AddText( $pTitle, $pText )
	{
		$this->mItems[] = array(
			'type' => self::Text,
			'title' => $pTitle,
			'text' => $pText,
		);
	}
		
	public function AddStatus( $pTitle, $pText, $pStatus )
	{
		$this->mItems[] = array(
			'type' => self::Status,
			'title' => $pTitle,
			'text' => $pText,
			'status' => intval( $pStatus ),
		);
	}
		
	public function AddProgress( $pTitle, $pText, $pProgress )
	{
		$this->mItems[] = array(
			'type' => self::Progress,
			'title' => $pTitle,
			'text' => $pText,
			'percentage' => floatval( $pProgress ),
		);		
	}
	
	// Actions
	
	public function AddAction( $pName, $pAction )
	{
		$this->mActions[] = array(
			'name' => $pName,
			'action' => $pAction,
		);
	}
	
	public function GetAction()
	{
		$getKeys = array_keys( $_GET );
		return isset( $getKeys[ 0 ] ) ? trim( $getKeys[ 0 ] ) : '';
	}
	
	// Response
	
	public function Send()
	{
		if ( headers_sent() )
		{
			exit( 1 );
		}

		if ( ob_get_length() !== false )
		{
			ob_end_clean();
		}
		
		header( 'Content-Type: application/json' );
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Headers: X-Requested-With' );

		echo json_encode( array(
			'title' => $this->mTitle,
			'version' => self::Version,
			'items' => $this->mItems,
			'actions' => $this->mActions,
		), JSON_FORCE_OBJECT );

		exit( 0 );
	}

	// Private Members
	
	private $mTitle = '';
	private $mItems = array();
	private $mActions = array();
}
