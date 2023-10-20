<?php
get_header();

while(have_posts()) {
    the_post();
    pageBanner();
?>

<!-- Highlights and Exclusions page links only - start -->
<?php if (is_page( 77 )) { ?>
<style>
    a strong {
    color: rgba(149, 79, 114, 1);
}
</style>
<?php } ?>
<!-- Highlights and Exclusions page only - end -->

<!-- <div class="container container--narrow page-section page-default"> -->
<div class="container page-section page-default">
    <div class="row justify-content-center">
        <div class="col-md col-md-10">
            <div class="content-block container"></div>

<?php the_content() ?>

            </div>
        </div>
    </div>
</div>
<?php }

    get_footer();
?>