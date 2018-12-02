<?php
/*
Plugin Name: Celtic Web Design - Function
Description: Styling for admin login, plus admin related pages.
Plugin URI: http://www.celticwebdesign.net
Version: 1.0
Author: Darren Stevens
License: GPLv2 or later
*/

/* Start Adding Functions Below this Line */



// html5blank
// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}




// https://www.wpbeginner.com/wp-tutorials/how-to-limit-search-results-for-specific-post-types-in-wordpress/
// function searchfilter($query)
// {
//     if ($query->is_search && !is_admin()) {
//         $query->set('post_type', array('members'));
//     }

//     return $query;
// }

// add_filter('pre_get_posts', 'searchfilter');








if (function_exists('add_theme_support')) {

    // Add Thumbnail Theme Support
    add_image_size('medium-small', 300, 200, ['centre', 'centre']); // Medium Small
}






function cptui_register_my_cpts_footer()
{

    /**
     * Post Type: Footers.
     */

    $labels = array(
        "name" 			=> __("Footers", "penryndental"),
        "singular_name" => __("Footer", "penryndental"),
    );

    $args = array(
        "label" 				=> __("Footers", "penryndental"),
        "labels" 				=> $labels,
        "description" 			=> "For the Above Footer section.",
        "public" 				=> true,
        "publicly_queryable" 	=> true,
        "show_ui" 				=> true,
        "show_in_rest" 			=> false,
        "rest_base" 			=> "",
        "has_archive" 			=> true,
        "show_in_menu" 			=> true,
        "exclude_from_search" 	=> true,
        "capability_type" 		=> "post",
        "map_meta_cap" 			=> true,
        "hierarchical" 			=> true,
        "rewrite" 				=> false,
        "query_var" 			=> true,
        "menu_position" 		=> 20,
        "menu_icon" 			=> "dashicons-screenoptions",
        "supports" 				=> array( "title", "editor", "revisions", "page-attributes" ),
    );

    register_post_type("footer", $args);
}

