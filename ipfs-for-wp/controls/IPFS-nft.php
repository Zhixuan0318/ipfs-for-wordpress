<?php

use Elementor\Control_Base_Multiple;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Plugin;
use Elementor\Utils;

/**
 * Elementor currency control.
 *
 * A control for displaying a select field with the ability to choose currencies.
 *
 * @since 1.0.0
 */
class Elementor_Ipfs_NFT_Library_Control extends Control_Base_Multiple
{

    /**
     * Get media control type.
     *
     * Retrieve the control type, in this case `media`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type() {
        return 'ipfs_nft';
    }

    /**
     * Get media control default values.
     *
     * Retrieve the default value of the media control. Used to return the default
     * values while initializing the media control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value() {
        return [
            'url'   => '',
            'id'    => '',
            'type'  => 'web3',
        ];
    }

    /**
     * Import media images.
     *
     * Used to import media control files from external sites while importing
     * Elementor template JSON file, and replacing the old data.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $settings Control settings
     *
     * @return array Control settings.
     */
    public function on_import( $settings ) {
        if ( empty( $settings['url'] ) ) {
            return $settings;
        }

        $settings = Plugin::$instance->templates_manager->get_import_images_instance()->import( $settings );

        if ( ! $settings ) {
            $settings = [
                'id' => '',
                'url' => Utils::get_placeholder_image_src(),
            ];
        }

        return $settings;
    }

    /**
     * Support SVG and JSON Import
     *
     * Called by the 'upload_mimes' filter. Adds SVG and JSON mime types to the list of WordPress' allowed mime types.
     *
     * @since 3.4.6
     * @deprecated 3.5.0
     *
     * @param $mimes
     * @return mixed
     */
    public function support_svg_and_json_import( $mimes ) {
        Plugin::$instance->modules_manager->get_modules( 'dev-tools' )->deprecation->deprecated_function( __METHOD__, '3.5.0' );

        return $mimes;
    }

    /**
     * Enqueue media control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by the media
     * control.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue(  ) {
        global $wp_version;

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        /*wp_enqueue_media();*/

        wp_enqueue_style( 'IPFS_font_family', '//fonts.googleapis.com/css?family=Inter', false, '1.0.0' );

        wp_enqueue_style(
            'IPFS_media_',
            plugins_url( '/assets/css/IPFS-media.css', IPFS_MEDIA_LIBRARY ),
            '10.0.1'
        );

        wp_enqueue_script ( 'IPFS_masonry', '//unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', Array ( 'jquery' ), '1.0.0', true );
        wp_enqueue_script ( 'IPFS_imagesloaded', '//unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', Array ( 'jquery' ), '1.0.0', true );

        wp_register_script(
            'IPFS-NFT',
            plugins_url( '/assets/js/IPFS-nft.js', IPFS_MEDIA_LIBRARY ),
            [ 'jquery', 'IPFS_masonry', 'IPFS_imagesloaded' ],
            '1.0.4'
        );

        wp_enqueue_script( 'IPFS-NFT' );

