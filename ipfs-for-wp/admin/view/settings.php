<form action="" method="post">
    <h3 class="ipfs-heading"> Pinata <input type="checkbox" hidden="hidden" name="ipfs_pinata" value="enable" id="pinata" <?php echo get_option ( 'ipfs_pinata' ) ? 'checked' : '' ?> />
        <label class="switch" for="pinata"></label>
    </h3>
    <div class="ipfs-form-control ipfs-hidden">
        <h4> Pinata API Key </h4>
        <input type="text" name="pinata_api_key" value="<?php echo get_option ( 'pinata_api_key' ); ?>" />
    </div>
    <div class="ipfs-form-control ipfs-hidden">
        <h4> Pinata API Secret </h4>
        <input type="text" name="pinata_api_secret" value="<?php echo get_option ( 'pinata_api_secret' ); ?>" />
    </div>
    <h3 class="ipfs-heading extra-space"> Web3.Storage <input type="checkbox" hidden="hidden" name="ipfs_web3" value="enable" id="web3" <?php echo get_option ( 'ipfs_web3' ) ? 'checked' : '' ?> />
        <label class="switch" for="web3"></label>
    </h3>
    <div class="ipfs-form-control ipfs-hidden last">
        <h4> Web3.Storage API Key </h4>
        <input type="text" name="web3_api_key" value="<?php echo get_option ( 'web3_api_key' ); ?>" />
    </div>
    <h3 class="ipfs-heading extra-space"> NFT.Storage <input type="checkbox" hidden="hidden" name="ipfs_nft" value="enable" id="nft" <?php echo get_option ( 'ipfs_nft' ) ? 'checked' : '' ?> />
        <label class="switch" for="nft"></label>
    </h3>
    <div class="ipfs-form-control ipfs-hidden">
        <h4> NFT.Storage API Key </h4>
        <input type="text" name="nft_api_key" value="<?php echo get_option ( 'nft_api_key' ); ?>" />
    </div>
    <input type="hidden" name="ipfs_settings" value="action">
    <button class="ipfs-button"> Save </button>
</form>