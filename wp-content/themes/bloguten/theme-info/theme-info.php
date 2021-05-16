<?php
/**
 * Bloguten - Theme Info Admin Menu
 * @package Keon Themes
 * @subpackage Admin
 */
if ( ! class_exists( 'bloguten_Theme_Info' ) ) {
    class bloguten_Theme_Info{

        private $config;
        private $theme_name;
        private $theme_slug;
        private $theme_version;
        private $page_title;
        private $menu_title;
        private $tabs;

        /**
         * Constructor.
         */
        public function __construct( $config ) {
            $this->config = $config;
            $this->prepare_class();

            

            /*admin menu*/
            add_action( 'admin_menu', array( $this, 'kt_admin_menu' ) );

            /* enqueue script and style for about page */
            add_action( 'admin_enqueue_scripts', array( $this, 'style_and_scripts' ) );

            /* ajax callback for dismissable required actions */
            add_action( 'wp_ajax_kt_theme_info_update_recommended_action', array( $this, 'update_recommended_action_callback' ) );

        }

        

        /**
         * Prepare and setup class properties.
         */
        public function prepare_class() {
            $theme = wp_get_theme();
            if ( is_child_theme() ) {
                $this->theme_name = $theme->parent()->get( 'Name' );
            } else {
                $this->theme_name = $theme->get( 'Name' );
            }
            $this->theme_slug    = $theme->get_template();
            $this->theme_version = $theme->get( 'Version' );
            $this->page_title    = isset( $this->config['page_title'] ) ? $this->config['page_title'] : esc_html__('Info','bloguten'). $this->theme_name;
            $this->menu_title    = isset( $this->config['menu_title'] ) ? $this->config['menu_title'] : esc_html__('Info','bloguten') . $this->theme_name;
            $this->tabs          = isset( $this->config['tabs'] ) ? $this->config['tabs'] : array();

        }

        /**
         * Return the valid array of recommended actions.
         * @return array The valid array of recommended actions.
         */
        /**
         * Dismiss required actions
         */
        public function update_recommended_action_callback() {

            /*getting for provided array*/
            $recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();

            /*from js action*/
            $action_id = esc_attr( ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0 );
            $todo = esc_attr( ( isset( $_GET['todo'] ) ) ? $_GET['todo'] : '' );

            /*getting saved actions*/
            $saved_actions = get_option( $this->theme_slug . '_recommended_actions' );

            echo esc_html( wp_unslash( $action_id ) ); /* this is needed and it's the id of the dismissable required action */

            if ( ! empty( $action_id ) ) {

                if( 'reset' == $todo ){
                    $saved_actions_new = array();
                    if ( ! empty( $recommended_actions ) ) {

                        foreach ( $recommended_actions as $recommended_action ) {
                            $saved_actions[ $recommended_action['id'] ] = true;
                        }
                        update_option( $this->theme_slug . '_recommended_actions', $saved_actions_new );
                    }
                }
                /* if the option exists, update the record for the specified id */
                elseif ( !empty( $saved_actions) and is_array( $saved_actions ) ) {

                    switch ( esc_html( $todo ) ) {
                        case 'add';
                            $saved_actions[ $action_id ] = true;
                            break;
                        case 'dismiss';
                            $saved_actions[ $action_id ] = false;
                            break;
                    }
                    update_option( $this->theme_slug . '_recommended_actions', $saved_actions );

                    /* create the new option,with false for the specified id */
                }
                else {
                    $saved_actions_new = array();
                    if ( ! empty( $recommended_actions ) ) {

                        foreach ( $recommended_actions as $recommended_action ) {
                            echo $recommended_action['id'];
                            echo " ".$todo;
                            if ( $recommended_action['id'] == $action_id ) {
                                switch ( esc_html( $todo ) ) {
                                    case 'add';
                                        $saved_actions_new[ $action_id ] = true;
                                        break;
                                    case 'dismiss';
                                        $saved_actions_new[ $action_id ] = false;
                                        break;
                                }
                            }
                        }
                    }
                    update_option( $this->theme_slug . '_recommended_actions', $saved_actions_new );
                }
            }
            exit;
        }

        private function get_recommended_actions() {
            $saved_actions = get_option( $this->theme_slug . '_recommended_actions' );
            if ( ! is_array( $saved_actions ) ) {
                $saved_actions = array();
            }
            $recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
            $valid       = array();
            if( isset( $recommended_actions ) && is_array( $recommended_actions ) ){
                foreach ( $recommended_actions as $recommended_action ) {
                    if (
                        (
                            ! isset( $recommended_action['check'] ) ||
                            ( isset( $recommended_action['check'] ) && ( $recommended_action['check'] == false ) )
                        )
                        &&
                        ( ! isset( $saved_actions[ $recommended_action['id'] ] ) ||
                            ( isset( $saved_actions[ $recommended_action['id']] ) && ($saved_actions[ $recommended_action['id']] == true ) )
                        )
                    ) {
                        $valid[] = $recommended_action;
                    }
                }
            }
            return $valid;
        }

        private function count_recommended_actions() {
            $count = 0;
            $actions_count = $this->get_recommended_actions();
            if ( ! empty( $actions_count ) ) {
                $count = count( $actions_count );
            }
            return $count;
        }
        
        /**
         * Adding Theme Info Menu under Appearance.
         */
        function kt_admin_menu() {

            if ( ! empty( $this->page_title ) && ! empty( $this->menu_title ) ) {
                $count = $this->count_recommended_actions();
                $menu_title = $count > 0 ? $this->menu_title . '<span class="badge-action-count">' . esc_html( $count ) . '</span>' : $this->menu_title;
                /* Example
                 * add_theme_page('My Plugin Theme', 'My Plugin', 'edit_theme_options', 'my-unique-identifier', 'my_plugin_function');
                 * */
                add_theme_page( $this->page_title, $menu_title, 'edit_theme_options', $this->theme_slug . '-info', array(
                    $this,
                    'kt_theme_info_screen',
                ) );
            }
        }

        /**
         * Render the info content screen.
         */
        public function kt_theme_info_screen() {

            if ( ! empty( $this->config['info_title'] ) ) {
                $welcome_title = $this->config['info_title'];
            }
            if ( ! empty( $this->config['info_content'] ) ) {
                $welcome_content = $this->config['info_content'];
            }
            if ( ! empty( $this->config['quick_links'] ) ) {
                $quick_links = $this->config['quick_links'];
            }

            if (
                ! empty( $welcome_title ) ||
                ! empty( $welcome_content ) ||
                ! empty( $quick_links ) ||
                ! empty( $this->tabs )
            ) {
                echo '<div class="wrap about-wrap info-wrap epsilon-wrap">';

                if ( ! empty( $welcome_title ) ) {
                    echo '<h1>';
                    echo esc_html( $welcome_title );
                    if ( ! empty( $this->theme_version ) ) {
                        echo esc_html( $this->theme_version ) . ' </sup>';
                    }
                    echo '</h1>';
                }
                if ( ! empty( $welcome_content ) ) {
                    echo '<div class="about-text">' . wp_kses_post( $welcome_content ) . '</div>';
                }

                echo '<a href="https://keonthemes.com/" target="_blank" class="wp-badge epsilon-info-logo"></a>';

                /*quick links*/
                if( !empty( $quick_links ) && is_array( $quick_links ) ){
                    echo '<p class="quick-links">';
                    foreach ( $quick_links as $quick_key => $quick_link ) {
                        $button = 'button-secondary';
                        if( 'pro_url' == $quick_key ){
                            $button = 'button-primary';
                        }
                        echo '<a href="'.esc_url( $quick_link['url'] ).'" class="button '.esc_attr( $button ).'" target="_blank">'.$quick_link['text'].'</a>';
                    }
                    echo "</p>";
                }
                /* Display tabs */
                if ( ! empty( $this->tabs ) ) {
                    $current_tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'getting_started';

                    echo '<h2 class="nav-tab-wrapper wp-clearfix">';
                    $count = $this->count_recommended_actions();
                    foreach ( $this->tabs as $tab_key => $tab_name ) {

                        echo '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-info' ) ) . '&tab=' . $tab_key . '" class="nav-tab ' . ( $current_tab == $tab_key ? 'nav-tab-active' : '' ) . '" role="tab" data-toggle="tab">';
                        echo esc_html( $tab_name );
                        if ( $tab_key == 'recommended_actions' ) {
                            if ( $count > 0 ) {
                                echo '<span class="badge-action-count">' . esc_html( $count ) . '</span>';
                            }
                        }
                        echo '</a>';
                    }

                    echo '</h2>';

                    /* Display content for current tab, dynamic method according to key provided*/
                    if ( method_exists( $this, $current_tab ) ) {

                        echo "<div class='changelog point-releases'>";
                        $this->$current_tab();
                        echo "</div>";
                    }
                }
                echo '</div><!--/.wrap.about-wrap-->';
            }
        }

        /**
         * Getting started tab
         */
        public function getting_started() {
            if ( ! empty( $this->config['getting_started'] ) ) {
                $getting_started = $this->config['getting_started'];
                if ( ! empty( $getting_started ) ) {

                    /*defaults values for getting_started array */
                    $defaults = array(
                        'title'     => '',
                        'desc'       => '',
                        'recommended_actions'=> '',
                        'link_title'   => '',
                        'link_url'   => '',
                        'is_button' => false,
                        'is_new_tab' => false
                    );

                    echo '<div class="feature-section col-wrap">';

                    foreach ( $getting_started as $getting_started_item ) {

                        /*allowed 6 value in array */
                        $instance = wp_parse_args( (array) $getting_started_item, $defaults );
                        /*default values*/
                        $title = esc_html( $instance[ 'title' ] );
                        $desc = wp_kses_post( $instance[ 'desc' ] );
                        $link_title = esc_html( $instance[ 'link_title' ] );
                        $link_url = esc_url( $instance[ 'link_url' ] );
                        $is_button = $instance[ 'is_button' ];
                        $is_new_tab = $instance[ 'is_new_tab' ];


                        echo '<div class="col"><div class="col-items">';
                        if ( ! empty( $title ) ) {
                            echo '<h3>' . $title . '</h3>';
                        }
                        if ( ! empty( $desc ) ) {
                            echo '<p>' . $desc . '</p>';
                        }
                        if ( ! empty( $link_title ) && ! empty( $link_url ) ) {

                            echo '<p>';
                            $button_class = '';
                            if ( $is_button ) {
                                $button_class = 'button button-primary';
                            }

                            $count = $this->count_recommended_actions();

                            if ( $getting_started_item['recommended_actions'] && isset( $count ) ) {
                                if ( $count == 0 ) {
                                    echo '<span class="dashicons dashicons-yes"></span>';
                                } else {
                                    echo '<span class="dashicons dashicons-no-alt"></span>';
                                }
                            }

                            $button_new_tab = '_self';
                            if ( $is_new_tab ) {
                                $button_new_tab = '_blank';
                            }

                            echo '<a target="' . $button_new_tab . '" href="' . $getting_started_item['link_url'] . '"class="' . $button_class . '">' . $getting_started_item['link_title'] . '</a>';
                            echo '</p>';
                        }
                        echo '</div></div><!-- .col -->';
                    }
                    echo '</div><!-- .feature-section three-col -->';
                }
            }
        }

        /**
         * Recommended Actions tab
         */
        public function check_plugin_status( $slug ) {

            $path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php';
            if ( ! file_exists( $path ) ) {
                $path = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php';
                if ( ! file_exists( $path ) ) {
                    $path = false;
                }
            }

            if ( file_exists( $path ) ) {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

                $needs = is_plugin_active( $slug . '/' . $slug . '.php' ) ? 'deactivate' : 'activate';

                return array( 'status' => is_plugin_active( $slug . '/' . $slug . '.php' ), 'needs' => $needs );
            }

            return array( 'status' => false, 'needs' => 'install' );
        }

        public function create_action_link( $state, $slug ) {

            switch ( $state ) {
                case 'install':
                    return wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'install-plugin',
                                'plugin' => $slug
                            ),
                            network_admin_url( 'update.php' )
                        ),
                        'install-plugin_' . $slug
                    );
                    break;

                case 'deactivate':
                    return add_query_arg(
                            array(
                                'action'        => 'deactivate',
                                'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
                                'plugin_status' => 'all',
                                'paged'         => '1',
                                '_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $slug . '/' . $slug . '.php' )
                                ),
                            network_admin_url( 'plugins.php' )
                    );
                    break;

                case 'activate':
                    return add_query_arg(
                            array(
                                'action'        => 'activate',
                                'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
                                'plugin_status' => 'all',
                                'paged'         => '1',
                                '_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' )
                            ),
                            network_admin_url( 'plugins.php' )
                    );
                    break;
            }
        }

        public function recommended_actions() {

            $recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
            $hooray = true;
            if ( ! empty( $recommended_actions ) ) {

                echo '<div class="feature-section action-recommended demo-import-boxed" id="plugin-filter">';

                if ( ! empty( $recommended_actions ) && is_array( $recommended_actions ) ) {

                    /*get saved recommend actions*/
                    $saved_recommended_actions = get_option( $this->theme_slug . '_recommended_actions' );

                    /*defaults values for getting_started array */
                    $defaults = array(
                        'title'         => '',
                        'desc'          => '',
                        'check'         => false,
                        'plugin_slug'   => '',
                        'id'            => ''
                    );
                    foreach ( $recommended_actions as $action_key => $action_value ) {
                        $instance = wp_parse_args( (array) $action_value, $defaults );

                        /*allowed 5 value in array */
                        $title = $instance[ 'title' ];
                        $desc = $instance[ 'desc' ];
                        $check = $instance[ 'check' ];
                        $plugin_slug = $instance[ 'plugin_slug' ];
                        $id = $instance[ 'id' ];

                        $hidden = false;

                        /*magic check for recommended actions*/
                        if (
                            isset( $saved_recommended_actions[ $id ] ) &&
                            $saved_recommended_actions[ $id ] == false ) {
                            $hidden = true;
                        }
                        if ( $hidden ) {
                            //continue;
                        }
                        $done = '';
                        if ( $check ) {
                           $done = 'done';
                        }

                        echo "<div class='kt-theme-info-action-recommended-box {$done}'>";

                        if ( ! $hidden ) {
                            echo '<span data-action="dismiss" class="dashicons dashicons-visibility kt-theme-info-recommended-action-button" id="' . esc_attr( $action_value['id'] ) . '"></span>';
                        } else {
                            echo '<span data-action="add" class="dashicons dashicons-hidden kt-theme-info-recommended-action-button" id="' . esc_attr( $action_value['id'] ) .'"></span>';
                        }

                        if ( ! empty( $title) ) {
                            echo '<h3>' . wp_kses_post( $title ) . '</h3>';
                        }

                        if ( ! empty( $desc ) ) {
                            echo '<p>' . wp_kses_post( $desc ) . '</p>';
                        }

                        if ( ! empty( $plugin_slug ) ) {

                            $active = $this->check_plugin_status( $action_value['plugin_slug'] );
                            $url    = $this->create_action_link( $active['needs'], $action_value['plugin_slug'] );
                            $label  = '';
                            $class  = '';
                            switch ( $active['needs'] ) {

                                case 'install':
                                    $class = 'install-now button';
                                    $label = esc_html__( 'Install', 'bloguten' );
                                    break;

                                case 'activate':
                                    $class = 'activate-now button button-primary';
                                    $label = esc_html__( 'Activate', 'bloguten' );

                                    break;

                                case 'deactivate':
                                    $class = 'deactivate-now button';
                                    $label = esc_html__( 'Deactivate', 'bloguten' );

                                    break;
                            }

                            ?>
                            <p class="plugin-card-<?php echo esc_attr( $action_value['plugin_slug'] ) ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
                                <a data-slug="<?php echo esc_attr( $action_value['plugin_slug'] ) ?>"
                                   class="<?php echo esc_attr( $class ); ?>"
                                   href="<?php echo esc_url( $url ) ?>"> <?php echo esc_html( $label ) ?> </a>
                            </p>

                            <?php

                        }
                        echo '</div>';
                        $hooray = false;
                    }
                }
                if ( $hooray ){
                    echo '<span class="hooray">' . esc_html__( 'Hooray! There are no recommended actions for you right now.', 'bloguten' ) . '</span>';
                    echo '<a data-action="reset" id="reset" class="reset-all" href="#">'.esc_html__('Show All Recommended Actions','bloguten').'</a>';
                }
                echo '</div>';
            }
        }

        /**
         * Recommended plugins tab
         */
        /*
         * Call plugin api
         */
        public function call_plugin_api( $slug ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

            if ( false === ( $call_api = get_transient( 'kt_theme_info_plugin_information_transient_' . $slug ) ) ) {
                $call_api = plugins_api( 'plugin_information', array(
                    'slug'   => $slug,
                    'fields' => array(
                        'downloaded'        => false,
                        'rating'            => false,
                        'description'       => false,
                        'short_description' => true,
                        'donate_link'       => false,
                        'tags'              => false,
                        'sections'          => true,
                        'homepage'          => true,
                        'added'             => false,
                        'last_updated'      => false,
                        'compatibility'     => false,
                        'tested'            => false,
                        'requires'          => false,
                        'downloadlink'      => false,
                        'icons'             => true
                    )
                ) );
                set_transient( 'kt_theme_info_plugin_information_transient_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
            }

            return $call_api;
        }
        public function get_plugin_icon( $arr ) {

            if ( ! empty( $arr['svg'] ) ) {
                $plugin_icon_url = $arr['svg'];
            } elseif ( ! empty( $arr['2x'] ) ) {
                $plugin_icon_url = $arr['2x'];
            } elseif ( ! empty( $arr['1x'] ) ) {
                $plugin_icon_url = $arr['1x'];
            } else {
                $plugin_icon_url = get_template_directory_uri() . '/assets/placeholder_plugin.png';
            }

            return $plugin_icon_url;
        }
        public function recommended_plugins() {
            $recommended_plugins = $this->config['recommended_plugins'];

            if ( ! empty( $recommended_plugins ) ) {
                if ( ! empty( $recommended_plugins ) && is_array( $recommended_plugins ) ) {

                    echo '<div class="feature-section recommended-plugins col-wrap demo-import-boxed" id="plugin-filter">';

                    foreach ( $recommended_plugins as $recommended_plugins_item ) {

                        if ( ! empty( $recommended_plugins_item['slug'] ) ) {
                            $info   = $this->call_plugin_api( $recommended_plugins_item['slug'] );
                            if ( ! empty( $info->icons ) ) {
                                $icon = $this->get_plugin_icon( $info->icons );
                            }

                            $active = $this->check_plugin_status( $recommended_plugins_item['slug'] );

                            if ( ! empty( $active['needs'] ) ) {
                                $url = $this->create_action_link( $active['needs'], $recommended_plugins_item['slug'] );
                            }

                            echo '<div class="col"><div class="col-items plugin_box">';
                            if ( ! empty( $icon ) ) {
                                echo '<img src="'.esc_url( $icon ).'" alt="plugin box image">';
                            }
                            if ( ! empty(  $info->version ) ) {
                                echo '<span class="version">'. ( ! empty( $this->config['recommended_plugins']['version_label'] ) ? esc_html( $this->config['recommended_plugins']['version_label'] ) : '' ) . esc_html( $info->version ).'</span>';
                            }
                            if ( ! empty( $info->author ) ) {
                                echo '<span class="separator"> | </span>' . wp_kses_post( $info->author );
                            }

                            if ( ! empty( $info->name ) && ! empty( $active ) ) {
                                echo '<div class="action_bar ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
                                echo '<span class="plugin_name">' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'Active: ' : '' ) . esc_html( $info->name ) . '</span>';
                                echo '</div>';

                                $label = '';

                                switch ( $active['needs'] ) {

                                    case 'install':
                                        $class = 'install-now button';
                                        $label = esc_html__( 'Install', 'bloguten' );
                                        break;

                                    case 'activate':
                                        $class = 'activate-now button button-primary';
                                        $label = esc_html__( 'Activate', 'bloguten' );

                                        break;

                                    case 'deactivate':
                                        $class = 'deactivate-now button';
                                        $label = esc_html__( 'Deactivate', 'bloguten' );

                                        break;
                                }

                                echo '<span class="plugin-card-' . esc_attr( $recommended_plugins_item['slug'] ) . ' action_button ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
                                echo '<a data-slug="' . esc_attr( $recommended_plugins_item['slug'] ) . '" class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
                                echo '</span>';
                            }
                            echo '</div></div><!-- .col.plugin_box -->';
                        }
                    }
                    echo '</div><!-- .recommended-plugins -->';
                }
            }
        }

        /**
         * Child themes
         */
        public function child_themes() {
            echo '<div id="child-themes" class="kt-theme-info-tab-pane">';
            $child_themes = isset( $this->config['child_themes'] ) ? $this->config['child_themes'] : array();
            if ( ! empty( $child_themes ) ) {

                /*defaults values for child theme array */
                $defaults = array(
                    'title'        => '',
                    'screenshot'   => '',
                    'download_link'=> '',
                    'preview_link' => ''
                );
                if ( ! empty( $child_themes ) && is_array( $child_themes ) ) {
                    echo '<div class="kt-about-row">';
                    $i = 0;
                    foreach ( $child_themes as $child_theme ){
                        $instance = wp_parse_args( (array) $child_theme, $defaults );

                        /*allowed 5 value in array */
                        $title = $instance[ 'title' ];
                        $screenshot = $instance[ 'screenshot'];
                        $download_link = $instance[ 'download_link'];
                        $preview_link = $instance[ 'preview_link'];

                        if( !empty( $screenshot) ){
                            echo '<div class="kt-about-child-theme">';
                            echo '<div class="kt-theme-info-child-theme-image">';

                            echo '<img src="' . esc_url( $screenshot ) . '" alt="' . ( ! empty( $title ) ? esc_attr( $title ) : '' ) . '" />';

                            if ( ! empty( $title ) ) {
                                echo '<div class="kt-theme-info-child-theme-details">';
                                echo '<div class="theme-details">';
                                echo '<span class="theme-name">' . esc_html( $title  ). '</span>';
                                if ( ! empty( $download_link ) ) {
                                    echo '<a href="' . esc_url( $download_link ) . '" class="button button-primary install right">' . esc_html__( 'Download','bloguten' ) . '</a>';
                                }
                                if ( ! empty( $preview_link ) ) {
                                    echo '<a class="button button-secondary preview right" target="_blank" href="' . $preview_link . '">' . esc_html__( 'Live Preview','bloguten' ). '</a>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }

                            echo "</div>";
                            echo "</div>";
                            $i++;
                        }
                        if( 0 == $i % 3 ){
                            echo "</div><div class='kt-about-row'>";/*.kt-about-row end-start*/
                        }
                    }

                    echo '</div>';/*.kt-about-row end*/
                }// End if().
            }// End if().
            echo '</div>';
        }

        /**
         * Support tab
         */
        public function support() {
            echo '<div class="feature-section col-wrap">';

            if ( ! empty( $this->config['support_content'] ) ) {

                $supports = $this->config['support_content'];

                if ( ! empty( $supports ) ) {

                    /*defaults values for child theme array */
                    $defaults = array(
                        'title' => '',
                        'icon' => '',
                        'desc' => '',
                        'button_label' => '',
                        'button_link' => '',
                        'is_button' => true,
                        'is_new_tab' => true
                    );

                    foreach ( $supports as $support ) {
                        $instance = wp_parse_args( (array) $support, $defaults );

                        /*allowed 7 value in array */
                        $title = $instance[ 'title' ];
                        $icon = $instance[ 'icon'];
                        $desc = $instance[ 'desc'];
                        $button_label = $instance[ 'button_label'];
                        $button_link = $instance[ 'button_link'];
                        $is_button = $instance[ 'is_button'];
                        $is_new_tab = $instance[ 'is_new_tab'];
                        
                        echo '<div class="col"><div class="col-items">';

                        if ( ! empty( $title ) ) {
                            echo '<h3>';
                            if ( ! empty( $icon ) ) {
                                echo '<i class="' . $icon . '"></i>';
                            }
                            echo $title;
                            echo '</h3>';
                        }

                        if ( ! empty( $desc ) ) {
                            echo '<p><i>' . $desc . '</i></p>';
                        }

                        if ( ! empty( $button_link ) && ! empty( $button_label ) ) {

                            echo '<p>';
                            $button_class = '';
                            if ( $is_button ) {
                                $button_class = 'button button-primary';
                            }

                            $button_new_tab = '_self';
                            if ( isset( $is_new_tab ) ) {
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }
                            }
                            echo '<a target="' . $button_new_tab . '" href="' . $button_link . '" class="' . $button_class . '">' . $button_label . '</a>';
                            echo '</p>';
                        }
                        echo '</div></div>';
                    }
                }
            }
            echo '</div>';
        }

        /**
         * Changelog tab
         */
        private function parse_changelog() {
            WP_Filesystem();
            global $wp_filesystem;
            $changelog = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
            if ( is_wp_error( $changelog ) ) {
                $changelog = '';
            }
            return $changelog;
        }

        public function changelog() {
            $changelog = $this->parse_changelog();
            if ( ! empty( $changelog ) ) {
                echo '<div class="featured-section changelog">';
                echo "<pre class='changelog'>";
                echo $changelog;
                echo "</pre>";
                echo '</div><!-- .featured-section.changelog -->';
            }
        }

        /**
         * Free vs PRO tab
         */
        public function free_pro() {
            $free_pro = isset( $this->config['free_pro'] ) ? $this->config['free_pro'] : array();
            if ( ! empty( $free_pro ) ) {
                /*defaults values for child theme array */
                $defaults = array(
                    'title'=> '',
                    'desc' => '',
                    'free' => '',
                    'pro'  => '',
                );

                if ( ! empty( $free_pro ) && is_array( $free_pro ) ) {
                    echo '<div class="feature-section">';
                    echo '<div id="free_pro" class="kt-theme-info-tab-pane kt-theme-info-fre-pro">';
                    echo '<table class="free-pro-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th>' . esc_html__( 'bloguten','bloguten' ) . '</th>';
                    echo '<th>' . esc_html__( 'blogutenPro','bloguten' ) . '</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ( $free_pro as $feature ) {

                        $instance = wp_parse_args( (array) $feature, $defaults );

                        /*allowed 7 value in array */
                        $title = $instance[ 'title' ];
                        $desc = $instance[ 'desc'];
                        $free = $instance[ 'free'];
                        $pro = $instance[ 'pro'];

                        echo '<tr>';
                        if ( ! empty( $title ) || ! empty( $desc ) ) {
                            echo '<td>';
                            if ( ! empty( $title ) ) {
                                echo '<h3>' . wp_kses_post( $title ) . '</h3>';
                            }
                            if ( ! empty( $desc ) ) {
                                echo '<p>' . wp_kses_post( $desc ) . '</p>';
                            }
                            echo '</td>';
                        }

                        if ( ! empty( $free )) {
                            if( 'yes' === $free ){
                                echo '<td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>';
                            }
                            elseif ( 'no' === $free ){
                                echo '<td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>';
                            }
                            else{
                                echo '<td class="only-lite">'.esc_html($free ).'</td>';
                            }

                        }
                        if ( ! empty( $pro )) {
                            if( 'yes' === $pro ){
                                echo '<td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>';
                            }
                            elseif ( 'no' === $pro ){
                                echo '<td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>';
                            }
                            else{
                                echo '<td class="only-lite">'.esc_html($pro ).'</td>';
                            }
                        }
                        echo '</tr>';
                    }

                    echo '<tr class="kt-theme-info-text-center">';
                    echo '<td></td>';
                    echo '<td colspan="2"><a href="https://keonthemes.com/downloads/bloguten-pro/" target="_blank" class="button button-primary button-hero">BlogutenPro</a></td>';
                    echo '</tr>';

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';

                }
            }
        }

        /**
         * Support tab
         */
        public function faq() {
            echo '<div class="feature-section  faq">';

            if ( ! empty( $this->config['faq'] ) ) {

                $supports = $this->config['faq'];

                if ( ! empty( $supports ) ) {

                    /*defaults values for child theme array */
                    $defaults = array(
                        'title' => '',
                        'icon' => '',
                        'desc' => '',
                        'button_label' => '',
                        'button_link' => '',
                        'is_button' => true,
                        'is_new_tab' => true
                    );

                    foreach ( $supports as $support ) {
                        $instance = wp_parse_args( (array) $support, $defaults );

                        /*allowed 7 value in array */
                        $title = $instance[ 'title' ];
                        $icon = $instance[ 'icon'];
                        $desc = $instance[ 'desc'];
                        $button_label = $instance[ 'button_label'];
                        $button_link = $instance[ 'button_link'];
                        $is_button = $instance[ 'is_button'];
                        $is_new_tab = $instance[ 'is_new_tab'];

                        echo '<div class="col-full">';

                        if ( ! empty( $title ) ) {
                            echo '<h3 class="faq-title">';
                            if ( ! empty( $icon ) ) {
                                echo '<i class="' . $icon . '"></i>';
                            }
                            echo $title;
                            echo '</h3>';
                        }
                        echo "<div class='faq-content'>";

                        if ( ! empty( $desc ) ) {
                            echo '<p><i>' . $desc . '</i></p>';
                        }
                        if ( ! empty( $button_link ) && ! empty( $button_label ) ) {

                            echo '<p>';
                            $button_class = '';
                            if ( $is_button ) {
                                $button_class = 'button button-primary';
                            }

                            $button_new_tab = '_self';
                            if ( isset( $is_new_tab ) ) {
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }
                            }
                            echo '<a target="' . $button_new_tab . '" href="' . $button_link . '" class="' . $button_class . '">' . $button_label . '</a>';
                            echo '</p>';
                        }
                        echo "</div>";

                        echo '</div>';
                    }
                }
            }
            echo '</div>';
        }

         /**
         * Demos tab
         */
        public function demos(){
            if( ! empty( $this->config['demos'] ) ){
                $demos= $this->config['demos'];
                    if( ! empty($demos) ){

                    /*defaults values for demos array */
                        $defaults = array(
                            'title'     => '',
                            'desc'       => '',
                            'recommended_actions'=> '',
                            'link_title'   => '',
                            'link_url'   => '',
                            'is_button' => false,
                            'is_new_tab' => false
                        );

                         echo '<div class="feature-section col-wrap demo-section">';

                        foreach ( $demos as $demos_item ) {

                            /*allowed 6 value in array */
                            $instance = wp_parse_args( (array) $demos_item, $defaults );
                            /*default values*/
                            $title = esc_html( $instance[ 'title' ] );
                            $desc = wp_kses_post( $instance[ 'desc' ] );
                            $link_title = esc_html( $instance[ 'link_title' ] );
                            $link_url = esc_url( $instance[ 'link_url' ] );
                            $is_button = $instance[ 'is_button' ];
                            $is_new_tab = $instance[ 'is_new_tab' ];


                            echo '<div class="col"><div class="col-items">';
                            if ( ! empty( $title ) ) {
                                echo '<h3>' . $title . '</h3>';
                            }
                            if ( ! empty( $desc ) ) {
                                echo '<p>' . $desc . '</p>';
                            }
                            if ( ! empty( $link_title ) && ! empty( $link_url ) ) {

                                echo '<p>';
                                $button_class = '';
                                if ( $is_button ) {
                                    $button_class = 'button button-primary';
                                }

                                $count = $this->count_recommended_actions();

                                if ( $demos_item['recommended_actions'] && isset( $count ) ) {
                                    if ( $count == 0 ) {
                                        echo '<span class="dashicons dashicons-yes"></span>';
                                    } else {
                                        echo '<span class="dashicons dashicons-no-alt"></span>';
                                    }
                                }

                                $button_new_tab = '_self';
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }

                                echo '<a target="' . $button_new_tab . '" href="' . $demos_item['link_url'] . '"class="' . $button_class . '">' . $demos_item['link_title'] . '</a>';
                                echo '</p>';
                            }
                            echo '</div></div><!-- .col -->';
                        }
                        echo '</div><!-- .feature-section three-col -->';
                    }
             }
        }

        /**
         * Load css and scripts for the about page
         */
        public function style_and_scripts( $hook_suffix ) {

            // this is needed on all admin pages, not just the about page, for the badge action count in the WordPress main sidebar
            wp_enqueue_style( 'kt-theme-info-css', get_template_directory_uri() . '/theme-info/assets/css/theme-info.css' );

            if ( 'appearance_page_' . $this->theme_slug . '-info' == $hook_suffix ) {

                wp_enqueue_script( 'kt-theme-info-js', get_template_directory_uri() . '/theme-info/assets/js/theme-info.js', array( 'jquery' ) );

                wp_enqueue_style( 'plugin-install' );
                wp_enqueue_script( 'plugin-install' );
                wp_enqueue_script( 'updates' );

                $count = $this->count_recommended_actions();
                wp_localize_script( 'kt-theme-info-js', 'kt_theme_info_object', array(
                    'nr_actions_recommended'      => $count,
                    'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
                    'template_directory'       => get_template_directory_uri()
                ) );

            }

        }
    }
}

