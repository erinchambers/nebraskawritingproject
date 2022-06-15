<?php
/**
* Simple Writer Theme Customizer.
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

if ( ! class_exists( 'WP_Customize_Control' ) ) {return NULL;}

/**
* Simple_Writer_Customize_Static_Text_Control class
*/

class Simple_Writer_Customize_Static_Text_Control extends WP_Customize_Control {
    public $type = 'simple-writer-static-text';

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
    }

    protected function render_content() {
        if ( ! empty( $this->label ) ) :
            ?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
        endif;

        if ( ! empty( $this->description ) ) :
            ?><div class="description customize-control-description"><?php

        echo wp_kses_post( $this->description );

            ?></div><?php
        endif;

    }
}

/**
* Simple_Writer_Customize_Button_Control class
*/

class Simple_Writer_Customize_Button_Control extends WP_Customize_Control {
        public $type = 'button';
        protected $button_tag = 'button';
        protected $button_class = 'button button-primary';
        protected $button_href = 'javascript:void(0)';
        protected $button_target = '';
        protected $button_onclick = '';
        protected $button_tag_id = '';

        public function render_content() {
        ?>
        <span class="center">
        <?php
        echo '<' . esc_html($this->button_tag);
        if (!empty($this->button_class)) {
            echo ' class="' . esc_attr($this->button_class) . '"';
        }
        if ('button' == $this->button_tag) {
            echo ' type="button"';
        }
        else {
            echo ' href="' . esc_url($this->button_href) . '"' . (empty($this->button_tag) ? '' : ' target="' . esc_attr($this->button_target) . '"');
        }
        if (!empty($this->button_onclick)) {
            echo ' onclick="' . esc_js($this->button_onclick) . '"';
        }
        if (!empty($this->button_tag_id)) {
            echo ' id="' . esc_attr($this->button_tag_id) . '"';
        }
        echo '>';
        echo esc_html($this->label);
        echo '</' . esc_html($this->button_tag) . '>';
        ?>
        </span>
        <?php
        }
}

