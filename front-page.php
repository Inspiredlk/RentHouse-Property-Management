<?php get_header(); ?>

<section class="hero">
    
    <div class="hero-content">

        <h1>Find Your Perfect House For Rent</h1>

        <p>Search thousands of houses, apartments and annexes across Sri Lanka</p>
<form class="search-box advanced-search-box" method="GET" action="<?php echo esc_url(home_url('/properties/')); ?>">

    <select name="location">
        <option value="">Location</option>
        <option value="Colombo">Colombo</option>
        <option value="Colombo 05">Colombo 05</option>
        <option value="Maharagama">Maharagama</option>
        <option value="Nugegoda">Nugegoda</option>
        <option value="Kandy">Kandy</option>
        <option value="Galle">Galle</option>
        <option value="Gampaha">Gampaha</option>
        <option value="Negombo">Negombo</option>
        <option value="Matara">Matara</option>
        <option value="Kurunegala">Kurunegala</option>
    </select>

    <select name="property_type">
        <option value="">Property Type</option>
        <option value="House Rent">House Rent</option>
        <option value="Apartment">Apartment</option>
        <option value="Annex">Annex</option>
        <option value="Room">Room</option>
        <option value="Villa">Villa</option>
        <option value="Commercial">Commercial</option>
    </select>

    <select name="beds">
        <option value="">Beds</option>
        <option value="1">1 Bed</option>
        <option value="2">2 Beds</option>
        <option value="3">3 Beds</option>
        <option value="4">4+ Beds</option>
    </select>

    <select name="price_range">
        <option value="">Budget</option>
        <option value="0-50000">Below Rs. 50,000</option>
        <option value="50000-100000">Rs. 50,000 - Rs. 100,000</option>
        <option value="100000-150000">Rs. 100,000 - Rs. 150,000</option>
        <option value="150000-200000">Rs. 150,000 - Rs. 200,000</option>
        <option value="200000-999999999">Above Rs. 200,000</option>
    </select>

    <button type="submit">Search</button>

</form>

    </div>
</section>


<!-- =========================
     QUICK ACTIONS SECTION WITH LEFT TENANT TAGS
========================= -->
<section class="quick-actions quick-actions-with-tags">
    <div class="container">

        <div class="portal-section-title left">
            <h2>What would you like to do?</h2>
            <p>Make your rental property decisions faster and easier.</p>
        </div>

        <div class="quick-action-layout">

            <aside class="tenant-side-tags">

                <a href="<?php echo esc_url(home_url('/properties/?property_type=House Rent')); ?>" class="tenant-side-tag">
                    <span>🏡</span>
                    <strong>Families</strong>
                </a>

                <a href="<?php echo esc_url(home_url('/properties/?property_type=Room')); ?>" class="tenant-side-tag">
                    <span>🎓</span>
                    <strong>Students</strong>
                </a>

                <a href="<?php echo esc_url(home_url('/properties/?property_type=Apartment')); ?>" class="tenant-side-tag">
                    <span>💼</span>
                    <strong>Professionals</strong>
                </a>

                <a href="<?php echo esc_url(home_url('/properties/?property_type=Annex')); ?>" class="tenant-side-tag">
                    <span>💑</span>
                    <strong>Couples</strong>
                </a>

            </aside>

            <div class="quick-action-grid">

                <a href="<?php echo esc_url(home_url('/properties/?property_type=House Rent')); ?>" class="quick-card rent-house">
                    <div class="quick-icon">🏠</div>
                    <h3>Find a House for Rent</h3>
                    <p>Browse houses available for rent across Sri Lanka.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/properties/?property_type=Apartment')); ?>" class="quick-card apartment">
                    <div class="quick-icon">🏢</div>
                    <h3>Find an Apartment</h3>
                    <p>Search modern apartments with bedrooms and parking.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/properties/?property_type=Annex')); ?>" class="quick-card annex">
                    <div class="quick-icon">🔑</div>
                    <h3>Find an Annex</h3>
                    <p>Find annexes suitable for students and workers.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/post-ad/')); ?>" class="quick-card post-property">
                    <div class="quick-icon">📢</div>
                    <h3>Post Your Ad</h3>
                    <p>List your property and reach tenants quickly.</p>
                </a>

            </div>

        </div>

    </div>
</section>
<!-- =========================
     FEATURED PROJECT AUTO SLIDER
