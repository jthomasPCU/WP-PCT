        <?php 
            $today = date('Ymd');
            $homepageSocials = WP_Query( array(
                'post_per_page' => -1,
                'post_type' => 'social',
                'meta_key' => 'social_date',
                'orderby' => 'meta_value_number',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key'   => 'social_date',
                        'compare' => '>=',
                        'value' => $today,
                        'type' => 'numeric'
                    )
                )
            ));
            while($homepageSocials->have_posts()) {
                $homepageSocials->the_post();
                
                echo the_title();    
            }
        ?>