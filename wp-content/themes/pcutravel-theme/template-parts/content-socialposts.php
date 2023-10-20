<div class="social-posts container">
    <div class="row" style="width:180480px;">
    <?php 
            $today = date('Ymd');
            $homepageSocials = new WP_Query( array(
                'posts_per_page' => 400,
                'post_type' => 'social',
            ));
            while($homepageSocials->have_posts()) {
                $homepageSocials->the_post();
            ?>        
            <?php if (get_field('social_image') || has_excerpt()) { ?>    
                <div class="social-post has-image">
            <?php } else { ?>
                <div class="social-post">
            <?php } ?> 

                <?php if (get_field('social_image') || has_excerpt()) { 
                    // Get the urls for thumbnail and IG follow from Zapier
                    $urls_with_tags = get_the_excerpt();
                    // Strip the <p> tag by replacing it empty string
                    $tags = array("<p>", "</p>");
                    $urls_without_tags = str_replace($tags, "", $urls_with_tags);
                    // Get the string before ' symbol
                    $thumbnail_url = strtok( $urls_without_tags, ",");
                    // Get the string after ' symbol
                    $follow_url = substr($urls_without_tags, strpos($urls_without_tags, ",") + 1);
                    ?>
                    <div class="image">
                            <img src="
                            <?php if (has_excerpt()) { 
                                // Echo the featured image url
                                echo $thumbnail_url; 
                            } else {
                                echo get_field('social_image'); 
                            } ?>">
                    </div>
                <?php } 
                // wp_reset_postdata();
                ?>
                <div class="entry">
                    <div class="details">
                    <?php if (get_field('post_by_logo')) { ?>
                        <img class="user-icon" src="<?php echo get_field('post_by_logo') ?>" alt="<?php echo get_field('post_by_title') ?>"> 
                        <strong><?php echo get_field('post_by_title') ?></strong>
                    <?php } else { ?>
                        <img class="user-icon" src="https://pcustoragewordpress.blob.core.windows.net/wordpress/79600046_840486036369390_1857999351851253760_n-jpg5c03921fc2104300a67d3087ee136aed.jpg" alt="pointcomforttravel"> 
                        <strong>pointcomforttravel</strong>
                    <?php } ?>
                    <a href="
                    <?php
                        if (has_excerpt()) { 
                            // Echo the follow url
                            echo $follow_url;
                        } else {
                                echo get_field('follow_link');
                        } 
                    ?>"
                    title="Follow pointcomforttravel on Instagram" target="_blank">Follow</a>                    
                </div>
                <div class="content">
                    <strong class="date"><?php echo get_the_date(); ?></strong>
                    <br>
                    <?php the_content(); ?>
                    <?php echo get_field('tag_links'); ?>
                    </div>
                </div>
            </div>            
        <?php 
            }
        ?>
    </div>
        </div>
    </div>
