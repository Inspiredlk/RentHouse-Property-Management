
<?php get_header(); ?>

<?php
while (have_posts()) :
    the_post();

    $property_id = get_the_ID();

    $price    = get_post_meta($property_id, 'renthouse_price', true);
    $location = get_post_meta($property_id, 'renthouse_location', true);
    $beds     = get_post_meta($property_id, 'renthouse_bedrooms', true);
    $baths    = get_post_meta($property_id, 'renthouse_bathrooms', true);
    $parking  = get_post_meta($property_id, 'renthouse_parking', true);
    $type     = get_post_meta($property_id, 'renthouse_property_type', true);
    $phone    = get_post_meta($property_id, 'renthouse_phone', true);
    $whatsapp = get_post_meta($property_id, 'renthouse_whatsapp', true);

    $owner_id = absint(
        get_post_field('post_author', $property_id)
    );

    $current_user = wp_get_current_user();

    $tenant_name = is_user_logged_in()
        ? $current_user->display_name
        : '';

    $tenant_email = is_user_logged_in()
        ? $current_user->user_email
        : '';

    $tenant_phone = is_user_logged_in()
        ? get_user_meta(
            get_current_user_id(),
            'renthouse_phone',
            true
        )
        : '';

    $current_user_roles = is_user_logged_in()
        ? (array) $current_user->roles
        : array();

    $is_tenant = in_array(
        'tenant',
        $current_user_roles,
        true
    );

    $is_property_owner =
        is_user_logged_in() &&
        get_current_user_id() === $owner_id;

    $inquiry_error = isset($_GET['inquiry_error'])
        ? sanitize_key(
            wp_unslash($_GET['inquiry_error'])
        )
        : '';

    $inquiry_success =
        isset($_GET['inquiry_submitted']) &&
        sanitize_key(
            wp_unslash($_GET['inquiry_submitted'])
        ) === 'success';

    $inquiry_reference = isset($_GET['inquiry_reference'])
        ? sanitize_text_field(
            wp_unslash($_GET['inquiry_reference'])
        )
        : '';
?>

