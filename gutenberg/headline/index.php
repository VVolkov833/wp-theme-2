<?php

$block_name = 'headline'; // basename( __DIR__ ) //++add optins to print different h and or.. maybe limit to sections type

add_action( 'init', function() use ( $block_name ) {

    $print_block = function( $props, $content = null ) use ( $block_name ) {

        $post = get_queried_object();
        $class = get_class( $post );
        $title = '';

        switch( $class ) {
            case 'WP_Post_Type' :
                $title = __( $post->labels->archives, 'fct' );
            break;
            case 'WP_Post' :
                $title = __( single_post_title( '', false ), 'fct' );
            break;
            case 'WP_Term' :
                $pre = __( get_the_title( get_option( 'page_for_posts', true ) ), 'fct' );
                $title = __( single_cat_title( '', false ), 'fct' );
                $title = $pre ? '<small>' . $pre .':</small> ' . $title : $title;
            break;        
        }

        return '<h1>' . $title . '</h1>';
    };

    register_block_type( 'fct-gutenberg/' . $block_name, [
        'editor_script' => 'fct-' . $block_name . '-block',
        'render_callback' => $print_block
    ] );

    wp_register_script(
        'fct-' . $block_name . '-block',
        get_template_directory_uri() . '/gutenberg/' . $block_name . '/block.js',
        ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'],
        FCT_VER
    );

});