        wp_localize_script( 'IPFS-NFT', 'ajax_vars_NFT',
            array(
                'ajaxurl'           => admin_url( 'admin-ajax.php' ),
                'add_image_nonce'   => wp_create_nonce("IPFS_add_image"),
                'not_found_image'   => plugins_url( '/admin/assets/images/notfound.png', IPFS_MEDIA_LIBRARY ),
                'type'              => 'nft'
            )
        );
    }

    /**
     * Render media control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template() {
        ?>
        <#
        // For BC.
        if ( data.media_type ) {
        data.media_types = [ data.media_type ];
        }

        if ( data.should_include_svg_inline_option ) {
        data.media_types.push( 'svg' );
        }

        // Determine if the current media type is viewable.
        const isViewable = () => {
        const viewable = [
        'image',
        'video',
        'svg',
        ];

        // Make sure that all media types are viewable.
        return data.media_types.every( ( type ) => viewable.includes( type ) );
        };

        // Get the preview type for the current media type.
        const getPreviewType = () => {
        if ( data.media_types.includes( 'video' ) ) {
        return 'video';
        }

        if ( data.media_types.includes( 'image' ) || data.media_types.includes( 'svg' ) ) {
        return 'image';
        }

        return 'none';
        }

        // Retrieve a button label by media type.
        const getButtonLabel = ( mediaType ) => {
        switch( mediaType ) {
        case 'image':
        return '<?php esc_html_e( 'Choose Image', 'elementor' ); ?>';

        case 'video':
        return '<?php esc_html_e( 'Choose Video', 'elementor' ); ?>';

        case 'svg':
        return '<?php esc_html_e( 'Choose SVG', 'elementor' ); ?>';

        default:
        return '<?php esc_html_e( 'Choose File', 'elementor' ); ?>';
        }
        }
        #>
        <div class="elementor-control-field elementor-control-media">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <#
            if ( isViewable() ) {
            let inputWrapperClasses = 'elementor-control-input-wrapper elementor-aspect-ratio-219';

            if ( ! data.label_block ) {
            inputWrapperClasses += ' elementor-control-unit-5';
            }
            #>
            <div class="{{{ inputWrapperClasses }}}">
                <div class="elementor-control-media__content elementor-control-tag-area elementor-fit-aspect-ratio" data-control="IPFS-NFT">
                    <div class="elementor-control-media-area elementor-fit-aspect-ratio">
                        <!--<div class="elementor-control-media__remove elementor-control-media__content__remove" title="<?php /*echo esc_html__( 'Remove', 'elementor' ); */?>">
                            <i class="eicon-trash-o"></i>
                        </div>-->
                        <div class="elementor-control-media__preview elementor-fit-aspect-ratio"></div>
                    </div>
                    <div class="elementor-control-media-upload-button elementor-control-media__content__upload-button">
                        <i class="eicon-plus-circle" aria-hidden="true"></i>
                    </div>
                    <div class="elementor-control-media__tools elementor-control-dynamic-switcher-wrapper">
                        <#
                        data.media_types.forEach( ( type ) => {
                        if ( type == 'image' ) {
                        #>
                        <div class="elementor-control-media__tool elementor-control-media__replace" data-media-type="{{{ type }}}">{{{ getButtonLabel( type ) }}}</div>
                        <#
                        }
                        } );
                        #>
                    </div>
                </div>
            </div>
            <# } #>
            <input type="hidden" data-setting="{{ data.name }}"/>
        </div>
        <?php
    }

    /**
     * Get media control default settings.
     *
     * Retrieve the default settings of the media control. Used to return the default
     * settings while initializing the media control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings() {
        return [
            'label_block' => true,
            'library_type' => 'web3',
            'media_types' => [
                'image',
            ],
            'dynamic' => [
                'categories' => [ TagsModule::IMAGE_CATEGORY ],
                'returnType' => 'object',
            ],
        ];
    }

    /**
     * Get media control image title.
     *
     * Retrieve the `title` of the image selected by the media control.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param array $attachment Media attachment.
     *
     * @return string Image title.
     */
    public static function get_image_title( $attachment ) {
        if ( empty( $attachment['id'] ) ) {
            return '';
        }

        return get_the_title( $attachment['id'] );
    }

    /**
     * Get media control image alt.
     *
     * Retrieve the `alt` value of the image selected by the media control.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param array $instance Media attachment.
     *
     * @return string Image alt.
     */
    public static function get_image_alt( $instance ) {
        if ( empty( $instance['id'] ) ) {
            // For `Insert From URL` images.
            return isset( $instance['alt'] ) ? trim( strip_tags( $instance['alt'] ) ) : '';
        }

        $attachment_id = $instance['id'];
        if ( ! $attachment_id ) {
            return '';
        }

        $attachment = get_post( $attachment_id );
        if ( ! $attachment ) {
            return '';
        }

        $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
        if ( ! $alt ) {
            $alt = $attachment->post_excerpt;
            if ( ! $alt ) {
                $alt = $attachment->post_title;
            }
        }
        return trim( strip_tags( $alt ) );
    }

}