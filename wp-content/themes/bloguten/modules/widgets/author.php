<?php
/**
* Bloguten Author Widget
*
* @since Bloguten 1.0.0
*/
if( ! class_exists( 'Bloguten_Author_Widget' ) ) :
    
    class Bloguten_Author_Widget extends Bloguten_Base_Widget {

        var $image_field = 'image';  // the image field ID

        public function __construct() {

            $widget_ops = array(
                'description' => esc_html__( 'Widget for your profile.', 'bloguten' ), 
                'customize_selective_refresh' => true
            );
            
            parent::__construct(
                'bloguten_author_widget', 
                esc_html__( 'Bloguten Author', 'bloguten' ),
                $widget_ops
            );

            $this->fields = array(
                'title' => array(
                    'label'   => esc_html__( 'Title', 'bloguten' ),
                    'type'    => 'text',
                    'default' => esc_html__( 'About the Author', 'bloguten' )
                ),
                'page_id' => array(
                    'label' => esc_html__( 'Select Page', 'bloguten' ),
                    'type'  => 'dropdown-pages',
                ),
                'sub_title' => array(
                    'label'   => esc_html__( 'Sub Title', 'bloguten' ),
                    'type'    => 'text',
                    'default' => esc_html__( 'Blogger','bloguten' )
                ),
                'btn_text' => array(
                    'label'   => esc_html__( 'Button Text', 'bloguten' ),
                    'type'    => 'text',
                    'default' => esc_html__( 'Know More', 'bloguten' )
                ),
                'social_menu' => array(
                    'label' => esc_html__( 'Select Social Menu', 'bloguten' ),
                    'type'  => 'dropdown-menus',
                ) 
            );
        }

        public function widget( $args, $instance ) {
            
            echo $args[ 'before_widget' ];

            $instance = $this->init_defaults( $instance );
            $unique_id = uniqid();
            ?>
            <?php if( $instance[ 'page_id' ] ): ?>

            <section class="<?php echo empty( $instance[ 'title' ] ) ? esc_attr( 'no-title' ): ''; ?> wrapper author-widget class-<?php echo esc_attr( $unique_id ); ?>">
                <?php
                echo '<div class="widget-title-wrap">' . $args[ 'before_title'] . esc_html( $instance[ 'title' ] ) . $args[ 'after_title' ] . '</div>';

                $query = new WP_Query( array(
                    'p'         => $instance[ 'page_id' ],
                    'post_type' => 'page'
                ) );

                while( $query->have_posts() ){
                    $query->the_post();
                    if( has_post_thumbnail() ){
                        $src = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
                    }else{
                        $src = bloguten_get_dummy_image( array(
                            'size' => 'thumbnail'
                        ) );
                    }
                ?>
                <div class="widget-content">
                    <div class="profile">
                        <div class="avatar">
                            <figure>
                                 <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $src ); ?>" >
                                 </a>
                            </figure>
                        </div>
                        <div class="name-title">
                            <headgroup>
                                <?php the_title( '<h2><a href="'. esc_url( get_permalink() ) .'">', '</a></h2>' ); ?>
                                 <h3><?php echo esc_html( $instance[ 'sub_title' ] ); ?></h3>
                            </headgroup>
                        </div>
                        <div class="socialgroup">
                            <?php echo $this->get_menu( $instance[ 'social_menu' ] ); ?>
                        </div>
                        <div class="button-container">
                            <a href="<?php the_permalink(); ?>" class="button-primary button-round" >
                                <?php echo esc_html( $instance[ 'btn_text' ]  ); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </section>
            <?php endif; ?>
            <?php
            
            wp_reset_postdata();
            echo $args[ 'after_widget' ];
        }
    }

endif;