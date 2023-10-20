<?php
// Page Banner for all pages and posts (ACF) 
function pageBanner($args = NULL) {
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    if (!isset($arg['photo'])) {
        if (get_field('page_banner_background_image') AND !is_archive() AND !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/hands-image.png');
        }
    }

    ?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>"></div>
    <div id="headline" class="page-banner__content container">
        <div class="row justify-content-center align-items-end">
            <div class="col-md col-md-10">
                <H1 class="page-banner__title"><?php if (get_field('page_banner_headline')) 
                { echo get_field('page_banner_headline'); } 
                else { echo $args['title']; } ?></H1>
            </div>
        </div>    
    </div>
</div>
<?php }


function pcutravel_files() {
    wp_enqueue_style( 'pcu_w3_animation', '//www.w3schools.com/w3css/4/w3.css' );
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css2?family=Montserrat&family=Raleway&family=Roboto:wght@300;400;500;700&display=swap"');
    wp_enqueue_style('bootstrap4-style','//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', '//use.fontawesome.com/releases/v5.12.1/css/all.css');

    wp_enqueue_script('jquery-script','//code.jquery.com/jquery-3.5.1.min.js');
    wp_enqueue_script('jquery-foundation','//code.jquery.com/jquery-migrate-1.2.1.min.js');
    wp_enqueue_script('main-script',get_theme_file_uri('/src/modules/main.min.js'),'1.0.0', true);
    wp_enqueue_script('moment-script',get_theme_file_uri('/src/modules/moment.min.js'));
    wp_enqueue_script('vuejs-script',get_theme_file_uri('/src/modules/vue.min.js'));
    wp_enqueue_script('vuejs-datepicker-script',get_theme_file_uri('/src/modules/vuejs-datepicker.min.js'));

    // Start a quote page
    wp_enqueue_script('start-a-quote-script', get_theme_file_uri('/src/modules/start-a-quote.js'), 'main-script','1.0.0', true);

    // wp_enqueue_script('jquery','//code.jquery.com/jquery-3.3.1.slim.min.js', 'jquery-script');
    wp_enqueue_script('popper','//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js');
    wp_enqueue_script('bootstrap4-script','//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
    wp_enqueue_script('main-pcu-js', get_theme_file_uri('/build/index.js'), 'jquery-script','1.0.0', true);
    wp_enqueue_style( 'pcu_main_styles', get_theme_file_uri( '/build/style-index.css' ) );
    wp_enqueue_style( 'pcu_extra_styles', get_theme_file_uri( '/build/index.css' ) );

    // Purchase path
    wp_enqueue_script('purchase-script', get_theme_file_uri('/src/modules/purchase-path.min.js'), 'vuejs-script','1.0.0', false);

    // Make the theme path available in JS files for main slider
    wp_register_script('custom-js',get_stylesheet_directory_uri(),array(),NULL,true);
    wp_enqueue_script('custom-js');    
    $wnm_custom = array( 'stylesheet_directory_uri' => get_stylesheet_directory_uri() );
    wp_localize_script( 'custom-js', 'directory_uri', $wnm_custom );

}
add_action('wp_enqueue_scripts', 'pcutravel_files');

function pcutravel_features() {
    // All nav bars (Header and Footer)
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerMenuLocation1', 'Footer Menu Location1');
    register_nav_menu('footerMenuLocation2', 'Footer Menu Location2');
    register_nav_menu('footerSubLegal', 'Footer Sub Legal');

    // Banner Image size 
    add_image_size('pageBanner', 1300, 300, true);
}
add_action('after_setup_theme', 'pcutravel_features');

// Highlighting selected category in blog search
function tax_cat_active( $output, $args ) {

    if(is_single()){
      global $post;
  
      $terms = get_the_terms( $post->ID, $args['taxonomy'] );
      foreach( $terms as $term )
          if ( preg_match( '#cat-item-' . $term ->term_id . '#', $output ) )
              $output = str_replace('cat-item-'.$term ->term_id, 'cat-item-'.$term ->term_id . ' current-cat', $output);
    }
  
    return $output;
  }
add_filter( 'wp_list_categories', 'tax_cat_active', 10, 2 );

// Ignore the mode_modules when push to repo
add_filter( 'ai1wm_exclude_themes_from_export',
function ( $exclude_filters ) {
  $exclude_filters[] = 'pcutravel-theme/node_modules';
  return $exclude_filters;
} );