<?php
/* Template Name: My Inquiries */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;

global $wpdb;

$table_name = $wpdb->prefix . 'renthouse_inquiries';

/* Load tenant inquiries */

$inquiries = $wpdb->get_results(
    $wpdb->prepare(
        "
        SELECT *
        FROM {$table_name}
        WHERE tenant_id = %d
        ORDER BY created_at DESC
        ",
        $user_id
    )
);
?>

<section class="rh-my-inquiries-page">

    <div class="rh-my-inquiries-container">

        <div class="rh-my-inquiries-hero">

            <div>

                <span class="rh-page-label">
                    My Inquiries
                </span>

                <h1>
                    Track Your Property Inquiries
                </h1>

                <p>
                    View inquiry status, owner replies and
                    property information in one place.
                </p>

            </div>

        </div>

        <?php if (!empty($inquiries)) : ?>
            <?php

$reply_count = 0;

foreach ($inquiries as $inquiry) {

    if (
        !empty($inquiry->owner_reply) &&
        $inquiry->inquiry_status === 'replied'
    ) {
        $reply_count++;
    }
}

?>

<?php if ($reply_count > 0) : ?>

<div class="rh-tenant-notification">

    <div class="rh-tenant-notification-icon">
        🔔
    </div>

    <div class="rh-tenant-notification-content">

        <span>New Reply Received</span>

        <h3>
            You have
            <?php echo esc_html($reply_count); ?>
            owner reply(s)
        </h3>

        <p>
            Property owners have responded
            to your inquiries.
        </p>

    </div>

</div>

<?php endif; ?>

            <div class="rh-my-inquiries-list">

                <?php foreach ($inquiries as $inquiry) :

                    $property_id = absint(
                        $inquiry->property_id
                    );

                    $property_title = get_the_title(
                        $property_id
                    );

                    $property_link = get_permalink(
                        $property_id
                    );

                    $property_image = get_the_post_thumbnail_url(
                        $property_id,
                        'medium'
                    );

                    if (!$property_image) {
                        $property_image = '';
                    }

                ?>

                    <div class="rh-my-inquiry-card">

                        <div class="rh-my-inquiry-top">

                            <div class="rh-my-inquiry-property">

                                <?php if ($property_image) : ?>

                                    <img
                                        src="<?php echo esc_url($property_image); ?>"
                                        alt=""
                                    >

                                <?php endif; ?>

                                <div>

                                    <h3>
                                        <?php echo esc_html(
                                            $property_title
                                        ); ?>
                                    </h3>

                                    <small>
                                        Inquiry Date:
                                        <?php echo esc_html(
                                            date_i18n(
                                                'd M Y',
                                                strtotime(
                                                    $inquiry->created_at
                                                )
                                            )
                                        ); ?>
                                    </small>

                                </div>

                            </div>

                            <span
                                class="rh-inquiry-status status-<?php echo esc_attr(
                                    $inquiry->inquiry_status
                                ); ?>"
                            >
                                <?php echo esc_html(
                                    ucfirst(
                                        $inquiry->inquiry_status
                                    )
                                ); ?>
                            </span>

                        </div>

                        <div class="rh-my-inquiry-message">

                            <strong>
                                Your Message
                            </strong>

                            <p>
                                <?php echo nl2br(
                                    esc_html(
                                        $inquiry->message
                                    )
                                ); ?>
                            </p>

                        </div>

                        <div class="rh-my-inquiry-reply">

                            <strong>
                                Owner Reply
                            </strong>

                            <?php if (
                                !empty(
                                    $inquiry->owner_reply
                                )
                            ) : ?>

                                <p>
                                    <?php echo nl2br(
                                        esc_html(
                                            $inquiry->owner_reply
                                        )
                                    ); ?>
                                </p>

                            <?php else : ?>

                                <p class="rh-waiting-reply">
                                    Waiting for owner response...
                                </p>

                            <?php endif; ?>

                        </div>

                        <div class="rh-my-inquiry-actions">

                            <a
                                href="<?php echo esc_url(
                                    $property_link
                                ); ?>"
                            >
                                View Property
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else : ?>

            <div class="rh-empty-inquiries">

                <h2>
                    No inquiries found
                </h2>

                <p>
                    Your submitted inquiries will
                    appear here.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php get_footer(); ?>