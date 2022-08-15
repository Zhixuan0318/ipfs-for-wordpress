<div class="IPFS-cdn-section">
	<div>
		<h3 class="IPFS-section-title"> API Status </h3>
		<p>Copies of CSS and JS files will be uploaded and stored on the IPFS network (which act as a Content Delivery Network) as a cache. Browsers can now reqeust and fetch those cache data from one of a node in the IPFS network.</p>
	</div>
	<div>
		<label>
			<input type="checkbox" name="ipfs_cdn" value="on" <?php echo get_option ( 'ipfs_cdn' ) ? 'checked' : '' ?> />
			Enable IPFS Content Delivery Network (ICDN)
		</label>
		<div class="IPFS-select-cdn">
			<p>Select an IPFS storage tool as ICDN provider:</p>
			<div class="IPFS-api-status-wrap">
				<input type="radio" name="ipfs_cdn_storage" value="pinata" id="ipfs_cdn_pinata" <?php echo checked( get_option ( 'ipfs_cdn_storage' ), 'pinata' ); ?>>
		        <label class="IPFS-pinata-status <?php echo get_option ( 'ipfs_pinata' ) ? 'connected' : '' ?>" for="ipfs_cdn_pinata">
		            <img src="<?php echo plugins_url( '/admin/assets/images/pinata.png', IPFS_MEDIA_LIBRARY ); ?>" />
		            <h3> Pinata </h3>
		        </label>
				<input type="radio" name="ipfs_cdn_storage" value="web3" id="ipfs_cdn_web3" <?php echo checked( get_option ( 'ipfs_cdn_storage' ), 'web3' ); ?>>
		        <label class="IPFS-web3-status <?php echo get_option ( 'ipfs_web3' ) ? 'connected' : '' ?>" for="ipfs_cdn_web3">
		            <img src="<?php echo plugins_url( '/admin/assets/images/web3.png', IPFS_MEDIA_LIBRARY ); ?>" />
		            <h3> Web3.Storage </h3>
		        </label>
				<input type="radio" name="ipfs_cdn_storage" value="nft" id="ipfs_cdn_nft" <?php echo checked( get_option ( 'ipfs_cdn_storage' ), 'nft' ); ?>>
		        <label class="IPFS-nft-status <?php echo get_option ( 'ipfs_nft' ) ? 'connected' : '' ?>" for="ipfs_cdn_nft">
		            <img src="<?php echo plugins_url( '/admin/assets/images/nft.png', IPFS_MEDIA_LIBRARY ); ?>" />
		            <h3> Nft.Storage </h3>
		            <span><?php echo get_option ( 'ipfs_nft' ) ? 'Connected' : 'Not connected' ?></span>
		        </label>
		    </div>
		</div>
	</div>
</div>
<div class="IPFS-cdn-section minify">
	<div>
		<h3 class="IPFS-section-title">Automated File Minification</h3>
		<p>CSS dan JS minification is a way to optimize your site performance by reducing whitespaces and comments to reduce file size. If enable, ICDN will automatically stores minified variants on the IPFS network, while keeping the uncompressed JS and CSS files on your main server.</p>
	</div>
	<div>
		<label>
			<input type="checkbox" name="IPFS_cdn_minify_js" <?php echo get_option ( 'IPFS_cdn_minify_js' ) ? 'checked' : ''; ?> />
			JS File Minification
		</label>
		<label>
			<input type="checkbox" name="IPFS_cdn_minify_css" <?php echo get_option ( 'IPFS_cdn_minify_css' ) ? 'checked' : ''; ?> />
			CSS File Minification
		</label>
	</div>
</div>
<div class="IPFS-cdn-section period">
	<div>
		<h3 class="IPFS-section-title">CDN Cache Lifespan</h3>
		<p>CDN cache lifespan is the period of time which the current cache stored on IPFS network will expired. A new CDN cache will be rebuilt automatically and upload onto IPFS network after the lifespan expiration to replace the expired cache.</p>
	</div>
	<div>
		<input type="text" name="" value="24" />
		<select>
			<option> Days </option>
			<option> Hours </option>
			<option> Minutes </option>
		</select>
	</div>
</div>
<div class="IPFS-cdn-section rebuilt">
	<div>
		<h3 class="IPFS-section-title">Instant Cache Rebuilt</h3>
		<p>Rebuilt the CDN cache instantly and upload onto IPFS network to replace the current cache.</p>
	</div>
	<div>
		<button class="ipfs-button ipfs-clear-cache">Instant Cache Rebuilt</button>
	</div>
</div>