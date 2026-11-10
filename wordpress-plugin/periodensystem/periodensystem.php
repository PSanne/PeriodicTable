<?php
/**
 * Plugin Name:       Periodensystem (interaktiv)
 * Description:       Interaktives Periodensystem aller 118 Elemente mit Detailkarten, Atommodellen, Suche und Temperatur-Slider. Einbinden per Shortcode [periodensystem].
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Peter Sanne
 * License:           GPL-2.0-or-later
 * Text Domain:       periodensystem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode: [periodensystem hoehe="900" theme="hell|dunkel"]
 * Die App läuft in einem iframe, damit sich Theme-CSS und App-CSS nicht beeinflussen.
 */
function periodensystem_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'hoehe' => '900',
			'theme' => '',
		),
		$atts,
		'periodensystem'
	);

	$hoehe = max( 400, absint( $atts['hoehe'] ) );
	$src   = plugins_url( 'app/index.html', __FILE__ );
	$src   = add_query_arg( 'v', '1.0.0', $src );

	$theme_map = array( 'hell' => 'light', 'dunkel' => 'dark', 'light' => 'light', 'dark' => 'dark' );
	$theme     = strtolower( trim( $atts['theme'] ) );
	if ( isset( $theme_map[ $theme ] ) ) {
		$src = add_query_arg( 'theme', $theme_map[ $theme ], $src );
	}

	return sprintf(
		'<div class="periodensystem-wrap" style="width:100%%;max-width:1400px;margin:0 auto;">'
		. '<iframe src="%s" title="%s" loading="lazy" style="width:100%%;height:%dpx;border:0;border-radius:12px;display:block;"></iframe>'
		. '</div>',
		esc_url( $src ),
		esc_attr__( 'Interaktives Periodensystem der Elemente', 'periodensystem' ),
		$hoehe
	);
}
add_shortcode( 'periodensystem', 'periodensystem_shortcode' );
