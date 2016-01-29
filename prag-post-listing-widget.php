<?php
/*
    Plugin Name: Post Listing Widget
    Plugin URI: https://www.pragmatticode.com
    Description: Widget to display a listing of posts
    Author: Matt Walters (mwalters@pragmatticode.com)
    Version: 0.1
    Author URI: https://www.pragmatticode.com
 */

if ( ! class_exists( Prag_Post_List_Widget ) ) {
    class Prag_Post_List_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                'Prag_Post_List_Widget', // Base ID
                __( 'Post List Widget', 'prag_post_listing_widget' ), // Name
                array( 'description' => __( 'Post List Widget', 'prag_post_listing_widget' ), ) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {

            $postsargs = array(
                'posts_per_page' => $instance['number_of_posts'],
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => 'post',
                'post_status' => 'publish',
                'tag' => $instance['tag']
            );

            $posts = get_posts( $postsargs );

            echo $args['before_widget'];

            echo $args['before_title'] . esc_html( apply_filters( 'widget_title', $instance['title'] ) ) . $args['after_title'];

            if ( ! empty( $posts ) ) {
                $first = true;
                echo '<ul>';
                foreach ( $posts as $post ) {
                    $image = array();
                    if ( $instance['show_image'] === 'yes' ) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                    }
                    echo '<li class="prag-post-list-item' . ( $instance['show_image'] && ! empty( $image ) ? ' has-image' : ' no-image' ) . ( ( $first ) ? ' first' : '' ) .'">';
                    echo '<div class="clear">';
                    if ( $instance['show_image'] === 'yes' && ! empty( $image ) ) {
                        echo '<div class="prag-post-list-image">';
                        echo '<img src="' . esc_attr( $image[0] ) . '">';
                        echo '</div>';
                    }
                    echo '<div class="prag-post">';
                    echo '<p class="prag-post-list-title"><a href="' . esc_attr( get_permalink( $post->ID ) ) . '">' . esc_html( $post->post_title ) . '</a></p>';
                    echo '<p class="prag-post-list-excerpt">' . esc_html( ( $post->post_excerpt != '' ) ? $post->post_excerpt : wp_trim_words( $post->post_content, 10 ) )  . '<a class="prag-post-list-read-more" href="' .  esc_attr( get_permalink( $post->ID ) ) . '">Read more</a></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                    $first = false;
                }
                echo '</ul>';
            }

            echo '<a class="home-widget-more-link" href="' . esc_attr( $instance['view_url'] ) . '">' . esc_html( $instance['view_text'] ) . ' <div class="dashicons dashicons-arrow-right-alt2"></div></a>';

            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'prag_post_listing_widget' );
            $number_of_posts = ! empty( $instance['number_of_posts'] ) ? $instance['number_of_posts'] : __( '', 'prag_post_listing_widget' );
            $tag = ! empty( $instance['tag'] ) ? $instance['tag'] : __( '', 'prag_post_listing_widget' );
            $show_image = ! empty( $instance['show_image'] ) ? $instance['show_image'] : __( '', 'prag_post_listing_widget' );
            $view_text = ! empty( $instance['view_text'] ) ? $instance['view_text'] : __( '', 'prag_post_listing_widget' );
            $view_url = ! empty( $instance['view_url'] ) ? $instance['view_url'] : __( '', 'prag_post_listing_widget' );
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php _e( 'Tag:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'tag' ); ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>" type="text" value="<?php echo esc_attr( $tag ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>"><?php _e( 'Number of posts:' ); ?></label>
                <select name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>">
                    <option value="1"<?php echo ($number_of_posts == 1) ? ' selected="selected"' : ''; ?>>1</option>
                    <option value="2"<?php echo ($number_of_posts == 2) ? ' selected="selected"' : ''; ?>>2</option>
                    <option value="3"<?php echo ($number_of_posts == 3) ? ' selected="selected"' : ''; ?>>3</option>
                    <option value="4"<?php echo ($number_of_posts == 4) ? ' selected="selected"' : ''; ?>>4</option>
                    <option value="5"<?php echo ($number_of_posts == 5) ? ' selected="selected"' : ''; ?>>5</option>
                    <option value="6"<?php echo ($number_of_posts == 6) ? ' selected="selected"' : ''; ?>>6</option>
                    <option value="7"<?php echo ($number_of_posts == 7) ? ' selected="selected"' : ''; ?>>7</option>
                    <option value="8"<?php echo ($number_of_posts == 8) ? ' selected="selected"' : ''; ?>>8</option>
                    <option value="9"<?php echo ($number_of_posts == 9) ? ' selected="selected"' : ''; ?>>9</option>
                    <option value="10"<?php echo ($number_of_posts == 10) ? ' selected="selected"' : ''; ?>>10</option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Featured Image:' ); ?></label>
                <select name="<?php echo $this->get_field_name( 'show_image' ); ?>" id="<?php echo $this->get_field_id( 'show_image' ); ?>">
                    <option value="no"<?php echo ($show_image == 'no') ? ' selected="selected"' : ''; ?>>No</option>
                    <option value="yes"<?php echo ($show_image == 'yes') ? ' selected="selected"' : ''; ?>>Yes</option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'view_text' ); ?>"><?php _e( 'View More Text' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'view_text' ); ?>" name="<?php echo $this->get_field_name( 'view_text' ); ?>" type="text" value="<?php echo esc_attr( $view_text ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'view_url' ); ?>"><?php _e( 'View More URL' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'view_url' ); ?>" name="<?php echo $this->get_field_name( 'view_url' ); ?>" type="text" value="<?php echo esc_attr( $view_url ); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
            $instance['number_of_posts'] = ( ! empty( $new_instance['number_of_posts'] ) ) ? strip_tags( $new_instance['number_of_posts'] ) : '';
            $instance['show_image'] = ( ! empty( $new_instance['show_image'] ) ) ? strip_tags( $new_instance['show_image'] ) : '';
            $instance['view_text'] = ( ! empty( $new_instance['view_text'] ) ) ? strip_tags( $new_instance['view_text'] ) : '';
            $instance['view_url'] = ( ! empty( $new_instance['view_url'] ) ) ? strip_tags( $new_instance['view_url'] ) : '';

            return $instance;
        }

    } // class Prag_Post_List_Widget
}
