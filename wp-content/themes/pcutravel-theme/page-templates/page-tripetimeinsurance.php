<?php 
/**
* Template Name: Insurance + Triptime Page
*/

get_header();

while(have_posts()) {
    the_post();
?>

<section class="page-banner">
    <video class="featured-video" video autobuffer autoplay muted loop playsinline>
        <source src="https://pcustoragewordpress.blob.core.windows.net/wordpress/tt_prodpage_banner_final.mp4" type="video/mp4">
    </video>
    <div class="page-banner__content container container--narrow">    
            <H1 class="page-banner__title" id="headline">
                <?php if (get_field('page_banner_headline')) {
                    echo get_field('page_banner_headline');
                } else {
                    the_title();
                }
                ?>
            </H1>
    </div>
</section>
<div class="compare-plans">
    <!--trip-time.begin-->
    <section class="trip-time">
        <div class="container trip-time__container">
            <div class="trip-time__body">
                <div class="row">
                    <div class="col-lg-7">
                        <h1 class="trip-time__title">
                            <i class="icon-double-angle-right"></i> 
                            <?php 
                                if (get_field('insurance_title')) {
                                    echo get_field('insurance_title');
                                } else { ?>
                                    TripTime<sup>&reg;</sup> Insurance
                            <?php } ?>
                        </h1>
                        <h2 class="trip-time__subtitle trip-time__subtitle--info">
                        <?php 
                            if (get_field('insurance_subtitle')) {
                                echo get_field('insurance_subtitle');
                            } else { ?>
                                Cover your trip with GoTime or PrimeTime!
                        <?php } ?>
                        </h2>
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="trip-time__text">
                            <p>
                                <p style="text-align:justify;">
                                    <?php 
                                        if (get_field('insurance_text_left')) {
                                            echo get_field('insurance_text_left');
                                        } 
                                    ?>
                                </p>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                    <!--SIDE BAR TEXT TO BE IMPLEMENTED LATER-->
<div class="trip-time__plans">
    <h3 class="trip-time__subtitle">
        <!-- <a href="/insurance/start-a-quote?selectPlan=GoTime20">Popular TripTime<sup>&reg;</sup> Plans</a> -->
        <a href="
        <?php if (get_field('popular_insurance_plans_link')) {
                    echo get_field('popular_insurance_plans_link');
                } else { ?>
                    /insurance/start-a-quote?selectPlan=GoTime20
                <?php } ?>
        ">Popular TripTime<sup>&reg;</sup> Plans</a>
    </h3>
    <div class="trip-time__items">
        <div class="trip-time__columns">
            <div class="trip-time__column">
                <a href="
                    <?php if (get_field('popular_insurance_plan1_link')) {
                        echo get_field('popular_insurance_plan1_link');
                    } else { ?>
                        /insurance/start-a-quote?selectPlan=GoTime20
                    <?php } ?>
                ">
                    <img class="trip-time__image img-fluid" src="
                        <?php if (get_field('popular_insurance_plan1_icon')) {
                            echo get_field('popular_insurance_plan1_icon');
                        } else { 
                            echo get_theme_file_uri('/images/planicons/go-time.png');
                        } ?>
                    " 
                    alt="Palms icon" /></a>
            </div>
            <div class="trip-time__column">
                <h4 class="trip-time__name">
                        <!-- <a href="/insurance/start-a-quote?selectPlan=GoTime20"><strong>TripTime</strong> GoTime</a> -->
                        <a href="
                            <?php 
                                if (get_field('popular_insurance_plan1_link')) {
                                    echo get_field('popular_insurance_plan1_link');
                                } else { ?>
                                    /insurance/start-a-quote?selectPlan=GoTime20
                            <?php } ?>
                        ">
                        <!-- <strong>TripTime</strong>  -->
                        <?php if (get_field('popular_insurance_plan1_title')) {
                        echo get_field('popular_insurance_plan1_title');
                    } else { ?>
                        GoTime
                    <?php } ?>
                    </a>
                </h4>
                <div class="trip-time__sign">
                <?php if (get_field('popular_insurance_plan1_sign')) {
                        echo get_field('popular_insurance_plan1_sign');
                    } else { ?>
                        $
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="trip-time__columns">
            <div class="trip-time__column">
                <a href="
                    <?php if (get_field('popular_insurance_plan2_link')) {
                        echo get_field('popular_insurance_plan2_link');
                    } else { ?>
                        /insurance/start-a-quote?selectPlan=PrimeTime20
                    <?php } ?>
                ">
                    <img class="trip-time__image img-fluid" src="

                        <?php if (get_field('popular_insurance_plan2_icon')) {
                            echo get_field('popular_insurance_plan2_icon');
                        } else { 
                            echo get_theme_file_uri('/images/planicons/prime-time.png');
                        } ?>

                    " alt="Mountains icon" /></a>
            </div>
            <div class="trip-time__column">
                <h4 class="trip-time__name">
                        <!-- <a href="/insurance/start-a-quote?selectPlan=GoTime20"><strong>TripTime</strong> GoTime</a> -->
                        <a href="
                            <?php if (get_field('popular_insurance_plan2_link')) {
                                echo get_field('popular_insurance_plan2_link');
                            } else { ?>
                                /insurance/start-a-quote?selectPlan=PrimeTime20
                            <?php } ?>
                        ">
                        <!-- <strong>TripTime</strong>  -->
                        <?php if (get_field('popular_insurance_plan2_title')) {
                        echo get_field('popular_insurance_plan2_title');
                    } else { ?>
                        PrimeTime
                    <?php } ?>
                    </a>
                </h4>
                <div class="trip-time__sign">
                <?php if (get_field('popular_insurance_plan2_sign')) {
                        echo get_field('popular_insurance_plan2_sign');
                    } else { ?>
                        $$$
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>
            <div class="trip-time__foot">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn--light js-toggle-compare">Compare Plans!</button>
                        <div class="trip-time__chevron-down">
                            <i class="icon-double-angle-down"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!--trip-time.end-->
    <!--packages.begin-->
    <section class="packages js-packages" style="display:none">
        <div class="container packages__container">
            <div class="packages__responsive">
<table class="table package">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>
                <img class="package__image img-fluid" src="
                    <?php if (get_field('popular_insurance_plan1_icon')) {
                            echo get_field('popular_insurance_plan1_icon');
                        } else { 
                            echo get_theme_file_uri('/images/planicons/go-time.png');
                        } 
                    ?>"
                  alt="Palms icon"><br />
                <!-- <a href="/insurance/start-a-quote?selectPlan=GoTime20" class="btn btn--light day-rate">Get a Quote</a> -->
                <a href="
                            <?php if (get_field('popular_insurance_plan1_link')) {
                                echo get_field('popular_insurance_plan1_link');
                            } else { ?>
                                /insurance/start-a-quote?selectPlan=PrimeTime20
                            <?php } ?>                
                " class="btn btn--light day-rate">Get a Quote</a>
                <div class="package__name">
                    <strong>
                        <?php if (get_field('popular_insurance_plan1_title')) {
                            echo get_field('popular_insurance_plan1_title');
                        } else { ?>
                            GoTime
                        <?php } ?>
                    </strong>
                </div>
                <div class="package__sign">
                <?php if (get_field('popular_insurance_plan1_sign')) {
                        echo get_field('popular_insurance_plan1_sign');
                    } else { ?>
                        $
                    <?php } ?>
                </div>
            </th>
            <th>
                <img class="package__image img-fluid" src="
                    <?php if (get_field('popular_insurance_plan2_icon')) {
                            echo get_field('popular_insurance_plan2_icon');
                        } else { 
                            echo get_theme_file_uri('/images/planicons/primtime-time.png');
                        } 
                    ?>
                " alt="Mountains icon"><br />
                <a href="
                    <?php if (get_field('popular_insurance_plan2_link')) {
                        echo get_field('popular_insurance_plan2_link');
                    } else { ?>
                        /insurance/start-a-quote?selectPlan=PrimeTime20
                    <?php } ?>                              
                " class="btn btn--light day-rate">Get a Quote</a>
                <div class="package__name">
                    <strong>
                        <?php if (get_field('popular_insurance_plan2_title')) {
                            echo get_field('popular_insurance_plan2_title');
                        } else { ?>
                            PrimeTime
                        <?php } ?>
                    </strong>
                </div>
                <div class="package__sign">
                <?php if (get_field('popular_insurance_plan2_sign')) {
                        echo get_field('popular_insurance_plan2_sign');
                    } else { ?>
                        $$$
                    <?php } ?>                    
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
    <!-- Package 1 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package1_title')) {
                        echo get_field('package1_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 1 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package1_r1c1')) {  ?>  
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package1_r1c1')) {
                            echo get_field('package1_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package1_r1c2')) {
                if(get_field('package1_r1c2', false, false ) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package1_r1c2'); } }?>  
        </td>
        <td>
            <?php if (get_field('package1_r1c3')) {
                if(get_field('package1_r1c3', false, false ) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package1_r1c3'); }}?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package1_r2c1')) {  ?>
    <tr>
        <td>
            <?php if (get_field('package1_r2c1')) {
                echo get_field('package1_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package1_r2c2')) {
                if(get_field('package1_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package1_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package1_r2c3')) {
                if(get_field('package1_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package1_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 2 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package2_title')) {
                        echo get_field('package2_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 2 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package2_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package2_r1c1')) {
                            echo get_field('package2_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package2_r1c2')) {
                if(get_field('package2_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package2_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package2_r1c3')) {
                if(get_field('package2_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package2_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package2_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package2_r2c1')) {
                echo get_field('package2_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package2_r2c2')) {
                if(get_field('package2_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package2_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package2_r2c3')) {
                if(get_field('package2_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package2_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 3 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package3_title')) {
                        echo get_field('package3_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 3 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package3_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package3_r1c1')) {
                            echo get_field('package3_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package3_r1c2')) {
                if(get_field('package3_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package3_r1c3')) {
                if(get_field('package3_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package3_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package3_r2c1')) {
                echo get_field('package3_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package3_r2c2')) {
                if(get_field('package3_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package3_r2c3')) {
                if(get_field('package3_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 3 -->
<?php if (get_field('package3_r3c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package3_r3c1')) {
                            echo get_field('package3_r3c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package3_r3c2')) {
                if(get_field('package3_r3c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r3c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package3_r3c3')) {
                if(get_field('package3_r3c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r3c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 4 -->
<?php if (get_field('package3_r4c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package3_r4c1')) {
                echo get_field('package3_r4c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package3_r4c2')) {
                if(get_field('package3_r4c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r4c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package3_r4c3')) {
                if(get_field('package3_r4c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package3_r4c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 4 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package4_title')) {
                        echo get_field('package4_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 4 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package4_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package4_r1c1')) {
                            echo get_field('package4_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package4_r1c2')) {
                if(get_field('package4_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package4_r1c3')) {
                if(get_field('package4_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package4_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package4_r2c1')) {
                echo get_field('package4_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package4_r2c2')) {
                if(get_field('package4_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package4_r2c3')) {
                if(get_field('package4_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 3 -->
<?php if (get_field('package4_r3c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package4_r3c1')) {
                            echo get_field('package4_r3c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package4_r3c2')) {
                if(get_field('package4_r3c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r3c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package4_r3c3')) {
                if(get_field('package4_r3c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r3c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 4 -->
<?php if (get_field('package4_r4c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package4_r4c1')) {
                echo get_field('package4_r4c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package4_r4c2')) {
                if(get_field('package4_r4c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r4c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package4_r4c3')) {
                if(get_field('package4_r4c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package4_r4c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 5 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package5_title')) {
                        echo get_field('package5_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 5 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package5_r1c1')) {  ?>
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package5_r1c1')) {
                            echo get_field('package5_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r1c2')) {
                if(get_field('package5_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r1c3')) {
                if(get_field('package5_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package5_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package5_r2c1')) {
                echo get_field('package5_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r2c2')) {
                if(get_field('package5_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r2c3')) {
                if(get_field('package5_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 3 -->
<?php if (get_field('package5_r3c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package5_r3c1')) {
                            echo get_field('package5_r3c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r3c2')) {
                if(get_field('package5_r3c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r3c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r3c3')) {
                if(get_field('package5_r3c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r3c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 4 -->
<?php if (get_field('package5_r4c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package5_r4c1')) {
                echo get_field('package5_r4c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r4c2')) {
                if(get_field('package5_r4c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r4c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r4c3')) {
                if(get_field('package5_r4c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r4c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 5 -->
<?php if (get_field('package5_r5c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package5_r5c1')) {
                echo get_field('package5_r5c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r5c2')) {
                if(get_field('package5_r5c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r5c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r5c3')) {
                if(get_field('package5_r5c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r5c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 6 -->
<?php if (get_field('package5_r6c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package5_r6c1')) {
                            echo get_field('package5_r6c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r6c2')) {
                if(get_field('package5_r6c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r6c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r6c3')) {
                if(get_field('package5_r6c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r6c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 7 -->
<?php if (get_field('package5_r7c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package5_r7c1')) {
                echo get_field('package5_r7c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package5_r7c2')) {
                if(get_field('package5_r7c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package5_r7c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package5_r7c3')) {
                if(get_field('package5_r7c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                      		echo get_field('package5_r7c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
		
    <!-- Package 6 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package6_title')) {
                        echo get_field('package6_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 6 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package6_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package6_r1c1')) {
                            echo get_field('package6_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r1c2')) {
                if(get_field('package6_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r1c3')) {
                if(get_field('package6_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package6_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package6_r2c1')) {
                echo get_field('package6_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r2c2')) {
                if(get_field('package6_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r2c3')) {
                if(get_field('package6_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 3 -->
<?php if (get_field('package6_r3c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package6_r3c1')) {
                            echo get_field('package6_r3c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r3c2')) {
                if(get_field('package6_r3c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r3c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r3c3')) {
                if(get_field('package6_r3c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r3c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 4 -->
<?php if (get_field('package6_r4c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package6_r4c1')) {
                echo get_field('package6_r4c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r4c2')) {
                if(get_field('package6_r4c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r4c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r4c3')) {
                if(get_field('package6_r4c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r4c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 5 -->
<?php if (get_field('package6_r5c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package6_r5c1')) {
                echo get_field('package6_r5c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r5c2')) {
                if(get_field('package6_r5c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r5c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r5c3')) {
                if(get_field('package6_r5c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r5c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 6 -->
<?php if (get_field('package6_r6c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package6_r6c1')) {
                            echo get_field('package6_r6c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r6c2')) {
                if(get_field('package6_r6c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r6c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r6c3')) {
                if(get_field('package6_r6c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r6c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 7 -->
<?php if (get_field('package6_r7c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package6_r7c1')) {
                            echo get_field('package6_r7c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r7c2')) {
                if(get_field('package6_r7c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r7c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r7c3')) {
                if(get_field('package6_r7c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r7c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 8 -->
<?php if (get_field('package6_r8c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package6_r8c1')) {
                echo get_field('package6_r8c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r8c2')) {
                if(get_field('package6_r8c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r8c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r8c3')) {
                if(get_field('package6_r8c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r8c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 9 -->
<?php if (get_field('package6_r9c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package6_r9c1')) {
                echo get_field('package6_r9c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r9c2')) {
                if(get_field('package6_r9c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r9c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r9c3')) {
                if(get_field('package6_r9c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r9c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 10 -->
<?php if (get_field('package6_r10c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package6_r10c1')) {
                            echo get_field('package6_r10c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package6_r10c2')) {
                if(get_field('package6_r10c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r10c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package6_r10c3')) {
                if(get_field('package6_r10c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package6_r10c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 7 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package7_title')) {
                        echo get_field('package7_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 7 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package7_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package7_r1c1')) {
                            echo get_field('package7_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package7_r1c2')) {
                if(get_field('package7_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package7_r1c3')) {
                if(get_field('package7_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package6_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package7_r2c1')) {
                echo get_field('package7_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package7_r2c2')) {
                if(get_field('package7_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package7_r2c3')) {
                if(get_field('package7_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 3 -->
<?php if (get_field('package7_r3c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package7_r3c1')) {
                            echo get_field('package7_r3c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package7_r3c2')) {
                if(get_field('package7_r3c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r3c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package7_r3c3')) {
                if(get_field('package7_r3c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r3c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 4 -->
<?php if (get_field('package7_r4c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package7_r4c1')) {
                echo get_field('package7_r4c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package7_r4c2')) {
                if(get_field('package7_r4c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r4c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package7_r4c3')) {
                if(get_field('package7_r4c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package7_r4c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 8 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package8_title')) {
                        echo get_field('package8_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 8 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package8_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package8_r1c1')) {
                            echo get_field('package8_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package8_r1c2')) {
                if(get_field('package8_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package8_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package8_r1c3')) {
                if(get_field('package8_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package8_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package6_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package8_r2c1')) {
                echo get_field('package8_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package8_r2c2')) {
                if(get_field('package8_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package8_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package8_r2c3')) {
                if(get_field('package8_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package8_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 9 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package9_title')) {
                        echo get_field('package9_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 9 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package9_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package9_r1c1')) {
                            echo get_field('package9_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package9_r1c2')) {
                if(get_field('package9_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package9_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package9_r1c3')) {
                if(get_field('package9_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package9_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package9_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package9_r2c1')) {
                echo get_field('package9_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package9_r2c2')) {
                if(get_field('package9_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package9_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package9_r2c3')) {
                if(get_field('package9_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package9_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Package 10 -->
    <tr>
        <td colspan="4">
            <h4 class="package__title">
                <?php if (get_field('package10_title')) {
                        echo get_field('package10_title'); }
                ?>  
            </h4>
        </td>
    </tr>
    <!-- Package 6 Rows -->
    <!-- Row 1 -->
<?php if (get_field('package10_r1c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package10_r1c1')) {
                            echo get_field('package10_r1c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package10_r1c2')) {
                if(get_field('package10_r1c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r1c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package10_r1c3')) {
                if(get_field('package10_r1c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r1c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 2 -->
<?php if (get_field('package10_r2c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package10_r2c1')) {
                echo get_field('package10_r2c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package10_r2c2')) {
                if(get_field('package10_r2c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r2c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package10_r2c3')) {
                if(get_field('package10_r2c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r2c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 3 -->
<?php if (get_field('package10_r3c1')) {  ?>    
    <tr class="package__tr-highlight">
        <td>
            <?php if (get_field('package10_r3c1')) {
                            echo get_field('package10_r3c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package10_r3c2')) {
                if(get_field('package10_r3c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r3c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package10_r3c3')) {
                if(get_field('package10_r3c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r3c3'); }} ?>  
        </td>
    </tr>
<?php } ?>
    <!-- Row 4 -->
<?php if (get_field('package10_r4c1')) {  ?>    
    <tr>
        <td>
            <?php if (get_field('package10_r4c1')) {
                echo get_field('package10_r4c1'); }
            ?>  
        </td>
        <td>
            <?php if (get_field('package10_r4c2')) {
                if(get_field('package10_r4c2', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r4c2'); }} ?>  
        </td>
        <td>
            <?php if (get_field('package10_r4c3')) {
                if(get_field('package10_r4c3', false, false) == 'check') { 
                    ?> <svg><use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#check') ?>"></use></svg> <?php } 
                else {
                            echo get_field('package10_r4c3'); }} ?>  
        </td>
    </tr>
<?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td>
                <a href="/insurance/start-a-quote?selectPlan=GoTime20" class="btn btn--light day-rate">Get a Quote</a>
            </td>
            <td>
                <a href="/insurance/start-a-quote?selectPlan=PrimeTime20" class="btn btn--light day-rate">Get a Quote</a>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">
            </td>
        </tr>
    </tfoot>

</table>

            </div>

            <div class="packages__chevron-down">
                <i class="icon-double-angle-down"></i>
            </div>
        </div>
    </section>
    <!--packages.end-->
    <!--trip-features.begin-->
    <section class="trip-features">
        <div class="container trip-features__container">
            <div class="trip-features__content">
                <div class="row align-items-end">
                    <div class="col-lg-6">
                        <h2 class="trip-features__title">
                            <?php if (get_field('trip_features_title')) {
                                echo get_field('trip_features_title'); }
                            ?>  
                        </h2>
                        <h3 class="trip-features__subtitle">
                            <?php if (get_field('trip_features_subtitle')) {
                                echo get_field('trip_features_subtitle'); }
                            ?>  
                        </h3>
                    </div>
                    <div class="col-lg-6">
                        <div class="trip-features__btns">
                                <a href="/insurance/start-a-quote" class="btn btn--light btn--light-custom text-uppercase">Get a Quote <i class="icon-double-angle-right"></i></a>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--trip-features.end-->
</div>


<div class="content-block container" >
    <div ><h4 style="text-align: center">TripTime<sup>®</sup>&nbsp;<span style="font-size: 1em; text-align: center">Coverage Features</span></h4></div>    
</div>
    </div>
</div>
<div class="row row-eq-height product-detail no-gutters">
    <div id="Content_C002_Col00" class="aa-content-card col-xl-4 col-lg-6 col-md-12 sf_colsIn" data-placeholder-label="Element 1 of 6">

<div class="aa-inner-content">
    <div class="aa-left-image">
    <img src="<?php echo get_theme_file_uri('/images/checkmark.png') ?>" alt="Checkmark Icon">
    </div>
    <div class="aa-main-content">
        <p>
            <p style="text-align:justify;">
                <?php if (get_field('aa_main_content_1')) {
                    echo get_field('aa_main_content_1'); }
                ?>  
            </p>
        </p>
        <div class="footnote">
                <?php if (get_field('footnote_1')) {
                    echo get_field('footnote_1'); }
                ?> 
            </div>
    </div>
</div></div>
    <div id="Content_C002_Col01" class="aa-content-card col-xl-4 col-lg-6 col-md-12 sf_colsIn" data-placeholder-label="Element 2 of 6">

<div class="aa-inner-content">
    <div class="aa-left-image">
    <img src="<?php echo get_theme_file_uri('/images/checkmark.png') ?>" alt="Checkmark Icon">
    </div>
    <div class="aa-main-content">
        <p>
            <style type="text/css">p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; line-height: 26.0px; font: 15.0px 'Roboto Light'; color: #3a3940}
span.s1 {font: 15.0px Roboto; letter-spacing: 0.5px}
span.s2 {letter-spacing: 0.5px}
</style>


<p style="text-align:justify;">
    <?php if (get_field('aa_main_content_2')) {
        echo get_field('aa_main_content_2'); }
    ?>  
</p>
        </p>
        <div class="footnote">
            <?php if (get_field('footnote_2')) {
                    echo get_field('footnote_2'); }
                ?> 
            </div>
    </div>
</div></div>
    <div id="Content_C002_Col02" class="aa-content-card col-xl-4 col-lg-6 col-md-12 sf_colsIn" data-placeholder-label="Element 3 of 6">

<div class="aa-inner-content">
    <div class="aa-left-image">
    <img src="<?php echo get_theme_file_uri('/images/checkmark.png') ?>" alt="Checkmark Icon">
    </div>
    <div class="aa-main-content">
        <p>
            <style type="text/css">p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; line-height: 26.0px; font: 15.0px 'Roboto Light'; color: #3a3940}
span.s1 {font: 15.0px Roboto; letter-spacing: 0.5px}
span.s2 {letter-spacing: 0.5px}
</style>


<p style="text-align:justify;">
    <?php if (get_field('aa_main_content_3')) {
        echo get_field('aa_main_content_3'); }
    ?>  
</p>
        </p>
        <div class="footnote">
            <?php if (get_field('footnote_3')) {
                    echo get_field('footnote_3'); }
            ?> 
        </div>
    </div>
</div></div>
    <div id="Content_C002_Col03" class="aa-content-card col-xl-4 col-lg-6 col-md-12 sf_colsIn" data-placeholder-label="Element 4 of 6">

<div class="aa-inner-content pending">
    <div class="aa-left-image">
 <img src="<?php echo get_theme_file_uri('/images/coverage.png') ?>" alt="Checked Icon">
    </div>
    <div class="aa-main-content">
        <p>
            <style type="text/css">p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; line-height: 26.0px; font: 15.0px Roboto; color: #3a3940}
span.s1 {font: 15.0px 'Roboto Light'; letter-spacing: 0.5px}
span.s2 {letter-spacing: 0.5px}
Marine Activities option provides Medical and Transportation coverage while participating in Water Sports named in the policy.&nbsp; It also includes coverage for your Scuba equipment.<strong>Marine Activity Information</strong></style>


<p style="text-align:justify;">
    <?php if (get_field('aa_main_content_4')) {
        echo get_field('aa_main_content_4'); }
    ?>  
</p>
        </p>
        <div class="footnote">
            <?php if (get_field('footnote_4')) {
                    echo get_field('footnote_4'); }
            ?> 
        </div>
    </div>
</div></div>
    <div id="Content_C002_Col04" class="aa-content-card col-xl-4 col-lg-6 col-md-12 sf_colsIn" data-placeholder-label="Element 5 of 6">

<div class="aa-inner-content pending">
    <div class="aa-left-image">
    <img src="<?php echo get_theme_file_uri('/images/coverage.png') ?>" alt="Checked Icon">
    </div>
    <div class="aa-main-content">
        <p>
            <p style="text-align:justify;">
                <?php if (get_field('aa_main_content_5')) {
                    echo get_field('aa_main_content_5'); }
                ?>  
            </p>
<div style="display:none;"></div>
<div style="display:none;"></div>
        </p>
        <div class="footnote">
            <?php if (get_field('footnote_5')) {
                    echo get_field('footnote_5'); }
            ?> 
        </div>
    </div>
</div></div>
    <div id="Content_C002_Col05" class="aa-content-card col-xl-4 col-lg-6 col-md-12 sf_colsIn" data-placeholder-label="Element 6 of 6">

<div class="aa-inner-content pending">
    <div class="aa-left-image">
    <img src="<?php echo get_theme_file_uri('/images/coverage.png') ?>" alt="Checked Icon">
    </div>
    <div class="aa-main-content">
        <p>
            <style type="text/css">p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; line-height: 26.0px; font: 15.0px 'Roboto Light'; color: #3a3940}
span.s1 {font: 15.0px Roboto; letter-spacing: 0.5px}
span.s2 {letter-spacing: 0.5px}
</style>

<p style="text-align:justify;">
    <?php if (get_field('aa_main_content_6')) {
        echo get_field('aa_main_content_6'); }
    ?>  
</p>
        </p>
        <div class="footnote">
            <?php if (get_field('footnote_6')) {
                    echo get_field('footnote_6'); }
            ?> 
        </div>
    </div>
</div></div>
</div><div id="Content_C018_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container"><div class="row pt-7 pb-7" data-sf-element="Row">
    <div id="Content_C019_Col00" class="sf_colsIn col-lg-12" data-sf-element="Column 1" data-placeholder-label="Column 1">

<?php
$faq = new WP_Query(array(
    'posts_per_page' => 100,
    'post_type' => 'faq',
    'orderby' => 'date',
    'order' => 'ASC'
));
?>
    <h1 class="title">TripTime<sup>&reg;</sup> Coverage Info</h1>
    <div class="faq-list-container mt-5">
        <div class="acc-container">
        <?php 
            while($faq->have_posts()) {
            $faq->the_post(); 

            // Display only Triptime Highlights
            if (get_field('faqs_type') == 'TripTime') {
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
            <?php }}            
            wp_reset_postdata();
            ?>
        </div>
<div class="faq-widget mb-5">
<ul class="faq-list row row-eq-height singular-category">
            
                <li class="entry download">
                    <a href="
                    <?php if (get_field('certificate')) {
                        echo get_field('certificate'); } 
                    ?>  
                    " title="View Sample Certificate" target="_blank">
                        <svg class="float-left">
                            <use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#download') ?>"></use>
                        </svg>
                        <span>View Sample Certificate</span>
                        <svg class="float-right">
                            <use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#download') ?>"></use>
                        </svg>
                    </a>
                </li>
        </ul>
    </div>
</div>

<!-- Links Section -->
<div class="content-block container" >
<div >

<?php if (get_field('link_1_title')) { ?>
    <p>
        <a href="<?php 
            if ( get_field('link_1')) {
                echo get_field('link_1');} 
            else { 
                 echo '#';} ?>">
                 <div style="float: left">&gt;&nbsp;</div>
                 <?php echo get_field('link_1_title');?>
        </a>
    </p>
<?php } ?>
<!-- <div style="display: none"></div> -->
<?php if (get_field('link_2_title')) { ?>
    <p>
        <a href="<?php 
            if ( get_field('link_2')) {
                echo get_field('link_2');} 
            else { 
                 echo '#';} ?>">
                 <div style="float: left">&gt;&nbsp;</div>
                 <?php echo get_field('link_2_title');?>
        </a>
    </p>
<?php } ?>

<?php if (get_field('link_3_title')) { ?>
    <p>
        <a href="<?php 
            if ( get_field('link_3')) {
                echo get_field('link_3');} 
            else { 
                 echo '#';} ?>">
                 <div style="float: left">&gt;&nbsp;</div>
                 <?php echo get_field('link_3_title');?>
        </a>
    </p>
<?php } ?>


<?php if (get_field('link_4_title')) { ?>
    <p>
        <a href="<?php 
            if ( get_field('link_4')) {
                echo get_field('link_4');} 
            else { 
                 echo '#';} ?>">
                 <div style="float: left">&gt;&nbsp;</div>
                 <?php echo get_field('link_4_title');?>
        </a>
    </p>
<?php } ?>

<?php if (get_field('link_5_title')) { ?>
    <p>
        <a href="<?php 
            if ( get_field('link_5')) {
                echo get_field('link_5');} 
            else { 
                 echo '#';} ?>">
                 <div style="float: left">&gt;&nbsp;</div>
                 <?php echo get_field('link_5_title');?>
        </a>
    </p>
<?php } ?>


</div>    
</div>
    </div>
</div>

</div>
<div class="row" data-sf-element="Row">
    <div id="Content_C022_Col00" class="sf_colsIn col-lg-12" data-sf-element="Column 1" data-placeholder-label="Column 1">


<section class="full-width-with-content bgimage box-inset" 
    style="width: 100%;  
    background-image: url(
    <?php 
        if (get_field('image_background')) { 
            the_field('image_background');
        }
        else { ?>
            https://pcustoragewordpress.blob.core.windows.net/wordpress/2023/08/triptime_pcu-promise_stress-free-zone.jpg
        <?php }
    ?>
    ); ">

    <div class="container-fluid no-gutters pl-0 pr-0">
        <div class="row no-gutters">
            <div class="col-lg-6  col-no-padding bgimage" style="">
            </div>
            <div class="col-lg-6  col-no-padding bgimage" style="">
                    <div>    
                        <div class="col-sm-12 col-exta-padding col-white-opac p-sm-2 p-md-4 p-lg-10">
                <div>

                <p>


                <?php if( get_field('text_overlay') ) { 
	                echo get_field('text_overlay');
                } ?>

</p>
            <!-- <p style="text-align:justify;"><style type="text/css">p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; font: 24.0px Roboto; color: #3a3940}
span.s1 {letter-spacing: 0.8px}
</style></p><h4 style="text-align:justify;">Service the PCU&nbsp;Way</h4><p style="text-align:justify;"><style type="text/css">p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; line-height: 26.0px; font: 18.0px Roboto; color: #3a3940}
p.p2 {margin: 0.0px 0.0px 0.0px 0.0px; line-height: 26.0px; font: 18.0px Roboto; color: #3a3940; min-height: 21.0px}
span.s1 {letter-spacing: 0.6px}
</style></p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">TripTime<sup>&reg;</sup> travel insurance is offered by Point Comfort Underwriters<sup>&reg;</sup> (PCU), a health services organization headquartered in the international insurance center of Indianapolis, Indiana. PCU is proud to provide state-of-the-art services to all TripTime travelers. Our dedicated staff brings over a century of combined experience to the table and stands ready to serve you 24/7/365.</p><p style="text-align:justify;">We also understand that many prefer the convenience of self-service. So we empower all TripTime customers with a personal travel insurance portal,&nbsp;<strong>PC</strong>YOU, a secure client access site where you can take care of most routine needs.</p><p style="text-align:justify;">We hope&nbsp;your time abroad is safe, happy and inspiring, but <s></s>we understand bad things can happen to anyone, anywhere in the world.&nbsp;Talented, compassionate people using advanced digital technology to deliver the best possible outcomes you, wherever in the world <s></s>your travels take <s></s>you&mdash;that&rsquo;s service the PCU way!</p><p style="text-align:justify;">&nbsp;
</p> -->


</div>
            </div>
</div>
            </div>
        </div>
    </div>
</section>
</div>
</div>

<!-- Social Posts Section -- Social Post Type + ACF -->
<section class="row pt-5 pb-9 no-gutters" data-sf-element="Row">
    <div id="Content_C044_Col00" class="sf_colsIn col-lg-12" data-sf-element="Column 1" data-placeholder-label="Column 1">
        <div class="content-block container" >
            <div>
                <h2>Say what?</h2>
                <p>Check out the latest on the PCU Travel social medial channels!</p>
            </div>
        </div>
    </div>
<!-- 	Social Posts content -->
	<?php
        get_template_part( 'template-parts/content', 'socialposts' );
    ?>
	
</section>
<!-- Triptime, Anytime logos -->
<div id="Content_C048_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container">
    <div class="container">
        <div class="row justify-content-center align-items-end no-gutters">
            <div class="col-md col-md-12">
                <div class="row justify-content-center brand-icons text-center">
                        <div class="col-md col-md-4 col-xl-3">
                            <a class="triptime brand-icon small" href="https://pointcomforttravel.com/insurance/triptime-insurance" target="_blank">
                                    <img src="https://pcustoragewordpress.blob.core.windows.net/wordpress/logo-full-color_tt_mrk_hor-soc_61219_gold.png?sfvrsn=bdf6aa31_0" />
                            </a>
                        </div>
                        <div class="col-md col-md-4 col-xl-3">
                            <a class="anytime brand-icon small" href="https://pointcomforttravel.com/insurance/anytime-insurance" target="_blank">
                                    <img src="https://pcustoragewordpress.blob.core.windows.net/wordpress/anytime-logo-h.png?sfvrsn=a84dbaef_0" />
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
};

get_footer(); ?>