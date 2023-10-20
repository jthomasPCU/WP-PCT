<?php
get_header();

while(have_posts()) {
    the_post();
    pageBanner();

?>

<!-- Displaying a Single post for Social posts custom post type -->
<div class="container container--narrow page-section page-default">
    <div class="row justify-content-center">
        <div class="col-md col-md-10">
            <div class="content-block container"></div>
                <?php if (get_field('social_image') || has_excerpt()) { ?>
                        <div class="image">
                            <?php if (get_field('social_image')) { ?>
                                <img src="<?php echo get_field('social_image'); ?>">
                            <?php } else { ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                                <?php } ?>
                        </div>
                <?php } ?>
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>
<?php }

    get_footer();
?>