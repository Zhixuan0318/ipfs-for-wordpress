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
class Elementor_Ipfs_Web3_Json_Library_Control extends Control_Base_Multiple
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
        return 'ipfs_web3_json';
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
            '10.0.2'
        );

        wp_enqueue_script ( 'IPFS_masonry', '//unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', Array ( 'jquery' ), '1.0.0', true );
        wp_enqueue_script ( 'IPFS_imagesloaded', '//unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', Array ( 'jquery' ), '1.0.0', true );

        wp_register_script(
            'IPFS-web3-json-library',
            plugins_url( '/assets/js/IPFS-web3-json-library.js', IPFS_MEDIA_LIBRARY ),
            [ 'jquery', 'IPFS_masonry', 'IPFS_imagesloaded' ],
            '1.0.10'
        );

        wp_enqueue_script( 'IPFS-web3-json-library' );

        wp_localize_script( 'IPFS-web3-json-library', 'ajax_vars_Web3_json',
            array(
                'ajaxurl'           => admin_url( 'admin-ajax.php' ),
                'add_image_nonce'   => wp_create_nonce("IPFS_add_image"),
                'not_found_image'   => plugins_url( '/admin/assets/images/notfound.png', IPFS_MEDIA_LIBRARY ),
                'type'              => 'web3',
                'fileType'          => 'json',
                'json_icon'         => plugins_url( '/admin/assets/images/file.png', IPFS_MEDIA_LIBRARY )
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
            <div class="elementor-control-media__file elementor-control-preview-area" data-control="IPFS-Web3-Json">
                <div class="elementor-control-media__file__content">
                    <div class="elementor-control-media__file__content__label"><?php echo esc_html__( 'Click the media icon to upload file', 'elementor' ); ?></div>
                    <div class="elementor-control-media__file__content__info">
                        <div class="elementor-control-media__file__content__info__icon">
                            <i class="eicon-document-file"></i>
                        </div>
                        <div class="elementor-control-media__file__content__info__name"></div>
                    </div>
                </div>
                <div class="elementor-control-media__file__controls">
                    
                    <div class="elementor-control-media__file__controls__upload-button elementor-control-media-upload-button" title="<?php echo esc_html__( 'Upload', 'elementor' ); ?>">
                        <i class="eicon-upload"></i>
                    </div>
                </div>
            </div>
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