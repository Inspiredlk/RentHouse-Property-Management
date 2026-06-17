<?php
/* Template Name: Advertisement */

get_header();
?>

<section class="rh-advertisement-page">

    <div class="container">

        <div class="rh-ad-hero">

            <span class="rh-ad-badge">
                Advertisement Packages
            </span>

            <h1>
                Advertise Your Property
            </h1>

            <p>
                Reach thousands of tenants across Sri Lanka and
                get inquiries directly from interested renters.
            </p>

            <div class="rh-ad-buttons">

                <a href="<?php echo esc_url(home_url('/post-ad/')); ?>" class="rh-ad-primary-btn">
                    Post Property
                </a>

                <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="rh-ad-secondary-btn">
                    View Pricing
                </a>

            </div>

        </div>

        <div class="rh-ad-features">

            <div class="rh-ad-feature-card">
                <div class="rh-ad-icon">🏠</div>
                <h3>Free Listings</h3>
                <p>
                    Publish rental advertisements and connect with tenants.
                </p>
            </div>

            <div class="rh-ad-feature-card">
                <div class="rh-ad-icon">⭐</div>
                <h3>Featured Ads</h3>
                <p>
                    Highlight your property and appear above standard listings.
                </p>
            </div>

            <div class="rh-ad-feature-card">
                <div class="rh-ad-icon">💬</div>
                <h3>Direct Inquiries</h3>
                <p>
                    Receive tenant messages directly through the platform.
                </p>
            </div>

            <div class="rh-ad-feature-card">
                <div class="rh-ad-icon">🚀</div>
                <h3>More Visibility</h3>
                <p>
                    Increase exposure and rent your property faster.
                </p>
            </div>

        </div>

    </div>

</section>

<?php get_footer(); ?>