function simple_writer_getting_started($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_getting_started', array( 'title' => esc_html__( 'Getting Started', 'simple-writer' ), 'description' => esc_html__( 'Thanks for your interest in Simple Writer! If you have any questions or run into any trouble, please visit us the following links. We will get you fixed up!', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 5, ) );

    $wp_customize->add_setting( 'simple_writer_options[documentation]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );

    $wp_customize->add_control( new Simple_Writer_Customize_Button_Control( $wp_customize, 'simple_writer_documentation_control', array( 'label' => esc_html__( 'Documentation', 'simple-writer' ), 'section' => 'simple_writer_section_getting_started', 'settings' => 'simple_writer_options[documentation]', 'type' => 'button', 'button_tag' => 'a', 'button_class' => 'button button-primary', 'button_href' => esc_url( 'https://themesdna.com/simple-writer-wordpress-theme/' ), 'button_target' => '_blank', ) ) );

    $wp_customize->add_setting( 'simple_writer_options[contact]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );

    $wp_customize->add_control( new Simple_Writer_Customize_Button_Control( $wp_customize, 'simple_writer_contact_control', array( 'label' => esc_html__( 'Contact Us', 'simple-writer' ), 'section' => 'simple_writer_section_getting_started', 'settings' => 'simple_writer_options[contact]', 'type' => 'button', 'button_tag' => 'a', 'button_class' => 'button button-primary', 'button_href' => esc_url( 'https://themesdna.com/contact/' ), 'button_target' => '_blank', ) ) );

}


function simple_writer_color_options($wp_customize) {

   $wp_customize->add_setting( 'simple_writer_options[header_text_hover_color]', array( 'default' => '#d14f42', 'type' => 'option', 'transport' => 'postMessage', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_hex_color' ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'simple_writer_header_text_hover_color_control', array( 'label' => esc_html__( 'Header Hover Text Color', 'simple-writer' ), 'section' => 'colors', 'settings' => 'simple_writer_options[header_text_hover_color]' ) ) );

    $wp_customize->add_setting( 'simple_writer_options[social_buttons_color]', array( 'default' => '#000000', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_hex_color' ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'simple_writer_social_buttons_color_control', array( 'label' => esc_html__( 'Social Buttons Color', 'simple-writer' ), 'section' => 'colors', 'settings' => 'simple_writer_options[social_buttons_color]' ) ) );

    $wp_customize->add_setting( 'simple_writer_options[social_buttons_shadow_color]', array( 'default' => '#ffffff', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_hex_color' ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'simple_writer_social_buttons_shadow_color_control', array( 'label' => esc_html__( 'Social Buttons Text-Shadow Color', 'simple-writer' ), 'section' => 'colors', 'settings' => 'simple_writer_options[social_buttons_shadow_color]' ) ) );

    $wp_customize->add_setting( 'simple_writer_options[social_buttons_hover_color]', array( 'default' => '#444444', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_hex_color' ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'simple_writer_social_buttons_hover_color_control', array( 'label' => esc_html__( 'Social Buttons Hover Color', 'simple-writer' ), 'section' => 'colors', 'settings' => 'simple_writer_options[social_buttons_hover_color]' ) ) );

}


function simple_writer_menu_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_menu_options', array( 'title' => esc_html__( 'Menu Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 100 ) );

    $wp_customize->add_setting( 'simple_writer_options[disable_primary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_disable_primary_menu_control', array( 'label' => esc_html__( 'Disable Primary Menu', 'simple-writer' ), 'section' => 'simple_writer_section_menu_options', 'settings' => 'simple_writer_options[disable_primary_menu]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[disable_sticky_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_disable_sticky_menu_control', array( 'label' => esc_html__( 'Disable Sticky Feature from Primary Menu', 'simple-writer' ), 'description' => esc_html__('If you check this option, sticky feature of primary menu will be disabled from all screen sizes.', 'simple-writer'), 'section' => 'simple_writer_section_menu_options', 'settings' => 'simple_writer_options[disable_sticky_menu]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[enable_sticky_mobile_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_enable_sticky_mobile_menu_control', array( 'label' => esc_html__( 'Enable Sticky Feature for Primary Menu on Small Screen', 'simple-writer' ), 'description' => esc_html__('By default, sticky feature of primary menu is only available for screen sizes larger than 1112px. If you check this option, the sticky feature also will be enabled for small screen sizes. There is no any effect from this option if you haved checked the option: "Disable Sticky Feature from Primary Menu"', 'simple-writer'), 'section' => 'simple_writer_section_menu_options', 'settings' => 'simple_writer_options[enable_sticky_mobile_menu]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[center_primary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_center_primary_menu_control', array( 'label' => esc_html__( 'Center Primary Menu', 'simple-writer' ), 'section' => 'simple_writer_section_menu_options', 'settings' => 'simple_writer_options[center_primary_menu]', 'type' => 'checkbox', ) );

}


function simple_writer_header_options($wp_customize) {

    // Header
    $wp_customize->add_section( 'simple_writer_section_header', array( 'title' => esc_html__( 'Header Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 120 ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_tagline]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_tagline_control', array( 'label' => esc_html__( 'Hide Tagline', 'simple-writer' ), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[hide_tagline]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_header_content]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_header_content_control', array( 'label' => esc_html__( 'Hide Header Content', 'simple-writer' ), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[hide_header_content]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_image]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'simple_writer_header_content_image_control', array(
        'label' => esc_html__( 'Header Content Background Image', 'simple-writer' ),
        'height' => 300,
        'width' => 1920,
        'flex_width' => true,
        'flex_height' => true,
        'section' => 'simple_writer_section_header',
        'settings' => 'simple_writer_options[header_content_image]',
        'button_labels' => array( 'select' => esc_html__( 'Select Image', 'simple-writer' ), 'remove' => esc_html__( 'Remove Image', 'simple-writer' ), 'change' => esc_html__( 'Change Image', 'simple-writer' ), )
    )));

    $wp_customize->add_setting( 'simple_writer_options[header_content_bg_size]', array( 'default' => 'cover', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_size' ) );

    $wp_customize->add_control( 'simple_writer_header_content_bg_size_control', array( 'label' => esc_html__( 'Header Content Background Image Size', 'simple-writer' ), 'description' => esc_html__('Select the background size value for header content background image. Default value: Cover', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_bg_size]', 'type' => 'select', 'choices' => array( 'auto' => esc_html__( 'Auto', 'simple-writer' ), 'cover' => esc_html__( 'Cover', 'simple-writer' ), 'contain' => esc_html__( 'Contain', 'simple-writer' ) ) ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_bg_position]', array( 'default' => 'center top', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_position' ) );

    $wp_customize->add_control( 'simple_writer_header_content_bg_position_control', array( 'label' => esc_html__( 'Header Content Background Image Position', 'simple-writer' ), 'description' => esc_html__('Select the background position value for header content background image. Default value: Center Top', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_bg_position]', 'type' => 'select', 'choices' => array( 'left top' => esc_html__( 'Left Top', 'simple-writer' ), 'left center' => esc_html__( 'Left Center', 'simple-writer' ), 'left bottom' => esc_html__( 'Left Bottom', 'simple-writer' ), 'right top' => esc_html__( 'Right Top', 'simple-writer' ), 'right center' => esc_html__( 'Right Center', 'simple-writer' ), 'right bottom' => esc_html__( 'Right Bottom', 'simple-writer' ), 'center top' => esc_html__( 'Center Top', 'simple-writer' ), 'center center' => esc_html__( 'Center Center', 'simple-writer' ), 'center bottom' => esc_html__( 'Center Bottom', 'simple-writer' ) ) ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_bg_attachment]', array( 'default' => 'scroll', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_attachment' ) );

    $wp_customize->add_control( 'simple_writer_header_content_bg_attachment_control', array( 'label' => esc_html__( 'Header Content Background Image Attachment', 'simple-writer' ), 'description' => esc_html__('Select the background attachment value for header content background image. Default value: Scroll', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_bg_attachment]', 'type' => 'select', 'choices' => array( 'scroll' => esc_html__( 'Scroll', 'simple-writer' ), 'fixed' => esc_html__( 'Fixed', 'simple-writer' ), 'local' => esc_html__( 'Local', 'simple-writer' ) ) ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_bg_repeat]', array( 'default' => 'no-repeat', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_repeat' ) );

    $wp_customize->add_control( 'simple_writer_header_content_bg_repeat_control', array( 'label' => esc_html__( 'Header Content Background Image Repeat', 'simple-writer' ), 'description' => esc_html__('Select the background repeat value for header content background image. Default value: no-repeat', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_bg_repeat]', 'type' => 'select', 'choices' => array( 'repeat' => esc_html__( 'repeat', 'simple-writer' ), 'repeat-x' => esc_html__( 'repeat-x', 'simple-writer' ), 'repeat-y' => esc_html__( 'repeat-y', 'simple-writer' ), 'no-repeat' => esc_html__( 'no-repeat', 'simple-writer' ) ) ) );


    $wp_customize->add_setting( 'simple_writer_options[header_content_height]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( 'simple_writer_header_content_height_control', array( 'label' => esc_html__( 'Header Content Minimum Height (Normal Screen)', 'simple-writer' ), 'description' => esc_html__('Enter the numeric minimum pixel height value of header content on screens sizes larger than 720px. You can use any non-negative numeric value.', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_height]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_height_small]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( 'simple_writer_header_content_height_small_control', array( 'label' => esc_html__( 'Header Content Minimum Height (Small Screen)', 'simple-writer' ), 'description' => esc_html__('Enter the numeric minimum pixel height value of header content on screen sizes between 414px and 720px. You can use any non-negative numeric value.', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_height_small]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_height_smaller]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( 'simple_writer_header_content_height_smaller_control', array( 'label' => esc_html__( 'Header Content Minimum Height (Smaller Screen)', 'simple-writer' ), 'description' => esc_html__('Enter the numeric minimum pixel height value of header content on screens sizes smaller than 414px. You can use any non-negative numeric value.', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_height_smaller]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_padding]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( 'simple_writer_header_content_padding_control', array( 'label' => esc_html__( 'Header Content Padding (Normal Screen)', 'simple-writer' ), 'description' => esc_html__('Enter the numeric padding pixel value of header content on screens sizes larger than 720px. Default value is 0. You can use any non-negative numeric value like 50.', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_padding]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_padding_small]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( 'simple_writer_header_content_padding_small_control', array( 'label' => esc_html__( 'Header Content Padding (Small Screen)', 'simple-writer' ), 'description' => esc_html__('Enter the numeric padding pixel value of header content on screen sizes between 414px and 720px. Default value is 0. You can use any non-negative numeric value like 30.', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_padding_small]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[header_content_padding_smaller]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( 'simple_writer_header_content_padding_smaller_control', array( 'label' => esc_html__( 'Header Content Padding (Smaller Screen)', 'simple-writer' ), 'description' => esc_html__('Enter the numeric padding pixel value of header content on screens sizes smaller than 414px. Default value is 0. You can use any non-negative numeric value like 10.', 'simple-writer'), 'section' => 'simple_writer_section_header', 'settings' => 'simple_writer_options[header_content_padding_smaller]', 'type' => 'text' ) );


    // Header Image
    $wp_customize->add_setting( 'simple_writer_options[hide_header_image]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_header_image_control', array( 'label' => esc_html__( 'Hide Header Image from Everywhere', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[hide_header_image]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[remove_header_image_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_remove_header_image_link_control', array( 'label' => esc_html__( 'Remove Link from Header Image', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[remove_header_image_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_header_image_details]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_header_image_details_control', array( 'label' => esc_html__( 'Hide both Title and Description from Header Image', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[hide_header_image_details]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_header_image_description]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_header_image_description_control', array( 'label' => esc_html__( 'Hide Description from Header Image', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[hide_header_image_description]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[header_image_custom_title]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_header_image_custom_title_control', array( 'label' => esc_html__( 'Header Image Custom Title', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[header_image_custom_title]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'simple_writer_options[header_image_custom_description]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_header_image_custom_description_control', array( 'label' => esc_html__( 'Header Image Custom Description', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[header_image_custom_description]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'simple_writer_options[header_image_destination]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_header_image_destination_control', array( 'label' => esc_html__( 'Header Image Destination URL', 'simple-writer' ), 'description' => esc_html__( 'Enter the URL a visitor should go when he/she click on the header image. If you did not enter a URL below, header image will be linked to the homepage of your website.', 'simple-writer' ), 'section' => 'header_image', 'settings' => 'simple_writer_options[header_image_destination]', 'type' => 'text' ) );

}


function simple_writer_post_summaries_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_posts_summaries', array( 'title' => esc_html__( 'Post Summaries Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 175 ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_posts_heading]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_posts_heading_control', array( 'label' => esc_html__( 'Hide HomePage Posts Heading', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_posts_heading]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[posts_heading]', array( 'default' => esc_html__( 'Recent Posts', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'simple_writer_posts_heading_control', array( 'label' => esc_html__( 'HomePage Posts Heading', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[posts_heading]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'simple_writer_options[read_more_length]', array( 'default' => 40, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_read_more_length' ) );

    $wp_customize->add_control( 'simple_writer_read_more_length_control', array( 'label' => esc_html__( 'Auto Post Summary Length', 'simple-writer' ), 'description' => esc_html__('Enter the number of words need to display in the post summary. Default is 20 words.', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[read_more_length]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_thumbnail_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_thumbnail_home_control', array( 'label' => esc_html__( 'Hide Featured Images from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_thumbnail_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[show_default_thumbnail_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_show_default_thumbnail_home_control', array( 'label' => esc_html__( 'Show Default Images on Posts Summaries (when there are no featured images are available)', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[show_default_thumbnail_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[summary_thumb_style]', array( 'default' => 'simple-writer-760w-autoh-image', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_fp_thumb_style' ) );

    $wp_customize->add_control( 'simple_writer_summary_thumb_style_control', array( 'label' => esc_html__( 'Posts Summaries Thumbnail Size', 'simple-writer' ), 'description' => esc_html__('Select the post thumbnails size for summary posts style.', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[summary_thumb_style]', 'type' => 'select', 'choices' => array( 'simple-writer-760w-450h-image' => esc_html__( '760:450', 'simple-writer' ), 'simple-writer-760w-autoh-image' => esc_html__( '760:Auto', 'simple-writer' ) ) ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_header_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_header_home_control', array( 'label' => esc_html__( 'Hide Post Header from Posts Summaries', 'simple-writer' ), 'description' => esc_html__('If you check this option, it will hide these data: Post Title', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_header_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_data_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_data_home_control', array( 'label' => esc_html__( 'Hide All Post Meta Data from Posts Summaries', 'simple-writer' ), 'description' => esc_html__('If you check this option, it will hide these data: Author Image, Author Name, Posted Date, Number of Comments, Post Categories, Post Tags, Post Edit Link', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_data_home]', 'type' => 'checkbox', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_author_image]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_author_image_control', array( 'label' => esc_html__( 'Hide Post Author Images from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_author_image]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[author_image_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_author_image_link_control', array( 'label' => esc_html__( 'Link Author Image to Author Posts URL', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[author_image_link]', 'type' => 'checkbox', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_author_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_author_home_control', array( 'label' => esc_html__( 'Hide Post Author Names from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_author_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[post_author_text]', array( 'default' => esc_html__( 'Posted by', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_post_author_text_control', array( 'label' => esc_html__( 'Post Author Pre Text', 'simple-writer' ), 'description' => esc_html__('Enter a text to display before post author. Default text is "Posted by".', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[post_author_text]', 'type' => 'text', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_posted_date_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_posted_date_home_control', array( 'label' => esc_html__( 'Hide Posted Dates from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_posted_date_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[post_date_text]', array( 'default' => esc_html__( 'Posted on', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_post_date_text_control', array( 'label' => esc_html__( 'Post Date Pre Text', 'simple-writer' ), 'description' => esc_html__('Enter a text to display before post date. Default text is "Posted on".', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[post_date_text]', 'type' => 'text', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_comments_link_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_comments_link_home_control', array( 'label' => esc_html__( 'Hide Comment Links from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_comments_link_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[post_comments_text]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_post_comments_text_control', array( 'label' => esc_html__( 'Post Comments Pre Text', 'simple-writer' ), 'description' => esc_html__('Enter a text to display before post comments.', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[post_comments_text]', 'type' => 'text', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_categories_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_categories_home_control', array( 'label' => esc_html__( 'Hide Post Categories from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_categories_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[cat_links_text]', array( 'default' => esc_html__( 'Posted in', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_cat_links_text_control', array( 'label' => esc_html__( 'Post Categories Pre Text', 'simple-writer' ), 'description' => esc_html__('Enter a text to display before post categories. Default text is "Posted in".', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[cat_links_text]', 'type' => 'text', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_tags_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_tags_home_control', array( 'label' => esc_html__( 'Hide Post Tags from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_tags_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[tag_links_text]', array( 'default' => esc_html__( 'Tagged', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_tag_links_text_control', array( 'label' => esc_html__( 'Post Tags Pre Text', 'simple-writer' ), 'description' => esc_html__('Enter a text to display before post tags. Default text is "Tagged".', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[tag_links_text]', 'type' => 'text', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_snippet]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_snippet_control', array( 'label' => esc_html__( 'Hide Post Snippets/Full Post Content from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_snippet]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[post_content_type]', array( 'default' => 'post-snippets', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_post_content_type' ) );

    $wp_customize->add_control( 'simple_writer_post_content_type_control', array( 'label' => esc_html__( 'Posts Content Display on Post Summaries', 'simple-writer' ), 'description' => esc_html__('Select "post snippets" or "full post content" as posts content type of post summaries.', 'simple-writer'), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[post_content_type]', 'type' => 'select', 'choices' => array( 'post-snippets' => esc_html__( 'Post Snippets', 'simple-writer' ), 'full-posts-content' => esc_html__( 'Full Posts Content', 'simple-writer' ) ) ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_read_more_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_read_more_button_control', array( 'label' => esc_html__( 'Hide Read More Buttons from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_read_more_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[read_more_text]', array( 'default' => esc_html__( 'Continue Reading', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'simple_writer_read_more_text_control', array( 'label' => esc_html__( 'Read More Text', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[read_more_text]', 'type' => 'text', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_post_edit_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_edit_home_control', array( 'label' => esc_html__( 'Hide Post Edit Link from Posts Summaries', 'simple-writer' ), 'section' => 'simple_writer_section_posts_summaries', 'settings' => 'simple_writer_options[hide_post_edit_home]', 'type' => 'checkbox', ) );

}


function simple_writer_post_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_posts', array( 'title' => esc_html__( 'Singular Post Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 180 ) );

    $wp_customize->add_setting( 'simple_writer_options[thumbnail_link]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_thumbnail_link' ) );

    $wp_customize->add_control( 'simple_writer_thumbnail_link_control', array( 'label' => esc_html__( 'Featured Image Link', 'simple-writer' ), 'description' => esc_html__('Do you want single post thumbnail to be linked to their post?', 'simple-writer'), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[thumbnail_link]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'simple-writer'), 'no' => esc_html__('No', 'simple-writer') ) ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_thumbnail_single]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_thumbnail_single_control', array( 'label' => esc_html__( 'Hide Featured Image from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_thumbnail_single]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_title_control', array( 'label' => esc_html__( 'Hide Post Header from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_post_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[remove_post_title_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_remove_post_title_link_control', array( 'label' => esc_html__( 'Remove Link from Full Post Titles', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[remove_post_title_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_data]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_data_control', array( 'label' => esc_html__( 'Hide All Post Meta Data from Full Posts', 'simple-writer' ), 'description' => esc_html__('If you check this option, it will hide these data: Author Name, Posted Date, Number of Comments, Post Categories, Post Tags, Post Edit Link', 'simple-writer'), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_post_data]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_author_control', array( 'label' => esc_html__( 'Hide Post Author from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_post_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_posted_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_posted_date_control', array( 'label' => esc_html__( 'Hide Posted Date from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_posted_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_comments_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_comments_link_control', array( 'label' => esc_html__( 'Hide Comment Link from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_comments_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_categories]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_categories_control', array( 'label' => esc_html__( 'Hide Post Categories from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_post_categories]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_tags]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_tags_control', array( 'label' => esc_html__( 'Hide Post Tags from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_post_tags]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_comment_form]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_comment_form_control', array( 'label' => esc_html__( 'Hide Comments/Comment Form from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_comment_form]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_edit_control', array( 'label' => esc_html__( 'Hide Post Edit Link from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_post_edit]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_author_bio_box]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_author_bio_box_control', array( 'label' => esc_html__( 'Hide Author Bio Box from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_posts', 'settings' => 'simple_writer_options[hide_author_bio_box]', 'type' => 'checkbox', ) );

}


function simple_writer_page_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_page', array( 'title' => esc_html__( 'Singular Page Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 185 ) );

    $wp_customize->add_setting( 'simple_writer_options[thumbnail_link_page]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_thumbnail_link' ) );

    $wp_customize->add_control( 'simple_writer_thumbnail_link_page_control', array( 'label' => esc_html__( 'Featured Image Link', 'simple-writer' ), 'description' => esc_html__('Do you want the featured image in a page to be linked to its page?', 'simple-writer'), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[thumbnail_link_page]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'simple-writer'), 'no' => esc_html__('No', 'simple-writer') ) ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_thumbnail_page]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_thumbnail_page_control', array( 'label' => esc_html__( 'Hide Featured Image from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_thumbnail_page]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_title_control', array( 'label' => esc_html__( 'Hide Page Header from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[remove_page_title_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_remove_page_title_link_control', array( 'label' => esc_html__( 'Remove Link from Single Page Titles', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[remove_page_title_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_data]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_data_control', array( 'label' => esc_html__( 'Hide All Page Meta Data', 'simple-writer' ), 'description' => esc_html__('If you check this option, it will hide these data: Author Name, Posted Date, Number of Comments', 'simple-writer'), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_data]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_date_control', array( 'label' => esc_html__( 'Hide Posted Date from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_author_control', array( 'label' => esc_html__( 'Hide Page Author from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_comments]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_comments_control', array( 'label' => esc_html__( 'Hide Comment Link from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_comments]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_comment_form]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_comment_form_control', array( 'label' => esc_html__( 'Hide Comments/Comment Form from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_comment_form]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_page_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_page_edit_control', array( 'label' => esc_html__( 'Hide Edit Link from Single Pages', 'simple-writer' ), 'section' => 'simple_writer_section_page', 'settings' => 'simple_writer_options[hide_page_edit]', 'type' => 'checkbox', ) );

}


function simple_writer_navigation_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_navigation', array( 'title' => esc_html__( 'Posts Navigation Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 190 ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_post_navigation]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_post_navigation_control', array( 'label' => esc_html__( 'Hide Post Navigation from Full Posts', 'simple-writer' ), 'section' => 'simple_writer_section_navigation', 'settings' => 'simple_writer_options[hide_post_navigation]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_posts_navigation]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_posts_navigation_control', array( 'label' => esc_html__( 'Hide Posts Navigation from Home/Archive/Search Pages', 'simple-writer' ), 'section' => 'simple_writer_section_navigation', 'settings' => 'simple_writer_options[hide_posts_navigation]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[posts_navigation_type]', array( 'default' => 'numberednavi', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_posts_navigation_type' ) );

    $wp_customize->add_control( 'simple_writer_posts_navigation_type_control', array( 'label' => esc_html__( 'Posts Navigation Type', 'simple-writer' ), 'description' => esc_html__('Select posts navigation type you need. If you activate WP-PageNavi plugin, this navigation will be replaced by WP-PageNavi navigation.', 'simple-writer'), 'section' => 'simple_writer_section_navigation', 'settings' => 'simple_writer_options[posts_navigation_type]', 'type' => 'select', 'choices' => array( 'normalnavi' => esc_html__('Link Navigation', 'simple-writer'), 'numberednavi' => esc_html__('Numbered Navigation', 'simple-writer') ) ) );

}


function simple_writer_header_social_profiles($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_social_header', array( 'title' => esc_html__( 'Social Buttons Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 240, ));

    $wp_customize->add_setting( 'simple_writer_options[hide_header_social_buttons]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_header_social_buttons_control', array( 'label' => esc_html__( 'Hide Social + Search + Login/Logout Buttons from Header', 'simple-writer' ), 'description' => esc_html__('If you checked this option, all buttons will disappear from header. There is no any effect from "Hide Search Button" and "Show Login/Logout Button" options.', 'simple-writer'), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[hide_header_social_buttons]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_header_search_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_header_search_button_control', array( 'label' => esc_html__( 'Hide Search Button', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[hide_header_search_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[show_header_login_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_show_header_login_button_control', array( 'label' => esc_html__( 'Show Login/Logout Button', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[show_header_login_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[twitter_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_twitter_button_control', array( 'label' => esc_html__( 'Twitter URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[twitter_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[facebook_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_facebook_button_control', array( 'label' => esc_html__( 'Facebook URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[facebook_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[gplus_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) ); 

    $wp_customize->add_control( 'simple_writer_gplus_button_control', array( 'label' => esc_html__( 'Google Plus URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[gplus_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[pinterest_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_pinterest_button_control', array( 'label' => esc_html__( 'Pinterest URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[pinterest_button]', 'type' => 'text' ) );
    
    $wp_customize->add_setting( 'simple_writer_options[linkedin_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_linkedin_button_control', array( 'label' => esc_html__( 'Linkedin Link', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[linkedin_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[instagram_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_instagram_button_control', array( 'label' => esc_html__( 'Instagram Link', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[instagram_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[vk_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_vk_button_control', array( 'label' => esc_html__( 'VK Link', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[vk_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[flickr_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_flickr_button_control', array( 'label' => esc_html__( 'Flickr Link', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[flickr_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[youtube_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_youtube_button_control', array( 'label' => esc_html__( 'Youtube URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[youtube_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[vimeo_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_vimeo_button_control', array( 'label' => esc_html__( 'Vimeo URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[vimeo_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[soundcloud_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_soundcloud_button_control', array( 'label' => esc_html__( 'Soundcloud URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[soundcloud_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[messenger_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_messenger_button_control', array( 'label' => esc_html__( 'Messenger URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[messenger_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[whatsapp_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_whatsapp_button_control', array( 'label' => esc_html__( 'WhatsApp URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[whatsapp_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[lastfm_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_lastfm_button_control', array( 'label' => esc_html__( 'Lastfm URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[lastfm_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[medium_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_medium_button_control', array( 'label' => esc_html__( 'Medium URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[medium_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[github_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_github_button_control', array( 'label' => esc_html__( 'Github URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[github_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[bitbucket_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_bitbucket_button_control', array( 'label' => esc_html__( 'Bitbucket URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[bitbucket_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[tumblr_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_tumblr_button_control', array( 'label' => esc_html__( 'Tumblr URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[tumblr_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[digg_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_digg_button_control', array( 'label' => esc_html__( 'Digg URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[digg_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[delicious_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_delicious_button_control', array( 'label' => esc_html__( 'Delicious URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[delicious_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[stumble_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_stumble_button_control', array( 'label' => esc_html__( 'Stumbleupon URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[stumble_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[mix_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_mix_button_control', array( 'label' => esc_html__( 'Mix URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[mix_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[reddit_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_reddit_button_control', array( 'label' => esc_html__( 'Reddit URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[reddit_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[dribbble_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_dribbble_button_control', array( 'label' => esc_html__( 'Dribbble URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[dribbble_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[flipboard_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_flipboard_button_control', array( 'label' => esc_html__( 'Flipboard URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[flipboard_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[blogger_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_blogger_button_control', array( 'label' => esc_html__( 'Blogger URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[blogger_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[etsy_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_etsy_button_control', array( 'label' => esc_html__( 'Etsy URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[etsy_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[behance_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_behance_button_control', array( 'label' => esc_html__( 'Behance URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[behance_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[amazon_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_amazon_button_control', array( 'label' => esc_html__( 'Amazon URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[amazon_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[meetup_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_meetup_button_control', array( 'label' => esc_html__( 'Meetup URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[meetup_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[mixcloud_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_mixcloud_button_control', array( 'label' => esc_html__( 'Mixcloud URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[mixcloud_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[slack_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_slack_button_control', array( 'label' => esc_html__( 'Slack URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[slack_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[snapchat_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_snapchat_button_control', array( 'label' => esc_html__( 'Snapchat URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[snapchat_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[spotify_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_spotify_button_control', array( 'label' => esc_html__( 'Spotify URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[spotify_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[yelp_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_yelp_button_control', array( 'label' => esc_html__( 'Yelp URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[yelp_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[wordpress_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_wordpress_button_control', array( 'label' => esc_html__( 'WordPress URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[wordpress_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[twitch_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_twitch_button_control', array( 'label' => esc_html__( 'Twitch URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[twitch_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[telegram_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_telegram_button_control', array( 'label' => esc_html__( 'Telegram URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[telegram_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[bandcamp_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_bandcamp_button_control', array( 'label' => esc_html__( 'Bandcamp URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[bandcamp_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[quora_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_quora_button_control', array( 'label' => esc_html__( 'Quora URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[quora_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[foursquare_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_foursquare_button_control', array( 'label' => esc_html__( 'Foursquare URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[foursquare_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[deviantart_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_deviantart_button_control', array( 'label' => esc_html__( 'DeviantArt URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[deviantart_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[imdb_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_imdb_button_control', array( 'label' => esc_html__( 'IMDB URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[imdb_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[codepen_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_codepen_button_control', array( 'label' => esc_html__( 'Codepen URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[codepen_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[jsfiddle_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_jsfiddle_button_control', array( 'label' => esc_html__( 'JSFiddle URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[jsfiddle_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[stackoverflow_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_stackoverflow_button_control', array( 'label' => esc_html__( 'Stack Overflow URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[stackoverflow_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[stackexchange_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_stackexchange_button_control', array( 'label' => esc_html__( 'Stack Exchange URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[stackexchange_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[bsa_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_bsa_button_control', array( 'label' => esc_html__( 'BuySellAds URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[bsa_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[web500px_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_web500px_button_control', array( 'label' => esc_html__( '500px URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[web500px_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[ello_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_ello_button_control', array( 'label' => esc_html__( 'Ello URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[ello_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[goodreads_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_goodreads_button_control', array( 'label' => esc_html__( 'Goodreads URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[goodreads_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[odnoklassniki_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_odnoklassniki_button_control', array( 'label' => esc_html__( 'Odnoklassniki URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[odnoklassniki_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[houzz_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_houzz_button_control', array( 'label' => esc_html__( 'Houzz URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[houzz_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[pocket_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_pocket_button_control', array( 'label' => esc_html__( 'Pocket URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[pocket_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[xing_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_xing_button_control', array( 'label' => esc_html__( 'XING URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[xing_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[googleplay_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_googleplay_button_control', array( 'label' => esc_html__( 'Google Play URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[googleplay_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[slideshare_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_slideshare_button_control', array( 'label' => esc_html__( 'SlideShare URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[slideshare_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[dropbox_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_dropbox_button_control', array( 'label' => esc_html__( 'Dropbox URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[dropbox_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[paypal_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_paypal_button_control', array( 'label' => esc_html__( 'PayPal URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[paypal_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[viadeo_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_viadeo_button_control', array( 'label' => esc_html__( 'Viadeo URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[viadeo_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[wikipedia_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_wikipedia_button_control', array( 'label' => esc_html__( 'Wikipedia URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[wikipedia_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[skype_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field' ) );

    $wp_customize->add_control( 'simple_writer_skype_button_control', array( 'label' => esc_html__( 'Skype Username', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[skype_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[email_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_email' ) );

    $wp_customize->add_control( 'simple_writer_email_button_control', array( 'label' => esc_html__( 'Email Address', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[email_button]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[rss_button]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'simple_writer_rss_button_control', array( 'label' => esc_html__( 'RSS Feed URL', 'simple-writer' ), 'section' => 'simple_writer_section_social_header', 'settings' => 'simple_writer_options[rss_button]', 'type' => 'text' ) );

}


function simple_writer_footer_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_footer', array( 'title' => esc_html__( 'Footer Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 280 ) );

    $wp_customize->add_setting( 'simple_writer_options[footer_text]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_footer_text_control', array( 'label' => esc_html__( 'Footer copyright notice', 'simple-writer' ), 'section' => 'simple_writer_section_footer', 'settings' => 'simple_writer_options[footer_text]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_footer_widgets]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_footer_widgets_control', array( 'label' => esc_html__( 'Hide Footer Widgets', 'simple-writer' ), 'section' => 'simple_writer_section_footer', 'settings' => 'simple_writer_options[hide_footer_widgets]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[footer_content_image]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'absint' ) );

    $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'simple_writer_footer_content_image_control', array(
        'label' => esc_html__( 'Footer Content Background Image', 'simple-writer' ),
        'flex_width' => true,
        'flex_height' => true,
        'section' => 'simple_writer_section_footer',
        'settings' => 'simple_writer_options[footer_content_image]',
        'button_labels' => array( 'select' => esc_html__( 'Select Image', 'simple-writer' ), 'remove' => esc_html__( 'Remove Image', 'simple-writer' ), 'change' => esc_html__( 'Change Image', 'simple-writer' ), )
    )));

    $wp_customize->add_setting( 'simple_writer_options[footer_content_bg_size]', array( 'default' => 'cover', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_size' ) );

    $wp_customize->add_control( 'simple_writer_footer_content_bg_size_control', array( 'label' => esc_html__( 'Footer Content Background Image Size', 'simple-writer' ), 'description' => esc_html__('Select the background size value for footer content background image. Default value: Cover', 'simple-writer'), 'section' => 'simple_writer_section_footer', 'settings' => 'simple_writer_options[footer_content_bg_size]', 'type' => 'select', 'choices' => array( 'auto' => esc_html__( 'Auto', 'simple-writer' ), 'cover' => esc_html__( 'Cover', 'simple-writer' ), 'contain' => esc_html__( 'Contain', 'simple-writer' ) ) ) );

    $wp_customize->add_setting( 'simple_writer_options[footer_content_bg_position]', array( 'default' => 'center top', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_position' ) );

    $wp_customize->add_control( 'simple_writer_footer_content_bg_position_control', array( 'label' => esc_html__( 'Footer Content Background Image Position', 'simple-writer' ), 'description' => esc_html__('Select the background position value for footer content background image. Default value: Center Top', 'simple-writer'), 'section' => 'simple_writer_section_footer', 'settings' => 'simple_writer_options[footer_content_bg_position]', 'type' => 'select', 'choices' => array( 'left top' => esc_html__( 'Left Top', 'simple-writer' ), 'left center' => esc_html__( 'Left Center', 'simple-writer' ), 'left bottom' => esc_html__( 'Left Bottom', 'simple-writer' ), 'right top' => esc_html__( 'Right Top', 'simple-writer' ), 'right center' => esc_html__( 'Right Center', 'simple-writer' ), 'right bottom' => esc_html__( 'Right Bottom', 'simple-writer' ), 'center top' => esc_html__( 'Center Top', 'simple-writer' ), 'center center' => esc_html__( 'Center Center', 'simple-writer' ), 'center bottom' => esc_html__( 'Center Bottom', 'simple-writer' ) ) ) );

    $wp_customize->add_setting( 'simple_writer_options[footer_content_bg_attachment]', array( 'default' => 'scroll', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_attachment' ) );

    $wp_customize->add_control( 'simple_writer_footer_content_bg_attachment_control', array( 'label' => esc_html__( 'Footer Content Background Image Attachment', 'simple-writer' ), 'description' => esc_html__('Select the background attachment value for footer content background image. Default value: Scroll', 'simple-writer'), 'section' => 'simple_writer_section_footer', 'settings' => 'simple_writer_options[footer_content_bg_attachment]', 'type' => 'select', 'choices' => array( 'scroll' => esc_html__( 'Scroll', 'simple-writer' ), 'fixed' => esc_html__( 'Fixed', 'simple-writer' ), 'local' => esc_html__( 'Local', 'simple-writer' ) ) ) );

    $wp_customize->add_setting( 'simple_writer_options[footer_content_bg_repeat]', array( 'default' => 'no-repeat', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_bg_repeat' ) );

    $wp_customize->add_control( 'simple_writer_footer_content_bg_repeat_control', array( 'label' => esc_html__( 'Footer Content Background Image Repeat', 'simple-writer' ), 'description' => esc_html__('Select the background repeat value for footer content background image. Default value: no-repeat', 'simple-writer'), 'section' => 'simple_writer_section_footer', 'settings' => 'simple_writer_options[footer_content_bg_repeat]', 'type' => 'select', 'choices' => array( 'repeat' => esc_html__( 'repeat', 'simple-writer' ), 'repeat-x' => esc_html__( 'repeat-x', 'simple-writer' ), 'repeat-y' => esc_html__( 'repeat-y', 'simple-writer' ), 'no-repeat' => esc_html__( 'no-repeat', 'simple-writer' ) ) ) );

}


function simple_writer_archive_pages_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_archive_pages', array( 'title' => esc_html__( 'Archive Pages Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 320 ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_cats_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_cats_title_control', array( 'label' => esc_html__( 'Hide Category Title + Category Description from Category Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_cats_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_cats_description]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_cats_description_control', array( 'label' => esc_html__( 'Hide Category Description from Category Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_cats_description]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_tags_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_tags_title_control', array( 'label' => esc_html__( 'Hide Tag Title + Tag Description from Tag Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_tags_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_tags_description]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_tags_description_control', array( 'label' => esc_html__( 'Hide Tag Description from Tag Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_tags_description]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_author_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_author_title_control', array( 'label' => esc_html__( 'Hide Author Title + Author Description from Author Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_author_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_author_description]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_author_description_control', array( 'label' => esc_html__( 'Hide Author Description from Author Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_author_description]', 'type' => 'checkbox', ) );


    $wp_customize->add_setting( 'simple_writer_options[hide_date_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_date_title_control', array( 'label' => esc_html__( 'Hide Title from Year/Month/Day Archive Pages', 'simple-writer' ), 'section' => 'simple_writer_section_archive_pages', 'settings' => 'simple_writer_options[hide_date_title]', 'type' => 'checkbox', ) );

}


function simple_writer_search_404_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_search_404', array( 'title' => esc_html__( 'Search and 404 Pages Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 340 ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_search_results_heading]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_search_results_heading_control', array( 'label' => esc_html__( 'Hide Search Results Heading', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[hide_search_results_heading]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[search_results_heading]', array( 'default' => esc_html__( 'Search Results for:', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_search_results_heading_control', array( 'label' => esc_html__( 'Search Results Heading', 'simple-writer' ), 'description' => esc_html__( 'Enter a sentence to display before the search query.', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[search_results_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[no_search_heading]', array( 'default' => esc_html__( 'Nothing Found', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_no_search_heading_control', array( 'label' => esc_html__( 'No Search Results Heading', 'simple-writer' ), 'description' => esc_html__( 'Enter a heading to display when no search results are found.', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[no_search_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[no_search_results]', array( 'default' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_no_search_results_control', array( 'label' => esc_html__( 'No Search Results Message', 'simple-writer' ), 'description' => esc_html__( 'Enter a message to display when no search results are found.', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[no_search_results]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[error_404_heading]', array( 'default' => esc_html__( 'Oops! That page can not be found.', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_error_404_heading_control', array( 'label' => esc_html__( '404 Error Page Heading', 'simple-writer' ), 'description' => esc_html__( 'Enter the heading for the 404 error page.', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[error_404_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'simple_writer_options[error_404_message]', array( 'default' => esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'simple-writer' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_html', ) );

    $wp_customize->add_control( 'simple_writer_error_404_message_control', array( 'label' => esc_html__( 'Error 404 Message', 'simple-writer' ), 'description' => esc_html__( 'Enter a message to display on the 404 error page.', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[error_404_message]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'simple_writer_options[hide_404_search]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_hide_404_search_control', array( 'label' => esc_html__( 'Hide Search Box from 404 Page', 'simple-writer' ), 'section' => 'simple_writer_section_search_404', 'settings' => 'simple_writer_options[hide_404_search]', 'type' => 'checkbox', ) );

}


function simple_writer_other_options($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_other_options', array( 'title' => esc_html__( 'Other Options', 'simple-writer' ), 'panel' => 'simple_writer_main_options_panel', 'priority' => 600 ) );

    $wp_customize->add_setting( 'simple_writer_options[disable_fitvids]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_disable_fitvids_control', array( 'label' => esc_html__( 'Disable FitVids.JS', 'simple-writer' ), 'description' => esc_html__( 'You can disable fitvids.js script if you are not using videos on your website or if you do not want fluid width videos in your post content.', 'simple-writer' ), 'section' => 'simple_writer_section_other_options', 'settings' => 'simple_writer_options[disable_fitvids]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[disable_backtotop]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_disable_backtotop_control', array( 'label' => esc_html__( 'Disable Back to Top Button', 'simple-writer' ), 'section' => 'simple_writer_section_other_options', 'settings' => 'simple_writer_options[disable_backtotop]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'simple_writer_options[enable_widgets_block_editor]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'simple_writer_sanitize_checkbox', ) );

    $wp_customize->add_control( 'simple_writer_enable_widgets_block_editor_control', array( 'label' => esc_html__( 'Enable Gutenberg Widget Block Editor', 'simple-writer' ), 'section' => 'simple_writer_section_other_options', 'settings' => 'simple_writer_options[enable_widgets_block_editor]', 'type' => 'checkbox', ) );

}


function simple_writer_upgrade_to_pro($wp_customize) {

    $wp_customize->add_section( 'simple_writer_section_upgrade', array( 'title' => esc_html__( 'Upgrade to Pro Version', 'simple-writer' ), 'priority' => 400 ) );
    
    $wp_customize->add_setting( 'simple_writer_options[upgrade_text]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );
    
    $wp_customize->add_control( new Simple_Writer_Customize_Static_Text_Control( $wp_customize, 'simple_writer_upgrade_text_control', array(
        'label'       => esc_html__( 'Simple Writer Pro', 'simple-writer' ),
        'section'     => 'simple_writer_section_upgrade',
        'settings' => 'simple_writer_options[upgrade_text]',
        'description' => esc_html__( 'Do you enjoy Simple Writer? Upgrade to Simple Writer Pro now and get:', 'simple-writer' ).
            '<ul class="simple-writer-customizer-pro-features">' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Color Options', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Font Options', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Custom Page Templates', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Custom Post Templates', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ajax Powered Featured Posts Widgets (Recent/Categories/Tags/PostIDs based)', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ajax Powered Tabbed Widget (Recent/Categories/Tags/PostIDs based)', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Layout Options for Posts/Pages - (Sidebar + Content) / (Content + Sidebar) / (One Column) / (One Column + Bottom Sidebar)', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Layout Options for Non-Singular Pages - (Sidebar + Content) / (Content + Sidebar) / (One Column) / (One Column + Bottom Sidebar)', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Width Change Options for Full Website/Main Content/Sidebar', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Custom Settings Panel to Control Options in Each Post', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Custom Settings Panel to Control Options in Each Page', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Posts Views Counter', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Posts Likes System', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Control Layout Style/Website Width/Header Style/Footer Style of each Post/Page', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Capability to Add Different Header Images for Each Post/Page with Unique Link, Title and Description', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'About and Social Widget - 60+ Social Buttons', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Header Styles with Width Options - (Logo + Social) / (Logo + Header Banner) / (Full Width Header)', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Footer with Layout Options (1/2/3/4/5/6 Columns)', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Thumbnails Sizes Based Post Styles for Posts Summaries', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Infinite Scroll and Load More Button', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Post Share Buttons with Options - 25+ Social Networks are Supported', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Related Posts (Categories/Tags/Author/PostIDs based) with Options', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Author Bio Box with Social Buttons - 60+ Social Buttons', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Enable/Disable Mobile View from Primary and Secondary Menus', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to add Ads under Post Title and under Post Content', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Disable Google Fonts - for faster loading', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Sticky Menu/Sticky Sidebar with enable/disable capability', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Post Navigation with Thumbnails', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'More Widget Areas', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Contact Form', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'WooCommerce Compatible', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Yoast SEO Breadcrumbs Support', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Search Engine Optimized', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Full RTL Language Support', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Random Posts Button', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Many Useful Customizer Theme options', 'simple-writer' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'More Features...', 'simple-writer' ) . '</li>' .
            '</ul>'.
            '<strong><a href="'.SIMPLE_WRITER_PROURL.'" class="button button-primary" target="_blank"><i class="fas fa-shopping-cart" aria-hidden="true"></i> ' . esc_html__( 'Upgrade To Simple Writer PRO', 'simple-writer' ) . '</a></strong>'
    ) ) ); 

}


function simple_writer_sanitize_checkbox( $input ) {
    return ( ( isset( $input ) && ( true == $input ) ) ? true : false );
}

function simple_writer_sanitize_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function simple_writer_sanitize_thumbnail_link( $input, $setting ) {
    $valid = array('yes','no');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_fp_thumb_style( $input, $setting ) {
    $valid = array('simple-writer-760w-450h-image','simple-writer-760w-autoh-image');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_bg_size( $input, $setting ) {
    $valid = array('auto','cover','contain');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_bg_position( $input, $setting ) {
    $valid = array('left top','left center','left bottom','right top','right center','right bottom','center top','center center','center bottom');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_bg_attachment( $input, $setting ) {
    $valid = array('scroll','fixed','local');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_bg_repeat( $input, $setting ) {
    $valid = array('repeat','repeat-x','repeat-y','no-repeat');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_post_content_type( $input, $setting ) {
    $valid = array('post-snippets','full-posts-content');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_posts_navigation_type( $input, $setting ) {
    $valid = array('normalnavi','numberednavi');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_email( $input, $setting ) {
    if ( '' != $input && is_email( $input ) ) {
        $input = sanitize_email( $input );
        return $input;
    } else {
        return $setting->default;
    }
}

function simple_writer_sanitize_read_more_length( $input, $setting ) {
    $input = absint( $input ); // Force the value into non-negative integer.
    return ( 0 < $input ) ? $input : $setting->default;
}

function simple_writer_sanitize_positive_integer( $input, $setting ) {
    $input = absint( $input ); // Force the value into non-negative integer.
    return ( 0 < $input ) ? $input : $setting->default;
}


function simple_writer_register_theme_customizer( $wp_customize ) {

    if(method_exists('WP_Customize_Manager', 'add_panel')):
    $wp_customize->add_panel('simple_writer_main_options_panel', array( 'title' => esc_html__('Theme Options', 'simple-writer'), 'priority' => 10, ));
    endif;
    
    $wp_customize->get_section( 'title_tagline' )->panel = 'simple_writer_main_options_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = 20;
    $wp_customize->get_section( 'header_image' )->panel = 'simple_writer_main_options_panel';
    $wp_customize->get_section( 'header_image' )->priority = 26;
    $wp_customize->get_section( 'background_image' )->panel = 'simple_writer_main_options_panel';
    $wp_customize->get_section( 'background_image' )->priority = 27;
    $wp_customize->get_section( 'colors' )->panel = 'simple_writer_main_options_panel';
    $wp_customize->get_section( 'colors' )->priority = 40;
      
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
    $wp_customize->get_control( 'background_color' )->description = esc_html__('To change Background Color, need to remove background image first:- go to Appearance : Customize : Theme Options : Background Image', 'simple-writer');

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.simple-writer-site-title a',
            'render_callback' => 'simple_writer_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.simple-writer-site-description',
            'render_callback' => 'simple_writer_customize_partial_blogdescription',
        ) );
    }

    simple_writer_getting_started($wp_customize);
    simple_writer_color_options($wp_customize);
    simple_writer_menu_options($wp_customize);
    simple_writer_header_options($wp_customize);
    simple_writer_post_summaries_options($wp_customize);
    simple_writer_post_options($wp_customize);
    simple_writer_navigation_options($wp_customize);
    simple_writer_page_options($wp_customize);
    simple_writer_header_social_profiles($wp_customize);
    simple_writer_footer_options($wp_customize);
    simple_writer_archive_pages_options($wp_customize);
    simple_writer_search_404_options($wp_customize);
    simple_writer_other_options($wp_customize);
    simple_writer_upgrade_to_pro($wp_customize);

}

add_action( 'customize_register', 'simple_writer_register_theme_customizer' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function simple_writer_customize_partial_blogname() {
    bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function simple_writer_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

function simple_writer_customizer_js_scripts() {
    wp_enqueue_script('simple-writer-theme-customizer-js', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), NULL, true);
}
add_action( 'customize_preview_init', 'simple_writer_customizer_js_scripts' );