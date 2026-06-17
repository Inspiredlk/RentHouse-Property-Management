<?php get_header(); ?>

<section class="properties-archive-page">
    <div class="container">

        <div class="archive-title">
            <h1>Property Listings</h1>
            <p>Browse rental properties matching your search</p>
        </div>

        <form class="archive-search-box advanced-archive-search" method="GET" action="<?php echo esc_url(home_url('/properties/')); ?>">

            <select name="location">
                <option value="">Location</option>
                <option value="Colombo" <?php selected($_GET['location'] ?? '', 'Colombo'); ?>>Colombo</option>
                <option value="Colombo 05" <?php selected($_GET['location'] ?? '', 'Colombo 05'); ?>>Colombo 05</option>
                <option value="Maharagama" <?php selected($_GET['location'] ?? '', 'Maharagama'); ?>>Maharagama</option>
                <option value="Nugegoda" <?php selected($_GET['location'] ?? '', 'Nugegoda'); ?>>Nugegoda</option>
                <option value="Kandy" <?php selected($_GET['location'] ?? '', 'Kandy'); ?>>Kandy</option>
                <option value="Galle" <?php selected($_GET['location'] ?? '', 'Galle'); ?>>Galle</option>
                <option value="Gampaha" <?php selected($_GET['location'] ?? '', 'Gampaha'); ?>>Gampaha</option>
                <option value="Negombo" <?php selected($_GET['location'] ?? '', 'Negombo'); ?>>Negombo</option>
                <option value="Matara" <?php selected($_GET['location'] ?? '', 'Matara'); ?>>Matara</option>
                <option value="Kurunegala" <?php selected($_GET['location'] ?? '', 'Kurunegala'); ?>>Kurunegala</option>
            </select>

            <select name="property_type">
                <option value="">Property Type</option>
                <option value="House Rent" <?php selected($_GET['property_type'] ?? '', 'House Rent'); ?>>House Rent</option>
                <option value="Apartment" <?php selected($_GET['property_type'] ?? '', 'Apartment'); ?>>Apartment</option>
                <option value="Annex" <?php selected($_GET['property_type'] ?? '', 'Annex'); ?>>Annex</option>
                <option value="Room" <?php selected($_GET['property_type'] ?? '', 'Room'); ?>>Room</option>
                <option value="Villa" <?php selected($_GET['property_type'] ?? '', 'Villa'); ?>>Villa</option>
                <option value="Commercial" <?php selected($_GET['property_type'] ?? '', 'Commercial'); ?>>Commercial</option>
            </select>

            <select name="beds">
                <option value="">Bedrooms</option>
                <option value="1" <?php selected($_GET['beds'] ?? '', '1'); ?>>1 Bed</option>
                <option value="2" <?php selected($_GET['beds'] ?? '', '2'); ?>>2 Beds</option>
                <option value="3" <?php selected($_GET['beds'] ?? '', '3'); ?>>3 Beds</option>
                <option value="4" <?php selected($_GET['beds'] ?? '', '4'); ?>>4+ Beds</option>
            </select>

           <select name="price_range">
    <option value="">Price Range</option>
    <option value="0-50000" <?php selected($_GET['price_range'] ?? '', '0-50000'); ?>>Below Rs. 50,000</option>
    <option value="50000-100000" <?php selected($_GET['price_range'] ?? '', '50000-100000'); ?>>Rs. 50,000 - Rs. 100,000</option>
    <option value="100000-150000" <?php selected($_GET['price_range'] ?? '', '100000-150000'); ?>>Rs. 100,000 - Rs. 150,000</option>
    <option value="150000-200000" <?php selected($_GET['price_range'] ?? '', '150000-200000'); ?>>Rs. 150,000 - Rs. 200,000</option>
    <option value="200000-999999999" <?php selected($_GET['price_range'] ?? '', '200000-999999999'); ?>>Above Rs. 200,000</option>
