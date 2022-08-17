<?php

/*
 * Plugin Name: IPFS for WordPress
 * Description: The most powerful & comprehensive IPFS solution for WordPress CMS.
 * Version: 1.0.0
 * Author: Tan Zhi Xuan
 * License: GPLv2 or later
 * Text Domain: elementor-ipfs-addon
 * Elementor tested up to: 3.5.0
 * Elementor Pro tested up to: 3.5.0
 *
 */

use Elementor\Controls_Manager;
use Elementor\Widgets_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('IPFS_MEDIA_LIBRARY', __FILE__);

require_once ( __DIR__ . '/libs/html_dom.php' );
require_once ( __DIR__ . '/admin/autoload.php' );
require_once ( __DIR__ . '/CDN/IPFS_CDN_Engine.php' );

/**
 * Register Currency Control.
 *
 * Include control file and register control class.
 *
 * @param Controls_Manager $controls_manager Elementor controls manager.
 * @return void
 * @since 1.0.0
 */
function register_currency_control ( $controls_manager )
{

    require_once ( __DIR__ . '/controls/IPFS-web3.php' );
    require_once ( __DIR__ . '/controls/IPFS-nft.php' );
    require_once ( __DIR__ . '/controls/IPFS-pinata.php' );
    require_once ( __DIR__ . '/controls/IPFS-pinata-json.php' );
    require_once ( __DIR__ . '/controls/IPFS-web3-json.php' );
    require_once ( __DIR__ . '/controls/IPFS-nft-json.php' );

    $controls_manager->register ( new Elementor_Ipfs_WEB3_Library_Control () );
    $controls_manager->register ( new Elementor_Ipfs_NFT_Library_Control () );
    $controls_manager->register ( new Elementor_Ipfs_Pinata_Library_Control () );
    $controls_manager->register ( new Elementor_Ipfs_Pinata_Json_Library_Control () );
    $controls_manager->register ( new Elementor_Ipfs_Web3_Json_Library_Control () );
    $controls_manager->register ( new Elementor_Ipfs_NFT_Json_Library_Control () );

}

add_action ( 'elementor/controls/register', 'register_currency_control' );

/**
 * Register Currency Widget.
 *
 * Include widget file and register widget class.
 *
 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 * @since 1.0.0
 */
function register_currency_widget ( $widgets_manager )
{

    require_once ( 'widgets/image_web.php' );
	require_once ( 'widgets/image_pinata.php' );
    require_once ( 'widgets/image-nft.php' );

    require_once ( 'widgets/json_pinata.php' );
    require_once ( 'widgets/json_web3.php' );
    require_once ( 'widgets/json_nft.php' );

    if ( get_option ( 'block_web3' ) ) {
        $widgets_manager->register ( new Image_Web3 () );
    }

    if ( get_option ( 'block_nft' ) ) {
        $widgets_manager->register ( new Image_NFT () );
    }

    if ( get_option ( 'block_pinata' ) ) {
        $widgets_manager->register ( new Image_Pinata () );
    }

    if ( get_option ( 'block_json_pinata' ) ) {
        $widgets_manager->register ( new IPFS_Lottie_Pinata () );
    }

    if ( get_option ( 'block_json_web3' ) ) {
        $widgets_manager->register ( new IPFS_Lottie_Web3 () );
    }

    if ( get_option ( 'block_json_nft' ) ) {
        $widgets_manager->register ( new IPFS_Lottie_NFT () );
    }

}

add_action ( 'elementor/widgets/register', 'register_currency_widget' );

add_action ( 'wp_print_footer_scripts', function () {
    ?>
    <script type="text/javascript">
        jQuery( 'document' ).ready( function () {

            jQuery( '.IPFS-skeleton-loading' ).each( function ( index, element ) {

                console.log( jQuery( element ) );

                jQuery( element ).find( 'img' ).ready( function () {

                    jQuery( element ).find( 'img' ).addClass( 'IPFS-image-loaded' );

                });

            });

        });
    </script>
    <?php
}, 99);

function add_elementor_widget_categories( $elements_manager ) {

    $elements_manager->add_category(
        'ipfs',
        [
            'title' => esc_html__( 'IPFS for WordPress', 'plugin-name' ),
            'icon' => 'fa fa-plug',
        ]
    );

}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );


add_filter( 'allowed_http_origins', 'add_allowed_origins' );
function add_allowed_origins( $origins ) {
    $origins[] = '*';
    return $origins;
}