$config = array(
    // Page title.
    'page_title'               => esc_html__( 'Bloguten Info', 'bloguten' ),

    // Menu name under Appearance.
    'menu_title'               => esc_html__( 'Bloguten Info', 'bloguten' ),

    // Main welcome title
    'info_title'         => sprintf( esc_html__( 'Welcome to %s - ', 'bloguten' ), 'Bloguten' ),

    // Main welcome content
    'info_content'       => sprintf( esc_html__( '%s is now installed and ready to use. We hope the following information will help you. If you want to ask any query or just want to say hello, you can always contact us. We hope you enjoy it! ', 'bloguten' ), '<b>Bloguten</b>' ),

    /**
     * Quick links
     */
    'quick_links'                    => array(
        'theme_url'  => array(
                'text' => __('Theme Details','bloguten'),
                'url' => 'https://keonthemes.com/downloads/bloguten/'
        ),
        'demo_url'  => array(
            'text' => __('View Demo','bloguten'),
            'url' => 'https://keonthemes.com/theme-demo/?id=Mzg3NXxibG9ndXRlbnxCbG9ndXRlbg='
        ),
        'pro_url'  => array(
            'text' => __('View Pro Version','bloguten'),
            'url' => 'https://keonthemes.com/theme-demo/?id=Mzg3OXxibG9ndXRlbi1wcm98QmxvZ3V0ZW4gUHJv'
        ),
        'rate_url'  => array(
            'text' => __('Rate This Theme','bloguten'),
            'url' => 'https://wordpress.org/support/theme/bloguten/reviews/?filter=5'
        ),
    ),

    'tabs' => array(
        'getting_started'      => __( 'Getting Started', 'bloguten' ),
        'recommended_plugins'  => __( 'Useful Plugins','bloguten' ),
        'support'              => __( 'Support', 'bloguten' ),
        'changelog'            => __( 'Changelog', 'bloguten' ),
        'faq'                  => __( 'FAQ', 'bloguten' ),
        'free_pro'             => __( 'Free VS PRO', 'bloguten' ),
        'demos'                => __( 'Demos', 'bloguten' ),
    ),

    /*Getting started tab*/
    'getting_started' => array(
        'first' => array(
            'title' => esc_html__( 'Step 1 : Read full documentation','bloguten' ),
            'desc' => esc_html__( 'Please check our full documentation for detailed information on how to Setup and Use Bloguten.','bloguten' ),
            'link_title' => esc_html__( 'Documentation','bloguten' ),
            'link_url' => 'http://keonthemes.com/doc/bloguten/',
            'is_button' => false,
            'recommended_actions' => false,
            'is_new_tab' => true
        ),
        'second' => array(
            'title' => esc_html__( 'Step 2 : Go to Customizer','bloguten' ),
            'desc' => esc_html__( 'All Setting, Theme Options, Frontpage Options, Widgets and Menus are available via Customize screen.','bloguten' ),
            'link_title' => esc_html__( 'Go to Customizer','bloguten' ),
            'link_url' => esc_url( admin_url( 'customize.php' ) ),
            'is_button' => true,
            'recommended_actions' => false,
            'is_new_tab' => true
        ),
        
    ),


    // Plugins array.
    'recommended_plugins' => array(
        'WooCommerce' => array(
            'slug' => 'woocommerce'
        ),
        'Contact Form 7' => array(
            'slug' => 'contact-form-7'
        ),
        'MailChimp for WordPress' => array(
            'slug' => 'mailchimp-for-wp'
        ),
        'Simple Social Buttons' => array(
            'slug' => 'simple-social-buttons'
        ),
        'Instagram Feed' => array(
            'slug' => 'instagram-feed'
        ),
        'One Click Demo Import' => array(
            'slug' => 'one-click-demo-import'
        ),
    ),

    /*FAQ*/
    'faq'      => array(
        'first' => array (
            'title' => esc_html__( 'Does this theme support any plugins?','bloguten' ),
            'desc' => esc_html__( 'Bloguten supports WooCommerce, Contact From 7 and MailChimp for WordPress.','bloguten' ),
            'is_new_tab' => true
        ),
    ),
    // Support content tab.
    'support_content'      => array(
        'first' => array (
            'title' => esc_html__( 'Support Forum','bloguten' ),
            'desc' => esc_html__( 'Got theme support question or found bug? Best place to ask your query is our dedicated Support forum.','bloguten' ),
            'button_label' => esc_html__( 'Support Forum','bloguten' ),
            'button_link' => esc_url( 'https://keonthemes.com/forums/forum/bloguten/' ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'second' => array(
            'title' => esc_html__( 'Documentation','bloguten' ),
            'desc' => esc_html__( 'Please check our full documentation for detailed information on how to Setup and Use Weblog.','bloguten' ),
            'button_label' => esc_html__( 'Read full documentation','bloguten' ),
            'button_link' => 'http://keonthemes.com/doc/bloguten/',
            'is_button' => false,
            'is_new_tab' => true
        ),
        'third' => array(
            'title' => esc_html__( 'Need more features?','bloguten' ),
            'desc' => esc_html__( 'Upgrade to PRO version for more exciting features and Priority Support.','bloguten' ),
            'button_label' => esc_html__( 'View Pro Version','bloguten' ),
            'button_link' => 'https://keonthemes.com/downloads/bloguten-pro',
            'is_button' => true,
            'is_new_tab' => true
        ),
        'fourth' => array(
            'title' => esc_html__( 'Got sales related question?','bloguten' ),
            'desc' => esc_html__( "Have any query before purchase, you are more than welcome to ask.",'bloguten' ),
            'button_label' => esc_html__( 'Pre-sale Question?','bloguten' ),
            'button_link' => 'mailto:keonthemes@gmail.com',
            'is_button' => false,
            'is_new_tab' => true
        ),
        'fifth' => array(
            'title' => esc_html__( 'Customization Request','bloguten' ),
            'desc' => esc_html__( 'Needed any customization for the theme, you can request from here.','bloguten' ),
            'button_label' => esc_html__( 'Customization Request','bloguten' ),
            'button_link' => 'https://keonthemes.com/hire-now/',
            'is_button' => false,
            'is_new_tab' => true
        )
    ),

    // Free vs pro array.
    'free_pro' => array(
        array(
            'title'=> __( 'Build with Live Customizer API', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'Fully Editable & Disable/Enable option', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Demo content import', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Fixed Header', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Theme Options', 'bloguten' ),
            'free' => __('Basic','bloguten'),
            'pro'  => __('Advanced','bloguten'),
        ),
       array(
            'title'=> __( 'Theme Support', 'bloguten' ),
            'free' => __('Basic','bloguten'),
            'pro'  => __('Premium','bloguten'),
        ),
       array(
            'title'=> __( 'Site Identity Extra Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Site Layout Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('More options','bloguten'),
        ),
        array(
            'title'=> __( 'Archive Page Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('More options','bloguten'),
        ),
        array(
            'title'=> __( 'Single Page Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('More options','bloguten'),
        ),
       array(
            'title'=> __( 'Pages Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('More options','bloguten'),
        ),
       array(
            'title'=> __( 'Post Layout Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('More options','bloguten'),
        ),
        array(
            'title'=> __( 'Sidebar Position Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Unlimited Color Options', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Custom Widget', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Thin Font Icons', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'Fully Responsive Design', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Translation Ready', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Cross-Browser Compatibility', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'RTL Language Support', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Plugins Support', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Slider Section', 'bloguten' ),
            'free' => __('Upto 3 items','bloguten'),
            'pro'  => __('Unlimited Slider Items, Advance Features','bloguten'),
        ),
        array(
            'title'=> __( 'Instagram Section', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
         array(
            'title'=> __( 'Footer Widgets Section', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'Copyright Section', 'bloguten' ),
            'free' => __('yes','bloguten'),
            'pro'  => __('Option to Change full copyright text','bloguten'),
        ),
       array(
            'title'=> __( 'Dedicated & Priority Support', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'Multiple Header Layout Options', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'Multiple Footer Layout Options', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'Multiple Page Header Layout & Image Options', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
        array(
            'title'=> __( 'MultipleMultiple Slider Type, Layout & Content Alignment', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Advanced Font Family Options', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( '100+ Google Fonts Options', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Multiple Site Preloader options', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Breadcrumb Separator Layouts', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('3 Layouts','bloguten'),
        ),
       array(
            'title'=> __( 'Coming Soon Page', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
       array(
            'title'=> __( 'Contact Page Template', 'bloguten' ),
            'free' => __('no','bloguten'),
            'pro'  => __('yes','bloguten'),
        ),
    ),

    
    //demos

    'demos' => array (
        'first' => array(
            'title' => esc_html__( 'Bloguten ','bloguten' ),
            'desc' => esc_html__ ( 'Free Theme Demo', 'bloguten' ),
            'link_title' => esc_html__( 'View Demo','bloguten' ),
            'link_url' => 'https://keonthemes.com/theme-demo/?id=Mzk4OXxibG9nYmVyZ3xCbG9nYmVyZw=',
            'is_button' => true,
            'recommended_actions' => false,
            'is_new_tab' => true
        ),
        'second'=> array(
            'title' => esc_html__( 'Bloguten Pro','bloguten' ),
            'desc' => esc_html__ ( 'Pro Theme Demo', 'bloguten' ),
            'link_title' => esc_html__( 'View Demo','bloguten' ),
            'link_url' => 'https://keonthemes.com/theme-demo/?id=Mzg3OXxibG9ndXRlbi1wcm98QmxvZ3V0ZW4gUHJv',
            'is_button' => true,
            'recommended_actions' => false,
            'is_new_tab' => true
        ),
    )

);
return new bloguten_Theme_Info( $config );