<section class="rh-single-page">

    <div class="container">

        <div class="rh-breadcrumb">
            Home / Properties / <?php the_title(); ?>
        </div>

        <div class="rh-title-card">

            <div>

                <span class="rh-badge">
                    <?php echo esc_html($type); ?>
                </span>

                <h1><?php the_title(); ?></h1>

                <p>
                    📍 <?php echo esc_html($location); ?>
                </p>

            </div>

            <div class="rh-price">
                <?php echo esc_html($price); ?>
            </div>

        </div>

        <div class="rh-property-layout">

            <main class="rh-property-main">

                <div class="rh-main-image">

                    <?php if (has_post_thumbnail()) : ?>

                        <?php the_post_thumbnail('large'); ?>

                    <?php else : ?>

                        <img
                            src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80"
                            alt="Property"
                        >

                    <?php endif; ?>

                </div>

                <div class="rh-feature-grid">

                    <div class="rh-feature">
                        <span>🛏</span>
                        <strong>
                            <?php echo esc_html($beds); ?>
                        </strong>
                        <p>Bedrooms</p>
                    </div>

                    <div class="rh-feature">
                        <span>🚿</span>
                        <strong>
                            <?php echo esc_html($baths); ?>
                        </strong>
                        <p>Bathrooms</p>
                    </div>

                    <div class="rh-feature">
                        <span>🚗</span>
                        <strong>
                            <?php echo esc_html($parking); ?>
                        </strong>
                        <p>Parking</p>
                    </div>

                    <div class="rh-feature">
                        <span>🏠</span>
                        <strong>
                            <?php echo esc_html($type); ?>
                        </strong>
                        <p>Property Type</p>
                    </div>

                </div>

                <div class="rh-description-card">

                    <h2>Property Description</h2>

                    <div class="rh-description">
                        <?php the_content(); ?>
                    </div>

                </div>

            </main>

            <aside class="rh-sidebar">

                <div class="rh-contact-card">

                    <h3>Contact Owner</h3>

                    <p>
                        Interested in this property?
                        Contact the owner directly.
                    </p>

                    <?php if ($phone) : ?>

                        <a
                            class="rh-call-btn"
                            href="tel:<?php echo esc_attr($phone); ?>"
                        >
                            📞 Call Owner
                        </a>

                    <?php endif; ?>

                    <?php if ($whatsapp) : ?>

                        <?php
                        $whatsapp_number = preg_replace(
                            '/[^0-9]/',
                            '',
                            $whatsapp
                        );

                        if (
                            strlen($whatsapp_number) === 10 &&
                            str_starts_with(
                                $whatsapp_number,
                                '0'
                            )
                        ) {
                            $whatsapp_number =
                                '94' .
                                substr(
                                    $whatsapp_number,
                                    1
                                );
                        }
                        ?>

                        <a
                            class="rh-whatsapp-btn"
                            href="https://wa.me/<?php echo esc_attr(
                                $whatsapp_number
                            ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            💬 WhatsApp
                        </a>

                    <?php endif; ?>

                </div>


                <div
                    class="rh-inquiry-card"
                    id="send-inquiry"
                >

                    <div class="rh-inquiry-card-header">

                        <div class="rh-inquiry-card-icon">
                            💬
                        </div>

                        <div>
                            <span>Secure Property Inquiry</span>
                            <h3>Send an Inquiry</h3>

                            <p>
                                Ask about availability, rental terms,
                                advance payments or property visits.
                            </p>
                        </div>

                    </div>


                    <?php if ($inquiry_success) : ?>

                        <div class="rh-inquiry-success">

                            <strong>
                                Inquiry sent successfully!
                            </strong>

                            <p>
                                The property owner will review your
                                message and contact you soon.
                            </p>

                            <?php if (!empty($inquiry_reference)) : ?>

                                <small>
                                    Reference:
                                    <?php echo esc_html(
                                        $inquiry_reference
                                    ); ?>
                                </small>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>


                    <?php if (!empty($inquiry_error)) : ?>

                        <div class="rh-inquiry-error">

                            <?php
                            $error_messages = array(
                                'login_required' =>
                                    'Please log in as a tenant to send an inquiry.',

                                'invalid_property' =>
                                    'This property is not available for inquiries.',

                                'tenant_only' =>
                                    'Only tenant accounts can send property inquiries.',

                                'own_property' =>
                                    'You cannot send an inquiry for your own property.',

                                'empty_fields' =>
                                    'Please complete all required fields.',

                                'invalid_email' =>
                                    'Please enter a valid email address.',

                                'invalid_phone' =>
                                    'Phone number must contain 10 digits and start with 07.',

                                'message_too_short' =>
                                    'Your message must contain at least 10 characters.',

                                'message_too_long' =>
                                    'Your message is too long.',

                                'duplicate' =>
                                    'You recently sent an inquiry for this property. Please wait before sending another.',

                                'database_error' =>
                                    'Inquiry service is currently unavailable.',

                                'save_failed' =>
                                    'Your inquiry could not be saved. Please try again.',

                                'owner_not_found' =>
                                    'The property owner could not be found.',
                            );

                            echo esc_html(
                                $error_messages[$inquiry_error] ??
                                'Something went wrong. Please try again.'
                            );
                            ?>

                        </div>

                    <?php endif; ?>


                    <?php if (!is_user_logged_in()) : ?>

                        <div class="rh-inquiry-login-notice">

                            <span>🔐</span>

                            <h4>Tenant Login Required</h4>

                            <p>
                                Log in to send a secure inquiry
                                to the property owner.
                            </p>

                            <a
                                href="<?php echo esc_url(
                                    add_query_arg(
                                        'redirect_to',
                                        rawurlencode(
                                            get_permalink($property_id)
                                        ),
                                        home_url('/login/')
                                    )
                                ); ?>"
                                class="rh-inquiry-login-btn"
                            >
                                Login to Send Inquiry
                            </a>

                        </div>

                    <?php elseif ($is_property_owner) : ?>

                        <div class="rh-inquiry-account-notice">

                            <span>🏠</span>

                            <h4>This is your property</h4>

                            <p>
                                You cannot send an inquiry
                                for your own advertisement.
                            </p>

                        </div>

                    <?php elseif (
                        !$is_tenant &&
                        !current_user_can('administrator')
                    ) : ?>

                        <div class="rh-inquiry-account-notice">

                            <span>👤</span>

                            <h4>Tenant Account Required</h4>

                            <p>
                                Please use a tenant account
                                to send property inquiries.
                            </p>

                        </div>

                    <?php else : ?>

                        <form
                            method="POST"
                            class="rh-inquiry-form"
                        >

                            <?php
                            wp_nonce_field(
                                'renthouse_submit_inquiry_action',
                                'renthouse_inquiry_nonce'
                            );
                            ?>

                            <input
                                type="hidden"
                                name="property_id"
                                value="<?php echo esc_attr(
                                    $property_id
                                ); ?>"
                            >

                            <div class="rh-inquiry-form-group">

                                <label for="tenant_name">
                                    Full Name
                                </label>

                                <input
                                    id="tenant_name"
                                    type="text"
                                    name="tenant_name"
                                    value="<?php echo esc_attr(
                                        $tenant_name
                                    ); ?>"
                                    required
                                >

                            </div>

                            <div class="rh-inquiry-form-group">

                                <label for="tenant_email">
                                    Email Address
                                </label>

                                <input
                                    id="tenant_email"
                                    type="email"
                                    name="tenant_email"
                                    value="<?php echo esc_attr(
                                        $tenant_email
                                    ); ?>"
                                    required
                                >

                            </div>

                            <div class="rh-inquiry-form-group">

                                <label for="tenant_phone">
                                    Phone Number
                                </label>

                                <input
                                    id="tenant_phone"
                                    type="tel"
                                    name="tenant_phone"
                                    value="<?php echo esc_attr(
                                        $tenant_phone
                                    ); ?>"
                                    placeholder="Example: 0771234567"
                                    pattern="07[0-9]{8}"
                                    maxlength="10"
                                    inputmode="numeric"
                                    required
                                >

                            </div>

                            <div class="rh-inquiry-form-group">

                                <label for="preferred_contact">
                                    Preferred Contact
                                </label>

                                <select
                                    id="preferred_contact"
                                    name="preferred_contact"
                                    required
                                >
                                    <option value="phone">
                                        Phone Call
                                    </option>

                                    <option value="whatsapp">
                                        WhatsApp
                                    </option>

                                    <option value="email">
                                        Email
                                    </option>
                                </select>

                            </div>

                            <div class="rh-inquiry-form-group">

                                <label for="inquiry_message">
                                    Your Message
                                </label>

                                <textarea
                                    id="inquiry_message"
                                    name="inquiry_message"
                                    minlength="10"
                                    maxlength="1500"
                                    placeholder="Example: Is this property available next month? I would like to arrange a property visit."
                                    required
                                ></textarea>

                                <small>
                                    Minimum 10 characters.
                                </small>

                            </div>

                            <button
                                type="submit"
                                name="renthouse_submit_inquiry"
                                class="rh-inquiry-submit-btn"
                            >
                                Send Inquiry
                                <span>→</span>
                            </button>

                            <p class="rh-inquiry-security-note">
                                🔒 Your contact information is shared
                                only with the property owner.
                            </p>

                        </form>

                    <?php endif; ?>

                </div>


                <div class="rh-info-card">

                    <h3>Property Information</h3>

                    <div class="rh-info-row">
                        <span>Location</span>
                        <strong>
                            <?php echo esc_html($location); ?>
                        </strong>
                    </div>

                    <div class="rh-info-row">
                        <span>Price</span>
                        <strong>
                            <?php echo esc_html($price); ?>
                        </strong>
                    </div>

                    <div class="rh-info-row">
                        <span>Type</span>
                        <strong>
                            <?php echo esc_html($type); ?>
                        </strong>
                    </div>

                    <div class="rh-info-row">
                        <span>Bedrooms</span>
                        <strong>
                            <?php echo esc_html($beds); ?>
                        </strong>
                    </div>

                    <div class="rh-info-row">
                        <span>Bathrooms</span>
                        <strong>
                            <?php echo esc_html($baths); ?>
                        </strong>
                    </div>

                    <div class="rh-info-row">
                        <span>Parking</span>
                        <strong>
                            <?php echo esc_html($parking); ?>
                        </strong>
                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>

<?php endwhile; ?>

<?php get_footer(); ?>

