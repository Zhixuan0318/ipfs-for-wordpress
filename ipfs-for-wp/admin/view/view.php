<?php

include_once ( __DIR__ . '/sidebar.php' );

$page = 'Dashboard';

if ( isset ( $_REQUEST['page'] ) ) {

    if ( $_REQUEST['page'] == 'ipfs_pinata' ) {
        $page = 'Pinata';
    } else if ( $_REQUEST['page'] == 'ipfs_web3' ) {
        $page = 'Web3.Storage';
    } else if ( $_REQUEST['page'] == 'ipfs_nft' ) {
        $page = 'NFT.Storage';
    } else if ( $_REQUEST['page'] == 'ipfs_settings' ) {
        $page = 'Settings';
    } else if ( $_REQUEST['page'] == 'ipfs_woo' ) {
        $page = 'WooCommerce';
    } else if ( $_REQUEST['page'] == 'ipfs_cdn' ) {
        $page = 'IPFS CDN';
    } else if ( $_REQUEST['page'] == 'ipfs_lottie' ) {
        $page = 'Lottie';
    }

}

?>
<div id="firstTab" class="tabcontent">
    <h3 class="title"><?php echo $page; ?></h3>
    <hr style="border-bottom-color: #959595; margin-top: -2px; border-top-color: transparent; margin-bottom: 24px"/>
    <?php

        if ( $_REQUEST['page'] == 'ipfs_pinata' || $_REQUEST['page'] == 'ipfs_web3' || $_REQUEST['page'] == 'ipfs_nft' ) {
            include_once ( __DIR__ . '/library.php' );
        } else if ( $_REQUEST['page'] == 'ipfs_settings' ) {
            include_once ( __DIR__ . '/settings.php' );
        } else if ( $_REQUEST['page'] == 'ipfs_lottie' || $_REQUEST['page'] == 'ipfs_woo' ) {
            include_once ( __DIR__ . '/lottie.php' );
        } else if ( $_REQUEST['page'] == 'ipfs_woo' ) {
            include_once ( __DIR__ . '/woo.php' );
        } else if ( $_REQUEST['page'] == 'ipfs_cdn' ) {
            include_once ( __DIR__ . '/cdn.php' );
        } else {
            include_once ( __DIR__ . '/dashboard.php' );
        }

    ?>
</div>