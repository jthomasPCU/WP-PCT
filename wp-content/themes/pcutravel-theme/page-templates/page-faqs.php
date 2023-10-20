<?php 
/**
* Template Name: FAQs Page
*/
get_header();

$faq = new WP_Query(array(
    'posts_per_page' => 100,
    'post_type' => 'faq',
    'orderby' => 'date',
    'order' => 'ASC'
));

?>
<section id="content"> 
    <div id="Content_C001_Col00" class="sf_colsIn container mt-5" data-sf-element="Container" data-placeholder-label="Container">
        <div class="faq-list-container mt-5">

            <h1 class="title">Frequently Asked Questions</h1>
            <div class="acc-container">

            <?php 
                while($faq->have_posts()) {
                    $faq->the_post(); 
            ?>


                <div class="entry">
                    <button class="acc-btn"><?php the_title(); ?></button>
                        <div class="acc-content">
                            <p>
                                <?php
                                    the_content();
                                ?>
                            </p>
                        </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php 
get_footer(); ?>