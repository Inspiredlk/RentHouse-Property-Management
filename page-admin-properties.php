<?php
/* Template Name: Admin Properties */

if (!defined('ABSPATH')) {
    exit;
}

if (!current_user_can('administrator')) {
    wp_safe_redirect(home_url('/'));
    exit;
}

/* APPROVE PROPERTY */

if (isset($_GET['approve_property'])) {

    $property_id = absint($_GET['approve_property']);

    wp_update_post(array(
        'ID'          => $property_id,
        'post_status' => 'publish'
    ));

    $property = get_post($property_id);

    if ($property) {

        $owner = get_user_by(
            'id',
            $property->post_author
        );

        if (
            $owner &&
            !empty($owner->user_email)
        ) {

            $subject =
                'Property Approved - Rent House Sri Lanka';

            $message =
                "Hello " .
                $owner->display_name .
                ",\n\n" .

                "Great news! Your property has been approved.\n\n" .

                "Property: " .
                $property->post_title .
                "\n\n" .

                "Your advertisement is now live on Rent House Sri Lanka.\n\n" .

                "Thank you,\n" .
                "Rent House Sri Lanka";

            wp_mail(
                $owner->user_email,
                $subject,
                $message
            );
        }
    }

    wp_safe_redirect(
        home_url('/admin-properties/')
    );
    exit;
}

/* APPROVE PROPERTY */

if (isset($_GET['approve_property'])) {

    $property_id = absint($_GET['approve_property']);

    wp_update_post(array(
        'ID'          => $property_id,
        'post_status' => 'publish'
    ));

    $property = get_post($property_id);

    if ($property) {

        $owner = get_user_by(
            'id',
            $property->post_author
        );

        if (
            $owner &&
            !empty($owner->user_email)
        ) {

            $subject =
                'Property Approved - Rent House Sri Lanka';

            $message =
                "Hello " .
                $owner->display_name .
                ",\n\n" .

                "Great news! Your property has been approved.\n\n" .

                "Property: " .
                $property->post_title .
                "\n\n" .

                "Your advertisement is now live on Rent House Sri Lanka.\n\n" .

                "Thank you,\n" .
                "Rent House Sri Lanka";

            wp_mail(
                $owner->user_email,
                $subject,
                $message
            );
        }
    }

    wp_safe_redirect(
        home_url('/admin-properties/')
    );
    exit;
}

/* GET PENDING PROPERTIES */

$pending_properties = get_posts(array(
    'post_type'      => 'property',
    'post_status'    => 'pending',
    'posts_per_page' => -1,
));

get_header();
?>

<section class="rh-admin-properties">

    <div class="container">

        <h1>Pending Property Approvals</h1>

        <?php if (!empty($pending_properties)) : ?>

            <div class="rh-admin-property-list">

                <?php foreach ($pending_properties as $property) : ?>

                    <?php
                    $owner = get_userdata($property->post_author);

                    $price = get_post_meta(
                        $property->ID,
                        'renthouse_price',
                        true
                    );

                    $location = get_post_meta(
                        $property->ID,
                        'renthouse_location',
                        true
                    );
                    ?>

                    <div class="rh-admin-property-card">

                        <?php if (has_post_thumbnail($property->ID)) : ?>

                            <div class="rh-admin-property-image">

                                <?php
                                echo get_the_post_thumbnail(
                                    $property->ID,
                                    'large'
                                );
                                ?>

                            </div>

                        <?php endif; ?>

                        <div class="rh-admin-property-content">

                            <span class="rh-pending-badge">
    ⏳ Pending Review
</span>
                            <h3>
                                <?php echo esc_html(
                                    $property->post_title
                                ); ?>
                            </h3>

                            <p>
                                <strong>Owner:</strong>
                                <?php echo esc_html(
                                    $owner->display_name
                                ); ?>
                            </p>

                            <p>
                                <strong>Location:</strong>
                                <?php echo esc_html(
                                    $location
                                ); ?>
                            </p>

                            <p>
                                <strong>Price:</strong>
                                <?php echo esc_html(
                                    $price
                                ); ?>
                            </p>

                            <div class="rh-admin-actions">

                                <a
                                    href="<?php echo esc_url(
                                        get_permalink(
                                            $property->ID
                                        )
                                    ); ?>"
                                    target="_blank"
                                >
                                    View
                                </a>

                                <a
                                    href="<?php echo esc_url(
                                        add_query_arg(
                                            array(
                                                'approve_property' => $property->ID
                                            )
                                        )
                                    ); ?>"
                                >
                                    Approve
                                </a>

                                <a
                                    href="<?php echo esc_url(
                                        add_query_arg(
                                            array(
                                                'reject_property' => $property->ID
                                            )
                                        )
                                    ); ?>"
                                >
                                    Reject
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else : ?>

            <div class="rh-no-properties">
                <h3>No Pending Properties</h3>
                <p>All submitted properties have been reviewed.</p>
            </div>

        <?php endif; ?>

    </div>

</section>

<?php get_footer(); ?>