========================= -->
<section class="project-slider-section">
    <div class="container">

        <div class="section-title">
            <h2>Featured Projects</h2>
            <p>Explore promoted rental and property projects across Sri Lanka</p>
        </div>

    </div>

    <div class="project-slider">
        <div class="project-track">

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=80" alt="Luxury Residence Colombo">
                <div class="project-caption">Luxury Residence Colombo</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=700&q=80" alt="Modern Villa Galle">
                <div class="project-caption">Modern Villa Galle</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=700&q=80" alt="Apartment Complex Colombo">
                <div class="project-caption">Apartment Complex Colombo</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=700&q=80" alt="Premium Homes Kandy">
                <div class="project-caption">Premium Homes Kandy</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=700&q=80" alt="City Apartments">
                <div class="project-caption">City Apartments</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?auto=format&fit=crop&w=700&q=80" alt="Family Housing Project">
                <div class="project-caption">Family Housing Project</div>
            </div>


            <!-- Duplicate slides for infinite smooth loop -->
            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=80" alt="Luxury Residence Colombo">
                <div class="project-caption">Luxury Residence Colombo</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=700&q=80" alt="Modern Villa Galle">
                <div class="project-caption">Modern Villa Galle</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=700&q=80" alt="Apartment Complex Colombo">
                <div class="project-caption">Apartment Complex Colombo</div>
            </div>

            <div class="project-slide">
                <img src="https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=700&q=80" alt="Premium Homes Kandy">
                <div class="project-caption">Premium Homes Kandy</div>
            </div>

        </div>
    </div>
</section>


