<?php
/**
 * gatsby Theme Customizer.
 *
 * @package gatsby
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function gatsby_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


		/*------------------------------------------------------------------------*/
		/*  Section: Theme Options
		/*------------------------------------------------------------------------*/

		$wp_customize->add_panel( 'gatsby_theme_options_panel' ,
				array(
					'priority'        => 30,
					'title'           => esc_html__( 'Theme Options', 'gatsby' ),
					'description'     => ''
				)
			);
			// section
			$wp_customize->add_section( 'gatsby_general' ,
				array(
					'priority'    => 3,
					'title'       => esc_html__( 'General', 'gatsby' ),
					'description' => '',
					'panel'       => 'gatsby_theme_options_panel',
				)
			);
				// settings
				$wp_customize->add_setting( 'gatsby_homepage_layout',
					array(
						'default'           => 'default',
					)
				);

				$wp_customize->add_control( 'gatsby_homepage_layout',
					array(
						'label' 		=> esc_html__( 'Homepage Layout', 'gatsby' ),
						'type'			=> 'select',
						'section' 	=> 'gatsby_general',
						'choices'   => array(
							'default' => esc_html__( 'Default', 'gatsby' ),
							'home1'   => esc_html__( 'Homepage 1', 'gatsby' ),
							'home2'   => esc_html__( 'Homepage 2', 'gatsby' ),
							'home3'   => esc_html__( 'Homepage 3', 'gatsby' ),
							'home4'   => esc_html__( 'Homepage 4', 'gatsby' ),
							'home5'   => esc_html__( 'Homepage 5', 'gatsby' )
						)
					)
				);

				// archive/search post layout
				$wp_customize->add_setting( 'gatsby_archive_layout',
					array(
						'sanitize_callback'	=> 'gatsby_sanitize_select',
						'default'           => 'default',
					)
				);
				$wp_customize->add_control( 'gatsby_archive_layout',
					array(
						'label' 		=> esc_html__( 'Archive/Search layout:', 'gatsby' ),
						'type'			=> 'select',
						'section' 		=> 'staff_picks',
						'choices'   	=> array (
							'default'	=> esc_html__( 'Default', 'gatsby' ),
							'grid'	    => esc_html__( 'Grid', 'gatsby' ),
							'list'		=> esc_html__( 'List', 'gatsby' ),
						)
					)
				);


				// Primary color setting
				$wp_customize->add_setting( 'primary_color' , array(
				    'default'     => '#e40018',
				) );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
					'label'        => __( 'Primary Color', 'gatsby' ),
					'section'    => 'colors',
					'settings'   => 'primary_color',
				) ) );

				// Second color setting
				$wp_customize->add_setting( 'secondary_color' , array(
				    'default'     => '#494949',
				) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
					'label'        => __( 'Secondary Color', 'gatsby' ),
					'section'    => 'colors',
					'settings'   => 'secondary_color',
				) ) );

}
add_action( 'customize_register', 'gatsby_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function gatsby_customize_preview_js() {
	wp_enqueue_script( 'gatsby_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'gatsby_customize_preview_js' );



/*------------------------------------------------------------------------*/
/*  gatsby Sanitize Functions.
/*------------------------------------------------------------------------*/

function gatsby_sanitize_file_url( $file_url ) {
	$output = '';
	$filetype = wp_check_filetype( $file_url );
	if ( $filetype["ext"] ) {
		$output = esc_url( $file_url );
	}
	return $output;
}

function gatsby_sanitize_number( $input ) {
    return force_balance_tags( $input );
}

function gatsby_sanitize_select( $input, $setting ) {
	$input = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function gatsby_sanitize_hex_color( $color ) {
	if ( $color === '' ) {
		return '';
	}
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
	return null;
}
function gatsby_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function gatsby_sanitize_text( $string ) {
	return wp_kses_post( balanceTags( $string ) );
}

function gatsby_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}
