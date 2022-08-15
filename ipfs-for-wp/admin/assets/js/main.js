jQuery.noConflict();

window.localData = ajax_vars;

(function( $ ) {

    $(function() {

        let $grid;

        // console.log ( window );

        // More code using $ as alias to jQuery
        $( document ).ready( function () {

            $ ( '#wp-admin-bar-IPFS-clear-assets-cache' ).on( 'click', function () {

                // console.log ( ajax_vars.page );

                if ( ajax_vars.page === 'ipfs_cdn' ) {

                    const storage = $('input[name="ipfs_cdn_storage"]:checked').val();

                    window.IPFS_CDN ( storage );

                } else {
                    window.IPFS_CDN ( ajax_vars.CDN_storage );
                }

            });

            if ( $ ( '#IPFS-woo-set-product-image' ).length ) {

                ipfs_woo_library ();
                ipfs_woo_library_toggle ();
                ipfs_woo_library_image_toggle ();

                $( 'input[name="ipfs_enable"]' ).on( 'change', function () {
                    ipfs_woo_library_toggle ();
                });

            }

            if ( ajax_vars.page == 'ipfs_pinata' || ajax_vars.page == 'ipfs_web3' || ajax_vars.page == 'ipfs_nft' ) {

                var colWidth = $(".grid-item").width();

                window.onresize = function(){
                    var colWidth = $(".grid-item").width();
                }
                $grid = $(".grid").masonry({
                    // options
                    itemSelector: ".grid-item",
                    columnWidth: ".grid-item",
                    // percentPosition: true,
                    gutter: 10,
                    fitWidth: true
                });

                $grid.imagesLoaded().progress(function() {
                    $grid.masonry("layout");
                });

                loadLibrary();

                $( '.IPFS-library-search > img' ).on( 'click', function ( event ) {
                    event.preventDefault();
                    $( this ).parent( 'div' ).parent( 'form' ).submit();
                });

                $( '.IPFS-library-search-form' ).submit( function( event ) {

                    event.preventDefault();

                    const keyword = $( this ).find( 'input[name="ipfs-search"]' ).val();

                    loadLibrary( keyword );

                });


            } else if ( ajax_vars.page == 'ipfs_settings' ) {
                ipfs_pinata ();
                ipfs_web3 ();
                ipfs_nft ();

                $( 'input[name="ipfs_pinata"]' ).on( 'change', function () {
                    ipfs_pinata ();
                });

                $( 'input[name="ipfs_web3"]' ).on( 'change', function () {
                    ipfs_web3 ();
                });

                $( 'input[name="ipfs_nft"]' ).on( 'change', function () {
                    ipfs_nft ();
                });

            } else if ( ajax_vars.page == 'ipfs' ) {

                $( '.IPFS-elementor-wrap input[type="checkbox"]' ).on( 'change', function () {

                    const value = $( this ).is(':checked');
                    const name  = $( this ).attr('name');

                    $.ajax({
                        type : "post",
                        dataType : "json",
                        url: ajax_vars.ajaxurl,
                        data: { name, value, action: 'IPFS_update_block' },
                        success: function ( result ) {
                        },
                        error: function (error) {
                            alert( 'Something is wrong, Please try again later!' );
                        }
                    });

                });

            } else if ( ajax_vars.page == 'ipfs_lottie' || ajax_vars.page == 'ipfs_woo' ) {

                var colWidth = $(".grid-item").width();

                window.onresize = function(){
                    var colWidth = $(".grid-item").width();
                }
                $grid = $(".grid").masonry({
                    // options
                    itemSelector: ".grid-item",
                    columnWidth: ".grid-item",
                    // percentPosition: true,
                    gutter: 10,
                    fitWidth: true
                });

                $grid.imagesLoaded().progress(function() {
                    $grid.masonry("layout");
                });

                loadLibrary();

                $( 'body' ).on( 'click', 'input#IPFS_select_pinata, input#IPFS_select_web3, input#IPFS_select_nft', function () {

                    if ( $( this ).val() == 'web3' ) {

                        $( 'body .ipfs-json-type-web3' ).show();
                    } else {

                        $( 'body .ipfs-json-type-web3' ).hide();

                    }

                });

                $( '.IPFS-library-search > img' ).on( 'click', function ( event ) {
                    event.preventDefault();
                    $( this ).parent( 'div' ).parent( 'form' ).submit();
                });

                $( '.IPFS-library-search-form' ).submit( function( event ) {

                    event.preventDefault();

                    const keyword = $( this ).find( 'input[name="ipfs-search"]' ).val();

                    // alert ( keyword );

                    loadLibrary( keyword );

                });

                $( 'body' ).on( 'change', '.IPFS-json-filter select', function () {

                    const keyword = $( this ).find( 'input[name="ipfs-search"]' ).val();

                    // alert ( keyword );

                    loadLibrary( keyword );

                })

            } else if ( ajax_vars.page == 'ipfs_cdn' ) {

                ipfs_cdn ();

                $( 'body' ).on( 'change', 'input[name="ipfs_cdn"], input[name="ipfs_cdn_storage"], input[name="IPFS_cdn_minify_js"], input[name="IPFS_cdn_minify_css"]', function () {

                    let value   = $( this ).is(':checked');
                    const name  = $( this ).attr('name');

                    if ( name == 'ipfs_cdn' ) {
                        ipfs_cdn ( $( this ) );
                    } else {

                        ipfs_cdn();
                    }

                });

                $( 'input[name="ipfs_cdn"], input[name="ipfs_cdn_storage"], input[name="IPFS_cdn_minify_js"], input[name="IPFS_cdn_minify_css"]' ).on( 'change', function () {

                    let storage = $( 'input[name="ipfs_cdn_storage"]:checked' ).val();
                    let value   = $( this ).is(':checked');
                    const name  = $( this ).attr('name');

                    if ( name == 'ipfs_cdn_storage' ) {
                        value = $( this ).val();
                        storage = value;
                    } else {

                    }

                    if ( name == 'ipfs_cdn' && !value ) {
                        $( 'input[name="ipfs_cdn_storage"]' ).prop( 'checked', false );
                        $( 'input[name="IPFS_cdn_minify_js"]' ).prop( 'checked', false );
                        $( 'input[name="IPFS_cdn_minify_css"]' ).prop( 'checked', false );
                        $.ajax({
                            type : "post",
                            dataType : "json",
                            url: ajax_vars.ajaxurl,
                            data: { name: 'ipfs_cdn_storage', value: 'none', action: 'IPFS_update_block' },
                            success: function ( result ) {
                            },
                            error: function (error) {
                                alert( 'Something is wrong, Please try again later!' );
                            }
                        });
                        $.ajax({
                            type : "post",
                            dataType : "json",
                            url: ajax_vars.ajaxurl,
                            data: { name: 'IPFS_cdn_minify_js', value: false, action: 'IPFS_update_block' },
                            success: function ( result ) {
                            },
                            error: function (error) {
                                alert( 'Something is wrong, Please try again later!' );
                            }
                        });
                        $.ajax({
                            type : "post",
                            dataType : "json",
                            url: ajax_vars.ajaxurl,
                            data: { name: 'IPFS_cdn_minify_css', value: false, action: 'IPFS_update_block' },
                            success: function ( result ) {
                            },
                            error: function (error) {
                                alert( 'Something is wrong, Please try again later!' );
                            }
                        });
                    } else {

                        if ( typeof storage != "undefined" ) {
                            window.IPFS_CDN(storage);
                        }
                    }

                    $.ajax({
                        type : "post",
                        dataType : "json",
                        url: ajax_vars.ajaxurl,
                        data: { name, value, action: 'IPFS_update_block' },
                        success: function ( result ) {
                        },
                        error: function (error) {
                            alert( 'Something is wrong, Please try again later!' );
                        }
                    });

                });

                $( '.ipfs-button.ipfs-clear-cache' ).on( 'click', function () {
                    $( '#wp-admin-bar-IPFS-clear-assets-cache' ).trigger( 'click' );
                });

            }

            $( 'body' ).on( 'click', '.ipfs_image_details_wrap > div:last-child span.ipfs_cid a', function ( event ) {

                event.preventDefault();

                const text = $( this ).text();

                var sampleTextarea = document.createElement("textarea");
                document.body.appendChild(sampleTextarea);
                sampleTextarea.value = text; //save main text in it
                sampleTextarea.select(); //select textarea contenrs
                document.execCommand("copy");
                document.body.removeChild(sampleTextarea);

                alert ( 'Text Copied!' );

            });

            $ ( '.ipfs-add-image' ).on( 'click', function () {

                window.IPFS_Add_Image();

                /*let page    = 'Pinata';
                let extra   = '';
                let title   = 'Add image from ';
                let html    = "";

                if ( ajax_vars.page == 'ipfs_web3' ) {
                    page = 'Web3.Storage';
                } else if ( ajax_vars.page == 'ipfs_nft' ) {
                    page = 'NFT.Storage';
                } else if ( ajax_vars.page == 'ipfs_nft' ) {
                    page = 'NFT.Storage';
                } else if ( ajax_vars.page == 'ipfs_lottie' ) {
                    page = '';
                    title = 'Add lottie JSON file';
                }

                if ( ajax_vars.page == 'ipfs_web3' ) {

                    extra = "" +
                    "<div class=\"ipfs-form-control\">\n" +
                    "   <h4> Image file name on Web3.Storage </h4>\n" +
                    "   <span> Enter the file of the image uploaded on Web3.Storage </span>\n" +
                    "   <input type=\"text\" placeholder=\"e.g. apple.png\" name=\"image_path\" value=\"slide20.jpg\" />\n" +
                    "</div>\n";

                }

                if ( ajax_vars.page == 'ipfs_lottie' ) {

                    extra = "" +
                    "<div class=\"ipfs-form-control ipfs-json-type-web3\" style=\"display: none;\">\n" +
                    "   <h4> Json file name on Web3.Storage </h4>\n" +
                    "   <span> Enter the file of the json uploaded on Web3.Storage </span>\n" +
                    "   <input type=\"text\" placeholder=\"e.g. apple.png\" name=\"image_path\" value=\"\" />\n" +
                    "</div>\n";

                    html = "" +
                        "<div class=\"modal-wrapper\">\n" +
                        "  <div class=\"modal\">\n" +
                        "    <div class=\"btn-close\"></div>\n" +
                        "    <div class=\"clear\"></div>\n" +
                        "    <div class=\"content\">\n" +
                        "        <h3 class=\"title\">" + title + " " + page + "</h3>\n" +
                        "        <div class=\"ipfs-form-control ipfs_qeual_buttons\">\n" +
                        "           <input id=\"IPFS_select_pinata\" type=\"radio\" name=\"ipfs_json_type\" value=\"pinata\" checked /><label class=\"ipfs_select\" for=\"IPFS_select_pinata\"> Pinata </label>\n" +
                        "           <input id=\"IPFS_select_web3\" type=\"radio\" name=\"ipfs_json_type\" value=\"web3\" /><label class=\"ipfs_select\" for=\"IPFS_select_web3\"> Web3.Storage </label>\n" +
                        "           <input id=\"IPFS_select_nft\" type=\"radio\" name=\"ipfs_json_type\" value=\"nft\" /><label class=\"ipfs_select\" for=\"IPFS_select_nft\"> NFT.Storage </label>\n" +
                        "        </div>\n" +
                        "        <div class=\"ipfs-form-control\">\n" +
                        "           <h4> File CID </h4>\n" +
                        "           <span> Enter the CID of the JSON file uploaded on IPFS storage tools </span>\n" +
                        "           <input type=\"text\" name=\"cid\" value=\"\" />\n" +
                        "        </div>\n" +
                        "        " + extra +
                        "        <div class=\"ipfs-form-control\">\n" +
                        "           <h4> File Name </h4>\n" +
                        "           <span> Give a name for your file you wanted to add </span>\n" +
                        "           <input type=\"text\" name=\"image_name\" value=\"\" />\n" +
                        "        </div>\n" +
                        "        <button class=\"ipfs-button add\"> Retrieve </button>" +
                        "    </div>\n" +
                        "  </div>\n" +
                        "</div>";

                } else {

                    html = "" +
                        "<div class=\"modal-wrapper\">\n" +
                        "  <div class=\"modal\">\n" +
                        "    <div class=\"btn-close\"></div>\n" +
                        "    <div class=\"clear\"></div>\n" +
                        "    <div class=\"content\">\n" +
                        "        <h3 class=\"title\">" + title + " " + page + "</h3>\n" +
                        "        <div class=\"ipfs-form-control\">\n" +
                        "           <h4> Image CID </h4>\n" +
                        "           <span> Enter the CID of the image uploaded on " + page + " </span>\n" +
                        "           <input type=\"text\" name=\"cid\" value=\"bafybeif6hz2uqwt5eugws62vkuhaguak2ah6hufgoxtvruuolx4zc7gcwa\" />\n" +
                        "        </div>\n" +
                        "       " + extra +
                        "        <div class=\"ipfs-form-control\">\n" +
                        "           <h4> Image Name </h4>\n" +
                        "           <span> Give a name for your image you wanted to add </span>\n" +
                        "           <input type=\"text\" name=\"image_name\" value=\"\" />\n" +
                        "        </div>\n" +
                        "        <button class=\"ipfs-button add\"> Retrieve </button>" +
                        "    </div>\n" +
                        "  </div>\n" +
                        "</div>";

                }

                $( 'body' ).append( html );

                $('body > .modal-wrapper').addClass('open');*/

            });

            $('body').on( 'click', '.IPFS-popup-close', function() {
                // $('body > .modal-wrapper').remove();
                if ( $ ( this ).parent( 'div' ).parent( 'div' ).parent( 'div' ).attr( 'id' ) == 'IPDS_node' ) {
                    $ ( this ).parent( 'div' ).parent( 'div' ).parent( 'div' ).hide();
                } else {
                    $ ( this ).parent( 'div' ).parent( 'div' ).remove();
                }
            });

            $( 'body' ).on ( 'click', '.modal button.add', async function () {

                const element   = $( this );
                let page        = ajax_vars.page;
                let fileType    = 'image';
                const CID       = $( 'body input[name="cid"]' ).val();
                const name      = $( 'body input[name="image_name"]' ).val();

                if ( CID != '' && name != '' ) {

                    if ( page == 'ipfs_lottie' ) {
                        page = $( 'input[name="ipfs_json_type"]:checked' ).val();
                        fileType = 'json';
                    }

                    let check = false;

                    element.attr('disabled','disabled');
                    element.text( 'Validating....' );

                    if ( page == 'ipfs_web3' || page == 'web3' ) {
                        const imagePath = $( 'body input[name="image_path"]' ).val();
                        if ( imagePath != '' ) {
                            check = await validateWEB3 ( CID, imagePath, name, element, fileType );
                        }
                    } else if ( page == 'ipfs_nft' || page == 'nft' ) {
                        check = await validateNFT ( CID, name, element, fileType );
                    } else if ( page == 'ipfs_pinata' || page == 'pinata' ) {
                        check = await validatePinata ( CID, name, element, fileType );
                    }

                }

            });

            $( 'body' ).on ( 'click', '.modal button.cancel-delete', async function () {
                $( this ).parent( 'div' ).parent( 'div' ).children( 'div.btn-close' ).trigger( 'click' );
            });

            $( 'body' ).on ( 'click', '.modal button.update', async function () {
                
                updateImage ( $( this ) );

            });

            $( 'body' ).on ( 'click', '.modal button.delete', async function () {

                $( this ).parent( 'div' ).children( 'button.outer-border' ).remove();
                $( this ).parent( 'div' ).parent( 'div' ).children( 'div.btn-close' ).remove();
                $( this ).prop( 'disabled', true );
                $( this ).text( 'Deleting...' );

                deleteImage ( $( this ).data( 'id' ), $( this ) );

                // alert ( $( this ).data( 'id' ) );

            });

            $( 'body .ipsf_media_library' ).on( 'click', '.grid-item > img', function () {

                const image = $( this );

                editImagePopup ( image );

            });

            $( 'body' ).on( 'click', '.ipfs_remove_image', function () {

                const element = $( this );

                deleteImagePopup ( element );

            });

            $( 'body' ).on( 'click', '.IPFS_upload_storage', function ( event ) {

                event.preventDefault();

                window.IPFS_Add_Image ( $( 'body input#attachment-details-two-column-copy-link' ).val(), $ ( 'body input#attachment-details-two-column-title' ).val() );

                /*const html = "" +
                "<div class=\"modal-wrapper open\" style='z-index: 999999999'>\n" +
                "  <div class=\"modal\" style='padding: 35px'>\n" +
                "    <div class=\"btn-close IPFS-popup-close\"></div>\n" +
                "    <div class=\"clear\"></div>\n" +
                "    <div class=\"content\">\n" +
                "        <h3 class=\"title\" style='font-size: 20px; margin-bottom: 30px'>Where to upload? </h3>\n" +
                "        <p style='max-width: 400px; margin-bottom: 30px'>Please select the storage where you want to upload this media file. </p>\n" +
                // "        <button class=\"ipfs-button outer-border cancel-delete\" style='margin-right: 35px;'> Cancel </button>" +
                "        <button class=\"ipfs-button ipfs_upload_pinata\" data-id=\"\"> Pinata </button>" +
                "        <button class=\"ipfs-button ipfs_upload_web3\" data-id=\"\"> Web3.Storage </button>" +
                "        <button class=\"ipfs-button ipfs_upload_nft\" data-id=\"\"> NFT.Storage </button>" +
                "    </div>\n" +
                "  </div>\n" +
                "</div>"*/

                // $( 'body' ).append( html );

                // $( '#IPDS_node > .modal-wrapper:first-child' ).addClass( 'open' );

            });

            $( 'body' ).on( 'click', '.ipfs_upload_web3', async function ( event ) {

                const element = $( this );

                element.attr( 'disabled', true );
                element.text( 'Uploading....' );

                element.parent( 'div' ).children( 'button' ).attr( 'disabled', true );

                const URL       = $( 'body input#attachment-details-two-column-copy-link' ).val();
                var filename    = URL.substring(URL.lastIndexOf('/')+1);

                const getUrlExtension = (url) => {
                    return url
                          .split(/[#?]/)[0]
                          .split(".")
                          .pop()
                          .trim();
                }

                var imgExt = getUrlExtension( URL );
                const response = await fetch( URL );
                const blob = await response.blob();
                const file = new File([blob], filename, {
                  type: blob.type,
                });

                var formData = new FormData();

                formData.append( 'file', [blob] );

                $.ajax({
                    type : "post",
                    // dataType : "json",
                    url: 'https://api.web3.storage/upload',
                    cache: false,
                    // contentType: 'multipart/form-data',
                    processData: false,
                    headers: { Authorization: "Bearer " + ajax_vars.web3_token },
                    data: new File([blob], filename, {
                        type: blob.type,
                    }) ,
                    success: function ( _result ) {
                        addImage ( { CID: _result.cid, name: $( 'input#attachment-details-two-column-title',  ).val(), URL: generate_URL( _result.cid, '', 'ipfs_web3' ), element: element, type: 'ipfs_web3' }, true );
                    },
                    error: function (error) {
                        console.log( error );
                    }
                });

            });

            $( 'body' ).on( 'click', '.ipfs_upload_pinata_', async function ( event ) {

                const element = $( this );

                element.attr( 'disabled', true );
                element.text( 'Uploading....' );

                element.parent( 'div' ).children( 'button' ).attr( 'disabled', true );

                ReactDOM.render( MyApp(), element.parent( 'div' ) );

                const URL       = $( 'body input#attachment-details-two-column-copy-link' ).val();
                var filename    = URL.substring(URL.lastIndexOf('/')+1);

                console.log( filename );

                const getUrlExtension = (url) => {
                    return url
                          .split(/[#?]/)[0]
                          .split(".")
                          .pop()
                          .trim();
                }

                var imgExt = getUrlExtension( URL );
                const response = await fetch( URL );
                const blob = await response.blob();
                const file = new File([blob], filename, {
                  type: blob.type,
                });

                const formData = new FormData();

                formData.append( 'file', blob, filename );
                formData.append( 'pinataMetadata', JSON.stringify({ 'name': filename, 'keyvalues': { 'MetaData1': 'Test1', 'MetaData2': 'Test2' } } ) );
                formData.append( 'pinataOptions', JSON.stringify({ 'cidVersion': 0 }) );

            });

            $( 'body' ).on( 'click', '.ipfs_upload_nft', async function ( event ) {

                const element = $( this );

                element.attr( 'disabled', true );
                element.text( 'Uploading....' );

                element.parent( 'div' ).children( 'button' ).attr( 'disabled', true );

                const URL       = $( 'body input#attachment-details-two-column-copy-link' ).val();
                var filename    = URL.substring(URL.lastIndexOf('/')+1);

                const getUrlExtension = (url) => {
                    return url
                          .split(/[#?]/)[0]
                          .split(".")
                          .pop()
                          .trim();
                }

                var imgExt = getUrlExtension( URL );
                const response = await fetch( URL );
                const blob = await response.blob();
                const file = new File([blob], filename, {
                  type: blob.type,
                });

                var formData = new FormData();

                formData.append( 'file', [blob] );

                $.ajax({
                    type : "post",
                    dataType : "json",
                    url: 'https://api.nft.storage/upload',
                    cache: false,
                    // contentType: 'multipart/form-data',
                    processData: false,
                    headers: { Authorization: "Bearer " + ajax_vars.nft_token },
                    data: new File([blob], filename, {
                        type: blob.type,
                    }),
                    success: function ( _result ) {

                        console.log( _result.value.files );

                        if ( _result.ok ) {

                            addImage ( { CID: _result.value.cid, name: $( 'input#attachment-details-two-column-title',  ).val(), URL: generate_URL( _result.value.cid, '', 'ipfs_nft' ), element: element, type: 'ipfs_nft' }, true );

                        }
                    },
                    error: function (error) {
                        console.log( error );
                    }
                });

            });

        });

        const updateImage = ( element ) => {

            const ID    = element.data( 'id' );
            const alt   = $( 'input[name="ipfs_alt"]' ).val();
            const name  = $( 'input[name="ipfs_name"]' ).val();
            const cap   = $( 'textarea[name="ipfs_cap"]' ).val();
            const des   = $( 'textarea[name="ipfs_des"]' ).val();

            if ( ID != '' || typeof ID != "undefined" ) {

                element.prop( 'disabled', true );
                element.text( 'Updating...' );
                
                element.parent( 'div' ).parent( 'div' ).parent( 'div' ).parent( 'div' ).children( 'div.btn-close' ).hide();

                $.ajax({
                    type : "post",
                    dataType : "json",
                    url: ajax_vars.ajaxurl,
                    data: { ID, alt, name, cap, des, action: 'IPFS_update_image' },
                    success: function ( result ) {
                        if ( result.success ) {
                            $( '#ipfs-image-' + ID + ' > img' ).data( 'name', name );
                            $( '#ipfs-image-' + ID + ' > img' ).data( 'des', des );
                            $( '#ipfs-image-' + ID + ' > img' ).data( 'cap', cap );
                            $( '#ipfs-image-' + ID + ' > img' ).attr( 'alt', alt );
                            element.parent( 'div' ).parent( 'div' ).parent( 'div' ).parent( 'div' ).children( 'div.btn-close' ).show();
                            element.prop( 'disabled', false );
                            element.text( 'Update' );
                        } else {
                            alert( 'Something is wrong, Please try again later!' );
                            element.parent( 'div' ).parent( 'div' ).parent( 'div' ).parent( 'div' ).children( 'div.btn-close' ).show();
                            element.prop( 'disabled', false );
                            element.text( 'Update' );
                        }
                    },
                    error: function (error) {
                        alert( 'Something is wrong, Please try again later!' );
                        element.parent( 'div' ).parent( 'div' ).parent( 'div' ).parent( 'div' ).children( 'div.btn-close' ).show();
                        element.prop( 'disabled', false );
                        element.text( 'Update' );
                    }
                });

            }

        }

        const deleteImage = ( ID, element ) => {

            $.ajax({
                type : "post",
                dataType : "json",
                url: ajax_vars.ajaxurl,
                data: { ID, action: 'IPFS_delete_image' },
                success: function ( result ) {
                    if ( result.success ) {
                        if ( ajax_vars.page == 'ipfs_lottie' ) {
                            window.location.reload();
                        } else {
                            $('body > .modal-wrapper').remove();
                            $('#ipfs-image-' + ID).remove();
                            var colWidth = $(".grid-item").width();

                            window.onresize = function () {
                                var colWidth = $(".grid-item").width();
                            }
                            var $grid = $(".grid").masonry({
                                // options
                                itemSelector: ".grid-item",
                                columnWidth: ".grid-item",
                                // percentPosition: true,
                                gutter: 10,
                                fitWidth: true
                            });

                            $grid.imagesLoaded().progress(function () {
                                $grid.masonry("layout");
                            });
                        }
                    } else {
                        alert( 'Something is wrong, Please try again later!' );
                        element.parent( 'div' ).parent( 'div' ).parent( 'div' ).remove();
                    }
                },
                error: function (error) {
                    alert( 'Something is wrong, Please try again later!' );
                    element.parent( 'div' ).parent( 'div' ).parent( 'div' ).remove();
                }
            });

        } 

        const deleteImagePopup = ( element ) => {

            const image = element.data( 'id' );

            const html = "" +
                "<div class=\"modal-wrapper open\" style='z-index: 999999999'>\n" +
                "  <div class=\"modal\" style='padding: 35px'>\n" +
                "    <div class=\"btn-close IPFS-popup-close\"></div>\n" +
                "    <div class=\"clear\"></div>\n" +
                "    <div class=\"content\">\n" +
                "        <h3 class=\"title\" style='font-size: 20px; margin-bottom: 30px'>Delete image from library? </h3>\n" +
                "        <p style='max-width: 400px; margin-bottom: 30px'>This image will be permanantly removed from the library. However, please note that this will only remove the image in this library, the original image file is still in your IPFS storage tool. </p>\n" +
                "        <button class=\"ipfs-button outer-border cancel-delete\" style='margin-right: 35px;'> Cancel </button>" +
                "        <button class=\"ipfs-button delete\" data-id=\"" + image + "\"> Delete </button>" +
                "    </div>\n" +
                "  </div>\n" +
                "</div>"

            $( 'body' ).append( html );

        }

        const editImagePopup = ( image ) => {

            let CIDText = 'Folder CID:';
            let orignaCID = '';
            let type        = 'Pinata';
            const imageID   = image.data( 'id' );
            let imageURL  = image.data( 'src' );
            const imageAlt  = image.attr( 'alt' );
            const imageDate = image.data( 'date' );
            const imageOwner= image.data( 'owner' );
            const imageName = image.data( 'name' );
            const imageCID  = image.data( 'cid' );
            const imageorignalCID  = image.data( 'orignalcid' );
            const imageType = image.data( 'type' );
            const imageCap  = image.data( 'cap' );
            const imageDes  = image.data( 'des' );

            if ( imageType == 'web3' ) {
                type = 'Web3.Storage';
            } else if ( imageType == 'nft' ) {
                type = 'NFT.Storage';
            }

            if ( ajax_vars.page == 'ipfs_lottie' ) {
                imageURL = ajax_vars.json_icon;
                CIDText = 'Lottie CID:';
            } else {
                orignaCID = "<span class='ipfs_cid'><b style='width: 85px'>Image CID:</b> <a href='#'> " + imageorignalCID + " </a>  </span>\n";
            }

            const html = "" +
                "<div class=\"modal-wrapper\" style='z-index: 99999; padding: 25px 25px;'>\n" +
                "  <div class=\"modal\" style='padding: 20px 0px;margin: 0; height: calc( 100% - 100px ); width: calc( 100% - 50px );'>\n" +
                "    <div class=\"btn-close IPFS-popup-close\"></div>\n" +
                "    <div class=\"clear\"></div>\n" +
                "    <div class=\"content\" style='height: 100%'>\n" +
                "        <h3 class=\"title\" style='margin-top: 5px; text-align: left; color: #595959; margin-bottom: 25px; font-size: 20px; padding: 0px 20px;'>Image Details</h3>\n" +
                "        <hr style='margin: 0px;' />\n" +
                "        <div class='ipfs_image_details_wrap'>\n" +
                "           <div>\n" +
                "               <i class=\"material-icons ipfs_remove_image\" data-id=\"" + imageID + "\">delete</i>\n" +
                "               <div class=\"grid ipsf_media_library loading\" style=\"position: absolute\">\n" +
                "                   <img style='height: auto;' src='" + ajax_vars.placeholderv2 + "'>\n" +
                "                   <p> <b>Hints:</b> If the image can’t be retrieved after a long period of time, you can check the status on your storage tool. You can also choose to delete this image and retrieve it again. </p>\n" +
                "               </div>\n" +
                "           </div>\n" +
                "           <div>\n" +
                "               <span><b>Added on:</b> " + imageDate + "  </span>\n" +
                "               <span><b>Added by:</b> " + imageOwner + " </span>\n" +
                "               <span><b>Added from:</b> " + type + "  </span>\n" +
                "               <span><b>Image name:</b> " + imageName + "  </span>\n" +
                "               " + orignaCID + "\n" +
                "               <span class='ipfs_cid'><b>" + CIDText + "</b> <a href='#'> " + imageCID + " </a>  </span>\n" +
                "               <hr />\n" +
                "               <div class=\"ipfs-form-control\">\n" +
                "                   <h4> Alternative text </h4>\n" +
                "                   <span> Leave empty if the image is purely decorative </span>\n" +
                "                   <input type=\"text\" name=\"ipfs_alt\" value=\"" + imageAlt + "\" />\n" +
                "               </div>" +
                "               <div class=\"ipfs-form-control\">\n" +
                "                   <h4> Image name </h4>\n" +
                "                   <input type=\"text\" name=\"ipfs_name\" value=\"" + imageName + "\" />\n" +
                "               </div>" +
                "               <div class=\"ipfs-form-control\">\n" +
                "                   <h4> Caption </h4>\n" +
                "                   <textarea name=\"ipfs_cap\" rows='4' style='width: 100%'>" + imageCap + "</textarea>\n" +
                "               </div>" +
                "               <div class=\"ipfs-form-control\">\n" +
                "                   <h4> Description </h4>\n" +
                "                   <textarea name=\"ipfs_des\" rows='4' style='width: 100%'>" + imageDes + "</textarea>\n" +
                "               </div>" +
                "               <button class=\"ipfs-button update\" data-id=\"" + imageID + "\"> Update </button>" +
                "           </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "  </div>\n" +
                "</div>"

            $( 'body' ).append( html );

            $('body > .modal-wrapper').addClass('open');

            $( '<img/>' ).attr( 'src', imageURL ).on( 'load', function() {

                // $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first' ).css({ 'background-image': `url(${imageURL})` });

                $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first' ).append( `<img src="${imageURL}" />`);

                const width = $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first img' ).width() / 2;

                $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first img' ).css({ left: `calc( 50% - ${width}px )` });

                $( window ).on( 'resize', function () {

                    const width = $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first img' ).width() / 2;

                    $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first img' ).css({ left: `calc( 50% - ${width}px )` });

                });

                $( 'body > .modal-wrapper .ipfs_image_details_wrap > div:first .grid.ipsf_media_library.loading' ).remove(  );

            });

        }

        const loadLibrary = ( search = '', edit = false, selected = null ) => {

            const count     = 0;
            let type        = ajax_vars.page;
            const library   = $ ( 'body .grid.ipsf_media_library' );
            let fileType    = 'image';

            library.addClass( 'loading' );
            library.removeClass( 'ipsf_lottie_library' );
            library.html( '<div class="lds-ripple"><div></div><div></div></div>' );

            if ( type == 'ipfs_lottie' ) {
                
                const filter = $( '.IPFS-json-filter select > option:selected' ).val();

                fileType = 'json';
                type = filter;
            }

            if ( type == 'ipfs_woo' || edit ) {

                const filter = $( '.IPFS-json-filter select > option:selected' ).val();

                fileType = 'woo';
                type = filter;
            }

            $.ajax({
                type : "post",
                dataType : "json",
                cache: false,
                url: ajax_vars.ajaxurl,
                data: { type, search, fileType, action: 'IPFS_get_images' },
                error: function (error) {
                    alert ( 'Something went wrong, Please  try again later!' );
                },
                success: async function ( result ) {

                    if ( result.count > 0 ) {

                        library.removeClass( 'loading' );

                        if ( ajax_vars.page == 'ipfs_lottie' ) {
                            library.addClass ( 'ipsf_lottie_library' );
                        }

                        library.html( "" );
                        library.find( '.lds-ripple' ).remove();
                        $( result.images ).each( ( index, image ) => {

                            let block = "";

                            if ( edit ) {
                                block = "<div class=\"grid-item\"><label class=\"form-control\"><img data-id='" + image.ID + "' style='height: auto;' src=\"" + ajax_vars.placeholder + "\" data-src=\"" + image.URL + "\" alt=\"\">\n" +
                                    "    <input type=\"radio\" name=\"ipfs-image\" value='" + image.ID + "' data-src=\"" + image.URL + "\" />\n" +
                                    "  </label></div>";
                            } else {
                                if (fileType == 'json') {
                                    block = "<div class=\"grid-item " + image.type + "\"><img src=\"" + ajax_vars.json_icon + "\"  data-id=\"" + image.ID + "\" data-type=\"" + image.type + "\" alt=\"" + image.alt + "\" data-cid=\"" + image.CID + "\" data-orignalCID=\"" + image.orignalCID + "\" data-owner=\"" + image.owner + "\" data-des=\"" + image.des + "\" data-cap=\"" + image.cap + "\" data-date=\"" + image.date + "\" data-name=\"" + image.name + "\" /><label> " + image.name + " </label></div>";
                                } else {
                                    block = "<div class=\"grid-item\" id=\"ipfs-image-" + image.ID + "\"><img class='IPFS-library-image-lazyload' style='height: auto;' src=\"" + ajax_vars.placeholder + "\" data-src=\"" + image.URL + "\" data-id=\"" + image.ID + "\" data-type=\"" + image.type + "\" data-cid=\"" + image.CID + "\" data-orignalCID=\"" + image.orignalCID + "\" data-owner=\"" + image.owner + "\" data-des=\"" + image.des + "\" data-cap=\"" + image.cap + "\" data-date=\"" + image.date + "\" data-name=\"" + image.name + "\" alt=\"" + image.alt + "\" ></div>";
                                }
                            }

                            // library.append( imageHtml );
                            const $content = $( block );
                            $grid.prepend( $content )
                            // add and lay out newly prepended items
                            .masonry( 'prepended', $content );

                            $( 'body .IPFS-library-image-lazyload' ).each( function ( image ) {

                                const imagePath = $ ( this ).data ( 'src' );
                                const imageEle = $ ( this );

                                $('<img src="'+ imagePath +'">').load( function () {
                                    imageEle.attr( 'src', imagePath );
                                });

                            })

                        });

                        $grid.imagesLoaded().progress(function() {

                            $grid.masonry('layout')
                            $grid.masonry('reloadItems')

                        });

                        // $grid.masonry('layout');

                        if ( selected ) {
                            $( 'body input[name="ipfs-image"][value="' + selected + '"]' ).attr( 'checked', true );
                        }

                    } else {

                        library.addClass( 'loading' );

                        const notFoundHtml = "<div class=\"ipfs_notfound\">\n" +
                            "        <img src=\"" + ajax_vars.not_found_image + "\" alt=\"Not found\" />\n" +
                            "        <p> There are no images added yet. Quiet and lonely. </p>\n" +
                            "    </div>";

                        library.html( notFoundHtml );

                    }

                }
            });

        }

        const validateNFT = ( CID, name, element, fileType = 'image' ) => {

            let success = false

            const url = generate_URL( CID, 'metadata.json' );

            $.ajax({
                url,
                // dataType : "json",
                success: async function ( result ) {
                    success = true;
                    let URL = '';
                    if ( fileType == 'json' ) {

                        const _type = $( 'input[name="ipfs_json_type"]:checked' ).val();

                        if ( _type == 'pinata' ) {
                            type = 'ipfs_pinata';
                        } else if ( _type == 'web3' ) {
                            type = 'ipfs_web3';
                        } else if ( _type == 'nft' ) {
                            type = 'ipfs_nft';
                        }
                        URL = generate_URL( CID, '', type );
                    
                    } else {
                        URL = generate_URL( CID, '' );
                    }
                    await addImage ( { CID, name, URL, fileType, element } );
                    $( 'body > .modal-wrapper' ).remove();
                    $( 'div.grid' ).append( '<div class="grid-item"><img src="' + URL + '" alt=""></div>' );
                },
                error: function (error) {
                    alert ( 'unable to validate CID and Image path please check details and try again!' );
                    element.removeAttr('disabled');
                    element.text( 'Retrieve' );
                }
            });

        }

        const validatePinata = ( CID, name, element, fileType = 'image' ) => {

            let success = false

            const url = generate_URL( CID, 'metadata.json' );

            $.ajax({
                url,
                // dataType : "json",
                success: async function ( result ) {
                    success = true;
                    let URL = '';
                    if ( fileType == 'json' ) {

                        const _type = $( 'input[name="ipfs_json_type"]:checked' ).val();

                        if ( _type == 'pinata' ) {
                            type = 'ipfs_pinata';
                        } else if ( _type == 'web3' ) {
                            type = 'ipfs_web3';
                        } else if ( _type == 'nft' ) {
                            type = 'ipfs_nft';
                        }
                        URL = generate_URL( CID, '', type );
                    
                    } else {
                        URL = generate_URL( CID, '' );
                    }
                    const image = await addImage ( { CID, name, URL, fileType, element } );

                },
                error: function (error) {
                    alert ( 'unable to validate CID and Image path please check details and try again!' );
                    element.removeAttr('disabled');
                    element.text( 'Retrieve' );
                }
            });

        }

        const validateWEB3 = ( CID, path, name, element, fileType = 'image' ) => {

            let success = false;
            let type = '';

            const url = generate_URL( CID, path );

            $.ajax({
                url: 'https://api.web3.storage/status/' + CID,
                // url,
                headers: { Authorization: "Bearer " + ajax_vars.web3_token },
                dataType : "json",
                success: async function ( result ) {
                    element.text( 'Adding....' );
                    // console.log( result );
                    success = true;
                    let URL = '';
                    if ( fileType == 'json' ) {

                        const _type = $( 'input[name="ipfs_json_type"]:checked' ).val();

                        if ( _type == 'pinata' ) {
                            type = 'ipfs_pinata';
                        } else if ( _type == 'web3' ) {
                            type = 'ipfs_web3';
                        } else if ( _type == 'nft' ) {
                            type = 'ipfs_nft';
                        }
                        URL = generate_URL( CID, path, type );
                    
                    } else {
                        URL = generate_URL( CID, path );
                    }

                    await generateImages( { CID, path, name, URL, fileType, element } );
                },
                error: function (error) {
                    alert ( 'unable to validate CID and Image path please check details and try again!' );
                    element.removeAttr('disabled');
                    element.text( 'Retrieve' );
                }
            });

            return success;

        }

        const generateImages = ( data ) => {

            data.element.text( 'Generating images....' );

            $.ajax({
                type : "POST",
                url: ajax_vars.ajaxurl,
                dataType : "json",
                cache: false,
                data: { image: data.URL, action: 'IPFS_generate_images' },
                success: function ( result ) {

                    const images = uploadImagesToWeb3 ( { ...data, images: result.images, ID: result.ID } );

                    // console.log( images );

                    // await addImage ( { CID, path, name, URL, fileType, element } );
                    // return result;
                },
                error: function (error) {

                    console.log( error );
                    alert ( 'unable to generate image required sizes!' );
                    data.element.removeAttr('disabled');
                    data.element.text( 'Retrieve' );
                
                }
            });

            return true;

        }

        const getUrlExtension = (url) => {
            return url
                  .split(/[#?]/)[0]
                  .split(".")
                  .pop()
                  .trim();
        }

        const getImageBlob = async ( image ) => {

            const URL       = image.url;
            var filename    = URL.substring ( URL.lastIndexOf ( '/' ) + 1 );

            var imgExt = await getUrlExtension( URL );
            const response = await fetch( URL );

            const blob = await response.blob();

            const file = new File([blob], filename, {
              type: blob.type,
            });

            // console.log( file );

            return file;

        }

        const uploadImagesToWeb3 = async ( data ) => {

            // console.log ( data );

            var formData = new FormData();

            const imagesData = [];
            const images = data.images;

            const files = await images.map ( async image => {

                const file = await getImageBlob( image );

                imagesData.push ( file );

                formData.append( 'files[]', file );

                return file;
            
            });

            const _imagesData = Promise.all ( files ).then( ( result ) => {

                console.log ( formData );


                $.ajax({
                    type : "post",
                    // dataType : "json",
                    url: 'https://api.web3.storage/upload',
                    cache: false,
                    // contentType: 'multipart/form-data',
                    processData: false,
                    headers: {
                        Authorization: "Bearer " + ajax_vars.web3_token,
                        contentType: 'multipart/form-data'
                    },
                    data: formData,
                    success: function ( _result ) {
                        console.log( _result );
                        // addImage ( { CID: _result.cid, name: $( 'input#attachment-details-two-column-title',  ).val(), URL: generate_URL( _result.cid, '', 'ipfs_web3' ), element: element, type: 'ipfs_web3' }, true );
                    },
                    error: function (error) {
                        console.log( error );
                    }
                });

            });

        }

        const generate_URL = ( CID, path, type = ajax_vars.page ) => {

            if ( type == 'ipfs_web3' ) {
                return `https://${CID.replace(/^\s+|\s+$/g,'')}.ipfs.dweb.link/${encodeURIComponent(path.replace(/^\s+|\s+$/g,''))}`;
            } else if ( type == 'ipfs_nft' ) {
                return `https://ipfs.io/ipfs/${CID.replace(/^\s+|\s+$/g,'')}`
            } else {
                return `https://gateway.pinata.cloud/ipfs/${CID.replace(/^\s+|\s+$/g,'')}`;
            }

        }

        const addImage = async( data, media = false, jsonType = '' ) => {

            const CID   = data.CID;
            const name  = data.name;
            const URL   = data.URL;
            const element = data.element;
            const fileType = data.fileType;
            let type    = ajax_vars.page;
            let path    = '';
            let output  = null;

            if ( media ) {
                type = data.type;
            }

            if ( type == 'ipfs_lottie' ) {
                _type = $( 'input[name="ipfs_json_type"]:checked' ).val();

                if ( _type == 'pinata' ) {
                    type = 'ipfs_pinata';
                } else if ( _type == 'web3' ) {
                    type = 'ipfs_web3';
                } else if ( _type == 'nft' ) {
                    type = 'ipfs_nft';
                }
            }

            if ( type == 'ipfs_web3' ) {
                path = data.path;
                path = path.replace(/^\s+|\s+$/g,'');
            }

            await $.ajax({
                type : "post",
                dataType : "json",
                url: ajax_vars.ajaxurl,
                data: { CID, path, URL, name, type, fileType, action: 'IPFS_add_image' },
                success: function ( image ) {

                    if ( !media ) {

                        location.reload();

                    } else {
                        console.log( image );

                        alert ( 'Image uplaoded! You can check in library.' );
                    }

                    output = image;

                }
            });

            if ( !media ) {

                element.removeAttr('disabled');
                element.text( 'Retrieve' );

            } else {
                element.parent( 'div' ).parent( 'div' ).parent( 'div' ).remove();
            }

            return output;

        }

        const ipfs_cdn = ( _element = null ) => {

            let element = $( 'input[name="ipfs_cdn"]' );

            if ( _element ) {
                element = _element;
            }

            if ( element.is(':checked') ) {
                $( '.IPFS-select-cdn' ).show();
                $( '.IPFS-cdn-section.minify' ).show();
                $( '.IPFS-cdn-section.period' ).show();
                $( '.IPFS-cdn-section.rebuilt' ).show();
            } else {
                $( '.IPFS-select-cdn' ).hide();
                $( '.IPFS-cdn-section.minify' ).hide();
                $( '.IPFS-cdn-section.period' ).hide();
                $( '.IPFS-cdn-section.rebuilt' ).hide();
            }

        }

        const ipfs_pinata = () => {

            const element = $( 'input[name="ipfs_pinata"]' );

            if ( element.is(':checked') ) {
                $( 'input[name="pinata_api_key"]' ).parent( 'div' ).show();
                $( 'input[name="pinata_api_secret"]' ).parent( 'div' ).show();
            } else {
                $( 'input[name="pinata_api_key"]' ).parent( 'div' ).hide();
                $( 'input[name="pinata_api_secret"]' ).parent( 'div' ).hide();
            }

        }

        const ipfs_web3 = () => {

            const element = $( 'input[name="ipfs_web3"]' );

            if ( element.is(':checked') ) {
                $( 'input[name="web3_api_key"]' ).parent( 'div' ).show();
            } else {
                $( 'input[name="web3_api_key"]' ).parent( 'div' ).hide();
            }

        }

        const ipfs_nft = () => {

            const element = $( 'input[name="ipfs_nft"]' );

            if ( element.is(':checked') ) {
                $( 'input[name="nft_api_key"]' ).parent( 'div' ).show();
            } else {
                $( 'input[name="nft_api_key"]' ).parent( 'div' ).hide();
            }

        }

        const ipfs_woo_library_load = () => {

            const html = "" +
                "<div id='IPFS-woo-set-product-image-library' class=\"modal-wrapper\">\n" +
                "  <div class=\"modal\">\n" +
                "    <div class=\"btn-close IPFS-woo-close\"></div>\n" +
                "    <div class=\"clear\"></div>\n" +
                "    <div class=\"content\">\n" +
                "       <h3 class=\"title\">Product Image</h3>\n" +
                "       <hr style='margin: 0px; border-bottom-color: #959595; border-top-color: transparent;' />\n" +
                "       <div class=\"ipfs-library-head\" style='padding: 20px; margin: 0 auto'>\n" +
                "           <div style=\"width: calc( 100% - 75px )\">\n" +
                "               <form class=\"IPFS-library-search-form\">\n" +
                "                   <div class=\"IPFS-library-search\">\n" +
                "                       <input type=\"text\" placeholder=\"Search images\" name=\"ipfs-search\" />\n" +
                "                       <img src=\"" + ajax_vars.search_icon + "\" type=\"submit\" />\n" +
                "                   </div>\n" +
                "               </form>\n" +
                "           </div>\n" +
                "           <div  class=\"IPFS-json-filter\" style=\"text-align: left\">\n" +
                "               <select>\n" +
                "                   <option value=\"\"> All </option>\n" +
                "                   <option value=\"pinata\"> Pinata </option>\n" +
                "                   <option value=\"web3\"> Web3.Storage </option>\n" +
                "                   <option value=\"nft\"> NFT.Storage </option>\n" +
                "               </select>\n" +
                "               <img src=\"" + ajax_vars.filter_icon + "\" />\n" +
                "           </div>\n" +
                "       </div>\n"+
                "       <div class=\"grid ipsf_media_library loading\">\n" +
                "           <div class=\"lds-ripple\"><div></div><div></div></div>\n" +
                "       </div>\n" +
                "       <div class='footer'>\n" +
                "           <button class=\"ipfs-button ipfs-insert-image web3\"> Insert </button> \n" +
                "       </div>\n" +
                "    </div>\n" +
                "  </div>\n" +
                "</div>";

            $( 'body' ).append ( html );


            var colWidth = $(".grid-item").width();

            window.onresize = function(){
                var colWidth = $(".grid-item").width();
            }
            $grid = $("body .grid").masonry({
                // options
                itemSelector: ".grid-item",
                columnWidth: ".grid-item",
                // percentPosition: true,
                gutter: 10,
                fitWidth: true
            });

            $grid.imagesLoaded().progress(function() {
                $grid.masonry("layout");
            });

            const width = $( window ).width () - 40;
            const height = $( window ).height () - 40;

            $( 'body #IPFS-woo-set-product-image-library' ).addClass ( 'open' );

            let selectedImage = null;
            const image = $( 'input[name="ipfs_image"]' ).val();

            if ( image != '' ) {
                selectedImage = image;
            }

            loadLibrary ( '', true, selectedImage );

        }

        const ipfs_woo_library = () => {

            $( '#IPFS-woo-set-product-image, #IPFS-woo-library img' ).on ( 'click', function ( event ) {

                event.preventDefault();

                ipfs_woo_library_load ();

            });

            $( 'body' ).on( 'click', '.IPFS-woo-close', function ( event ) {

                event.preventDefault();

                $ ( this ).parent ( 'div' ).parent ( 'div' ).removeClass ( 'open' );

                setTimeout ( () => {
                    $ ( this ).parent ( 'div' ).parent ( 'div' ).remove ();
                }, 200 );

            });



            $( 'body' ).on( 'click', 'button.ipfs-insert-image', function ( event ) {

                if ( $ ( 'body input[name="ipfs-image"]:checked' ).length ) {

                    const current   = $ ( 'body input[name="ipfs-image"]:checked' );
                    const image     = $( '#IPFS-woo-library .inside > img' );
                    const input     = $( '#IPFS-woo-library .inside > input[name="ipfs_image"]' );
                    const src       = current.data( 'src' );

                    image.show ();
                    image.attr ( 'src', src );

                    input.val ( current.val () );

                    $( '.IPFS-woo-close' ).trigger ( 'click' );

                }

            });

        }

        const ipfs_woo_library_toggle = () => {

            if ( $( 'input[name="ipfs_enable"]' ).is( ':checked' ) ) {

                $( '#IPFS-woo-library' ).show();
                $( '#postimagediv' ).hide();

            } else {

                $( '#IPFS-woo-library' ).hide();
                $( '#postimagediv' ).show();

            }

        }

        const ipfs_woo_library_image_toggle = () => {

            const current = $ ( 'body input[name="ipfs_image"]' ).val();

            if ( current ) {

                $( '#IPFS-woo-library img' ).show();
                $( '#IPFS-woo-set-product-image' ).parent( 'p' ).hide();
                $( '#IPFS-set-post-thumbnail-desc' ).show();
                $( '#IPFS-remove-post-thumbnail' ).parent( 'p' ).show();

            } else {

                $( '#IPFS-woo-library img' ).hide();
                $( '#IPFS-woo-set-product-image' ).parent( 'p' ).show();
                $( '#IPFS-set-post-thumbnail-desc' ).hide();
                $( '#IPFS-remove-post-thumbnail' ).parent( 'p' ).hide();

            }

        }

    });

})(jQuery);

// Other code using $ as an alias to the other library