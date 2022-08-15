<?php

add_action( 'setup_theme', array( 'IPFS_CDN_Engine', 'start' ) );

final class IPFS_CDN_Engine
{

    public static function start() {

        new self();
    }

    public function __construct() {

        self::start_buffering();

    }

    private static function start_buffering() {

       ob_start( 'self::end_buffering' );
       // ob_start( Array ( self, 'end_buffering' ) );

    }

    private static function end_buffering ( $content, $phase ) {

	    $CDN = get_option ( 'ipfs_cdn' );
	    $CDNStorage = get_option ( 'ipfs_cdn_storage' );

		if ( ( isset ( $_GET['IPFS_cache'] ) && $_GET['IPFS_cache'] == 'no-cache' ) || ( !$CDN || empty ( $CDNStorage ) ) ) { return $content; } else {

			$assets = get_option( 'IPFS_cache_files', true );

			foreach ( $assets as $asset ) {
				$content = str_replace( $asset['file'], $asset['storage'], $content );
			}

		}

        return $content;

    }

}