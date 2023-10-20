<?php
get_header();
?>

<section id="content"> 
    <div id="Content_C001_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container">
        <div class="row" data-sf-element="Row">
            <!-- Search Column -->
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
                                    'show_count'        => 1,
                                    'title_li'          => __( 'Select Category: ' ),
                                    'separator'         => '<br />',
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
                <div class="content-block container" >
                    <div ><h1>PCU Blog</h1></div>    
                </div>
                <div class="blogs">
                    <div class="card-columns">
<?php
    while(have_posts()) {
        the_post(); ?>


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
                        <?php 
                            // echo wp_list_categories($args);
                            echo get_the_category_list(); 
                        ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <h4 ><?php if(get_field('card_title')) {echo get_field('card_title');} else { the_title(); } ?></h4>
        <div class="subtitle" ><?php echo get_field('card_subtitle'); ?></div>
        <div><?php the_excerpt(); ?></div>
    </div>
    <div class="card-footer">
        <a href="<?php The_permalink(); ?>" class="btn btn-lg btn-block">Read More</a>
    </div>
</div>

<?php } ?>
                    </div>
                    <!-- Load More Section -->
                    <div class="js-load-more-div post-pager d-flex justify-content-between">
                        <?php echo paginate_links(); ?>
                    </div>
            </div>
</div>
</div>
</div>
</section>


<?php 
get_footer();
?>
