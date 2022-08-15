window.addEventListener( 'elementor/init', () => {

    var IPFS_libraryItemView = elementor.modules.controls.BaseMultiple.extend({

        ui: function() {
            return {
                Pinata_opener: 'div[data-control="IPFS-NFT-Json"]',
                _closer: '.modal-wrapper .btn-close',
                input: 'input',
                Json_name: '.elementor-control-media__file__content__info__name'
            };
        },

        // Override the base events
        events: function() {
            return {
                'click @ui.Pinata_opener': 'loadLibrary',
                'click @ui.closer_': 'closeLibrary',
            };
        },

        closeLibrary: async function () {

            jQuery( 'body .modal-wrapper.open' ).remove();

        },


        loadLibrary: async function ( event ) {

            const ID = Date.now();

            const html = "" +
                "<div class=\"modal-wrapper open\" id=\"IPFS-" + ID + "\" >\n" +
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

            jQuery( 'body' ).append( html );

            const self = this;

            // console.log( this );

            const library   = jQuery ( 'body #IPFS-' + ID + ' .grid.ipsf_media_library' );

            await this.loadImages( self );

            jQuery( 'body' ).on( 'click', '#IPFS-' + ID + ' .btn-close', function ( event ) {

               jQuery( this ).parent( 'div' ).parent( 'div' ).remove();
               jQuery( "body #IPFS-" + ID + " .btn-close" ).unbind();
               jQuery( "body #IPFS-" + ID + " .ipfs-insert-image.web3" ).unbind();

            });

            jQuery ( 'body' ).on( 'click', '#IPFS-' + ID + ' .ipfs-insert-image.web3', function () {

                const selected = jQuery('input[name="ipfs-image"]:checked');
                const val = selected.val();

                if ( val != '' || val != null ) {

                    self.setValue ({ id: selected.data( 'id' ), url: val, alt: selected.data( 'alt' ), name: selected.data( 'name' ) });

                    self.ui.Pinata_opener.find( '.elementor-control-media__file__content__info__name' ).text( selected.data( 'name' ) );

                    // const preview = self.ui.Pinata_opener.find( '.elementor-control-media__preview' );

                    // preview.css( 'background-image', `url( "${val}" )` );

                }

                console.log( self.ui );
                // console.log( self.control_select.val() );

                // self.control_select.parent( 'div' ).children( 'input' ).remove();

                jQuery( '#IPFS-' + ID + ' .btn-close' ).unbind();
                jQuery( '#IPFS-' + ID + ' .ipfs-insert-image.web3' ).unbind();

                jQuery( 'body #IPFS-' + ID ).removeClass( 'open' );

            });


            jQuery ( 'body' ).on( 'click', '#IPFS-' + ID + ' .ipsf_media_library img', function () {

                jQuery( this ).parent( 'div' ).children( 'label' ).trigger( 'click' );

            });

        },

        onBeforeRender: function ( options ) {


            

            // elementor.modules.controls.BaseMultiple.prototype.initialize.apply( this, arguments );

            // this.registerValidators();

            // return options;
        },

        onReady: function () {

            const self= this;

            if ( self.elementSettingsModel.attributes.source_json?.name ) {
              self.ui.Json_name.text( self.elementSettingsModel.attributes.source_json.name );
            }

            // if (  )

            /*if ( typeof this.elementSettingsModel.attributes.image.url != 'undefined' ) {

                const preview = this.ui.Pinata_opener.find( '.elementor-control-media__preview' );

                preview.css( 'background-image', `url( "${this.elementSettingsModel.attributes.image.url}" )` );
            }*/

            /*alert('okay');*/

            // this.control_select = this.$el.find('div[data-control="IPFS-library"]');

            // self.setValue ({ id: 123, url: "https://picsum.photos/200/300" });

            // console.log( this );

            /*this.control_select.on( 'click', () => {

                self.loadLibrary( self )

                // console.log( this );

            });*/

        },

        saveValue: function() {
            this.setValue( this.ui.input[0].value );

            // console.log( this.control_select.val() );

        },

        onBeforeDestroy: function() {

            // this.saveValue();
            // this.$el.remove();
               jQuery( "body .modal-wrapper.open .btn-close" ).unbind( 'click' );
               jQuery( "body .modal-wrapper.open .ipfs-insert-image.web3" ).unbind( 'click' );

               const notFoundHtml = "<div class=\"lds-ripple\"><div></div><div></div></div>\n";

               jQuery( '.grid' ).addClass( 'loading' );
               jQuery( '.grid' ).html( notFoundHtml );

        },

        loadImages: function ( element ) {

            const library   = jQuery ( 'body .grid.ipsf_media_library' );

            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: ajax_vars_nft_json.ajaxurl,
                data: { type: 'ipfs_' + ajax_vars_nft_json.type, fileType: ajax_vars_nft_json.fileType, action: 'IPFS_get_images' },
                error: function (error) {
                    alert('Something went wrong, Please  try again later!');
                },
                success: async function (result) {

                    if ( result.count > 0 ) {

                        library.removeClass( 'loading' );
                        library.addClass ( 'ipsf_lottie_library' );
                        library.html( "" );
                        jQuery( result.images ).each( ( index, image ) => {
                            const imageHtml = "<div class=\"grid-item\"><img style='height: auto;' src=\"" + ajax_vars_nft_json.json_icon + "\" alt=\"\"><label class=\"form-control\">\n" + image.name +
                                "    <input type=\"radio\" name=\"ipfs-image\" value='" + image.URL + "' data-id='" + image.ID + "' data-name='" + image.name + "' data-alt='" + image.alt + "' />\n" +
                                "  </label></div>";
                            library.append( imageHtml );
                        });

                        var colWidth = jQuery(".grid-item").width();

                        window.onresize = function(){
                            var colWidth = jQuery(".grid-item").width();
                        }
                        var $grid = jQuery(".grid").masonry({
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

                    } else {

                        const notFoundHtml = "<div class=\"ipfs_notfound\">\n" +
                            "        <img src=\"" + ajax_vars_nft_json.not_found_image + "\" alt=\"Not found\" />\n" +
                            "        <p> There are no images added yet. Quiet and lonely. </p>\n" +
                            "    </div>";

                        library.html( notFoundHtml );

                    }
                }
            });

        }

    });

    elementor.addControlView( 'ipfs_nft_json', IPFS_libraryItemView );

});