</select>
            <button type="submit">Search</button>

            <a class="clear-search-btn" href="<?php echo esc_url(home_url('/properties/')); ?>">
                Clear
            </a>

        </form>

        <div class="property-grid">

            <?php
            $meta_query = array('relation' => 'AND');

            if (!empty($_GET['location'])) {
                $meta_query[] = array(
                    'key'     => 'renthouse_location',
                    'value'   => sanitize_text_field($_GET['location']),
                    'compare' => '='
                );
            }

            if (!empty($_GET['property_type'])) {
                $meta_query[] = array(
                    'key'     => 'renthouse_property_type',
                    'value'   => sanitize_text_field($_GET['property_type']),
                    'compare' => '='
                );
            }

            if (!empty($_GET['beds'])) {
                $beds_value = sanitize_text_field($_GET['beds']);

                if ($beds_value === '4') {
                    $meta_query[] = array(
                        'key'     => 'renthouse_bedrooms',
                        'value'   => 4,
                        'type'    => 'NUMERIC',
                        'compare' => '>='
                    );
                } else {
                    $meta_query[] = array(
                        'key'     => 'renthouse_bedrooms',
                        'value'   => $beds_value,
                        'compare' => '='
                    );
                }
            }

            /*
             * Price Filter
             * IMPORTANT:
             * renthouse_price is saved like "Rs. 70,000 / month"
             * So pure numeric meta filtering will not work perfectly unless price is saved as number.
             * For now, we support clean numeric prices if saved as 70000.
             * Later we should add a separate numeric meta key: renthouse_price_number.
             */

            if (!empty($_GET['price_range'])) {

    $price_range = sanitize_text_field($_GET['price_range']);
    $range_parts = explode('-', $price_range);

    if (count($range_parts) === 2) {

        $min_price = intval($range_parts[0]);
        $max_price = intval($range_parts[1]);

        $meta_query[] = array(
            'key'     => 'renthouse_price_number',
            'value'   => array($min_price, $max_price),
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN'
        );
    }
}
            $args = array(
                'post_type'      => 'property',
                'posts_per_page' => 12,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC'
            );

            if (count($meta_query) > 1) {
                $args['meta_query'] = $meta_query;
            }

            $properties = new WP_Query($args);

            if ($properties->have_posts()) :
                while ($properties->have_posts()) :
                    $properties->the_post();

                    $price    = get_post_meta(get_the_ID(), 'renthouse_price', true);
                    $location = get_post_meta(get_the_ID(), 'renthouse_location', true);
                    $beds     = get_post_meta(get_the_ID(), 'renthouse_bedrooms', true);
                    $baths    = get_post_meta(get_the_ID(), 'renthouse_bathrooms', true);
                    $parking  = get_post_meta(get_the_ID(), 'renthouse_parking', true);
                    $type     = get_post_meta(get_the_ID(), 'renthouse_property_type', true);
                    $package  = get_post_meta(get_the_ID(), 'renthouse_package', true);
            ?>

            <div class="property-card">

                <div class="property-image">

                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large'); ?>
                    <?php else : ?>
                        <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80" alt="Property">
                    <?php endif; ?>

                    <?php
                    if ($package === 'premium') {
                        echo '<span class="badge premium-badge">★ Premium</span>';
                    } elseif ($package === 'featured') {
                        echo '<span class="badge featured-badge">🔥 Featured</span>';
                    } elseif (!empty($type)) {
                        echo '<span class="badge type-badge">' . esc_html($type) . '</span>';
                    }
                    ?>

                </div>

                <div class="property-info">

                    <h3><?php the_title(); ?></h3>

                    <p class="location">
                        📍 <?php echo esc_html($location); ?>
                    </p>

                    <p class="price">
                        <?php echo esc_html($price); ?>
                    </p>

                    <p class="features">
                        🛏 <?php echo esc_html($beds); ?> Beds
                        &nbsp; 🚿 <?php echo esc_html($baths); ?> Baths
                        &nbsp; 🚗 <?php echo esc_html($parking); ?> Parking
                    </p>

                    <?php if (!empty($type)) : ?>
                        <p class="property-type-pill">
                            <?php echo esc_html($type); ?>
                        </p>
                    <?php endif; ?>

                    <p class="property-desc">
                        <?php echo esc_html(wp_trim_words(get_the_content(), 20)); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>">View Details</a>

                </div>
            </div>

            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>

                <div class="no-results">
                    <h2>No Properties Found</h2>
                    <p>No rental properties matched your search. Try another location, property type, bedroom count, or price range.</p>
                </div>

            <?php endif; ?>

        </div>

    </div>
</section>

<?php get_footer(); ?>