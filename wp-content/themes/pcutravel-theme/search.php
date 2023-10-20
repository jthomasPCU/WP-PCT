<?php
/*
Template Name: Search Page
*/

get_header();
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/triptime_triptime-product_philippines-kayak-selfie_374218297.jpg') ?>"></div>
    <div id="headline" class="page-banner__content container">
        <div class="row justify-content-center align-items-end">
            <div class="col-md col-md-10">
                <h1 class="page-banner__title">Blog Search Results</h1>
            </div>
        </div>    
    </div>
</div>

<div class="content-block container" >
<div class="row" data-sf-element="Row">

<div id="Content_C007_Col00" class="sf_colsIn col-lg-3 order-1 order-lg-12" data-sf-element="Column 2" data-placeholder-label="Column 2">
                <div class="sidebar-block">
                    <div class="form-inline">
                    <h3>Search</h3>

                    <form method="get" action="<?php echo esc_url(site_url('/')); ?>" class="form-group sf-search-input-wrapper">
                        <!-- <input id="s" type="search" name="s" class="form-control" placeholder="&#xF002;" value=""> -->
                        <input id="s" type="search" name="s" class="form-control" value="">
                        <input type="submit" value="search" class="btn btn-primary ml-2 sr-only">
                    </form>

                    </div>
                </div>
                <div class="sidebar-block">
                    <div class="form-inline">
                        <h3>Filter Archives</h3>
                            <div class="form-group">
                                <select name="archive-dropdown" class="form-control custom-select-sm" onchange="document.location.href=this.options[this.selectedIndex].value;">
                                    <option value=""><?php esc_attr( _e( 'Select Month', 'textdomain' ) ); ?></option> 
                                <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); wp_reset_postdata();?>
                                </select>
                            </div>
                            <div class="form-group">
                                <i class="fas fa-bookmark"></i>
                                <?php 
                                // args will be used in the featured image and sidebar filter archives
                                $args = [
                                    'show_count'         => 1,
                                    'title_li'           => __( 'Select Category: ' ),
                                    'separator'          => '<br />',
                                ];
                                
                                echo '<ul>';
                                    wp_list_categories( $args );
                                echo '</ul>';                                              
                                ?>
                            </div>
                    </div>
                </div>
            </div>

<div id="Content_C007_Col01" class="sf_colsIn col-lg-9 order-12 order-lg-1" data-sf-element="Column 1" data-placeholder-label="Column 1">
    <?php
        if (have_posts()) {
            ?>
            <h2 class="search-title">
                <?php echo $wp_query->found_posts; ?> 
                <?php _e( 'Search Results Found For', 'locale' ); ?>: "<?php the_search_query(); ?>"
            </h2>
            <?php
            while(have_posts()) {
                the_post();
            // }
            // echo paginate_links();
            ?>
            <div class="blog-item card" >
    <div class="card-top">
            <img class="card-img-top" src="<?php echo get_field('card_image_top') ?>" />


        <div class="post-meta d-flex justify-content-between">
            <div class="post-author d-flex align-items-center">
                <!-- <div class="avatar">
                    <img class="js-avatar avatar" data-avatar-id="49929ad7-f179-4426-80c5-a7e1e4eead23" src="/SFRes/images/Telerik.Sitefinity.Resources/Images.DefaultPhoto.png" />
                </div> -->
                <div class="author">
                    By: <?php echo get_field('post_author'); ?><br />
                    <?php the_date('F j, Y'); ?> <?php the_time('g:i a'); ?>
                </div>
            </div>
            <div class="post-category">
                    <i class="fas fa-bookmark"></i>
                        <?php echo wp_list_categories(); ?>
                        <!-- <a class="js-category-tag" data-category-id="1f963312-2a9a-4545-be2a-9c0484eedcdf" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="ce3f8b29-0f4f-49f8-a85a-e88d84f392db" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="1abcf199-b757-416e-a63f-90524788c8f0" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="78078261-4ecd-453c-9d21-9a7ea94e66cf" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="1d0e0b23-43c5-4541-ad50-e696f08d7e18" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="650a35ef-34b6-422a-a57c-79361a107550" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="f4c5388a-922a-4598-8b4c-e3e182acca1f" href="javascript:void(0)" rel="category tag"></a>
                        <a class="js-category-tag" data-category-id="7603c68e-aef9-4fff-b0ce-b5e5234074ca" href="javascript:void(0)" rel="category tag"></a> -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <h4 ><?php if(get_field('card_title')) {echo get_field('card_title');} else { the_title(); } ?></h4>
        <div class="subtitle" ><?php echo get_field('card_subtitle'); ?></div>
        <div><?php echo get_field('card_content'); ?></div>
    </div>
    <div class="card-footer">
        <a href="<?php The_permalink(); ?>" class="btn btn-lg btn-block">Read More</a>
    </div>
</div>      
                <?php }
?>
<div class="js-load-more-div post-pager d-flex justify-content-between">
<?php echo paginate_links(); ?>
</div>
<?php
        } else {
            echo '<h3>No results</h3>';
        }
    ?>
</div>
    </div>
    </div>
<?php
get_footer();
?>
