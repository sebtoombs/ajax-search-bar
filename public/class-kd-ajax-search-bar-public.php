<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://kingsdesign.com.au
 * @since      1.0.0
 *
 * @package    Kd_Ajax_Search_Bar
 * @subpackage Kd_Ajax_Search_Bar/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kd_Ajax_Search_Bar
 * @subpackage Kd_Ajax_Search_Bar/public
 * @author     KingsDesign <seb@kingsdesign.com.au>
 */
class Kd_Ajax_Search_Bar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kd_Ajax_Search_Bar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kd_Ajax_Search_Bar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kd-ajax-search-bar-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kd_Ajax_Search_Bar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kd_Ajax_Search_Bar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kd-ajax-search-bar-public.js', array( 'jquery' ), null, true );
        wp_localize_script( $this->plugin_name, 'kd_ajax_search', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	public function add_shortcode() {
	    add_shortcode('kd_ajax_search_bar', array($this, 'do_shortcode'));
    }

    public function do_shortcode($atts) {
	    $atts = shortcode_atts(array(), $atts);

	    extract($atts);
	    ob_start();
	    include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/kd-ajax-search-bar-public-display.php';
	    return ob_get_clean();
    }


	public function load_search_results() {
        $search_query = $_POST['query'];

        $isSKUQuery = preg_match('/^\d{3}\.?[\d\.]+?$/', $search_query);

        $args = array(
            's' => $search_query,
            'posts_per_page' =>9, //get 9 results, return 8. this way we know if there are more
            //'post_type'=>['product']
        );
        $query = new WP_Query();
        $query->parse_query( $args );
        relevanssi_do_query( $query );

        $posts = array_map(function($p) {
            $p =  (array) $p;
            $p['thumbnail'] = get_the_post_thumbnail_url($p['ID'], 'thumbnail');
            $p['permalink'] = get_the_permalink($p['ID']);
            return $p;
        }, $query->posts);

        $has_more = count($posts)>8;
        $posts = $has_more ? array_slice($posts, 0, 8) : $posts;

        $data = [
            'posts'=>$posts,
            'view_all'=>apply_filters('kd-ajax-search__view_all_link', home_url() . '?s='.urlencode($search_query), $search_query),
            'has_more'=>$has_more
        ];

        wp_send_json($data);
        exit;


        /*$post_types = ['product', 'product_cat'];
        if($isSKUQuery) $post_types[] = 'product_variation';

        $args = array(
            'post_type' => $post_types,
            'post_status' => 'publish',
            's' => $query,
            'posts_per_page'=>8
        );
        $search = new WP_Query($args);

        $posts = relevanssi_do_query( $search );

        //if($search->have_posts()){
        if(!empty($posts)) {

            //$posts = $search->posts;

            usort($posts, function($a, $b) {
                $typeA = get_post_type($a);
                $typeB = get_post_type($b);
                if(strcmp($typeA, 'product') == 0) return -1;
                if(strcmp($typeB, 'product') == 0 ) return 1;
                if(strcmp($typeA, 'product_variation') == 0) return -1;
                if(strcmp($typeB, 'product_variation') ==0) return 1;
                return 0;
            });

            $posts = array_map(function($p) {
                $p =  (array) $p;
                $p['thumbnail'] = get_the_post_thumbnail_url($p['ID'], 'thumbnail');
                $p['permalink'] = get_the_permalink($p['ID']);

                if(strcmp(get_post_type($p['ID']), 'product_variation') == 0) {
                    $variation = wc_get_product($p['ID']);
                    $p['variation_name'] = $variation->get_name(). ' ('.$variation->get_sku().')';
                }
                return $p;
            }, $posts);
            wp_send_json($posts);
        } else {
            wp_send_json([]);
        }
        exit;*/
    }
}
