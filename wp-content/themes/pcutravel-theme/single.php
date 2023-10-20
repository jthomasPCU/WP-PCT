<?php
get_header();

while(have_posts()) {
    the_post();
?>


<section id="content"> 
    <div id="Content_C001_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container"><div class="row" data-sf-element="Row">
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
        </div>
        <div id="Content_C007_Col01" class="sf_colsIn col-lg-9 order-12 order-lg-1" data-sf-element="Column 1" data-placeholder-label="Column 1">
            <div class="blog-item" >
                <div class="card-top">
                    <img class="card-img-top" src="<?php echo get_field('card_image_top') ?>" alt="<?php the_title(); ?>" />    
                    <div class="post-meta d-flex justify-content-between">
                        <div>
                            <div class="post-author d-flex align-items-center">
                                <!-- <div class="avatar">
                                    <img class="js-avatar avatar" data-avatar-id="49929ad7-f179-4426-80c5-a7e1e4eead23" src="/SFRes/images/Telerik.Sitefinity.Resources/Images.DefaultPhoto.png" />
                                </div> -->
                                        <div class="author">
                                            By: <?php echo get_field('post_author'); ?><br />
                                            <?php the_date('F j, Y'); ?> <?php the_time('g:i a'); ?>
                                        </div>
                                    </div>  
                        </div>
                        <div class="post-category">
                            <i class="fas fa-bookmark"></i><br />
                            <?php echo get_the_category_list(); ?>
                        </div> 
                    </div>
                </div>
                <h3 class="text-center mt-5 mb-1">
                    <span><?php the_title(); ?></span>
                </h3>
                <div class="subtitle text-center mb-5" ><?php echo get_field('card_subtitle'); ?></div>
                <div ><p style="text-align: justify">By <?php echo get_field('post_author'); ?></div>
                <br>
                <br>
                <br>
                    <?php the_content(); ?><br />
                    <?php if(has_tag()) {the_tags();} ?>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php }
    get_footer();
?>