<section class="featured-properties">
    <div class="container">

        <div class="section-title">
            <h2>Featured Properties</h2>
            <p>Find the best rental properties in Sri Lanka</p>
        </div>

        <div class="property-grid">

            <?php
          $featured_properties = new WP_Query(array(
    'post_type'      => 'property',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'meta_key'       => 'renthouse_package',
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'key'     => 'renthouse_package',
            'value'   => array('featured', 'premium'),
            'compare' => 'IN',
        ),
        array(
            'key'     => 'renthouse_payment_status',
            'value'   => 'paid',
            'compare' => '=',
        ),
    ),
    'orderby'        => array(
        'meta_value' => 'DESC',
        'date'       => 'DESC',
    ),
));
            if ($featured_properties->have_posts()) :
                while ($featured_properties->have_posts()) :
                    $featured_properties->the_post();

                    $price    = get_post_meta(get_the_ID(), 'renthouse_price', true);
                    $location = get_post_meta(get_the_ID(), 'renthouse_location', true);
                    $beds     = get_post_meta(get_the_ID(), 'renthouse_bedrooms', true);
                    $baths    = get_post_meta(get_the_ID(), 'renthouse_bathrooms', true);
                    $parking  = get_post_meta(get_the_ID(), 'renthouse_parking', true);
                    $type     = get_post_meta(get_the_ID(), 'renthouse_property_type', true);
            ?>

            <div class="property-card">

               <div class="property-image">

    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('medium_large'); ?>
    <?php else : ?>
        <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80" alt="Property">
    <?php endif; ?>

    <?php
    $package = get_post_meta(get_the_ID(), 'renthouse_package', true);

    if ($package === 'premium') {
        echo '<span class="badge premium-badge">Premium</span>';
    } elseif ($package === 'featured') {
        echo '<span class="badge featured-badge">Featured</span>';
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

                <p>No paid featured or premium properties available yet.</p>

            <?php endif; ?>

        </div>

    </div>
</section>


<!-- =========================
     ADVERTISEMENT BANNER
========================= -->
<section class="home-ad-banner">
    <div class="container">

        <div class="ad-banner-card">
            <div>
                <span>Advertise with us</span>
                <h2>Promote Your Property to More Tenants</h2>
                <p>Choose featured or premium packages to increase visibility and get faster tenant inquiries.</p>
            </div>

            <a href="<?php echo esc_url(home_url('/pricing/')); ?>">
                View Packages
            </a>
        </div>

    </div>
</section>


<!-- =========================
     TRENDING PROPERTIES
========================= -->
<!-- =========================
     TRENDING PROPERTIES / LATEST RENTAL DEALS
========================= -->
<section class="trending-properties">
    <div class="container">

        <div class="portal-section-title left with-link">
            <div>
                <span>Trending</span>
                <h2>Latest Rental Deals</h2>
                <p>Recently listed rental properties across Sri Lanka.</p>
            </div>

            <a href="<?php echo esc_url(home_url('/properties/')); ?>">View More →</a>
        </div>

        <div class="deal-grid">

            <?php
            $deal_properties = new WP_Query(array(
                'post_type'      => 'property',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC'
            ));

            if ($deal_properties->have_posts()) :
                while ($deal_properties->have_posts()) :
                    $deal_properties->the_post();
$deal_price    = get_post_meta(get_the_ID(), 'renthouse_price', true);
$deal_location = get_post_meta(get_the_ID(), 'renthouse_location', true);
$deal_beds     = get_post_meta(get_the_ID(), 'renthouse_bedrooms', true);
$deal_baths    = get_post_meta(get_the_ID(), 'renthouse_bathrooms', true);
$deal_parking  = get_post_meta(get_the_ID(), 'renthouse_parking', true);
$deal_type     = get_post_meta(get_the_ID(), 'renthouse_property_type', true);
$deal_package  = get_post_meta(get_the_ID(), 'renthouse_package', true);
            ?>

            <a href="<?php the_permalink(); ?>" class="deal-card">

                <div class="deal-img">

                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large'); ?>
                    <?php else : ?>
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Property">
                    <?php endif; ?>

                    <?php
if ($deal_package === 'premium') {
    echo '<div class="deal-badge premium-deal-badge">★ Premium</div>';
} elseif ($deal_package === 'featured') {
    echo '<div class="deal-badge featured-deal-badge">🔥 Featured</div>';
} elseif (!empty($deal_type)) {
    echo '<div class="deal-badge type-deal-badge">' . esc_html($deal_type) . '</div>';
}
?>

                </div>

                <div class="deal-info">

    <p class="deal-location">
        📍 <?php echo esc_html($deal_location); ?>
    </p>

    <h3><?php the_title(); ?></h3>

    <p class="deal-price">
        <?php echo esc_html($deal_price); ?>
    </p>

   <div class="deal-features">
    <span>🛏 <?php echo esc_html($deal_beds); ?> Beds</span>
    <span>🚿 <?php echo esc_html($deal_baths); ?> Baths</span>
    <span>🚗 <?php echo esc_html($deal_parking); ?> Parking</span>
</div>

<?php if (!empty($deal_type)) : ?>
    <div class="deal-type-pill">
        <?php echo esc_html($deal_type); ?>
    </div>
<?php endif; ?>
    <span class="deal-view-btn">View Details</span>

</div>

            </a>

            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>

                <p>No rental properties available yet.</p>

            <?php endif; ?>

        </div>

    </div>
</section>

<section class="popular-locations">
    <div class="container">

        <div class="section-title">
            <h2>Popular Locations</h2>
            <p>Browse rental properties by location</p>
        </div>

        <?php
        $popular_locations = array(
            'Colombo',
            'Kandy',
            'Galle',
            'Gampaha',
            'Negombo',
            'Matara'
        );
        ?>

        <div class="location-grid">

            <?php foreach ($popular_locations as $location_name) : ?>

                <?php
                $location_count = renthouse_get_property_count_by_location($location_name);
                $property_label = ($location_count == 1) ? 'Property' : 'Properties';
                ?>

                <a class="location-card" href="<?php echo esc_url(home_url('/properties/?location=' . urlencode($location_name))); ?>">
                    <?php echo esc_html($location_name); ?>

                    <span>
                        <?php echo esc_html($location_count); ?> <?php echo esc_html($property_label); ?>
                    </span>
                </a>

            <?php endforeach; ?>

        </div>

    </div>
</section>


<!-- =========================
     POPULAR SEARCHES - MODERN
========================= -->
<section class="popular-searches modern-searches">
    <div class="container">

        <div class="section-title">
            <span class="section-kicker">Popular Searches</span>
            <h2>Find Rentals Faster</h2>
            <p>Choose from the most searched rental property categories in Sri Lanka.</p>
        </div>

        <div class="modern-search-grid">

            <div class="modern-search-card">
                <div class="search-card-top">
                    <div class="search-icon">🏠</div>
                    <div>
                        <h3>Houses for Rent</h3>
                        <p>Family houses in popular cities</p>
                    </div>
                </div>

                <div class="search-link-list">
                    <a href="<?php echo esc_url(home_url('/properties/?location=Colombo&property_type=House Rent')); ?>">
                        <span>House for rent in Colombo</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Kandy&property_type=House Rent')); ?>">
                        <span>House for rent in Kandy</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Gampaha&property_type=House Rent')); ?>">
                        <span>House for rent in Gampaha</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Nugegoda&property_type=House Rent')); ?>">
                        <span>House for rent in Nugegoda</span>
                        <strong>→</strong>
                    </a>
                </div>
            </div>

            <div class="modern-search-card featured-search-card">
                <div class="search-card-top">
                    <div class="search-icon">🏢</div>
                    <div>
                        <h3>Apartments for Rent</h3>
                        <p>Modern apartments with easy access</p>
                    </div>
                </div>

                <div class="search-link-list">
                    <a href="<?php echo esc_url(home_url('/properties/?location=Colombo&property_type=Apartment')); ?>">
                        <span>Apartment for rent in Colombo</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Nugegoda&property_type=Apartment')); ?>">
                        <span>Apartment for rent in Nugegoda</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Maharagama&property_type=Apartment')); ?>">
                        <span>Apartment for rent in Maharagama</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Kandy&property_type=Apartment')); ?>">
                        <span>Apartment for rent in Kandy</span>
                        <strong>→</strong>
                    </a>
                </div>
            </div>

            <div class="modern-search-card">
                <div class="search-card-top">
                    <div class="search-icon">🔑</div>
                    <div>
                        <h3>Annexes for Rent</h3>
                        <p>Budget-friendly spaces for tenants</p>
                    </div>
                </div>

                <div class="search-link-list">
                    <a href="<?php echo esc_url(home_url('/properties/?location=Colombo&property_type=Annex')); ?>">
                        <span>Annex for rent in Colombo</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Gampaha&property_type=Annex')); ?>">
                        <span>Annex for rent in Gampaha</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Kandy&property_type=Annex')); ?>">
                        <span>Annex for rent in Kandy</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo esc_url(home_url('/properties/?location=Matara&property_type=Annex')); ?>">
                        <span>Annex for rent in Matara</span>
                        <strong>→</strong>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- =========================
     TOP CITIES - COLORFUL CHIPS
========================= -->
<section class="top-cities city-chip-section">
    <div class="container">

        <div class="section-title">
            <span class="section-kicker">Top Locations</span>
            <h2>Explore Rentals by City</h2>
            <p>Choose a popular Sri Lankan city and quickly browse available rental properties.</p>
        </div>

        <div class="city-chip-wrap">

            <a href="<?php echo esc_url(home_url('/properties/?location=Colombo')); ?>" class="city-chip chip-orange">
                <span>🏙️</span> Colombo
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Gampaha')); ?>" class="city-chip chip-green">
                <span>🏡</span> Gampaha
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Kandy')); ?>" class="city-chip chip-purple">
                <span>⛰️</span> Kandy
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Galle')); ?>" class="city-chip chip-sky">
                <span>🌊</span> Galle
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Nugegoda')); ?>" class="city-chip chip-pink">
                <span>🚆</span> Nugegoda
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Maharagama')); ?>" class="city-chip chip-yellow">
                <span>🏘️</span> Maharagama
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Negombo')); ?>" class="city-chip chip-blue">
                <span>✈️</span> Negombo
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Matara')); ?>" class="city-chip chip-green">
                <span>🌴</span> Matara
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Kurunegala')); ?>" class="city-chip chip-orange">
                <span>🛣️</span> Kurunegala
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Battaramulla')); ?>" class="city-chip chip-purple">
                <span>🏢</span> Battaramulla
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Rajagiriya')); ?>" class="city-chip chip-pink">
                <span>🌆</span> Rajagiriya
            </a>

            <a href="<?php echo esc_url(home_url('/properties/?location=Kadawatha')); ?>" class="city-chip chip-sky">
                <span>🚗</span> Kadawatha
            </a>

        </div>

    </div>
</section>
<!-- =========================
     RENTAL MARKET INSIGHTS - DYNAMIC
========================= -->
<!-- =========================
     RENTAL MARKET INSIGHTS - DYNAMIC GRAPH
========================= -->
<section class="market-insights dynamic-market-insights">
    <div class="container">

        <div class="section-title">
            <h2>Rental Market Insights</h2>
            <p>Based on currently listed rental properties on Rent House Sri Lanka</p>
        </div>

        <?php
        $market_stats = renthouse_get_market_insights_stats();

        $average_rent = $market_stats['average'];
        $highest_rent = $market_stats['highest'];
        $lowest_rent  = $market_stats['lowest'];
        $total_listed = $market_stats['count'];

        $chart_values = array(
            array('label' => 'Lowest', 'value' => $lowest_rent),
            array('label' => 'Average', 'value' => $average_rent),
            array('label' => 'Highest', 'value' => $highest_rent)
        );

        $chart_min = $lowest_rent;
        $chart_max = $highest_rent;

        $points = array();

        if ($total_listed > 0 && $chart_max > 0) {
            foreach ($chart_values as $index => $item) {
                $x = 80 + ($index * 240);

                if ($chart_max == $chart_min) {
                    $y = 140;
                } else {
                    $normalized = ($item['value'] - $chart_min) / ($chart_max - $chart_min);
                    $y = 220 - ($normalized * 160);
                }

                $points[] = round($x) . ',' . round($y);
            }
        }

        $points_string = implode(' ', $points);
        ?>

        <div class="market-insight-layout">

            <div class="market-graph-card">

                <div class="market-graph-header">
                    <div>
                        <span>Rent Price Graph</span>
                        <h3>Current Rental Price Range</h3>
                    </div>

                    <p><?php echo esc_html($total_listed); ?> active listings</p>
                </div>

                <?php if ($total_listed > 0) : ?>

                    <div class="market-svg-box">

                        <div class="graph-y-label top">
                            Rs. <?php echo esc_html(number_format($highest_rent)); ?>
                        </div>

                        <div class="graph-y-label middle">
                            Rs. <?php echo esc_html(number_format($average_rent)); ?>
                        </div>

                        <div class="graph-y-label bottom">
                            Rs. <?php echo esc_html(number_format($lowest_rent)); ?>
                        </div>

                        <svg class="market-rent-svg" viewBox="0 0 640 280" preserveAspectRatio="none">

                            <line x1="0" y1="60" x2="640" y2="60" class="market-grid-line"></line>
                            <line x1="0" y1="140" x2="640" y2="140" class="market-grid-line"></line>
                            <line x1="0" y1="220" x2="640" y2="220" class="market-grid-line"></line>

                            <polyline
                                class="market-rent-line"
                                points="<?php echo esc_attr($points_string); ?>"
                            />

                            <?php foreach ($points as $point) :
                                list($cx, $cy) = explode(',', $point);
                            ?>
                                <circle class="market-line-dot" cx="<?php echo esc_attr($cx); ?>" cy="<?php echo esc_attr($cy); ?>" r="8"></circle>
                            <?php endforeach; ?>

                        </svg>

                        <div class="graph-x-labels">
                            <span>Lowest<br><strong>Rs. <?php echo esc_html(number_format($lowest_rent)); ?></strong></span>
                            <span>Average<br><strong>Rs. <?php echo esc_html(number_format($average_rent)); ?></strong></span>
                            <span>Highest<br><strong>Rs. <?php echo esc_html(number_format($highest_rent)); ?></strong></span>
                        </div>

                    </div>

                <?php else : ?>

                    <div class="market-empty-state">
                        No rental price data available yet.
                    </div>

                <?php endif; ?>

            </div>

            <div class="market-summary-panel">

                <span class="summary-badge">Market Summary</span>

                <h3>Rental insight is calculated from active listings</h3>

                <p>
                    These values are generated using rental prices added to published property advertisements.
                    The graph updates automatically when property prices are added or changed.
                </p>

                <div class="summary-mini-stats">

                    <div>
                        <strong>Rs. <?php echo esc_html(number_format($average_rent)); ?></strong>
                        <span>Average Rent</span>
                    </div>

                    <div>
                        <strong>Rs. <?php echo esc_html(number_format($highest_rent)); ?></strong>
                        <span>Highest Rent</span>
                    </div>

                    <div>
                        <strong>Rs. <?php echo esc_html(number_format($lowest_rent)); ?></strong>
                        <span>Lowest Rent</span>
                    </div>

                    <div>
                        <strong><?php echo esc_html($total_listed); ?></strong>
                        <span>Listings</span>
                    </div>

                </div>

                <a href="<?php echo esc_url(home_url('/properties/')); ?>">
                    Explore Properties
                </a>

            </div>

        </div>

    </div>
</section>

<!-- =========================
     FINAL CTA
========================= -->
<section class="final-cta">
    <div class="container">

        <div class="final-cta-card">
            <h2>Your next rental home is just a search away</h2>
            <p>Search properties, contact owners, or post your property advertisement within minutes.</p>

            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/properties/')); ?>">Browse Properties</a>
                <a href="<?php echo esc_url(home_url('/post-ad/')); ?>">Post Your Ad</a>
            </div>
        </div>

    </div>
</section>

<?php get_footer(); ?>