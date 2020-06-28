<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
/*
Plugin Name:OKCOM Sort and Show ID Slug Thumbnails
Plugin URI:https://www.ok-computer.jp/wordpress/plugin/
Description:With sorting function, ID, slug, thumbnail, and character count are displayed.
Version:1.00
Author:OK COMPUTER
Author URI:https://www.ok-computer.jp
Domain Path: /languages
Text Domain:OkcomSortnShowIdSlugThumbnails
*/

if( !class_exists( 'Okcom_Sort_And_Show_Id_Slug_Thumbnails' )){
	class Okcom_Sort_And_Show_Id_Slug_Thumbnails{

		const DOMAIN = "OkcomSortnShowIdSlugThumbnails";

		public function __construct(){

			load_plugin_textdomain(self::DOMAIN, false, basename( dirname( __FILE__ ) ).'/languages' );

			// =================================================
			// Hook in Construct
			//==================================================

			//posts hook
			add_filter( 'manage_posts_columns' , array( $this, 'add_posts_columns' ) );
			add_action( 'manage_posts_custom_column' , array( $this, 'add_posts_columns_row'), 10, 2 );
			add_filter( 'manage_edit-post_sortable_columns', array( $this, 'sort_posts_columns' ) );

			//pages hook
			add_filter( 'manage_pages_columns' , array( $this, 'add_pages_columns' ) );
			add_action( 'manage_pages_custom_column' , array( $this, 'add_pages_columns_row'), 10, 2 );
			add_filter( 'manage_edit-page_sortable_columns', array( $this, 'sort_pages_columns' ) );

			//media hook
			add_filter( 'manage_media_columns' , array( $this, 'add_media_columns' ) );
			add_action( 'manage_media_custom_column' , array( $this, 'add_media_columns_row'), 10, 2 );
			add_filter( 'manage_upload_sortable_columns', array( $this, 'sort_media_columns' ) );

			//comment hook
			add_filter( 'manage_edit-comments_columns' , array( $this, 'add_comment_columns' ) );
			add_action( 'manage_comments_custom_column' , array( $this, 'add_comments_columns_row'), 10, 2 );
			add_filter( 'manage_edit-comments_sortable_columns', array( $this, 'sort_comment_columns' ) );

			//category hook
			add_filter( 'manage_edit-category_columns' , array( $this, 'add_category_columns' ) );
			add_action( 'manage_category_custom_column' , array( $this, 'add_category_columns_row'), 10, 3 );
			add_filter( 'manage_edit-category_sortable_columns', array( $this, 'sort_category_columns' ) );

			//tag hook
			add_filter( 'manage_edit-post_tag_columns' , array( $this, 'add_post_tag_columns' ) );
			add_action( 'manage_post_tag_custom_column' , array( $this, 'add_post_tag_columns_row'), 10, 3 );
			add_filter( 'manage_edit-post_tag_sortable_columns', array( $this, 'sort_post_tag_columns' ) ) ;
		}


		// =================================================
		// posts
		//==================================================

		//index
		public function add_posts_columns($columns) {
			$columns['thumbnail'] = __( 'Thumbnail', 'DOMAIN' );
			$columns['postid'] = 'ID';
			$columns['slug'] = __( 'Slug', 'DOMAIN' );
			$columns['count'] = __( 'Count', 'DOMAIN' );

			wp_register_style( 'showthumbstyle', plugins_url('css/style.css', __FILE__ ) );
			wp_enqueue_style( 'showthumbstyle' );

			return $columns;
		}

		//column row
		public function add_posts_columns_row($column_name, $post_id) {
			if ( 'thumbnail' == $column_name ) {
				$thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
				echo ( $thumb ) ? $thumb : '－';
			} elseif ( 'postid' == $column_name ) {
		        echo $post_id;
			} elseif ( 'slug' == $column_name ) {
				$slug = get_post($post_id) -> post_name;
		        echo $slug;
		    } elseif ( 'count' == $column_name ) {
		        $count = mb_strlen(strip_tags(get_post_field('post_content', $post_id)));
		        echo $count;
		    }
		}

		//sort
		function sort_posts_columns($columns) {
			$columns['postid'] = 'ID';
			$columns['slug'] = __( 'Slug', 'DOMAIN' );
			$columns['count'] = __( 'Count', 'DOMAIN' );
			return $columns;
		}


		// =================================================
		// pages
		//==================================================

		//index
		public function add_pages_columns($columns) {

			$columns['thumbnail'] = __( 'Thumbnail', 'DOMAIN' );
			$columns['postid'] = 'ID';
			$columns['slug'] = __( 'Slug', 'DOMAIN' );

			wp_register_style( 'showthumbstyle', plugins_url('css/style.css', __FILE__ ) );
			wp_enqueue_style( 'showthumbstyle' );

			return $columns;
		}

		//column row
		public function add_pages_columns_row($column_name, $post_id) {
			if ( 'thumbnail' == $column_name ) {
				$thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
				echo ( $thumb ) ? $thumb : '－';
			} elseif ( 'postid' == $column_name ) {
						echo $post_id;
			} elseif ( 'slug' == $column_name ) {
				$slug = get_post($post_id) -> post_name;
						echo $slug;
			}
		}

		//sort
		function sort_pages_columns($columns) {
			$columns['postid'] = 'ID';
			$columns['slug'] = __( 'Slug', 'DOMAIN' );
			return $columns;
		}


		// =================================================
		// media
		//==================================================

		//index
		public function add_media_columns($columns) {

			$columns['postid'] = 'ID';

			wp_register_style( 'showthumbstyle', plugins_url('css/style.css', __FILE__ ) );
			wp_enqueue_style( 'showthumbstyle' );

			return $columns;
		}

		//column row
		public function add_media_columns_row($column_name, $post_id) {
			if ( 'postid' == $column_name ) {
		        echo $post_id;
			}
		}

		//sort
		function sort_media_columns($columns) {
			$columns['postid'] = 'ID';
			return $columns;
		}


		// =================================================
		// comment
		//==================================================

		//index
		public function add_comment_columns($columns) {

			$columns['postid'] = 'ID';

			wp_register_style( 'showthumbstyle', plugins_url('css/style.css', __FILE__ ) );
			wp_enqueue_style( 'showthumbstyle' );

			return $columns;
		}

		//column row
		public function add_comments_columns_row($column_name, $post_id) {
			if ( 'postid' == $column_name ) {
		        echo $post_id;
			}
		}

		//sort
		function sort_comment_columns($columns) {
			$columns['postid'] = 'ID';
			return $columns;
		}


		// =================================================
		// category
		//==================================================

		//index
		public function add_category_columns($columns) {

			$columns['postid'] = 'ID';

			wp_register_style( 'showthumbstyle', plugins_url('css/style.css', __FILE__ ) );
			wp_enqueue_style( 'showthumbstyle' );

			return $columns;
		}

		//column row
		public function add_category_columns_row($content, $column_name, $term_id) {
			if ( 'postid' == $column_name ) {
		        echo $term_id;
			}
		}

		//sort
		function sort_category_columns($columns) {
			$columns['postid'] = 'ID';
			return $columns;
		}


		// =================================================
		// tag
		//==================================================

		//index
		public function add_post_tag_columns($columns) {

			$columns['postid'] = 'ID';

			wp_register_style( 'showthumbstyle', plugins_url('css/style.css', __FILE__ ) );
			wp_enqueue_style( 'showthumbstyle' );

			return $columns;
		}

		//column row
		public function add_post_tag_columns_row($content, $column_name, $term_id) {
			if ( 'postid' == $column_name ) {
		        echo $term_id;
			}
		}

		//sort
		function sort_post_tag_columns($columns) {
			$columns['postid'] = 'ID';
			return $columns;
		}

	}
}

$Okcom_Sort_And_Show_Id_Slug_Thumbnails = new Okcom_Sort_And_Show_Id_Slug_Thumbnails();

?>
