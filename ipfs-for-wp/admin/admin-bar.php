<?php


add_action( 'admin_bar_menu', 'IPFS_admin_bar', PHP_INT_MAX - 2 );

function IPFS_admin_bar ( $wp_admin_bar ) {

    $wp_admin_bar->add_menu(
        [
            'id'    => 'IPFS-for-wp',
            'title' => 'IPFS for WP',
            'href'  => current_user_can( 'rocket_manage_options' ) ? admin_url( 'options-general.php?page=' ) : false,
        ]
    );

    $wp_admin_bar->add_menu(
        [
            'parent' => 'IPFS-for-wp',
            'id'     => 'IPFS-clear-assets-cache',
            'title'  => __( 'Clear Cache', 'rocket' ),
            'href'   => '#',
        ]
    );

}