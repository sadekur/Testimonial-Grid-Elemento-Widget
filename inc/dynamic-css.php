<?php
/*
*	Dynamic Css value
*/
function add_dynamic_css_cwpt() { ?>
    <style type="text/css" media="all">
        .grey {
            background-color: <?php $color_theme = get_option( 'title-color-option', true ); if(!empty($color_theme)) { echo esc_attr( $color_theme );} else {echo _e( "#fceded" );}?>;
        }
        .avatar {
            border: <?php $color_theme = get_option( 'title-color-option', true ); if(!empty($color_theme)) { echo esc_attr( $color_theme );} else {echo _e( "#000000" );}?>;
        }
        .profile-name, .heading, .grey{
            color: <?php $hover_color = get_option( 'hover-color-option', true ); if(!empty($hover_color)) { echo esc_attr( $hover_color ); } else {echo _e( "#000000" ); }?>;
        }
        .profile-title, blockquote{
            color: <?php $body_color = get_option( 'body-color-option', true ); if(!empty($body_color)) { echo esc_attr( $body_color ); } else {echo _e( "#000000" ); }?>;
        }
    </style>
    <?php 
}
add_action( 'wp_head', 'add_dynamic_css_cwpt' );
