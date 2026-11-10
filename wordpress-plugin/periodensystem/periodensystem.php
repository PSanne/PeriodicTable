<?php
/**
 * Plugin Name:       Periodensystem (interaktiv)
 * Description:       Interaktives Periodensystem aller 118 Elemente mit Detailkarten, Atommodellen, Suche und Temperatur-Slider. Einbinden per Shortcode [periodensystem].
 * Version:           1.1.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Peter Sanne
 * License:           GPL-2.0-or-later
 * Text Domain:       periodensystem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PERIODENSYSTEM_VERSION', '1.1.0' );

/**
 * Kleines Skript für die Elternseite:
 * - passt die iframe-Höhe automatisch an den Inhalt an (kein innerer Scrollbalken),
 * - meldet der App den sichtbaren Ausschnitt, damit die Detailkarte immer im Blick ist,
 * - korrigiert die volle Breite um die Breite des Browser-Scrollbalkens.
 */
function periodensystem_embed_script() {
	return <<<'JS'
(function () {
	var root = document.documentElement;
	function frames() { return document.querySelectorAll('iframe.periodensystem-frame'); }
	function scrollbar() { root.style.setProperty('--pse-sbw', (window.innerWidth - root.clientWidth) + 'px'); }
	function send(f) {
		if (!f.contentWindow) { return; }
		var r = f.getBoundingClientRect(), vh = window.innerHeight;
		var top = Math.max(0, -r.top), bottom = Math.min(r.height, vh - r.top);
		var origin; try { origin = new URL(f.src, location.href).origin; } catch (e) { origin = '*'; }
		f.contentWindow.postMessage({ type: 'pse-viewport', top: top, height: Math.max(0, bottom - top) }, origin);
	}
	function all() { scrollbar(); Array.prototype.forEach.call(frames(), send); }
	window.addEventListener('message', function (e) {
		if (!e.data || e.data.type !== 'pse-height') { return; }
		Array.prototype.forEach.call(frames(), function (f) {
			if (e.source !== f.contentWindow) { return; }
			var h = Math.max(400, Math.min(4000, Math.ceil(+e.data.height || 0)));
			f.style.height = h + 'px';
			send(f);
		});
	});
	window.addEventListener('scroll', all, { passive: true });
	window.addEventListener('resize', all);
	document.addEventListener('DOMContentLoaded', all);
	all();
})();
JS;
}

/**
 * Shortcode: [periodensystem breite="voll|inhalt" hoehe="900" theme="hell|dunkel"]
 * Die App läuft in einem iframe, damit sich Theme-CSS und App-CSS nicht beeinflussen.
 * hoehe ist nur die Starthöhe; danach passt sich das iframe automatisch an.
 */
function periodensystem_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'breite' => 'voll',
			'hoehe'  => '900',
			'theme'  => '',
		),
		$atts,
		'periodensystem'
	);

	$hoehe = max( 400, absint( $atts['hoehe'] ) );
	$src   = plugins_url( 'app/index.html', __FILE__ );
	$src   = add_query_arg( 'v', PERIODENSYSTEM_VERSION, $src );

	$theme_map = array( 'hell' => 'light', 'dunkel' => 'dark', 'light' => 'light', 'dark' => 'dark' );
	$theme     = strtolower( trim( $atts['theme'] ) );
	if ( isset( $theme_map[ $theme ] ) ) {
		$src = add_query_arg( 'theme', $theme_map[ $theme ], $src );
	}

	$voll = ( 'inhalt' !== strtolower( trim( $atts['breite'] ) ) );

	// Volle Breite: aus der Inhaltsspalte des Themes ausbrechen (Scrollbalken wird herausgerechnet).
	$wrap_style = $voll
		? 'position:relative;width:calc(100vw - var(--pse-sbw, 0px));max-width:none;margin:1.5em 0 1.5em calc(50% - (100vw - var(--pse-sbw, 0px)) / 2);'
		: 'width:100%;margin:1.5em auto;';
	$frame_style = 'width:100%;height:' . $hoehe . 'px;border:0;display:block;' . ( $voll ? '' : 'border-radius:12px;' );

	wp_register_script( 'periodensystem-embed', false, array(), PERIODENSYSTEM_VERSION, true );
	wp_enqueue_script( 'periodensystem-embed' );
	if ( ! wp_script_is( 'periodensystem-embed', 'done' ) && empty( $GLOBALS['periodensystem_inline_added'] ) ) {
		wp_add_inline_script( 'periodensystem-embed', periodensystem_embed_script() );
		$GLOBALS['periodensystem_inline_added'] = true;
	}

	return sprintf(
		'<div class="periodensystem-wrap" style="%s"><iframe class="periodensystem-frame" src="%s" title="%s" loading="lazy" scrolling="no" style="%s"></iframe></div>',
		esc_attr( $wrap_style ),
		esc_url( $src ),
		esc_attr__( 'Interaktives Periodensystem der Elemente', 'periodensystem' ),
		esc_attr( $frame_style )
	);
}
add_shortcode( 'periodensystem', 'periodensystem_shortcode' );
