<?php

    $page = 'dashboard';

    if ( isset ( $_REQUEST['page'] ) ) {

        if ( $_REQUEST['page'] == 'ipfs_pinata' ) {
            $page = 'pinata';
        } else if ( $_REQUEST['page'] == 'ipfs_web3' ) {
            $page = 'web3';
        } else if ( $_REQUEST['page'] == 'ipfs_nft' ) {
            $page = 'nft';
        } else if ( $_REQUEST['page'] == 'ipfs_lottie' ) {
            $page = 'lottie';
        } else if ( $_REQUEST['page'] == 'ipfs_woo' ) {
            $page = 'woo';
        } else if ( $_REQUEST['page'] == 'ipfs_cdn' ) {
            $page = 'cdn';
        } else if ( $_REQUEST['page'] == 'ipfs_settings' ) {
            $page = 'settings';
        }

    }

?>
<div class="tab IPFS_sidebar_menu">
    <img src="<?php echo plugins_url( '/admin/assets/images/logo_new.png', IPFS_MEDIA_LIBRARY ); ?>" style="margin:  0 auto; width: 163px; padding: 18px 0 24px;" />
    <a class="tablinks<?php echo $page == 'dashboard' ? ' active' : '' ?>" href="<?php echo $page == 'dashboard' ? '#' : admin_url( 'admin.php?page=ipfs' ) ?>">
        Dashboard
        <span> Getting started, status and info </span>
    </a>
    <?php if ( get_option ( 'ipfs_pinata' ) ) : ?>
    <a class="tablinks<?php echo $page == 'pinata' ? ' active' : '' ?>" href="<?php echo $page == 'pinata' ? '#' : admin_url( 'admin.php?page=ipfs_pinata' ) ?>">
        Pinata
        <span> Media library for Pinata </span>
    </a>
    <?php endif; ?>
    <?php if ( get_option ( 'ipfs_web3' ) ) : ?>
    <a class="tablinks<?php echo $page == 'web3' ? ' active' : '' ?>" href="<?php echo $page == 'web3' ? '#' : admin_url( 'admin.php?page=ipfs_web3' ) ?>">
        WEB3.STORAGE
        <span> Media library for Web3.Storage </span>
    </a>
    <?php endif; ?>
    <?php if ( get_option ( 'ipfs_nft' ) ) : ?>
    <a class="tablinks<?php echo $page == 'nft' ? ' active' : '' ?>" href="<?php echo $page == 'nft' ? '#' : admin_url( 'admin.php?page=ipfs_nft' ) ?>">
        NFT.STORAGE
        <span> Media library for Nft.Storage </span>
    </a>
    <?php endif; ?>
    <a class="tablinks<?php echo $page == 'lottie' ? ' active' : '' ?>" href="<?php echo $page == 'lottie' ? '#' : admin_url( 'admin.php?page=ipfs_lottie' ) ?>">
        Lottie
        <span> Library for lottie JSON files </span>
    </a>
    <a style="" class="tablinks<?php echo $page == 'woo' ? ' active' : '' ?>" href="<?php echo $page == 'woo' ? '#' : admin_url( 'admin.php?page=ipfs_woo' ) ?>">
        WooCommerce
        <span> Library for product image </span>
    </a>
    <a class="tablinks<?php echo $page == 'cdn' ? ' active' : '' ?>" href="<?php echo $page == 'cdn' ? '#' : admin_url( 'admin.php?page=ipfs_cdn' ) ?>">
        IPFS CDN
        <span> Content Delivery Network on IPFS </span>
    </a>
    <a class="tablinks<?php echo $page == 'settings' ? ' active' : '' ?>" href="<?php echo $page == 'settings' ? '#' : admin_url( 'admin.php?page=ipfs_settings' ) ?>">
        Settings
        <span> Connect API keys and secrets </span>
    </a>
</div>