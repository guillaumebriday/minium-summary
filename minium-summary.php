<?php
/*
Plugin Name: Minium Summary
Plugin URI: https://blog.guillaumebriday.fr
Description: A plugin to generate a summary with anchors on each title
Version: 1.0
Author: Guillaume Briday
Author URI: https://guillaumebriday.fr
License: MIT
*/

function minium_assets() {
    wp_enqueue_style( 'minium-summary', plugins_url( 'minium-summary.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'minium_assets');

if ( ! function_exists( 'replace_ca' ) ) {
    function replace_ca( $matches ) {
        array_shift($matches);
        $lvl = $matches[0];
        $title = $matches[1];
        $sanitize_title = sanitize_title($title);

        return "<h{$lvl} id='{$sanitize_title}'>{$title}</h{$lvl}>";
    }
}

if ( ! function_exists( 'add_anchor_to_title' ) ) {
    function add_anchor_to_title( $content ) {
        if ( is_singular( 'post' ) ) {
            global $post;
            $pattern = "/<h([2-4]).*?>(.*?)<\/h[2-4]>/i";

            return preg_replace_callback( $pattern, 'replace_ca', $content );
        }
        return $content;
    }
}
add_filter('the_content', 'add_anchor_to_title', 12);

if ( ! function_exists( 'summary' ) ) {
    function summary( $atts = [] ) {
        global $post;
        $atts = array_change_key_case( (array)$atts, CASE_LOWER );
        $atts = shortcode_atts( [ 'deep' => 1, 'numbering' => 'tiered' ], $atts );
        $deep = $atts['deep'];
        $numbering = $atts['numbering'];
        $titles = [];
        $class = ($numbering == 'tiered') ? 'tiered' : '';

        $summary = "<nav class='article-summary {$class}'><ol>";

        $pattern = "/<h([2-4]).*?>(.*?)<\/h[2-4]>/i";
        preg_match_all( $pattern, $post->post_content, $matches );
        array_shift($matches);

        foreach ( $matches[0] as $key => $value ) {
            if ( $deep > 1 && $value > $deep ) {
                continue;
            }
            $titles[] = [ $value => $matches[ 1 ][ $key ] ];
        }

        foreach ($titles as $k => $title) {
            $lvl = key( $title );
            $next_lvl = key( $titles[ $k + 1 ] );
            $title_content = $title[ $lvl ];
            $sanitize_title = sanitize_title( $title_content );
            $link = "<a href='#{$sanitize_title}'>{$title_content}</a>";

            if ( $lvl == $next_lvl || $lvl > $next_lvl ) {
                $summary .= "<li>{$link}</li>";
            }

            if ( $next_lvl > $lvl) {
                $summary .= "<li>{$link}";

                for ( $i = 0; $i < $next_lvl - $lvl; $i++ ) {
                    $summary .= '<ol>';
                }
            }
            elseif ($next_lvl < $lvl && $next_lvl != null) {
                for ( $i = 0; $i < $lvl - $next_lvl; $i++ ) {
                    $summary .= '</ol></li>';
                }
            }
        }

        $summary .= '</ol></nav>';
        return $summary;
    }
}

add_shortcode( 'summary', 'summary' );