add_action('init', 'cptui_register_my_cpts_footer');







    function click_telephone($telephone, $string = null, $prepend = null, $countrycode = "0044")
    {

        /*
            Parameters:
            $telephone, the actual number
            $string, if you want to dispay a clickable string rather than telephone number,
            $prepend, prepend the telephone number.
            $countrycode, country code or default UK 0044
        */

        $ori_tel    = str_replace(' ', '', $telephone);
        $new_tel    = $countrycode.substr($ori_tel, 1);
        $output     = "<a href='tel:".$new_tel."' class='tel transition'>";

        if ($string) {
            $output.=$string;
        } else {
            if ($prepend) {
                $output.=$prepend."";
            }
            $output.=substr($telephone, 1);
        }

        $output     .= "</a>";

        return $output;
    }






    // https://css-tricks.com/snippets/php/convert-hex-to-rgb/
    function hex2rgb($colour)
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        // return array( 'red' => $r, 'green' => $g, 'blue' => $b );
        return $r.','.$g.','.$b;
    }




    if (function_exists('acf_add_options_page')) {
        acf_add_options_page();
    }



    function show_me($print)
    {
        echo $print;
    }





    function pr($data)
    {
        echo "<pre>";
        print_r($data); // or var_dump($data);
        echo "</pre>";
    }
    // call pr($array);





    function vr($data)
    {
        echo "<pre>";
        var_dump($data); // or var_dump($data);
        echo "</pre>";
    }
    // call vr($array);




    // http://www.joelwolfgang.com/adding-a-logged-out-class-to-wordpress-body-tag/
    // add_filter('body_class', 'my_class_names');
    // function my_class_names($classes) {

    //     if (! (is_user_logged_in())) {
    //         $classes[] = 'logged-out';
    //     } else {
    //         $classes[] = 'logged-in';
    //     }
    //     return $classes;

    // }





    // https://mattrad.uk/gravity-forms-css-spinner/
    function gf_spinner_replace($image_src, $form)
    {
        return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        // relative to you theme images folder
    }
    add_filter('gform_ajax_spinner_url', 'gf_spinner_replace', 10, 2);





    // https://wordpress.stackexchange.com/questions/35724/function-to-return-true-if-current-page-has-child-pages
    // get child / sibling pages of current page
    // and show the parent page
    function wpb_get_child_pages_or_siblings() {

        // Show child pages of current parent
        // or sibling pages of current page

        global $post;

        // does page have children?
        $children = get_pages( array( 'child_of' => $post->ID ) );

        if ( count( $children ) == 0 ) {
            // echo "1";
            // not a parent page,
            // show children page links of parent (syblings)
            $parentpage = wp_list_pages('depth=1&sort_column=menu_order&title_li=&include=' . $post->post_parent . '&echo=0');
            $childpages = wp_list_pages('depth=1&sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0');
        
        } else {
            // echo "2";
            // is a parent page
            // show child page of this page
            $parentpage = wp_list_pages('depth=1&sort_column=menu_order&title_li=&include=' . $post->ID . '&echo=0');
            $childpages = wp_list_pages('depth=1&sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0');

        }


        if ($childpages) {

            // $parentpage, includes the parent page in the menu
            $string = '<ul>' . $parentpage . $childpages . '</ul>';

        }

        return $string;
    }
    add_shortcode('wpb_get_child_pages_or_siblings', 'wpb_get_child_pages_or_siblings');







    // get child pages of another parent - page_id
    function wpb_get_child_pages_links($atts = [], $content = null, $tag = '')
    {

        // normalize attribute keys, lowercase
        $atts       = array_change_key_case((array)$atts, CASE_LOWER);

        // override default attributes with user attributes
        $wporg_atts = shortcode_atts([
                                         'page_id' => '9',
                                     ], $atts, $tag);
        // Show child pages of $page_id


        $childpages = wp_list_pages('depth=1&sort_column=menu_order&title_li=&child_of=' . $wporg_atts['page_id'] . '&echo=0');

        if ($childpages) {
            $string = '<ul>' . $childpages . '</ul>';
        }

        return $string;
    }
    add_shortcode('wpb_get_child_pages_links', 'wpb_get_child_pages_links');
    // get child pages of another parent - page_id






    // get all top level pages except...
    function wpb_get_top_level_pages_links($atts = [], $content = null, $tag = '')
    {

        // normalize attribute keys, lowercase
        $atts       = array_change_key_case((array)$atts, CASE_LOWER);

        /*
            2716 Dental Plan
            3033 Conditions
            3034 Privacy
                   */

        // override default attributes with user attributes
        $wporg_atts = shortcode_atts([
                                         'exclude_page_ids' => '2716,3033,3034',
                                     ], $atts, $tag);

        // echo "asd".$wporg_atts['exclude_page_ids'];

        // Show all top level pages except...
        $childpages = wp_list_pages('depth=1&sort_column=menu_order&title_li=&child_of=0&exclude=' . $wporg_atts['exclude_page_ids'] . '&echo=0');

        if ($childpages) {
            $string = '<ul>' . $childpages . '</ul>';
        }

        return $string;
    }
    add_shortcode('wpb_get_top_level_pages_links', 'wpb_get_top_level_pages_links');
    // get all top level pages except...






    // function fnm_get_social_media() {

    //     $string .= get_template_part('template-parts/content', 'social');

    //     return $string;

    // }
    // add_shortcode('social-media', 'fnm_get_social_media');









    // https://www.jonahcoyote.com/use-custom-post-widget-visual-composer/
    // Make Content Blocks Public
    // function filter_content_block_init() {
    //     $content_block_public = true;
    //     return $content_block_public;
    // }
    // add_filter('content_block_post_type','filter_content_block_init');




    // https://stackoverflow.com/questions/965235/how-can-i-truncate-a-string-to-the-first-20-words-in-php
    // function limit_text($text, $limit) {
    //     if (str_word_count($text, 0) > $limit) {
    //         $words = str_word_count($text, 2);
    //         $pos = array_keys($words);
    //         $text = substr($text, 0, $pos[$limit]) . '...';
    //     }
    //     return $text;
    // }




    // http://www.wpbeginner.com/wp-tutorials/how-to-limit-search-results-for-specific-post-types-in-wordpress/
    // function searchfilter($query) {

    //     if ($query->is_search && !is_admin() ) {
    //         $query->set('post_type',array('recipes'));
    //         $query->set('posts_per_page',10);
    //     }

    //     return $query;

    // }

    // add_filter('pre_get_posts','searchfilter');
    // used for short section immediately below



    // function get_all_categories($taxonomy) {

    //     $terms = get_terms(
    //         array(
    //             'taxonomy'      => $taxonomy,
    //             'hide_empty'    => false,
    //         )
    //     );

    //     if ( $terms && ! is_wp_error( $terms ) ) :

    //         $output = "";

    //         $draught_links = array();

    //         foreach ( $terms as $term ) {
    //             $term_link = get_term_link( $term );
    //             $draught_links[] = $term->name;

    //             $output .= "<span>
    //                             <a href='".$term_link."'>".$term->name."</a>
    //                         </span>";

    //         }

    //         $on_draught = join( " ", $draught_links );

    //         return $output;

    //     endif;

    // }





/* Stop Adding Functions Below this Line */
