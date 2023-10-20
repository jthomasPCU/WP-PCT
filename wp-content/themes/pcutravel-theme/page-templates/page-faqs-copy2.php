<?php 
/**
* Template Name: FAQs Page
*/
get_header();

$faq = new WP_Query(array(
    'post_per_page' => -1,
    'post_type' => 'triptimefaq',
    'orderby' => 'date',
    'order' => 'ASC'
));

?>


<section id="content"> 
<div id="Content_C001_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container">
<div id="faq" class="faq-widget mt-5 mb-5">

    <h1 class="title">Frequently Asked Questions</h1>

    <div class="faq-list-container mt-5">
            <ul class="faq-list row row-eq-height">
            <?php 
            while($faq->have_posts()) {
                $faq->the_post(); 
                ?>
                <h2><?php the_title(); ?></h2>
                <li class="entry">
                    <div class="row row-eq-height no-gutters">
                        <div class="col col-1 control">
                            <span>+</span></div>
                        <div class="col col-11">
                            <div class="question">
                                <?php 
                                    the_title(); 
                                ?>
                                <div class="answer">
                                        <?php 
                                    the_content();
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php 
            }; 
            ?>
            </ul>
        </div>



















        
</div>
</section>


<?php 
// };

get_footer(); ?>