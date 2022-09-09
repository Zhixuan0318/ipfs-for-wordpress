<?php include_once ( __DIR__ . '/sidebar.php' );?>
<div class="IPFS-block-body">
    <h3 class="IPFS-section-title"> API Status </h3>
    <p>Connect yourself to the IPFS storage tools you need. Setup in the configuration setting now.</p>
    <div class="IPFS-api-status-wrap">
        <div class="IPFS-pinata-status <?php echo get_option ( 'ipfs_pinata' ) ? 'connected' : '' ?>">
            <img src="<?php echo plugins_url( '/admin/assets/images/pinata.png', IPFS_MEDIA_LIBRARY ); ?>" />
            <h3> Pinata </h3>
            <span><?php echo get_option ( 'ipfs_pinata' ) ? 'Connected' : 'Not connected' ?></span>
        </div>
        <div class="IPFS-web3-status <?php echo get_option ( 'ipfs_web3' ) ? 'connected' : '' ?>">
            <img src="<?php echo plugins_url( '/admin/assets/images/web3.png', IPFS_MEDIA_LIBRARY ); ?>" />
            <h3> Web3.Storage </h3>
            <span><?php echo get_option ( 'ipfs_web3' ) ? 'Connected' : 'Not connected' ?></span>
        </div>
        <div class="IPFS-nft-status <?php echo get_option ( 'ipfs_nft' ) ? 'connected' : '' ?>">
            <img src="<?php echo plugins_url( '/admin/assets/images/nft.png', IPFS_MEDIA_LIBRARY ); ?>" />
            <h3> Nft.Storage </h3>
            <span><?php echo get_option ( 'ipfs_nft' ) ? 'Connected' : 'Not connected' ?></span>
        </div>
    </div>
    <h3 class="IPFS-section-title"> Elementor Addons </h3>
    <p>Hide or show the widget addons you need in Elementor.</p>
    <div class="IPFS-table">
        <div class="IPFS-table_cell">
            <div class="IPFS-elementor-wrap">
                <div class="IPFS-image-logo">
                    <img src="<?php echo plugins_url( '/admin/assets/images/pinata.png', IPFS_MEDIA_LIBRARY ); ?>" />
                </div>
                <div>
                    <h3> Pinata Image </h3>
                    <input type="checkbox" hidden="hidden" name="block_pinata" value="enable" id="block_pinata" <?php echo get_option ( 'block_pinata' ) ? 'checked' : '' ?> />
                    <label class="switch" for="block_pinata"></label>
                </div>
            </div>
        </div>
        <div class="IPFS-table_cell">
            <div class="IPFS-elementor-wrap">
                <div class="IPFS-image-logo">
                    <img src="<?php echo plugins_url( '/admin/assets/images/web3.png', IPFS_MEDIA_LIBRARY ); ?>" />
                </div>
                <div>
                    <h3> Web3.Storage Image </h3>
                    <input type="checkbox" hidden="hidden" name="block_web3" value="enable" id="block_web3" <?php echo get_option ( 'block_web3' ) ? 'checked' : '' ?> />
                    <label class="switch" for="block_web3"></label>
                </div>
            </div>
        </div>
        <div class="IPFS-table_cell">
            <div class="IPFS-elementor-wrap">
                <div class="IPFS-image-logo">
                    <img src="<?php echo plugins_url( '/admin/assets/images/nft_mini.png', IPFS_MEDIA_LIBRARY ); ?>" />
                </div>
                <div>
                    <h3> Nft.Storage Image </h3>
                    <input type="checkbox" hidden="hidden" name="block_nft" value="enable" id="block_nft" <?php echo get_option ( 'block_nft' ) ? 'checked' : '' ?> />
                    <label class="switch" for="block_nft"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="IPFS-table">
        <div class="IPFS-table_cell">
            <div class="IPFS-elementor-wrap">
                <div class="IPFS-image-logo">
                    <img src="<?php echo plugins_url( '/admin/assets/images/pinata.png', IPFS_MEDIA_LIBRARY ); ?>" />
                </div>
                <div>
                    <h3> Pinata Lottie </h3>
                    <input type="checkbox" hidden="hidden" name="block_json_pinata" value="enable" id="block_json_pinata" <?php echo get_option ( 'block_json_pinata' ) ? 'checked' : '' ?> />
                    <label class="switch" for="block_json_pinata"></label>
                </div>
            </div>
        </div>
        <div class="IPFS-table_cell">
            <div class="IPFS-elementor-wrap">
                <div class="IPFS-image-logo">
                    <img src="<?php echo plugins_url( '/admin/assets/images/web3.png', IPFS_MEDIA_LIBRARY ); ?>" />
                </div>
                <div>
                    <h3> Web3.Storage Lottie </h3>
                    <input type="checkbox" hidden="hidden" name="block_json_web3" value="enable" id="block_json_web3" <?php echo get_option ( 'block_json_web3' ) ? 'checked' : '' ?> />
                    <label class="switch" for="block_json_web3"></label>
                </div>
            </div>
        </div>
        <div class="IPFS-table_cell">
            <div class="IPFS-elementor-wrap">
                <div class="IPFS-image-logo">
                    <img src="<?php echo plugins_url( '/admin/assets/images/nft_mini.png', IPFS_MEDIA_LIBRARY ); ?>" />
                </div>
                <div>
                    <h3> Nft.Storage Lottie </h3>
                    <input type="checkbox" hidden="hidden" name="block_json_nft" value="enable" id="block_json_nft" <?php echo get_option ( 'block_json_nft' ) ? 'checked' : '' ?> />
                    <label class="switch" for="block_json_nft"></label>
                </div>
            </div>
        </div>
    </div>
</div>