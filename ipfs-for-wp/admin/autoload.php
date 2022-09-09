<?php

/**
 * Register a custom menu page.
 */

include_once ( 'admin-bar.php' );

/*add_action( 'elementor/editor/footer', function () {
    ?>
    <script> const html = "" +
                "<div class=\"modal-wrapper \">\n" +
                "  <div class=\"modal\">\n" +
                "    <div class=\"btn-close\"></div>\n" +
                "    <div class=\"clear\"></div>\n" +
                "    <div class=\"content\">\n" +
                "        <h3 class=\"title\">Image Details</h3>\n" +
                "        <hr style='margin: 0px; border-bottom-color: #959595; border-top-color: transparent;' />\n" +
                "        <div class=\"grid ipsf_media_library loading\">\n" +
                "           <div class=\"lds-ripple\"><div></div><div></div></div>\n" +
                "         </div>\n" +
                "    </div>\n" +
                "    <div class='footer'>\n" +
                "       <button class=\"ipfs-button ipfs-insert-image web3\"> Insert </button> \n" +
                "    </div>\n" +
                "  </div>\n" +
                "</div>";

            jQuery( 'body' ).append( html ); </script>
    <?php
}, 99);*/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

add_action( 'admin_footer', function (  ) {
    ?><div id="IPDS_node"></div><?php
});

add_action( 'admin_init', function () {

    if ( isset ( $_POST['ipfs_settings'] ) ) {

        if ( isset ( $_POST['pinata_api_key'] ) ) {
            update_option ( 'pinata_api_key', $_POST['pinata_api_key'] );
        }

        if ( isset ( $_POST['pinata_api_secret'] ) ) {
            update_option ( 'pinata_api_secret', $_POST['pinata_api_secret'] );
        }

        if ( isset ( $_POST['web3_api_key'] ) ) {
            update_option ( 'web3_api_key', $_POST['web3_api_key'] );
        }

        if ( isset ( $_POST['nft_api_key'] ) ) {
            update_option ( 'nft_api_key', $_POST['nft_api_key'] );
        }

    }

});

