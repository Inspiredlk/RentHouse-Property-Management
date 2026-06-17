<?php get_header(); ?>

<section class="pricing-page">
    <div class="container">

        <div class="pricing-hero">
            <span class="pricing-label">Advertising Packages</span>
            <h1>Choose the Best Plan for Your Property Ad</h1>
            <p>
                Select a package that helps your rental property reach more tenants across Sri Lanka.
            </p>
        </div>

        <div class="pricing-grid">

            <!-- Free Plan -->
            <div class="pricing-card">
                <div class="pricing-card-header">
                    <span class="plan-badge free">Free</span>
                    <h2>Free Ad</h2>
                    <p>Best for testing your first listing.</p>
                </div>

                <div class="price-box">
                    <span>Rs.</span> 0
                    <small>/ ad</small>
                </div>

                <ul>
                    <li>1 property advertisement</li>
                    <li>Visible in normal listings</li>
                    <li>Basic property details</li>
                    <li>Admin approval required</li>
                    <li>Contact details display</li>
                </ul>

                <a href="<?php echo esc_url(home_url('/post-ad/')); ?>" class="pricing-btn">
                    Post Free Ad
                </a>
            </div>

            <!-- Basic Plan -->
            <div class="pricing-card">
                <div class="pricing-card-header">
                    <span class="plan-badge basic">Basic</span>
                    <h2>Basic Ad</h2>
                    <p>Suitable for simple rental promotions.</p>
                </div>

                <div class="price-box">
                    <span>Rs.</span> 500
                    <small>/ ad</small>
                </div>

                <ul>
                    <li>1 property advertisement</li>
                    <li>Better listing visibility</li>
                    <li>Photos and description display</li>
                    <li>Phone and WhatsApp contact</li>
                    <li>Visible for 14 days</li>
                </ul>

                <a href="<?php echo esc_url(home_url('/post-ad/?package=basic')); ?>" class="pricing-btn">
                    Choose Basic
                </a>
            </div>

            <!-- Featured Plan -->
            <div class="pricing-card featured-plan">
                <div class="popular-tag">Most Popular</div>

                <div class="pricing-card-header">
                    <span class="plan-badge featured">Featured</span>
                    <h2>Featured Ad</h2>
                    <p>Get more attention from tenants.</p>
                </div>

                <div class="price-box">
                    <span>Rs.</span> 1,500
                    <small>/ ad</small>
                </div>

                <ul>
                    <li>Featured badge on listing</li>
                    <li>Homepage featured section display</li>
                    <li>Priority in search results</li>
                    <li>Photos and full description</li>
                    <li>Visible for 30 days</li>
                </ul>

                <a href="<?php echo esc_url(home_url('/post-ad/?package=featured')); ?>" class="pricing-btn featured-btn">
                    Choose Featured
                </a>
            </div>

            <!-- Premium Plan -->
            <div class="pricing-card">
                <div class="pricing-card-header">
                    <span class="plan-badge premium">Premium</span>
                    <h2>Premium Ad</h2>
                    <p>Maximum exposure for faster renting.</p>
                </div>

                <div class="price-box">
                    <span>Rs.</span> 3,000
                    <small>/ ad</small>
                </div>

                <ul>
                    <li>Top placement in listings</li>
                    <li>Featured + boosted visibility</li>
                    <li>Homepage priority display</li>
                    <li>Best for urgent rentals</li>
                    <li>Visible for 45 days</li>
                </ul>

                <a href="<?php echo esc_url(home_url('/post-ad/?package=premium')); ?>" class="pricing-btn">
                    Choose Premium
                </a>
            </div>

        </div>

        <div class="pricing-note">
            <h3>Need help choosing a package?</h3>
            <p>
                Free ads are suitable for simple listings. Featured and Premium packages are better for owners who need more tenant inquiries and faster results.
            </p>
        </div>

    </div>
</section>

<?php get_footer(); ?>