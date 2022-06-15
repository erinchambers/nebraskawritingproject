<?php
/*
Author: Shoofly Solutions
Plugin Name: (Simply) Guest Author Name
Slug: guest-author-name
Plugin URI: http://plugins.shooflysolutions.com/guest-author-name
Description: An ideal plugin for cross posting. Guest Author Name helps you to publish posts by authors without having to add them as users. If the Guest Author field is filled in on the post, the Guest Author name will override the author.  The optional Url link allows you to link to another web site.
Version: 4.32
Author URI: http://www.shooflysolutions.com
Copyright (C) 2015, 2016 Shoofly Solutions
Contact me at http://www.shooflysolutions.com*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
remove_filter('pre_user_description', 'wp_filter_kses');




	$path =  (plugin_dir_path(__FILE__));
	require_once( $path . 'guest-author-notices.php' );
	require_once( $path . 'sfly-guest-author-settings.php' );

	/**
	 * sfly_guest_author class.
	 */
	 if ( !class_exists( 'sfly_guest_author' ) ):

	 class sfly_guest_author
	{
		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		function __construct()
		{
			$options = get_option( 'guest_author_name_settings' );
			self::sfly_guest_author_add_filters();
			$this->comment_list = false;
			add_action('wp_enqueue_scripts', array( $this, 'sfly_guest_author_enqueue_scripts' ) );
			add_action( 'get_sidebar', array($this, 'sfly_guest_author_add_filters' ));
			$disable = isset( $options['guest_author_disable_for_comments'] ) ? true : false ;

			if ( $disable ) {
				'disable is on';
//				add_filter( 'the_content', array($this, 'sfly_guest_author_content' ) );
//				add_filter( 'get_the_excerpt', array($this, 'sfly_guest_author_excerpt' ) );
				add_filter( 'wp_list_comments_args', array( $this, 'list_comments' ) ); //manage comments

			}



			if (is_admin())
			{

					add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
					add_action( 'save_post', array( $this, 'save_meta' ), 10, 2 );
					$quickedit = isset( $options['guest_author_name_quickedit'] ) ? true : false ;
					if ( $quickedit )
					{
						add_action( 'quick_edit_custom_box', array( $this, 'add_quick_meta_box' ), 10, 2 ) ;
						add_action( 'manage_posts_custom_column', array( $this, 'render_post_columns' ), 10, 2 ) ;
						add_filter( 'manage_edit-post_columns', array( $this, 'change_posttype_columns' ) );
						add_action( 'admin_enqueue_scripts', array( $this, 'guest_admin_scripts' ) );
						//add_action( 'save_post', array ($this, 'save_quick_meta' ), 10, 3 );
					}
			}

		}

		/**
		 * sfly_guest_author_open_link function.
		 * append jQuery to existing script file
		 * @access public
		 * @return void
		 */
		function sfly_guest_author_open_link( $options ){

		//	$options = get_option( 'guest_author_name_settings' );

			$selector = esc_attr(  $options['guest_author_url_selector_single'] ) ;
			if ( $selector ) {
			$script="
						(function($) {
						var url      = window.location.href;
						var href   =  jQuery('.sfly_guest-author-post $selector' ).attr('href');


						if ( url != href ) {
						      $('.sfly_guest-author-post $selector' ).attr('target', '_blank');
						}
						})(jQuery);";
			$success = wp_add_inline_script('guest_author_post_scripts', $script);


			}

		}


		/**
		 * sfly_guest_author_enqueue_scripts function.
		 * Enqueue Scripts
		 * @access public
		 * @return void
		 */
		function sfly_guest_author_enqueue_scripts() {
			wp_enqueue_script('jquery');

			wp_enqueue_script( 'guest_author_post_scripts' ,  plugins_url('assets/guest-author-post.js', __FILE__), array('jquery'), '1.00', true);

			$options = get_option( 'guest_author_name_settings' );
			$open = isset( $options['guest_author_open_new_window'] ) ? true : false ;


			if ( $open  ) {
				$this->sfly_guest_author_open_link( $options );
			}


		}

		/**
		 * sfly_guest_author_add_filters function.
		 * Add Faliters
		 * @access public
		 * @return void
		 */
		function sfly_guest_author_add_filters() {
			$admin = isset( $options['guest_author_name_admin'] ) ? true : false ;

			if (!is_admin() || $admin || wp_doing_ajax() )
			{
				add_filter( 'the_author', array( $this, 'guest_author_name' ), 12 );
				add_filter( 'get_the_author_display_name', array( $this, 'guest_author_name' ), 12 );

			}
			if (!is_admin() || wp_doing_ajax() )
			{
				add_action ( 'ampforwp_modify_author_name', array( $this, 'guest_author_name' ), 12 );

		        add_action( 'the_post', array($this, 'register_author' ), 10);
				add_filter( 'author_link', array( $this, 'guest_author_link' ), 12 );
				add_filter( 'get_the_author_link', array( $this, 'guest_author_link' ), 12 );
				add_filter( 'get_the_author_url', array( $this, 'guest_author_link' ), 21 );
				add_filter( 'ampforwp_author_description', array( $this, 'guest_author_description_amp' ), 12 ) ;
				add_filter( 'author_description', array( $this, 'guest_author_description'), 12) ;
				add_filter( 'get_the_author_description', array( $this,  'guest_author_description' ), 12 ) ;
				add_filter( 'get_the_author_id', array( $this, 'guest_author_id' ), 12 ) ;
				add_filter( 'author_id', array( $this, 'guest_author_id' ), 12 );
				add_filter( 'get_avatar', array( $this, 'guest_author_avatar' ), 40, 5 );
				add_filter( 'get_avatar_url', array( $this, 'guest_avatar_link' ), 40, 3);
				$include = isset( $options['guest_author_include_guest'] ) ? true : false ;

				add_filter( 'wpseo_canonical', array( $this, 'guest_author_canonical_link') );
				if ( $include )
					add_action( 'pre_get_posts',     array( $this, 'author_query' ) , 50 );   //Fix query for author query without guest posts or guest author

				add_filter("td_wp_booster_module_constructor", array( $this, 'set_guest_author_ids' ), 10, 2   );
				add_action('comment_form_top', array ($this, 'sfly_guest_author_remove_filters'), 10);  //remove filters before comments form
				add_filter( 'body_class',        array( $this, 'sfly_guest_author_body_class') );            //add some classes to the body class


			}
		}
		/**
		 * sfly_guest_author_remove_filters function.
		 * Remove Filters
		 * @access public
		 * @return void
		 */
		function sfly_guest_author_remove_filters() {
				remove_action( 'the_post', array($this, 'register_author') );
				remove_filter( 'author_link', array( $this, 'guest_author_link' ) );
				remove_filter( 'get_the_author_link', array( $this, 'guest_author_link' ) );
				remove_filter( 'get_the_author_url', array( $this, 'guest_author_link' ) );
				remove_filter( 'author_description', array( $this, 'guest_author_description') ) ;
				remove_filter( 'get_the_author_description', array( $this,  'guest_author_description' ) ) ;
				remove_filter( 'get_the_author_id', array( $this, 'guest_author_id' ) ) ;
				remove_filter( 'author_id', array( $this, 'guest_author_id' ) );
				remove_filter( 'get_avatar', array( $this, 'guest_author_avatar' ) );
				remove_filter( 'get_avatar_url', array( $this, 'guest_avatar_link' ) );
				remove_filter( 'wpseo_canonical', array( $this, 'guest_author_canonical_link') );
				remove_action( 'pre_get_posts',     array( $this, 'author_query' )  );   //Fix query for author query without guest posts or guest author
				remove_filter("td_wp_booster_module_constructor", array( $this, 'set_guest_author_ids' )   );
				remove_filter( 'the_author', array( $this, 'guest_author_name' ) );
				remove_filter( 'get_the_author_display_name', array( $this, 'guest_author_name' ) );
				remove_filter( 'body_class',        array( $this, 'sfly_guest_author_body_class') );            //add some classes to the body class
		}
		function sfly_guest_author_excerpt( $content ) {
			global $authordata;
			if ( isset ($authordata) && $authordata->guest_author ) {
				$content = $content . '<label style="visibility:hidden" class="guest-author-data" data-url="' . $authordata->user_url . '" data-name="' . $authordata->display_name . '">';
			}
			return $content;
		}
		function sfly_guest_author_content( $content ) {
			global $authordata;
			if ( isset ($authordata) && $authordata->guest_author ) {
				$content = $content . '<label style="visibility:hidden" id="guest-author-data" data-url="' . $authordata->user_url . '" data-name="' . $authordata->display_name . '">';
			}
			return $content;
		}
		/**
		 * guest_author_canonical_link function.
		 * Handle paging
		 * @access public
		 * @param mixed $url
		 * @return void
		 */
		function guest_author_canonical_link ($url)
		{
			global $wp;


			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if ( $paged > 1 ) {

				$current_url = home_url( add_query_arg( array(), $wp->request ) );
				if ($url != $current_url)
					return $current_url;
			}
			return $url;

		}

		/**
		 * list_comments function.
		 * disable guest author functions for comment list
		 * add hooks to ensure that the correct comment author & link
		 * @access public
		 * @param array $r  - arguments not changed)
		 * @return void
		 */
		function list_comments($r)
		{

			$this->comment_list = true;
			self::sfly_guest_author_remove_filters();
			global $guest_author_post_id;

			if ( $guest_author_post_id != null )
			{

				add_filter( 'get_comment_author', array( $this, 'comment_author' ), 99, 3);
				add_filter( 'get_comment_author_link', array( $this, 'comment_author_link' ), 99, 3 );
			}
			return $r;

		}
		/**
		 * comment_author function.
		 * get the original comment author which can be overriden when it's a guest author post.
		 * @access public
		 * @param string $author - author name
		 * @param int $comment_ID - comment id
		 * @param object $comment
		 * @return void
		 */
		function comment_author( $author, $comment_ID, $comment )
		{
			if ( $author != $comment->author )
				return $comment->comment_author;
			else
				return $author;



		}
		/**
		 * comment_author_link function.
		 *
		 * @access public
		 * @param mixed $return
		 * @param mixed $author  - author name
		 * @param mixed $comment_ID  - comment id
		 * @return void
		 */
		function comment_author_link( $return, $author, $comment_ID )
		{

		   $comment = get_comment( $comment_ID );
		   if ( $author != $comment->author ) {
			   $url = $comment->comment_author_url;


			   if ( empty( $url ) || 'http://' == $url ) {
			        $return = $author;
			   } else {
			        $return = "<a href='$url' rel='external nofollow' class='url'>$author</a>";
			   }
		   }
		   return $return;
    	}
		/**
		 * is_classic_editor_plugin_active function.
		 * check to see if the classic editor is active
		 * @access public
		 * @return void
		 */
		function is_classic_editor_plugin_active() {
		    if ( ! function_exists( 'is_plugin_active' ) ) {
		        include_once ABSPATH . 'wp-admin/includes/plugin.php';
		    }

		    if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
		        return true;
		    }

		    return false;
		}
		/**
		 * sfly_guest_author_body_class function.
		 * Add a class to the post body
		 * @access public
		 * @param mixed $classes
		 * @return void
		 */
		function sfly_guest_author_body_class ($classes) {
			global $post;
			if ( is_single() ) {
			$author = get_post_meta( $post->ID, 'sfly_guest_author_names', true );
	        if ($author)

				$classes[] = 'sfly_guest-author-post';
		    }
		    return $classes;
		}
		/**
		 * register_author function.
		 * register the author data for the current post being edited
		 * @access public
		 * @return void
		 */
		function register_author() {
			$id = $this->get_post_id();
			$gauthor = get_post_meta( $id, 'sfly_guest_author_names', true );
			$guest_author_post_id = null;
	        if (!$gauthor)
	            return;

			global $authordata, $post, $guest_author_post_id;
			$guest_author_post_id = $post->ID;
			$author = new WP_User();

			$author->user_url = $this->guest_author_link('');
			$author->user_email = $this->guest_author_email('');
			$author->user_description = $this->guest_author_description('');
			$author->display_name = $this->guest_author_name('');
			$author->ID = $this->guest_author_id('');
			$author->guest_author = true;

			// register the global
			$authordata = $author;

		}

		/**
		 * guest_admin_scripts function.
		 * enqueue scripts
		 * @access public
		 * @param string $hook
		 * @return void
		 */
		function guest_admin_scripts( $hook )
		{

			if ( $hook == 'edit.php' ) {
				wp_enqueue_script('guest_author_name_scripts', plugins_url('assets/guest-author.js', __FILE__), array('inline-edit-post'), '1.00');

			}

		}
		/**
		 * guest_author_id function.
		 * get the author id
		 * @access public
		 * @param number $id
		 * @return the author id or null if it's a guest author
		 */
		function guest_author_id( $id ) {
			$id = $this->get_post_id();
			$author = get_post_meta( $id, 'sfly_guest_author_names', true );
			if ( $author )
				$id = NULL;
			return $id;
		}

		/**
		 * author_query function.
		 *
		 * @access public
		 * @param mixed $query
		 * @return void
		 */
		function author_query( $query ) {
			if ( $query->is_author )
			{
				$meta_query = $query->get('meta_query');
				if ( is_string($meta_query) )
				{
					if ($meta_query == '' )
						$meta_query = array();
					else
						$meta_query = array ( $meta_query );
				}
				//Add our meta query to the original meta queries
				$meta_query['relation'] = "OR";
				$meta_query[] =  array(
					'key'     => 'sfly_guest_author_names',
					'compare' => 'NOT EXISTS',
					'value' => ''
				);
				$meta_query[] =  array(
					'key'     => 'sfly_guest_author_names',
					'compare' => '=',
					'value' => ''
				);
				$query->set('meta_query',$meta_query);
			}

			return $query;
		}


		/**
		 * guest_author_name function.
		 * get the guest author name if one exists
		 * @access public
		 * @param string $name
		 * @return name to be displayed as the author name
		 */
		function guest_author_name( $name ) {
			$id = $this->get_post_id();
			$author = get_post_meta( $id, 'sfly_guest_author_names', true );
			if ( $author )
				$name = $author;
			return $name;
		}
		/**
		 * guest_author_link function.
		 * get the guest author url if one exists
		 * @access public
		 * @param string $link - real author link
		 * @return string
		 */
		function guest_author_link( $link ) {
			$id = $this->get_post_id();
			$author = get_post_meta( $id, 'sfly_guest_author_names', true );
			if ( $author )
			{
				$link = get_post_meta( $id, 'sfly_guest_link', true );
				if (!$link)
					$link = "";
			}
			return $link;
		}
		/**
		 * guest_author_description function.
		 * get the guest author bio if it exists
		 * @access public
		 * @param string $description - real author bio
		 * @return string
		 */
		function guest_author_description( $description ) {
			$id = $this->get_post_id();
			$author = get_post_meta( $id, 'sfly_guest_author_names', true );
			if ( $author )
			{
				$options = get_option( 'guest_author_name_settings' );
				$allowhtml = isset( $options['guest_author_allow_html'] ) ? true : false ;

				if ( $allowhtml )
					$description =  html_entity_decode(get_post_meta( $id, 'sfly_guest_author_description', true ) );
				else
					$description =   get_post_meta( $id, 'sfly_guest_author_description', true ) ;

				if (!$description)
					$description = "";
			}
			return $description;
		}
		/**
		 * guest_author_description function.
		 * get the guest author bio if it exists
		 * @access public
		 * @param string $description - real author bio
		 * @return string
		 */
		function guest_author_description_amp( $description ) {

			$new_description = $this->guest_author_description($description);
			$pattern = "/<p[^>]*><\\/p[^>]*>/"; // regular expression
			$description = preg_replace($pattern, '', $description);

			if ( $new_description != $description ) {
				$description = '<p>' . $new_description . '</p>';
			}

			return $description;
		}
		/**
		 * guest_author_email function.
		 * get the guest author email if one exists
		 * @access public
		 * @param string $email - real author email
		 * @return string
		 */
		function guest_author_email( $email ) {
			$id = $this->get_post_id();
			$author = get_post_meta( $id, 'sfly_guest_author_names', true );
			if ( $author )
			{
				$email = get_post_meta( $id, 'sfly_guest_author_email', true );
				if (!$email)
					$email = "";
			}
			return $email;
		}
		/**
		 * guest_author_avatar function.
		 * get the guest author avatar image html
		 * @access public
		 * @param string $avatar - real author avatar
		 * @return avatar html
		 */
		function guest_author_avatar( $avatar, $id_or_email, $size, $default, $alt )

		{

			global $guest_author_post_id;
			if ( (!isset( $guest_author_post_id) ||  $guest_author_post_id <= 0 ) ) {
				return $avatar;
			}

			global $comment;



			if ( isset( $comment )  && $this->comment_list) {
				$email = $comment->comment_author_email;
				if ( $email ) {
					//$image_path = $this->get_guest_gravatar($email);
					$avatar = $this->guest_author_avatar_url_link( $avatar, $email) ; // '<img src="'.$image_path.'" width="'.$size.'" height="'.$size.'" />';
				} else {
					$avatar = $default;
				}


			} else {
				$id = $this->get_post_id();

				$author = get_post_meta( $id, 'sfly_guest_author_names', true );

				if ( $author )
				{
					$email = get_post_meta( $id, 'sfly_guest_author_email', true );


					if ( $email ) {
					//	$image_path = $this->get_author_avatar($email);
						$avatar =  $this->guest_author_avatar_url_link( $avatar, $email);// '<img src="'.$image_path.'" width="'.$size.'" height="'.$size.'" />';
					}

				}
			}

			return $avatar;
		}

		/**
		 * guest_avatar_link function.
		 *
		 * @access public
		 * @param mixed $email
		 * @param array $args (default: array())
		 * @return void
		 */
		function guest_avatar_link( $url, $email, $args = array() ) {

			global $guest_author_post_id;
			global $comment;
			if ( isset( $comment ) &&  $this->comment_list ) {
				$cemail = $comment->comment_author_email;
				if ($cemail) {
					$url = $this->get_guest_gravatar_link($cemail);
				}
			}
			else {
				$id = $this->get_post_id();

				$author = get_post_meta( $id, 'sfly_guest_author_names', true );

				if ( $author )
				{
					$email = get_post_meta( $id, 'sfly_guest_author_email', true );
					if ($email) {
						$url = $this->get_guest_gravatar_link($email);
					}
				}


			}
			return $url;
		}

		/**
		 * guest_author_avatar_url_link function.
		 * get the avatar url with link
		 * @access public
		 * @param mixed $url
		 * @param mixed $email
		 * @param array $args (default: array())
		 * @return void
		 */
		function guest_author_avatar_url_link( $url, $email, $args = array() )

		{

			global $guest_author_post_id;

			if ( !isset( $guest_author_post_id ) || $guest_author_post_id <= 0) {
				return $url;
			}
			global $comment;

			if ( isset( $comment ) &&  $this->comment_list ) {
				$cemail = $comment->comment_author_email;
				if ($cemail) {

					$avatar_url = $this->get_guest_gravatar_link($cemail);

				}

			}
			else {
				$id = $this->get_post_id();

				$author = get_post_meta( $id, 'sfly_guest_author_names', true );

				if ( $author )
				{
					$email = get_post_meta( $id, 'sfly_guest_author_email', true );

					if ($email) {
						$avatar_url = $this->get_guest_gravatar_link($email);

					}
				}


			}

			if ( isset ( $avatar_url ) ) {
				$avatar_url = "'" . $avatar_url . "'";

				$html = preg_replace('/<a href="(http:\/\/)?[\w.]+\/([\w]+)"\s?>/',  $avatar_url ,$url);

				return $html;
			}
			else  {
				return $url;
			}
		}
		/**
		 * get_guest_gravatar function.
		 *
		 * @access public
		 * @param mixed $email
		 * @param int $s (default: 80)
		 * @param string $d (default: 'mm')
		 * @param string $r (default: 'g')
		 * @param bool $img (default: false)
		 * @param array $atts (default: array())
		 * @return void
		 */
		function get_guest_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {

			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $email ) ) );

			$url .= "?s=$s&d=$d&r=$r";
			if ( $img ) {
				$url = '<img src="' . $url . '"';
				foreach ( $atts as $key => $val )
					$url .= ' ' . $key . '="' . $val . '"';
				$url .= ' />';
			}

			return $url;
		}

				/**
		 * get_guest_gravatar_link function.
		 *
		 * @access public
		 * @param mixed $email
		 * @param int $s (default: 80)
		 * @param string $d (default: 'mm')
		 * @param string $r (default: 'g')
		 * @param bool $img (default: false)
		 * @param array $atts (default: array())
		 * @return void
		 */
		function get_guest_gravatar_link( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
			$link = 'http://www.gravatar.com/avatar/';
			$link .= md5( strtolower( trim( $email ) ) );

			$link .= "?s=$s&d=$d&r=$r";


			return $link;
		}
		/**
		 * get_post_id function.
		 * get the post id for the current post
		 * @access public
		 * @return void
		 */
		function get_post_id()
		{
			global $post;
			global $post_id;
			if (isset($post))
				$id = $post->ID;
			elseif (isset($post_id))
				$id = $post_id;
			else
				$id = NULL;
			return $id;
		}
		/**
		 * Adds the meta box container.
		 */
		/**
		 * add_meta_box function.
		 *
		 * @access public
		 * @param mixed $post_type
		 * @return void
		 */
		public function add_meta_box( $post_type ) {
			$post_types = array('post', 'page');	 //limit meta box to certain post types
			if ( in_array( $post_type, $post_types )) {
				add_meta_box(
					'some_meta_box_name'
					,__( 'Guest Author', 'sfly_guest_author' )
					,array( $this, 'render_meta_box_content' )
					,$post_type
					,'advanced'
					,'high'
				);
			}
		}

		/**
		 * change_posttype_columns function.
		 * captions for the post list
		 * @access public
		 * @param mixed $cols
		 * @return void
		 */
		function change_posttype_columns( $cols ) {
			$cols2 = array(
				'sfly_guest_author' => 'Guest Author',
				'sfly_guest_link' => 'Guest Link',
				'sfly_guest_author_description' => 'Guest Description',
				'sfly_guest_author_email' => 'Guest Email',

			);
			$cols = array_merge($cols, $cols2);
			return $cols;
		}

		// But remove it again on the edit screen (other screens to?)

		/**
		 * remove_dummy_column function.
		 *
		 * @access public
		 * @param mixed $cols
		 * @return void
		 */
		function remove_dummy_column($cols)
		{
			unset($cols['sfly_guest_author']);
			unset($cols['sfly_guest_link']);
			unset($cols['sfly_guest_author_description']);
			unset($cols['sfly_guest_author_email']);
			return $cols;
		}

		/**
		 * render_post_columns function.
		 * output the post column data for the list
		 * @access public
		 * @param mixed $column_name

		 * @param mixed $id
		 * @return void
		 */
		function render_post_columns($column_name, $id) {

			switch ($column_name) {
			case 'sfly_guest_author':
				echo get_post_meta( $id, 'sfly_guest_author_names', TRUE);
				break;
			case 'sfly_guest_link':
				echo get_post_meta( $id, 'sfly_guest_link', TRUE);
				break;
			case 'sfly_guest_author_description':
				echo get_post_meta( $id, 'sfly_guest_author_description', TRUE);
				break;
			case 'sfly_guest_author_email':
				echo get_post_meta( $id, 'sfly_guest_author_email', TRUE);


			}
		}

		/**
		 * save_quick_meta function.
		 * save the data from the quick edit screen
		 * @access public
		 * @param mixed $post_id
		 * @return void
		 */
		function save_quick_meta( $post_id, $post ) {

			$post_types = array('post', 'page');	 //limit meta box to certain post types
			if ( in_array( $post_type, $post_types )) {
				if ( $printNonce ) {
					$printNonce = FALSE;
					wp_nonce_field( plugin_basename( __FILE__ ), 'guest_author_edit_nonce' );
				}
				if ( !current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
				if ( isset( $_REQUEST['sfly_guest_author'] ) ) {
					update_post_meta( $post_id, 'sfly_guest_author', $_REQUEST['sfly_guest_author'] );
				}
				if ( isset( $_REQUEST['sfly_guest_link'] ) ) {
					update_post_meta( $post_id, 'sfly_guest_link', $_REQUEST['sfly_guest_link'] );
				}
				if ( isset( $_REQUEST['sfly_guest_author_description'] ) ) {
					update_post_meta( $post_id, 'sfly_guest_author_description', $_REQUEST['sfly_guest_author_description'] );
				}
				if ( isset( $_REQUEST['sfly_guest_author_email'] ) ) {
					update_post_meta( $post_id, 'sfly_guest_author_email', $_REQUEST['sfly_guest_author_email'] );
				}
			}
		}

		/**
		 * add_quick_meta_box function.
		 * create the quick edit screen
		 * @access public
		 * @param mixed $col

		 * @param mixed $post_type
		 * @return void
		 */
		public function add_quick_meta_box( $col,  $post_type ) {
			static $printNonce = TRUE;
			$post_types = array('post', 'page');	 //limit meta box to certain post types
			if ( in_array( $post_type, $post_types )) {
				if ( $printNonce ) {
					wp_nonce_field( 'sfly_guest_author_box', 'sfly_guest_author_nonce' );
					$printNonce = FALSE;
					//	wp_nonce_field( plugin_basename( __FILE__ ), 'guest_author_edit_nonce' );
				}
	?>


			<?php
				switch ( $col ) {
				case 'sfly_guest_author':
					?><fieldset class="inline-edit-col-right inline-edit-book">
		  <div class="inline-edit-col column-<?php echo $col; ?>" style="display:block; border:1px;">
			<label class="inline-edit-group"><div style='display:block'><span class="sfly_guest_author" style="width:150px;">Guest Author Name(s)</span><input name="sfly_guest_author" class="widefat" /></div></label><?php
					break;
				case 'sfly_guest_link':
					?><label  class="inline-edit-group"><div style="display:block"><span class="sfly_guest_link" style="width:150px;">Guest URL</span><input name="sfly_guest_link" class="widefat" /></div></label><?php
					break;
				case 'sfly_guest_author_description':
					?><label class="inline-edit-group"><div style="display:block"><span class="sfly_guest_author_description" style="width:150px;">Author Bio / Description</span><input name="sfly_guest_author_description" class="widefat" /></div></label><?php
					break;
				case 'sfly_guest_author_email':
					?><label class="inline-edit-group"><div style="display:block"><span class="sfly_guest_author_email" style="width:150px;">Author Gravatar Email</span><input name="sfly_guest_author_email" class="widefat" /></div>
			</div></label>
		  </div>
		</fieldset><?php
					break;
				}
	?>
		<?php
			}
		}
		/**
		 * Save the meta when the post is saved.
		 *
		 * @param int $post_id The ID of the post being saved.
		 */
		/**
		 * save function.
		 *
		 * @access public
		 * @param mixed $post_id
		 * @return void
		 */
		public function save_meta( $post_id, $post ) {

			if ( ! isset( $_POST['sfly_guest_author_nonce'] ) )
				return $post_id;
			$nonce = $_POST['sfly_guest_author_nonce'];
			if ( ! wp_verify_nonce( $nonce, 'sfly_guest_author_box' ) )
				return $post_id;
			// If this is an autosave, our form has not been submitted,
			//	 so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			// Check the user's permissions.
			if ( 'page' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
					return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
					return $post_id;
			}
			// Sanitize the user input.
			$author = sanitize_text_field( $_POST['sfly_guest_author'] );
			$link = esc_url($_POST['sfly_guest_link']);

					$options = get_option( 'guest_author_name_settings' );
					$allowhtml = isset( $options['guest_author_allow_html'] ) ? true : false ;

			if ($allowhtml)
				$description = htmlentities(  $_POST['sfly_guest_author_description'] );
			else
				$description = sanitize_text_field( $_POST['sfly_guest_author_description']);

			$email = sanitize_email( $_POST['sfly_guest_author_email'] );
			// Update the meta field.
			update_post_meta( $post_id, 'sfly_guest_author_names', $author );
			update_post_meta( $post_id, 'sfly_guest_link', $link);
			update_post_meta( $post_id, 'sfly_guest_author_description', $description);
			update_post_meta( $post_id, 'sfly_guest_author_email', $email);
		}

		 /* render_meta_box_content function.
		 *
		 * @access public
		 * @param mixed $post
		 * @return void
		 */
		/**
		 * render_meta_box_content function.
		 *
		 * @access public
		 * @param mixed $post
		 * @return void
		 */
		public function render_meta_box_content( $post ) {
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'sfly_guest_author_box', 'sfly_guest_author_nonce' );
			// Use get_post_meta to retrieve an existing values from the database.
			$value = get_post_meta( $post->ID, 'sfly_guest_author_names', true );
			$link = get_post_meta( $post->ID, 'sfly_guest_link', true );
			$description = get_post_meta($post->ID, 'sfly_guest_author_description', true);
			$email = get_post_meta($post->ID, 'sfly_guest_author_email', true);
			// Display the form, using the current values.
			echo '<label for="sfly_guest_author">';
			_e( 'Guest Author Name(s)', 'sfly_guest_author' );
			echo '</label> ';
			echo '<input type="text" id="sfly_guest_author" name="sfly_guest_author"';
			echo ' value="' . esc_attr( $value ) . '" style="max-width:100%" size="150" class="widefat" />';
			echo '<br/><label for="sfly_guest_link">';
			_e( 'Guest URL', 'sfly_guest_link' );
			echo '</label><br/>';
			echo '<input type="text" id="sfly_guest_link" name="sfly_guest_link"';
			echo ' value="' . esc_url( $link ) . '" style="max-width:100%" class="widefat"  />';
			echo '<br/><label for="sfly_guest_description">';
			_e( 'Guest Description', 'sfly_guest_description' );
			echo '</label><br/> ';
			echo '<textarea id="sfly_guest_author_description" name="sfly_guest_author_description" style="width:100%;height:40px;">' . esc_attr($description) . '</textarea>';
			echo '<label for="sfly_guest_author_email">';
			_e( 'Guest Gravatar Email', 'sfly_guest_author_email' );
			echo '</label> ';
			echo '<input type="text" id="sfly_guest_author_email" name="sfly_guest_author_email"';
			echo ' value="' . esc_attr( $email ) . '" style="max-width:100%" class="widefat" size="150" />';
		}
			/****Functions for tag_div only ***/


		function set_guest_author_ids($module, $post) {
				if ( isset( $post ) ) {
					global $g_post_id;
					$g_post_id = $post->ID;
					add_filter('author_link', array( $this, 'tag_div_author' ), 99);
					add_filter( 'get_the_author_display_name', array( $this, 'tag_div_display_name' ), 99 );

				}
				else
				{
					$g_post_id = nulll;
					remove_filter('author_link', array( $this, 'tag_div_author' ), 99);
					remove_filter( 'get_the_author_display_name', array( $this, 'tag_div_display_name' ), 99 );
				}

		    }
		function tag_div_display_name( $name )
		{
			global $g_post_id;
			if ( isset(  $g_post_id ) &&  $g_post_id > 0 )
			{
			$author = get_post_meta( $g_post_id, 'sfly_guest_author_names', true );
			if ( $author )
				$name = $author;
			}
			return $name;


		}

		function tag_div_author($link, $authorid=null)
		{
			global $g_post_id;

			if ( isset ( $g_post_id ) && $g_post_id  > 0 ) {
				$author = get_post_meta( $g_post_id, 'sfly_guest_author_names', true );
				if ( $author )
				{
					$link = get_post_meta( $g_post_id, 'sfly_guest_link', true );
					if (!$link)
						$link = "";
				}

			}
			return $link;

		}
	}
endif;

	// Admin Settings



	new sfly_guest_author();