function wpdocs_register_my_custom_menu_page(){



    if ( isset ( $_POST['ipfs_settings'] ) ) {

        if ( isset ( $_POST['ipfs_pinata'] ) && !empty ( $_POST['ipfs_pinata'] ) ) {
            update_option('ipfs_pinata', true);
        } else {
            update_option('ipfs_pinata', false);
        }

        if ( isset ( $_POST['ipfs_web3'] ) && !empty ( $_POST['ipfs_web3'] ) ) {
            update_option('ipfs_web3', true);
        } else {
            update_option('ipfs_web3', false);
        }

        if ( isset ( $_POST['ipfs_nft'] ) && !empty ( $_POST['ipfs_nft'] ) ) {
            update_option('ipfs_nft', true);
        } else {
            update_option('ipfs_nft', false);
        }

    }

    add_menu_page(
        __( 'IPFS for WP', 'textdomain' ),
        'IPFS for WP',
        'manage_options',
        'ipfs',
        'my_custom_menu_page',
        plugins_url( '/admin/assets/images/ipfs.png', IPFS_MEDIA_LIBRARY ),
        11
    );

    if ( get_option ( 'ipfs_pinata' ) ) {

        add_submenu_page(
            'ipfs',
            __('Pinata', 'textdomain'),
            __('Pinata', 'textdomain'),
            'manage_options',
            'ipfs_pinata',
            'my_custom_menu_page'
        );

    }

    if ( get_option ( 'ipfs_web3' ) ) {

        add_submenu_page(
            'ipfs',
            __('Web3.Storage', 'textdomain'),
            __('WEB3 Storage', 'textdomain'),
            'manage_options',
            'ipfs_web3',
            'my_custom_menu_page'
        );

    }

    if ( get_option ( 'ipfs_nft' ) ) {

        add_submenu_page(
            'ipfs',
            __('NFT.Storage', 'textdomain'),
            __('NFT Storage', 'textdomain'),
            'manage_options',
            'ipfs_nft',
            'my_custom_menu_page'
        );

    }

    add_submenu_page(
        'ipfs',
        __('Lottie', 'textdomain'),
        __('Lottie', 'textdomain'),
        'manage_options',
        'ipfs_lottie',
        'my_custom_menu_page'
    );

    add_submenu_page(
        'ipfs',
        __('WooCommerce', 'textdomain'),
        __('WooCommerce', 'textdomain'),
        'manage_options',
        'ipfs_woo',
        'my_custom_menu_page'
    );

    add_submenu_page(
        'ipfs',
        __('IPFS CDN', 'textdomain'),
        __('IPFS CDN', 'textdomain'),
        'manage_options',
        'ipfs_cdn',
        'my_custom_menu_page'
    );

    add_submenu_page(
        'ipfs',
        __( 'Settings', 'textdomain' ),
        __( 'Settings', 'textdomain' ),
        'manage_options',
        'ipfs_settings',
        'my_custom_menu_page'
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

/**
 * Display a custom menu page
 */
function my_custom_menu_page(){

    echo "<div class=\"IPFS-main-block\">";

    include_once ( __DIR__ . '/view/view.php' );

    echo "</div>";

}

function wpdocs_enqueue_custom_admin_style() {

    $data = array(
        'ajaxurl'           => admin_url( 'admin-ajax.php' ),
        'add_image_nonce'   => wp_create_nonce("IPFS_add_image"),
        'page'              => isset ( $_REQUEST['page'] ) ? $_REQUEST['page'] : '',
        'web3_token'        => get_option( 'web3_api_key' ),
        'nft_token'         => get_option( 'nft_api_key' ),
        'pinata_api'        => get_option( 'pinata_api_key' ),
        'pinata_secret'     => get_option( 'pinata_api_secret' ),
        'not_found_image'   => plugins_url( '/admin/assets/images/notfound.png', IPFS_MEDIA_LIBRARY ),
        'json_icon'         => plugins_url( '/admin/assets/images/file.png', IPFS_MEDIA_LIBRARY ),
        'search_icon'       => plugins_url( '/admin/assets/images/search.png', IPFS_MEDIA_LIBRARY ),
        'filter_icon'       => plugins_url( '/admin/assets/images/filter.png', IPFS_MEDIA_LIBRARY ),
        'placeholder'       => plugins_url( '/admin/assets/images/placeholder.png', IPFS_MEDIA_LIBRARY ),
        'placeholderv2'       => plugins_url( '/admin/assets/images/placeholder-without-border.png', IPFS_MEDIA_LIBRARY ),
        'error_icon'       => plugins_url( '/admin/assets/images/error.png', IPFS_MEDIA_LIBRARY ),
        'CDN_storage'       => get_option ( 'ipfs_cdn_storage' )
    );

    wp_enqueue_style( 'IPFS_font_family', '//fonts.googleapis.com/css?family=Inter', false, '1.0.0' );
    wp_enqueue_style( 'IPFS_Material_icon', '//fonts.googleapis.com/icon?family=Material+Icons', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css', plugins_url ( '/admin/assets/css/settings.css', IPFS_MEDIA_LIBRARY ), false, '1.0.28' );
    // wp_enqueue_style( '_custom_wp_admin_css', plugins_url ( '/admin/assets/js/static/css/main.css', IPFS_MEDIA_LIBRARY ), false, '1.0.14' );

    // https://unpkg.com/react@18/umd/react.development.js
    wp_enqueue_script ( 'IPFS_masonry', '//unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', Array ( 'jquery' ), '1.0.0', true );
    wp_enqueue_script ( 'IPFS_imagesloaded', '//unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', Array ( 'jquery' ), '1.0.0', true );
    // wp_enqueue_script ( 'IPFS_axios', '//cdn.jsdelivr.net/npm/axios/dist/axios.min.js', Array ( 'jquery' ), '1.0.0', true );
    // wp_enqueue_script ( 'IPFS_BrowserFS', 'https://cdn.jsdelivr.net/combine/npm/fs-js@1.0.6,npm/node-fs@0.1.7/example.min.js', Array (  ), '1.0.8', true );
    
    // React
    // wp_enqueue_script ( 'IPFS_react', '//unpkg.com/react@18/umd/react.development.js', Array (  ), '1.0.8', true );
    // wp_enqueue_script ( 'IPFS_react_Dome', '//unpkg.com/react-dom@18/umd/react-dom.development.js', Array (  ), '1.0.8', true );

	wp_enqueue_script ( 'IPFS_lib', plugins_url ( '/admin/assets/js/static/js/main.js', IPFS_MEDIA_LIBRARY ), Array (  ), '1.0.28', true );

	wp_enqueue_script ( 'IPFS_main', plugins_url ( '/admin/assets/js/main.js', IPFS_MEDIA_LIBRARY ), Array ( 'jquery', 'IPFS_masonry', 'IPFS_imagesloaded', 'IPFS_lib' ), '1.0.44', true );


	wp_localize_script( 'IPFS_main', 'ajax_vars', $data );
    wp_localize_script( 'IPFS_lib', 'ajax_vars', $data );

}

add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' );

function mediabutton(){

    wp_register_script( 'mediabutton', plugins_url ( '/admin/assets/js/media.js', IPFS_MEDIA_LIBRARY ), Array ( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'mediabutton');

}

add_action('admin_print_scripts-media-upload-popup','mediabutton'); // Adding insert button

add_action( 'wp_ajax_IPFS_add_image', 'IPFS_add_image' );
add_action( 'wp_ajax_nopriv_IPFS_add_image', 'IPFS_add_image' );

function IPFS_add_image () {

    $type   = 'pinata';
    $my_post = array(
        'post_title'    => $_GET['name'],
        'post_status'   => 'publish',
        'post_author'   => get_current_user_id(),
        'post_type'     => 'ipfs_media'
    );

    if ( isset( $_GET['type'] ) && !empty ( $_GET['type'] ) ) {

        if ( $_GET['type'] == 'ipfs_web3' ) {
            $type = 'web3';
        } else if ( $_GET['type'] == 'ipfs_nft' ) {
            $type = 'nft';
        }

    }

    // Insert the post into the database.
    $post_id = wp_insert_post( $my_post );

    update_post_meta ( $post_id, 'CID', $_GET['CID'] );
    update_post_meta ( $post_id, 'orignalCID', $_GET['orignalCID'] );
    update_post_meta ( $post_id, 'URL', $_GET['URL'] );
    update_post_meta ( $post_id, 'alt', $_GET['name'] );
    update_post_meta ( $post_id, 'file_type', $_GET['fileType'] );
    update_post_meta ( $post_id, 'sizes', $_GET['sizes'] );
    update_post_meta ( $post_id, 'fileName', $_GET['fileName'] );
    update_post_meta ( $post_id, 'fileEx', $_GET['fileEx'] );
    update_post_meta ( $post_id, 'storage', $type );

    if ( $type == 'web3' ) {
        update_post_meta ( $post_id, 'path', $_GET['path'] );
    }

    $_post      = get_post( $post_id );
    $author_obj = get_user_by( 'id', $_post->post_author );
    

    $posts = Array (
        'ID'    => $post_id,
        'name'  => get_the_title( $post_id ),
        'URL'   => get_post_meta ( $post_id, 'URL', true ),
        'alt'   => get_post_meta ( $post_id, 'alt', true ),
        'CID'   => get_post_meta ( $post_id, 'CID', true ),
        'orignalCID'   => get_post_meta ( $post_id, 'orignalCID', true ),
        'type'  => get_post_meta ( $post_id, 'storage', true ),
        'cap'   => get_post_meta ( $post_id, 'cap', true ),
        'des'   => get_post_meta ( $post_id, 'des', true ),
        'owner' => $author_obj->data->display_name,
        'date'  => get_the_date ( 'dS M Y', $post_id ),
    );

    echo wp_json_encode( $posts );

    wp_die();

}

add_action( 'wp_ajax_IPFS_get_images', 'IPFS_get_images' );
add_action( 'wp_ajax_nopriv_IPFS_get_images', 'IPFS_get_images' );

function IPFS_get_images() {

    global $_wp_additional_image_sizes;

    $thumbnail = $_wp_additional_image_sizes['IPFS_thumbnail'];
    $width = $thumbnail['width'];
    $height = $thumbnail['height'];
	$sizeName = '-'.$width.'x'.$height;

	$type   = '';
    $filetype = isset( $_POST['fileType'] ) && !empty ( $_POST['fileType'] ) ? $_POST['fileType'] :'image';
    $posts  = Array ();
    $query  = Array ( 'post_type' => 'ipfs_media', 'posts_per_page' => -1 );

    if ( isset ( $_POST['search'] ) && !empty ( $_POST['search'] ) ) {
        $query['s'] = $_POST['search'];
    }

    if ( isset( $_POST['type'] ) && !empty ( $_POST['type'] ) ) {

        if ( $_POST['type'] == 'ipfs_web3' ) {
            $type = 'web3';
        } else if ( $_POST['type'] == 'ipfs_nft' ) {
            $type = 'nft';
        } else if ( $_POST['type'] == 'ipfs_pinata' ) {
            $type = 'pinata';
        } else {
            $type = $_POST['type'];
        }

    }

    $query['meta_query'] = Array (
        'relation' => 'AND',
        /*Array (
            'key'     => 'storage',
            'value'   => $type,
            'compare' => '='
        ),*/
        Array (
            'key'     => 'URL',
            'value'   => '',
            'compare' => '!='
        ),
        Array (
            'key'     => 'CID',
            'value'   => '',
            'compare' => '!='
        ),
        Array (
            'key'     => 'file_type',
            'value'   => $filetype,
            'compare' => '='
        )
    );

    if ( !empty( $type ) ) {
        $query['meta_query'][] =  Array (
            'key'     => 'storage',
            'value'   => $type,
            'compare' => '='
        );      
    }

    $query  = new WP_Query( $query );

    if ( $query->have_posts () ) :

        while ( $query->have_posts () ) : $query->the_post ();

            $_post      = get_post( get_the_ID() );
            $author_obj = get_user_by( 'id', $_post->post_author );
            $fileName   = get_post_meta ( get_the_ID(), 'fileName', true );
            $fileEx     = get_post_meta ( get_the_ID(), 'fileEx', true );


            $posts[] = Array (
                'ID'    => get_the_ID(),
                'name'  => get_the_title(),
                'URL'   => str_replace ( $fileName, str_replace( $fileEx, '', $fileName ).$sizeName.$fileEx, get_post_meta ( get_the_ID(), 'URL', true ) ),
                'alt'   => get_post_meta ( get_the_ID(), 'alt', true ),
                'CID'   => get_post_meta ( get_the_ID(), 'CID', true ),
                'orignalCID'   => get_post_meta ( get_the_ID(), 'orignalCID', true ),
                'type'  => get_post_meta ( get_the_ID(), 'storage', true ),
                'cap'   => get_post_meta ( get_the_ID(), 'cap', true ),
                'des'   => get_post_meta ( get_the_ID(), 'des', true ),
                'path'  => get_post_meta ( get_the_ID(), 'path', true ),
                'fileName'  => get_post_meta ( get_the_ID(), 'fileName', true ),
                'fileEx'  => get_post_meta ( get_the_ID(), 'fileEx', true ),
                'owner' => $author_obj->data->display_name,
                'date'  => get_the_date ( 'M d Y', get_the_ID() ),
                'main'  => get_post_meta ( get_the_ID(), 'URL', true ),
            );

        endwhile;

    endif;

    echo wp_json_encode ( Array ( 'success' => true, 'count' => count( $posts ), 'images' => $posts, 'size' => $thumbnail ) );

    wp_die();

}

add_action( 'wp_ajax_IPFS_delete_image', 'IPFS_delete_image' );
add_action( 'wp_ajax_nopriv_IPFS_delete_image', 'IPFS_delete_image' );

function IPFS_delete_image ()
{

    $output = Array ( "success" => false );

    if ( isset ( $_POST[ 'ID' ] ) ) {

        wp_delete_post( $_POST[ 'ID' ], true );

        $output[ 'success' ] = true;

    }

    echo wp_json_encode( $output );

    wp_die();

}

add_action( 'wp_ajax_IPFS_update_image', 'IPFS_update_image' );
add_action( 'wp_ajax_nopriv_IPFS_update_image', 'IPFS_update_image' );

function IPFS_update_image ()
{

    $output = Array ( "success" => false );

    if ( isset ( $_POST['ID'] ) && ! empty ( $_POST['ID'] ) ) {

        $my_post = array(
            'ID'           => $_POST['ID'],
            'post_title'   => $_POST['name']
        );
     
        // Update the post into the database
        wp_update_post( $my_post );

        update_post_meta ( $_POST['ID'], 'alt', $_POST['alt'] );
        update_post_meta ( $_POST['ID'], 'cap', $_POST['cap'] );
        update_post_meta ( $_POST['ID'], 'des', $_POST['des'] );

        $output[ 'success' ] = true;

    }

    echo wp_json_encode( $output );

    wp_die();

}

add_filter ( 'attachment_fields_to_edit', function ( $form_fields, $post ) {

    $form_fields["enable-media-replace"] = array(
              "label" => esc_html__("Upload to IPFS", "enable-media-replace"),
              "input" => "html",
              "html" => "<a class='button-secondary IPFS_upload_storage' data-path=\"" . get_attached_file( $post->ID ) . "\" >" . esc_html__("Upload image file", "enable-media-replace") . "</a>", "helps" => esc_html__("Upload this image file to IPFS and use this image without the need of storing it in your server storage.", "enable-media-replace")
            );

      return $form_fields;

}, 10, 2 );

add_action( 'wp_ajax_IPFS_update_block', 'IPFS_update_block' );
add_action( 'wp_ajax_nopriv_IPFS_update_block', 'IPFS_update_block' );

function IPFS_update_block () {

    $output = Array ( "success" => false );

    if ( isset ( $_POST['name'] ) && !empty( $_POST['name'] ) && isset ( $_POST['value'] ) && $_POST['value'] ) {

        $output[ 'success' ] = true;

        if ( $_POST['value'] != 'false' ) {
            $output[ 'message' ] = 'update';
            update_option( $_POST['name'], $_POST['value'] );
        } else {
            $output[ 'message' ] = 'disabled';
            update_option( $_POST['name'], '' );
        }

    }

    echo wp_json_encode( $output );

    wp_die();

}



add_action( 'wp_ajax_IPFS_generate_images', 'IPFS_generate_images' );
add_action( 'wp_ajax_nopriv_IPFS_generate_images', 'IPFS_generate_images' );

function IPFS_generate_images()
{

	@ini_set( 'display_errors', 1 );

    header( 'Access-Control-Allow-Origin: *' );

    add_action('send_headers', 'cors_header');

    global $_wp_additional_image_sizes;

    $Id         = time ();
    $images     = Array ();
    $folderPath = '/ipfs-temp/';
    $orignal    = $_GET['image'];
    $_upload_path= wp_get_upload_dir();
    $upload_path= $_upload_path['basedir'];
    $extentions = Array (
        'png'   => 'image/png',
        // 'jpe'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'gif'   => 'image/gif',
        'bmp'   => 'image/bmp',
        'ico'   => 'image/vnd.microsoft.icon',
        'tiff'  => 'image/tiff',
        'tif'   => 'image/tiff',
        'svg'   => 'image/svg+xml',
        'svgz'  => 'image/svg+xml',
    );
    $buffer     = file_get_contents ( $orignal );
    $finfo      = new finfo ( FILEINFO_MIME_TYPE );
    $filetype   = $finfo -> buffer ( $buffer );
    $extention  = array_search ( $filetype, $extentions, true );
    $fileName   = $folderPath . $Id;

    if ( count ( $_wp_additional_image_sizes ) > 0 && !empty ( $extention ) ) {

        $extention = '.' . $extention;

        file_put_contents ( $upload_path . $fileName . $extention, fopen ( $orignal, 'r' ) );

        $images[] = Array ( 'url' => $_upload_path['baseurl'] . $fileName . $extention, 'path' => $upload_path . $fileName . $extention );

        foreach ( $_wp_additional_image_sizes as $key => $size ) {

            $width          = $size['width'];
            $height         = $size['height'];
            $name           = '-' . $width . 'x' . $height;
            $_fileName      = $fileName . $name . $extention;

            $found = array_search ( $_upload_path['baseurl'] . $fileName . $name . $extention, array_column ( $images, 'url' ) );

            if ( !$found ) {

                $orig_size      = getimagesize ( $upload_path . $fileName . $extention );
                $image_src[0]   = $upload_path . $fileName . $extention;
                $image_src[1]   = $orig_size[0];
                $image_src[2]   = $orig_size[1];
                $file_info      = pathinfo ( $upload_path . $fileName . $extention );

                $no_ext_path    = $file_info['dirname'] . '/' . $file_info['filename'];
                $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extention;
                $image          = wp_get_image_editor ( $upload_path . $fileName . $extention );
                $image -> resize ( $width, $height, true );

                $image -> save ( $cropped_img_path );

                $images[] = Array ( 'url' => $_upload_path['baseurl'] . $fileName . $name . $extention, 'path' => $cropped_img_path, 'size' => $size, 'size_name' => $width . 'x' . $height );

            }

        }

        echo json_encode ( Array ( 'success' => true, 'images' => $images, 'ID' => $Id ) );

    } else {

        echo json_encode ( Array ( 'success' => false, 'images' => $images, 'ID' => $Id ) );

    }

    wp_die();

}

add_action( 'wp_ajax_IPFS_get_CSS', 'IPFS_get_CSS' );
add_action( 'wp_ajax_nopriv_IPFS_get_CSS', 'IPFS_get_CSS' );

function IPFS_get_CSS() {

    global $wp_enqueue_script;

    $data = Array ();
    $allcss = Array ();
    $html = new simple_html_dom();

//    echo add_query_arg( 'IPFS_cache', 'no-cache', home_url() );

    $_html = file_get_contents ( add_query_arg( 'IPFS_cache', 'no-cache', home_url() ) );

    // Load HTML from a string
    $html->load( $_html );

    # collect all styles, but filter out if excluded
    foreach($html->find('link[rel=stylesheet], style') as $element) {
        // if(!in_array($element->outertext, $excl)) {
            $allcss[] = $element;
        // }
    }


    foreach($allcss as $k => $tag ) {

        if($tag->tag == 'link' && isset($tag->href)) {

            $data['css'][] = Array ( 'url' => strtok ( $tag->href, '?' ) );

            // break;

        }

    }

    # get all scripts
    $allscripts = array();
    foreach($html->find('script') as $element) {
        $allscripts[] = $element;
    }

    foreach($allscripts as $k=>$tag) {

        if(isset($tag->src)) {
            $data['js'][] = Array ( 'url' => strtok ( $tag->src, '?' ) );
        }

    }

    echo wp_json_encode( $data );

    wp_die();

}

add_action( 'wp_ajax_IPFS_store_cache', 'IPFS_store_cache' );
add_action( 'wp_ajax_nopriv_IPFS_store_cache', 'IPFS_store_cache' );

function IPFS_store_cache() {

    if ( isset ( $_GET['cache'] ) ) {

        update_option ( 'IPFS_cache_files', json_decode( str_replace("\\", "", $_GET['cache'] ), true ) );

    }

    wp_die();

}

add_action( 'after_setup_theme', 'IPFS_theme_setup' );

function IPFS_theme_setup () {
	add_image_size( 'IPFS_thumbnail', 500 );
}

add_action( 'add_meta_boxes', 'IPFS_woo_register_meta_boxes' );

function IPFS_woo_register_meta_boxes () {

	add_meta_box( 'IPFS-enable-woo', __( 'Enable IPFS', 'textdomain' ), 'IPFS_enable_woo_view_meta_boxes', 'product', 'side' );
	add_meta_box( 'IPFS-woo-library', __( 'IPFS Library', 'textdomain' ), 'IPFS_woo_view_meta_boxes', 'product', 'side' );

}

function IPFS_enable_woo_view_meta_boxes ( $post ) {
    ?>
        <h3 class="ipfs-heading" style="font-size: 1.1em; color: #1d2327;"> Enable
            <input type="checkbox" hidden="hidden" name="ipfs_enable" value="enable" id="pinata" <?php echo get_post_meta ( $post->ID, 'ipfs_enable', true ) ? 'checked' : '' ?> />
            <label class="switch" for="pinata" style="margin-left: 0;"></label>
        </h3>
    <?php
}

function IPFS_woo_view_meta_boxes ( $post ) {

    $imageURL   = "";
    $image      = get_post_meta ( $post->ID, 'ipfs_image', true );

    if ( $image ) {

	    $imageData = get_post_meta( $image );

	    global $_wp_additional_image_sizes;

	    $thumbnail = $_wp_additional_image_sizes['IPFS_thumbnail'];
	    $width     = $thumbnail['width'];
	    $height    = $thumbnail['height'];
	    $sizeName  = '-' . $width . 'x' . $height;

	    $imageURL = str_replace( $imageData['fileName'][0], str_replace( $imageData['fileEx'][0], '', $imageData['fileName'][0] ) . $sizeName . $imageData['fileEx'][0], $imageData['URL'][0] );

	    /*echo "<pre>";
	    print_r( $imageData );
	    echo "</pre>";*/

    }

	?>
        <img src="<?php echo $imageURL ?>" style="width: 100%; margin-top: 5px; display: none;" />
        <p class="hide-if-no-js howto" id="IPFS-set-post-thumbnail-desc">Click the image to edit or update</p>
        <p class="hide-if-no-js"><a href="#" id="IPFS-remove-post-thumbnail" style="color: #b32d2e;">Remove product image</a></p>
        <p><a href="#" id="IPFS-woo-set-product-image"> Set product image </a></p>
        <input type="hidden" name="ipfs_image" value="<?php echo $image; ?>" />
    <?php

}

add_action( 'save_post', 'IPFS_save_meta_box' );

function IPFS_save_meta_box ( $post_id ) {

    if ( isset ( $_REQUEST['ipfs_enable'] ) ) {

        update_post_meta ( $post_id, 'ipfs_enable', true );

    } else {

	    update_post_meta ( $post_id, 'ipfs_enable', false );

    }

	if ( isset ( $_REQUEST['ipfs_image'] ) ) {
		update_post_meta ( $post_id, 'ipfs_image', $_REQUEST['ipfs_image'] );
    }

}


add_filter( 'woocommerce_product_get_image', 'wp_kama_woocommerce_product_get_image_filter', 10, 5 );

/**
 * Function for `woocommerce_product_get_image` filter-hook.
 *
 * @param  $image
 * @param  $that
 * @param  $size
 * @param  $attr
 * @param  $placeholder
 *
 * @return
 */
function wp_kama_woocommerce_product_get_image_filter( $imageWoo, $that, $size, $attr, $placeholder ){

//    echo $that->get_ID ();

    $imageEnable = get_post_meta ( $that->get_ID (), 'ipfs_enable', true );

	$imageURL   = "";
	$image      = get_post_meta ( $that->get_ID (), 'ipfs_image', true );

    if ( $imageEnable ) {

	    if ( $image ) {

		    $imageData = get_post_meta( $image );

		    global $_wp_additional_image_sizes;

		    $thumbnail = $_wp_additional_image_sizes[ $size ];
		    $width     = $thumbnail['width'];
		    $height    = $thumbnail['height'];
		    $sizeName  = '-' . $width . 'x' . $height;

		    $imageURL = str_replace( $imageData['fileName'][0], str_replace( $imageData['fileEx'][0], '', $imageData['fileName'][0] ) . $sizeName . $imageData['fileEx'][0], $imageData['URL'][0] );

		    $dom = new DOMDocument();
		    $dom->loadHTML( $imageWoo );

		    $imageWoo = preg_replace( '/srcset="*?"/', '', $imageWoo );
		    $imageWoo = preg_replace( '/src="*?"/', 'src="' . $imageURL . '"', $imageWoo );


		    return $imageWoo;

	    }

    }

	// filter...
	return $imageWoo;
}

add_action ( 'init', function () {

//	remove_action ( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

});

add_action ( '_woocommerce_before_single_product_summary', function () {

    global $post, $product;

	$imageEnable = get_post_meta ( $post -> ID, 'ipfs_enable', true );

	$imageURL   = "";
	$image      = get_post_meta ( $post -> ID, 'ipfs_image', true );

	if ( $imageEnable ) {

		$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$post_thumbnail_id = $image;
		$wrapper_classes   = apply_filters(
			'woocommerce_single_product_image_gallery_classes',
			array(
				'woocommerce-product-gallery',
				'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
				'woocommerce-product-gallery--columns-' . absint( $columns ),
				'images',
			)
		);

        ?>
        <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
            <figure class="woocommerce-product-gallery__wrapper">
                <?php
                if ( $post_thumbnail_id ) {
                    ?>
                    <?php
                } else {
	                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
	                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
	                $html .= '</div>';
                }

//                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

                do_action( 'woocommerce_product_thumbnails' );
                ?>
            </figure>
        </div>
        <?php

//	$_product = wc_get_product ( $post -> ID );
//
//
//    echo "<pre>";
//    print_r ( $_product );
//    echo "</prE>";

	} else {

		wc_get_template( 'single-product/product-image.php' );

	}

}, 21);


add_filter( 'woocommerce_gallery_image_html_attachment_image_params', 'wp_kama_woocommerce_gallery_image_html_attachment_params_filter', 10, 4 );

/**
 * Function for `woocommerce_gallery_image_html_attachment_image_params` filter-hook.
 *
 * @param  $array
 * @param  $attachment_id
 * @param  $image_size
 * @param  $main_image
 *
 * @return
 */
function wp_kama_woocommerce_gallery_image_html_attachment_params_filter( $array, $attachment_id, $image_size, $main_image ){

    if ( is_product() && $main_image ) {

	    global $product;

	    $imageEnable = get_post_meta ( $product->get_ID(), 'ipfs_enable', true );

        if ( $imageEnable ) {

	        $imageEnable = get_post_meta( $product->get_ID(), 'ipfs_enable', true );

	        $imageURL = "";
	        $image    = get_post_meta( $product->get_ID(), 'ipfs_image', true );

//        unset ( $array[ 'data-large_image' ] );
//        unset ( $array[ 'data-large_image' ] );

	        $imageData = get_post_meta( $image );

	        global $_wp_additional_image_sizes;

	        $thumbnail = $_wp_additional_image_sizes[ $image_size ];
	        $width     = $thumbnail['width'];
	        $height    = $thumbnail['height'];
	        $sizeName  = '-' . $width . 'x' . $height;

	        $array['IPFS-replace-image'] = str_replace( $imageData['fileName'][0], str_replace( $imageData['fileEx'][0], '', $imageData['fileName'][0] ) . $sizeName . $imageData['fileEx'][0], $imageData['URL'][0] );

	        $array['data-large_image'] = str_replace( $imageData['fileName'][0], str_replace( $imageData['fileEx'][0], '', $imageData['fileName'][0] ) . $imageData['fileEx'][0], $imageData['URL'][0] );
	        $array['data-src']         = str_replace( $imageData['fileName'][0], str_replace( $imageData['fileEx'][0], '', $imageData['fileName'][0] ) . $imageData['fileEx'][0], $imageData['URL'][0] );

//        echo $imageURL;

        }

    }

	// filter...
	return $array;
}

function wpdocs_filter_gallery_img_atts( $atts, $attachment ) {

    if ( isset ( $atts[ 'IPFS-replace-image' ] ) ) {

	    /*echo "<pre>";
	    print_r( $atts );
//	    print_r( $attachment );
	    echo "</prE>";*/

	    $atts['src'] = $atts[ 'IPFS-replace-image' ];
	    $atts['srcset'] = $atts[ 'IPFS-replace-image' ];

    }

	return $atts;
}
add_filter( 'wp_get_attachment_image_attributes', 'wpdocs_filter_gallery_img_atts', 10, 2 );