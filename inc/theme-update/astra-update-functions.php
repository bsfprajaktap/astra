<?php
/**
 * Astra Updates
 *
 * Functions for updating data, used by the background updater.
 *
 * @package Astra
 * @version 2.1.3
 */

defined( 'ABSPATH' ) || exit;

/**
 * Open Submenu just below menu for existing users.
 *
 * @since 2.1.3
 * @return void
 */
function astra_submenu_below_header() {
	$theme_options = get_option( 'astra-settings' );

	// Set flag to use flex align center css to open submenu just below menu.
	if ( ! isset( $theme_options['submenu-open-below-header'] ) ) {
		$theme_options['submenu-open-below-header'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Do not apply new default colors to the Elementor & Gutenberg Buttons for existing users.
 *
 * @since 2.2.0
 *
 * @return void
 */
function astra_page_builder_button_color_compatibility() {
	$theme_options = get_option( 'astra-settings', array() );

	// Set flag to not load button specific CSS.
	if ( ! isset( $theme_options['pb-button-color-compatibility'] ) ) {
		$theme_options['pb-button-color-compatibility'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Migrate option data from button vertical & horizontal padding to the new responsive padding param.
 *
 * @since 2.2.0
 *
 * @return void
 */
function astra_vertical_horizontal_padding_migration() {
	$theme_options = get_option( 'astra-settings', array() );

	$btn_vertical_padding   = isset( $theme_options['button-v-padding'] ) ? $theme_options['button-v-padding'] : 10;
	$btn_horizontal_padding = isset( $theme_options['button-h-padding'] ) ? $theme_options['button-h-padding'] : 40;

	if ( false === astra_get_db_option( 'theme-button-padding', false ) ) {

		// Migrate button vertical padding to the new padding param for button.
		$theme_options['theme-button-padding'] = array(
			'desktop'      => array(
				'top'    => $btn_vertical_padding,
				'right'  => $btn_horizontal_padding,
				'bottom' => $btn_vertical_padding,
				'left'   => $btn_horizontal_padding,
			),
			'tablet'       => array(
				'top'    => '',
				'right'  => '',
				'bottom' => '',
				'left'   => '',
			),
			'mobile'       => array(
				'top'    => '',
				'right'  => '',
				'bottom' => '',
				'left'   => '',
			),
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
		);

		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Migrate option data from button url to the new link param.
 *
 * @since 2.3.0
 *
 * @return void
 */
function astra_header_button_new_options() {

	$theme_options = get_option( 'astra-settings', array() );

	$btn_url = isset( $theme_options['header-main-rt-section-button-link'] ) ? $theme_options['header-main-rt-section-button-link'] : 'https://www.wpastra.com';
	$theme_options['header-main-rt-section-button-link-option'] = array(
		'url'      => $btn_url,
		'new_tab'  => false,
		'link_rel' => '',
	);

	update_option( 'astra-settings', $theme_options );

}

/**
 * For existing users, do not provide Elementor Default Color Typo settings compatibility by default.
 *
 * @since 2.3.3
 *
 * @return void
 */
function astra_elementor_default_color_typo_comp() {

	$theme_options = get_option( 'astra-settings', array() );

	// Set flag to not load button specific CSS.
	if ( ! isset( $theme_options['ele-default-color-typo-setting-comp'] ) ) {
		$theme_options['ele-default-color-typo-setting-comp'] = false;
		update_option( 'astra-settings', $theme_options );
	}

}

/**
 * For existing users, change the separator from html entity to css entity.
 *
 * @since 2.3.4
 *
 * @return void
 */
function astra_breadcrumb_separator_fix() {

	$theme_options = get_option( 'astra-settings', array() );

	// Check if the saved database value for Breadcrumb Separator is "&#187;", then change it to '\00bb'.
	if ( isset( $theme_options['breadcrumb-separator'] ) && '&#187;' === $theme_options['breadcrumb-separator'] ) {
		$theme_options['breadcrumb-separator'] = '\00bb';
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Check if we need to change the default value for tablet breakpoint.
 *
 * @since 2.4.0
 * @return void
 */
function astra_update_theme_tablet_breakpoint() {

	$theme_options = get_option( 'astra-settings' );

	if ( ! isset( $theme_options['can-update-theme-tablet-breakpoint'] ) ) {
		// Set a flag to check if we need to change the theme tablet breakpoint value.
		$theme_options['can-update-theme-tablet-breakpoint'] = false;
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Migrate option data from site layout background option to its desktop counterpart.
 *
 * @since 2.4.0
 *
 * @return void
 */
function astra_responsive_base_background_option() {

	$theme_options = get_option( 'astra-settings', array() );

	if ( false === get_option( 'site-layout-outside-bg-obj-responsive', false ) && isset( $theme_options['site-layout-outside-bg-obj'] ) ) {

		$theme_options['site-layout-outside-bg-obj-responsive']['desktop'] = $theme_options['site-layout-outside-bg-obj'];
		$theme_options['site-layout-outside-bg-obj-responsive']['tablet']  = array(
			'background-color'      => '',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'auto',
			'background-attachment' => 'scroll',
		);
		$theme_options['site-layout-outside-bg-obj-responsive']['mobile']  = array(
			'background-color'      => '',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'auto',
			'background-attachment' => 'scroll',
		);
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Do not apply new wide/full image CSS for existing users.
 *
 * @since 2.4.4
 *
 * @return void
 */
function astra_gtn_full_wide_image_group_css() {

	$theme_options = get_option( 'astra-settings', array() );

	// Set flag to not load button specific CSS.
	if ( ! isset( $theme_options['gtn-full-wide-image-grp-css'] ) ) {
		$theme_options['gtn-full-wide-image-grp-css'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Do not apply new wide/full Group and Cover block CSS for existing users.
 *
 * @since 2.5.0
 *
 * @return void
 */
function astra_gtn_full_wide_group_cover_css() {
	$theme_options = get_option( 'astra-settings', array() );

	if ( ! isset( $theme_options['gtn-full-wide-grp-cover-css'] ) ) {
		$theme_options['gtn-full-wide-grp-cover-css'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}


/**
 * Do not apply the global border width and border color setting for the existng users.
 *
 * @since 2.5.0
 *
 * @return void
 */
function astra_global_button_woo_css() {
	$theme_options = get_option( 'astra-settings', array() );

	// Set flag to not load button specific CSS.
	if ( ! isset( $theme_options['global-btn-woo-css'] ) ) {
		$theme_options['global-btn-woo-css'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Migrate Footer Widget param to array.
 *
 * @since 2.5.2
 *
 * @return void
 */
function astra_footer_widget_bg() {
	$theme_options = get_option( 'astra-settings', array() );

	// Check if Footer Backgound array is already set or not. If not then set it as array.
	if ( isset( $theme_options['footer-adv-bg-obj'] ) && ! is_array( $theme_options['footer-adv-bg-obj'] ) ) {
		$theme_options['footer-adv-bg-obj'] = array(
			'background-color'      => '',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'auto',
			'background-attachment' => 'scroll',
		);
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Migrate Background control options to new array.
 *
 * @since 3.0.0
 *
 * @return void
 */
function astra_bg_control_migration() {

	$db_options = array(
		'footer-adv-bg-obj',
		'footer-bg-obj',
		'sidebar-bg-obj',
	);

	$theme_options = get_option( 'astra-settings', array() );

	foreach ( $db_options as $option_name ) {

		if ( ! ( isset( $theme_options[ $option_name ]['background-type'] ) && isset( $theme_options[ $option_name ]['background-media'] ) ) && isset( $theme_options[ $option_name ] ) ) {

			if ( ! empty( $theme_options[ $option_name ]['background-image'] ) ) {
				$theme_options[ $option_name ]['background-type']  = 'image';
				$theme_options[ $option_name ]['background-media'] = attachment_url_to_postid( $theme_options[ $option_name ]['background-image'] );
			} else {
				$theme_options[ $option_name ]['background-type']  = '';
				$theme_options[ $option_name ]['background-media'] = '';
			}

			error_log( sprintf( 'Astra: Migrating Background Option - %s', $option_name ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			update_option( 'astra-settings', $theme_options );
		}
	}
}

/**
 * Migrate Background Responsive options to new array.
 *
 * @since 3.0.0
 *
 * @return void
 */
function astra_bg_responsive_control_migration() {

	$db_options = array(
		'site-layout-outside-bg-obj-responsive',
		'content-bg-obj-responsive',
		'header-bg-obj-responsive',
		'primary-menu-bg-obj-responsive',
		'above-header-bg-obj-responsive',
		'above-header-menu-bg-obj-responsive',
		'below-header-bg-obj-responsive',
		'below-header-menu-bg-obj-responsive',
	);

	$theme_options = get_option( 'astra-settings', array() );

	foreach ( $db_options as $option_name ) {

		if ( ! ( isset( $theme_options[ $option_name ]['desktop']['background-type'] ) && isset( $theme_options[ $option_name ]['desktop']['background-media'] ) ) && isset( $theme_options[ $option_name ] ) ) {

			if ( ! empty( $theme_options[ $option_name ]['desktop']['background-image'] ) ) {
				$theme_options[ $option_name ]['desktop']['background-type']  = 'image';
				$theme_options[ $option_name ]['desktop']['background-media'] = attachment_url_to_postid( $theme_options[ $option_name ]['desktop']['background-image'] );
			} else {
				$theme_options[ $option_name ]['desktop']['background-type']  = '';
				$theme_options[ $option_name ]['desktop']['background-media'] = '';
			}

			if ( ! empty( $theme_options[ $option_name ]['tablet']['background-image'] ) ) {
				$theme_options[ $option_name ]['tablet']['background-type']  = 'image';
				$theme_options[ $option_name ]['tablet']['background-media'] = attachment_url_to_postid( $theme_options[ $option_name ]['tablet']['background-image'] );
			} else {
				$theme_options[ $option_name ]['tablet']['background-type']  = '';
				$theme_options[ $option_name ]['tablet']['background-media'] = '';
			}

			if ( ! empty( $theme_options[ $option_name ]['mobile']['background-image'] ) ) {
				$theme_options[ $option_name ]['mobile']['background-type']  = 'image';
				$theme_options[ $option_name ]['mobile']['background-media'] = attachment_url_to_postid( $theme_options[ $option_name ]['mobile']['background-image'] );
			} else {
				$theme_options[ $option_name ]['mobile']['background-type']  = '';
				$theme_options[ $option_name ]['mobile']['background-media'] = '';
			}

			error_log( sprintf( 'Astra: Migrating Background Response Option - %s', $option_name ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			update_option( 'astra-settings', $theme_options );
		}
	}
}

/**
 * Do not apply new Group, Column and Media & Text block CSS for existing users.
 *
 * @since 3.0.0
 *
 * @return void
 */
function astra_gutenberg_core_blocks_design_compatibility() {
	$theme_options = get_option( 'astra-settings', array() );

	if ( ! isset( $theme_options['guntenberg-core-blocks-comp-css'] ) ) {
		$theme_options['guntenberg-core-blocks-comp-css'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Header Footer builder - Migration compatibility.
 *
 * @since 3.0.0
 *
 * @return void
 */
function astra_header_builder_compatibility() {
	$theme_options = get_option( 'astra-settings', array() );

	// Set flag to not load button specific CSS.
	if ( ! isset( $theme_options['is-header-footer-builder'] ) ) {
		$theme_options['is-header-footer-builder'] = false;
		update_option( 'astra-settings', $theme_options );
		astra_header_builder_migration();
	}
	if ( ! isset( $theme_options['header-footer-builder-notice'] ) ) {
		$theme_options['header-footer-builder-notice'] = false;
		update_option( 'astra-settings', $theme_options );
		astra_header_builder_migration();
	}
}

function astra_header_builder_migration() {
		/**
	 * All theme options.
	 */
	$theme_options = get_option( 'astra-settings', array() );

	// Header : Primary Header - Layout.
	$primary_header_layout = $theme_options['header-layouts'];

	 // Header : Primary Header - Last Menu Item.
	$last_menu_item                = $theme_options['header-main-rt-section'];
	$last_menu_item_mobile_flag    = $theme_options['hide-custom-menu-mobile'];
	$last_menu_item_mobile_outside = $theme_options['header-display-outside-menu'];
	$new_menu_item                 = '';
	$new_menu_item_mobile          = '';
	$new_menu_item_mobile_outside  = '';

	switch ( $last_menu_item ) {
		case 'search':
			$new_menu_item = 'search';
			break;

		case 'button':
			$new_menu_item                                  = 'button-1';
			$theme_options['header-button1-text']           = $theme_options['header-main-rt-section-button-text'];
			$theme_options['header-button1-link-option']    = $theme_options['header-main-rt-section-button-link-option'];
			$theme_options['header-button1-text-color']     = $theme_options['header-main-rt-section-button-text-color'];
			$theme_options['header-button1-back-color']     = $theme_options['header-main-rt-section-button-back-color'];
			$theme_options['header-button1-text-h-color']   = $theme_options['header-main-rt-section-button-text-h-color'];
			$theme_options['header-button1-back-h-color']   = $theme_options['header-main-rt-section-button-back-h-color'];
			$theme_options['header-button1-border-size']    = $theme_options['header-main-rt-section-button-border-size'];
			$theme_options['header-button1-border-color']   = $theme_options['header-main-rt-section-button-border-color'];
			$theme_options['header-button1-border-h-color'] = $theme_options['header-main-rt-section-button-border-h-color'];
			$theme_options['header-button1-border-radius']  = $theme_options['header-main-rt-section-button-border-radius'];
			$theme_options['header-button1-font-family']    = $theme_options['primary-header-button-font-family'];
			$theme_options['header-button1-font-size']      = $theme_options['primary-header-button-font-size'];
			$theme_options['header-button1-font-weight']    = $theme_options['primary-header-button-font-weight'];
			$theme_options['header-button1-text-transform'] = $theme_options['primary-header-button-text-transform'];
			$theme_options['header-button1-line-height']    = $theme_options['primary-header-button-line-height'];
			$theme_options['header-button1-letter-spacing'] = $theme_options['primary-header-button-letter-spacing'];
			$theme_options['section-hb-button-1-padding']   = $theme_options['header-main-rt-section-button-padding'];
			break;

		case 'text-html':
			$new_menu_item                  = 'html-1';
			$theme_options['header-html-1'] = $theme_options['header-main-rt-section-html'];
			break;

		case 'widget':
			$new_menu_item = 'widget-1';
			break;

		case 'woocommerce':
			$new_menu_item = 'woo-cart';
			break;
	}

	$new_menu_item_mobile = ( ! $last_menu_item_mobile_flag ) ? $new_menu_item : '';

	$new_menu_item_mobile_outside = ( ! $last_menu_item_mobile_flag && $last_menu_item_mobile_outside ) ? $new_menu_item : '';

	/**
	 * Assign the new locations.
	 */
	switch ( $primary_header_layout ) {
		case 'header-main-layout-1':
			$theme_options['header-desktop-items'] = array(
				'above'   =>
					array(
						'above_left'         => array(),
						'above_left_center'  => array(),
						'above_center'       => array(),
						'above_right_center' => array(),
						'above_right'        => array(),
					),
				'primary' =>
					array(
						'primary_left'         => array( 'logo' ),
						'primary_left_center'  => array(),
						'primary_center'       => array(),
						'primary_right_center' => array(),
						'primary_right'        => ( ! empty( $new_menu_item ) ) ? array( 'menu-1', $new_menu_item ) : array( 'menu-1' ),
					),
				'below'   =>
					array(
						'below_left'         => array(),
						'below_left_center'  => array(),
						'below_center'       => array(),
						'below_right_center' => array(),
						'below_right'        => array(),
					),
			);
			break;

		case 'header-main-layout-2':
			$theme_options['header-desktop-items'] = array(
				'above'   =>
					array(
						'above_left'         => array(),
						'above_left_center'  => array(),
						'above_center'       => array(),
						'above_right_center' => array(),
						'above_right'        => array(),
					),
				'primary' =>
					array(
						'primary_left'         => array(),
						'primary_left_center'  => array(),
						'primary_center'       => array( 'logo' ),
						'primary_right_center' => array(),
						'primary_right'        => array(),
					),
				'below'   =>
					array(
						'below_left'         => array(),
						'below_left_center'  => array(),
						'below_center'       => ( ! empty( $new_menu_item ) ) ? array( 'menu-1', $new_menu_item ) : array( 'menu-1' ),
						'below_right_center' => array(),
						'below_right'        => array(),
					),
			);
			break;

		case 'header-main-layout-3':
			$theme_options['header-desktop-items'] = array(
				'above'   =>
					array(
						'above_left'         => array(),
						'above_left_center'  => array(),
						'above_center'       => array(),
						'above_right_center' => array(),
						'above_right'        => array(),
					),
				'primary' =>
					array(
						'primary_left'         => ( ! empty( $new_menu_item ) ) ? array( 'menu-1', $new_menu_item ) : array( 'menu-1' ),
						'primary_left_center'  => array(),
						'primary_center'       => array(),
						'primary_right_center' => array(),
						'primary_right'        => array( 'logo' ),
					),
				'below'   =>
					array(
						'below_left'         => array(),
						'below_left_center'  => array(),
						'below_center'       => array(),
						'below_right_center' => array(),
						'below_right'        => array(),
					),
			);
			break;
	}

	// Header : Primary Header - Mobile Layout.
	$mobile_layout = astra_get_option( 'header-main-menu-align' );
	if ( 'stack' === $mobile_layout ) {
		$theme_options['header-mobile-items'] = array(
			'popup' => array(
				'popup_content' => ( ! empty( $new_menu_item ) ) ? array( 'menu-1', $new_menu_item ) : array( 'menu-1' ),
				'above'         =>
					array(
						'above_left'   => array(),
						'above_center' => array(),
						'above_right'  => array(),
					),
				'primary'       =>
					array(
						'primary_left'   => array(),
						'primary_center' => array( 'logo' ),
						'primary_right'  => array(),
					),
				'below'         =>
					array(
						'below_left'   => array(),
						'below_center' => ( ! empty( $new_menu_item_mobile_outside ) ) ? array( $new_menu_item_mobile_outside, 'mobile-trigger' ) : array( 'mobile-trigger' ),
						'below_right'  => array(),
					),
			),
		);
	} else {
		$theme_options['header-mobile-items'] = array(
			'popup' => array(
				'popup_content' => ( ! empty( $new_menu_item_mobile ) ) ? array( 'menu-1', $new_menu_item_mobile ) : array( 'menu-1' ),
				'above'         =>
					array(
						'above_left'   => array(),
						'above_center' => array(),
						'above_right'  => array(),
					),
				'primary'       =>
					array(
						'primary_left'   => array( 'logo' ),
						'primary_center' => array(),
						'primary_right'  => ( ! empty( $new_menu_item_mobile_outside ) ) ? array( $new_menu_item_mobile_outside, 'mobile-trigger' ) : array( 'mobile-trigger' ),
					),
				'below'         =>
					array(
						'below_left'   => array(),
						'below_center' => array(),
						'below_right'  => array(),
					),
			),
		);
	}

	// Header - Primary Header - Content Width
	$theme_options['hb-header-main-layout-width'] = $theme_options['header-main-layout-width'];

	// Header - Primary Header - Border Bottom
	$theme_options['hb-header-main-sep'] = $theme_options['header-main-sep'];

	/**
	 * Primary Menu
	 */
	$theme_options['header-menu1-submenu-container-animation'] = $theme_options['header-main-submenu-container-animation'];
	$theme_options['header-menu1-submenu-border']              = $theme_options['primary-submenu-border'];
	$theme_options['header-menu1-submenu-b-color']             = $theme_options['primary-submenu-b-color'];
	$theme_options['header-menu1-submenu-item-border']         = $theme_options['primary-submenu-item-border'];
	$theme_options['header-menu1-submenu-item-b-color']        = $theme_options['primary-submenu-item-b-color'];

	/**
	 * Primary Menu - Mobile
	 */
	$theme_options['mobile-header-menu-label']           = $theme_options['header-main-menu-label'];
	$theme_options['mobile-header-toggle-btn-color']     = $theme_options['mobile-header-toggle-btn-style-color'];
	$theme_options['mobile-header-toggle-border-radius'] = $theme_options['mobile-header-toggle-btn-border-radius'];

	/**
	 * Footer
	 */
	$footer_layout = $theme_options['footer-sml-layout'];

	// Footer Section 1.
	$footer_section_1   = $theme_options['footer-sml-section-1'];
	$new_section_1_item = '';
	switch ( $footer_section_1 ) {
		case 'custom':
			$new_section_1_item                             = 'copyright';
			$theme_options['footer-copyright-alignment']    = array(
				'desktop' => 'left',
				'tablet'  => 'left',
				'mobile'  => 'center',
			);
			$theme_options['footer-copyright-editor']       = $theme_options['footer-sml-section-1-credit'];
			$theme_options['footer-copyright-color']        = $theme_options['footer-color'];
			$theme_options['footer-copyright-link-color']   = $theme_options['footer-link-color'];
			$theme_options['footer-copyright-link-h-color'] = $theme_options['footer-link-h-color'];
			break;

		case 'widget':
			$new_section_1_item                         = 'widget-1';
			$theme_options['footer-widget-alignment-1'] = array(
				'desktop' => 'left',
				'tablet'  => 'left',
				'mobile'  => 'center',
			);
			$theme_options[ 'footer-' . $new_section_1_item . '-color' ]        = array(
				'desktop' => $theme_options['footer-color'],
				'tablet'  => '',
				'mobile'  => '',
			);
			$theme_options[ 'footer-' . $new_section_1_item . '-link-color' ]   = array(
				'desktop' => $theme_options['footer-link-color'],
				'tablet'  => '',
				'mobile'  => '',
			);
			$theme_options[ 'footer-' . $new_section_1_item . '-link-h-color' ] = array(
				'desktop' => $theme_options['footer-link-h-color'],
				'tablet'  => '',
				'mobile'  => '',
			);
			break;

		case 'menu':
			$theme_options['footer-menu-alignment'] = array(
				'desktop' => 'flex-start',
				'tablet'  => 'flex-start',
				'mobile'  => 'center',
			);
			$new_section_1_item                     = 'footer-menu';
			break;
	}

	// Footer Section 2.
	$footer_section_2   = $theme_options['footer-sml-section-2'];
	$new_section_2_item = '';
	switch ( $footer_section_2 ) {
		case 'custom':
			$new_section_2_item = ( 'copyright' !== $new_section_1_item ) ? 'copyright' : 'html-1';
			if ( 'copyright' !== $new_section_1_item ) {
				$theme_options['footer-copyright-alignment']    = array(
					'desktop' => 'right',
					'tablet'  => 'right',
					'mobile'  => 'center',
				);
				$theme_options['footer-copyright-editor']       = $theme_options['footer-sml-section-2-credit'];
				$theme_options['footer-copyright-color']        = $theme_options['footer-color'];
				$theme_options['footer-copyright-link-color']   = $theme_options['footer-link-color'];
				$theme_options['footer-copyright-link-h-color'] = $theme_options['footer-link-h-color'];
			} else {
				$theme_options['footer-html-1-alignment']    = array(
					'desktop' => 'right',
					'tablet'  => 'right',
					'mobile'  => 'center',
				);
				$theme_options['footer-html-1']              = $theme_options['footer-sml-section-2-credit'];
				$theme_options['footer-html-1-color']        = array(
					'desktop' => $theme_options['footer-color'],
					'tablet'  => '',
					'mobile'  => '',
				);
				$theme_options['footer-html-1-link-color']   = array(
					'desktop' => $theme_options['footer-link-color'],
					'tablet'  => '',
					'mobile'  => '',
				);
				$theme_options['footer-html-1-link-h-color'] = array(
					'desktop' => $theme_options['footer-link-h-color'],
					'tablet'  => '',
					'mobile'  => '',
				);
			}
			
			break;

		case 'widget':
			$new_section_2_item = ( 'widget-1' !== $new_section_1_item ) ? 'widget-1' : 'widget-2';
			if ( 'widget-1' !== $new_section_1_item ) {
				$theme_options['footer-widget-alignment-1'] = array(
					'desktop' => 'right',
					'tablet'  => 'right',
					'mobile'  => 'center',
				);
			} else {
				$theme_options['footer-widget-alignment-2'] = array(
					'desktop' => 'right',
					'tablet'  => 'right',
					'mobile'  => 'center',
				);
			}
			$theme_options[ 'footer-' . $new_section_2_item . '-color' ]        = array(
				'desktop' => $theme_options['footer-color'],
				'tablet'  => '',
				'mobile'  => '',
			);
			$theme_options[ 'footer-' . $new_section_2_item . '-link-color' ]   = array(
				'desktop' => $theme_options['footer-link-color'],
				'tablet'  => '',
				'mobile'  => '',
			);
			$theme_options[ 'footer-' . $new_section_2_item . '-link-h-color' ] = array(
				'desktop' => $theme_options['footer-link-h-color'],
				'tablet'  => '',
				'mobile'  => '',
			);
			break;

		case 'menu':
			$new_section_2_item = ( 'footer-menu' !== $new_section_1_item ) ? 'footer-menu' : 'widget-3';
			if ( 'footer-menu' !== $new_section_1_item ) {
				$theme_options['footer-menu-alignment'] = array(
					'desktop' => 'flex-end',
					'tablet'  => 'flex-end',
					'mobile'  => 'center',
				);
			} else {
				$theme_options['footer-widget-alignment-3'] = array(
					'desktop' => 'right',
					'tablet'  => 'right',
					'mobile'  => 'center',
				);
			}
			break;
	}
	if ( '' === $footer_section_1 || '' === $footer_section_2 ) {
		$theme_options['hbb-footer-column'] = 1;
		$theme_options['hbb-footer-layout'] = array(
			'desktop' => 'full',
			'tablet'  => 'full',
			'mobile'  => 'full',
		);
	} elseif ( '' !== $footer_section_1 && '' !== $footer_section_2 ) {
		$theme_options['hbb-footer-column'] = 2;
		$theme_options['hbb-footer-layout'] = array(
			'desktop' => '2-equal',
			'tablet'  => '2-equal',
			'mobile'  => 'full',
		);
	}
	switch ( $footer_layout ) {
		case 'none':
			$theme_options['footer-desktop-items'] = array(
				'above'   =>
					array(
						'above_1' => array(),
						'above_2' => array(),
						'above_3' => array(),
						'above_4' => array(),
						'above_5' => array(),
					),
				'primary' =>
					array(
						'primary_1' => array(),
						'primary_2' => array(),
						'primary_3' => array(),
						'primary_4' => array(),
						'primary_5' => array(),
					),
				'below'   =>
					array(
						'below_1' => array(),
						'below_2' => array(),
						'below_3' => array(),
						'below_4' => array(),
						'below_5' => array(),
					),
			);
			break;

		case 'footer-sml-layout-1':
			$theme_options['footer-desktop-items'] = array(
				'above'   =>
					array(
						'above_1' => array(),
						'above_2' => array(),
						'above_3' => array(),
						'above_4' => array(),
						'above_5' => array(),
					),
				'primary' =>
					array(
						'primary_1' => array(),
						'primary_2' => array(),
						'primary_3' => array(),
						'primary_4' => array(),
						'primary_5' => array(),
					),
				'below'   =>
					array(
						'below_1' => array( $new_section_1_item, $new_section_2_item ),
						'below_2' => array(),
						'below_3' => array(),
						'below_4' => array(),
						'below_5' => array(),
					),
			);
			break;

		case 'footer-sml-layout-2':
			$theme_options['footer-desktop-items'] = array(
				'above'   =>
					array(
						'above_1' => array(),
						'above_2' => array(),
						'above_3' => array(),
						'above_4' => array(),
						'above_5' => array(),
					),
				'primary' =>
					array(
						'primary_1' => array(),
						'primary_2' => array(),
						'primary_3' => array(),
						'primary_4' => array(),
						'primary_5' => array(),
					),
				'below'   =>
					array(
						'below_1' => array( $new_section_1_item ),
						'below_2' => array( $new_section_2_item ),
						'below_3' => array(),
						'below_4' => array(),
						'below_5' => array(),
					),
			);
			break;
	}

	$theme_options['hb-footer-layout-width']      = $theme_options['footer-layout-width'];
	$theme_options['hbb-footer-separator']        = $theme_options['footer-sml-divider'];
	$theme_options['hbb-footer-top-border-color'] = $theme_options['footer-sml-divider-color'];

	update_option( 'astra-settings', $theme_options );
}

/**
 * Do not apply new Media & Text block padding CSS & not remove padding for #primary on mobile devices directly for existing users.
 *
 * @since 2.6.1
 *
 * @return void
 */
function astra_gutenberg_media_text_block_css_compatibility() {
	$theme_options = get_option( 'astra-settings', array() );

	if ( ! isset( $theme_options['guntenberg-media-text-block-padding-css'] ) ) {
		$theme_options['guntenberg-media-text-block-padding-css'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}
