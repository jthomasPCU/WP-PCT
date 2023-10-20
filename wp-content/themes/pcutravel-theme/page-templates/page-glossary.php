<?php 
/**
* Template Name: Glossary Page
*/
get_header();

// while(have_posts()) {
//     the_post();
?>

<section id="content"> 
    <div id="Content_C001_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container">
        <div id="glossary" class="glossary-widget mt-5 mb-5 pt-5">
            <h1 class="title">Glossary</h1>

<?php
    $glossary = new WP_Query(array(
        'posts_per_page' => 200,
        'post_type' => 'glossary',
        'orderby' => 'name',
        'order' => 'ASC'
    ));

?>
  
            <div class="entries-container mt-5" style="display: block;">
                <div>
                    <?php

                        $initial = "";

                        while($glossary->have_posts()) {
                            $glossary->the_post(); 

                        $title = get_the_title(); 
                        $currentInitial = strtoupper(substr($title,0,1));
                        // echo ($initial);

                        
                        if ($initial != $currentInitial) { 
                            ?>
                                <div class="first-letter">
                            <?php
                                echo $currentInitial;
                                $initial = $currentInitial;
                            ?>
                                </div>
                            <?php
                        } 
                    ?>

            <div class="glossary-entry">
                <div class="acc-btn"><?php the_title(); ?></div>
                    <div class="acc-content">
                        <p>
                            <?php
                                the_content();
                            ?>
                        </p>
                    </div>
            </div>


            <?php
                    };
            ?>
</div>



            </div>


        </div>
    </div>
</section>


<?php 
// };

get_footer(); ?>