<?php

if( ! defined ( 'ABSPATH' ) )

    exit;

function save_version_meta( $post_id, $post, $update){

    global $wpdb;
    $args = array(
  		'numberposts' => -1,
  		'order' => 'ASC',
  		'post_parent' => $post_id,
  		'post_type' => 'product_variation',
  	);

  	if ( isset( $_POST['blog_meta_box_nonce'] ) ) {
  	// Verify that the nonce is valid.
  	if ( wp_verify_nonce( $_POST['blog_meta_box_nonce'], 'blog_save_meta_box_data' ) ) {

       	if(!empty($_REQUEST['seller_id'])){

       		$table_name = "{$wpdb->prefix}posts";

       		$res = $wpdb->update($table_name,array('post_author'=> $_REQUEST['seller_id']), array('ID' => $post_id), array('%d'), array('%d'));

          $variations = get_children($args);

          if ( $variations ) {
            foreach ($variations as $key => $value) {
              $wpdb->update(
                $table_name,
                array(
                  'post_author' => $_REQUEST['seller_id']
                ),
                array(
                  'ID' => $value->ID
                ),
                array('%d'),
                array('%d')
              );
            }
          }

       	}

      }

  	}

}

function save_extra_user_profile_fields( $user_id ) {
  global $wpdb;

  $seller_id = $result = '';

  $seller_table = $wpdb->prefix . 'mpsellerinfo';

  $res_query = $wpdb->get_results( "SELECT seller_id from $seller_table where user_id = '$user_id'"
    );

  if ( $res_query ) {
    $seller_id = $res_query[0]->seller_id;
  }

  $seller_key = 'role';

	$shop_name = strip_tags( $_POST['shopname'] );

	$shop_url = isset( $_POST['shopurl'] ) ? sanitize_text_field( wp_unslash( $_POST['shopurl'] ) ) : '';

  $role = isset( $_POST['role'] ) ? sanitize_text_field( wp_unslash( $_POST['role'] ) ) : ''; // Input var okay.

  if ( $role == 'wk_marketplace_seller' ) {
    update_user_meta( $user_id, 'shop_name', $shop_name );
	} else {
    if ( $seller_id ) {
      $admin_id = get_users( array( 'role' 	=> 'administrator', 'number' => '1' ) )[0]->ID;
      $seller_product_data = get_posts(
        array(
          'author'    => $user_id,
          'post_type' => 'product'
        )
      );

      foreach ( $seller_product_data as $key => $value ) {
        wp_update_post(
          array(
            'ID'  => $value->ID,
            'post_author' => $admin_id
          )
        );
      }
      $wpdb->delete( $seller_table, array( 'seller_id' => $seller_id ), array( '%d' ) );
    }
  }
}

function mp_validate_extra_profile_fields( &$errors, $update = null, &$user = null ) {
  if ( isset( $user->ID ) ) {

    global $wpdb;

    $seller_id = $result = '';

    $seller_table = $wpdb->prefix . 'mpsellerinfo';

    $res_query = $wpdb->get_results( "SELECT seller_id from $seller_table where user_id = '$user->ID'"
      );

    if ( $res_query ) {
      $seller_id = $res_query[0]->seller_id;
    }

    $seller_key = 'role';

    $shop_url = isset( $_POST['shopurl'] ) ? sanitize_text_field( wp_unslash( $_POST['shopurl'] ) ) : '';

    $role = isset( $_POST['role'] ) ? sanitize_text_field( wp_unslash( $_POST['role'] ) ) : ''; // Input var okay.

    if ( $role == 'wk_marketplace_seller' ) {
      $sql = $wpdb->prepare( "SELECT user_id from {$wpdb->prefix}usermeta where (meta_key = 'shop_address') and (meta_value = '%s')", $shop_url );

      $result = $wpdb->get_results( $sql );

      if ( $result && $result[0]->user_id && $result[0]->user_id != $user->ID ) {
        $errors->add( 'invalid-shop-url', "<strong>ERROR</strong>: The shop URL already EXISTS please try different shop url.");
      } else {
        $shop_url = get_user_meta( $user->ID, 'shop_address', true ) ? get_user_meta( $user->ID, 'shop_address', true ) : $shop_url;

        $user_creds = array('ID' => $user->ID, 'user_nicename' => "$shop_url" );

    		wp_update_user($user_creds);

        $check = update_user_meta( $user->ID, 'shop_address', $shop_url );

        if ( $check ) {
          if ( isset( $seller_id ) && ! empty( $seller_id ) ) {
            $seller = array( 'user_id' => $user->ID, 'seller_key' => $seller_key, 'seller_value' => "seller" );

            $seller_res = $wpdb->update( $seller_table, $seller, array( 'seller_id' => $seller_id ) );
          } else {
            $seller = array( 'user_id' => $user->ID, 'seller_key' => $seller_key, 'seller_value' => "seller" );

            $seller_res = $wpdb->insert($seller_table, $seller);
          }
        }
      }
    }
  }
}
