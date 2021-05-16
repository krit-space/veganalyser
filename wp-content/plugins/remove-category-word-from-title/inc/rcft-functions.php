<?php

add_filter( 'get_the_archive_title', 'remove_category_word_from_title', 10);

function remove_category_word_from_title($category_name) {

    if ( is_category() ) {

            $category_name = single_cat_title( '', false );

        } 

    return $category_name;

}

?>