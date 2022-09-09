<?php

$page = 'Pinata';

if ( $_REQUEST['page'] == 'ipfs_web3' ) {
    $page = 'Web3.Storage';
} else if ( $_REQUEST['page'] == 'ipfs_nft' ) {
    $page = 'NFT.Storage';
}

?>
<div class="ipfs-library-head">
    <div>
        <form class="IPFS-library-search-form">
            <div class="IPFS-library-search">
                <input type="text" placeholder="Search images" name="ipfs-search" />
                <img src="<?php echo plugins_url( '/admin/assets/images/search.png', IPFS_MEDIA_LIBRARY ); ?>" type="submit" />
            </div>
        </form>
    </div>
    <div>
        <button class="ipfs-button ipfs-add-image"> Add new + </button>
    </div>
</div>

<div class="grid ipsf_media_library loading">
    <div class="lds-ripple"><div></div><div></div></div>
</div>