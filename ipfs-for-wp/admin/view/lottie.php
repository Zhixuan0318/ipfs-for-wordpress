<div class="ipfs-library-head">
    <div style="width: 70%">
        <form class="IPFS-library-search-form">
            <div class="IPFS-library-search">
                <input type="text" placeholder="Search images" name="ipfs-search" />
                <img src="<?php echo plugins_url( '/admin/assets/images/search.png', IPFS_MEDIA_LIBRARY ); ?>" type="submit" />
            </div>
        </form>
    </div>
    <div  class="IPFS-json-filter" style="text-align: left">
        <select>
            <option value=""> All </option>
            <option value="pinata"> Pinata </option>
            <option value="web3"> Web3.Storage </option>
            <option value="nft"> NFT.Storage </option>
        </select>
        <img src="<?php echo plugins_url( '/admin/assets/images/filter.png', IPFS_MEDIA_LIBRARY ); ?>" />
    </div>
    <div style="width: 100%; align-items: end;">
        <button class="ipfs-button ipfs-add-image"> Add new + </button>
    </div>
</div>

<div class="grid ipsf_media_library loading">
    <!-- <div class="grid-item">
        <img src="<?php echo plugins_url( '/admin/assets/images/file.png', IPFS_MEDIA_LIBRARY ); ?>" />
        <label> Main.json </label>
    </div> -->
    <div class="lds-ripple"><div></div><div></div></div>
</div>