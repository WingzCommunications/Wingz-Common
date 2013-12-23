if( ! function_exists( 'wingz_single_post_share_bar' ) ) {
    function wingz_single_post_share_bar() {
        global $post;

        $post_id = get_the_ID();

        //Get & encode post permalink
        $url = get_permalink( $post_id );
        $encoded_url = urlencode( $url );

        //Get & encode site URL
        $site_url = get_site_url();
        $encoded_site_url = urlencode( $site_url );

        //Get & encode post title
        $title = $post->post_title;
        $encoded_title = urlencode( $title );

        //Get & encode post image
        $image = woo_image( 'link=url&return=true' );
        if( isset( $image ) && strlen( $image ) > 0 ) {
            $encoded_image = urlencode( $image );
        }

        //Get & encode post excerpt
        $excerpt = get_the_excerpt( $post_id );
        $encoded_excerpt = urlencode( $excerpt );

        //Get post type label
        $post_type = get_post_type( $post_id );
        $post_type_obj = get_post_type_object( $post_type );
        $post_type_label = $post_type_obj->labels->singular_name;

        $links = array(
            array( 'name' => __( 'Twitter', 'wingz' ), 'class' => 'twitter', 'url' => 'https://twitter.com/intent/tweet?original_referer=' . $encoded_site_url . '&text=' . $encoded_title . '&url=' . $encoded_url ),
            array( 'name' => __( 'Facebook', 'wingz' ), 'class' => 'facebook', 'url' => 'http://www.facebook.com/share.php?u=' . $encoded_url ),
            array( 'name' => __( 'Technorati', 'wingz' ), 'class' => 'technorati', 'url' => 'http://technorati.com/faves?sub=addfavbtn&add=' . $encoded_url ),
            array( 'name' => __( 'Reddit', 'wingz' ), 'class' => 'reddit', 'url' => 'http://www.reddit.com/submit?url=' . $encoded_url . '&title=' . $encoded_title ),
            array( 'name' => __( 'Delicious', 'wingz' ), 'class' => 'delicious', 'url' => 'http://delicious.com/post?url=' . $encoded_url )
        );

        //Pinterest requires an image
        if( isset( $encoded_image ) ) {
            $links[] = array( 'name' => __( 'Pinterest', 'wingz' ), 'class' => 'pinterest' , 'url' => 'http://pinterest.com/pin/create/button/?url=' . $encoded_url . '&media=' . $encoded_image . '&description=' . $encoded_excerpt );
        }

        $links = (array) apply_filters('woo_single_post_share_bar_links', $links);

        $html = '<div class="post-share-bar">
					<ul>
						<li class="share_title">' . apply_filters( 'wingz_single_post_share_bar_title' , sprintf( __( 'Share this %s:', 'wingz' ) , $post_type_label ) ) . ' </li>' . "\n";
        foreach( $links as $link ) {
            $html .= '<li class="' . esc_attr( $link['class'] ) . '"><a target="_blank" title="' . sprintf( esc_attr__( 'Share on %s' , 'wingz' ) , $link['name'] ) . '" href="' . esc_url( $link['url'] ) . '">' . $link['name'] . '</a></li>' . "\n";
        }

        $html .= '</ul>
				</div>';

        echo apply_filters( 'wingz_single_post_share_bar_output' , $html , $links );
    } // End wingz_single_post_share_bar()
}
