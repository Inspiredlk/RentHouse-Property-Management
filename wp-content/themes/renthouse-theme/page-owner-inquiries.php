<?php
/* Template Name: Owner Inquiries Page */

if (!defined('ABSPATH')) {
    exit;
}

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$user_roles = (array) $current_user->roles;

$is_owner = in_array(
    'property_owner',
    $user_roles,
    true
);

$is_admin = current_user_can('administrator');

if (!$is_owner && !$is_admin) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

global $wpdb;

$table_name = $wpdb->prefix . 'renthouse_inquiries';

$table_exists = $wpdb->get_var(
    $wpdb->prepare(
        'SHOW TABLES LIKE %s',
        $table_name
    )
);

if ($table_exists !== $table_name) {
    wp_die('Inquiry database table was not found.');
}

$allowed_filters = array(
    'all',
    'new',
    'viewed',
    'replied',
    'contacted',
    'closed',
    'rejected',
);

$current_filter = isset($_GET['status'])
    ? sanitize_key(wp_unslash($_GET['status']))
    : 'all';

if (!in_array($current_filter, $allowed_filters, true)) {
    $current_filter = 'all';
}

if ($is_admin) {

    $total_count = (int) $wpdb->get_var(
        "SELECT COUNT(*)
         FROM {$table_name}"
    );

    $new_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE inquiry_status = %s",
            'new'
        )
    );

    $replied_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE inquiry_status = %s",
            'replied'
        )
    );

    $contacted_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE inquiry_status = %s",
            'contacted'
        )
    );

    $closed_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE inquiry_status = %s",
            'closed'
        )
    );

} else {

    $total_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE owner_id = %d",
            $current_user_id
        )
    );

    $new_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE owner_id = %d
             AND inquiry_status = %s",
            $current_user_id,
            'new'
        )
    );

    $replied_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE owner_id = %d
             AND inquiry_status = %s",
            $current_user_id,
            'replied'
        )
    );

    $contacted_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE owner_id = %d
             AND inquiry_status = %s",
            $current_user_id,
            'contacted'
        )
    );

    $closed_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE owner_id = %d
             AND inquiry_status = %s",
            $current_user_id,
            'closed'
        )
    );
}

if ($is_admin) {

    if ($current_filter === 'all') {

        $inquiries = $wpdb->get_results(
            "SELECT *
             FROM {$table_name}
             ORDER BY created_at DESC"
        );

    } else {

        $inquiries = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                 FROM {$table_name}
                 WHERE inquiry_status = %s
                 ORDER BY created_at DESC",
                $current_filter
            )
        );
    }

} else {

    if ($current_filter === 'all') {

        $inquiries = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                 FROM {$table_name}
                 WHERE owner_id = %d
                 ORDER BY created_at DESC",
                $current_user_id
            )
        );

    } else {

        $inquiries = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                 FROM {$table_name}
                 WHERE owner_id = %d
                 AND inquiry_status = %s
                 ORDER BY created_at DESC",
                $current_user_id,
                $current_filter
            )
        );
    }
}

$action_message = isset($_GET['inquiry_action'])
    ? sanitize_key(wp_unslash($_GET['inquiry_action']))
    : '';

get_header();
?>

<section class="rh-owner-inquiries-page">


<div class="rh-owner-inquiries-container">

    <div class="rh-owner-inquiries-hero">

        <div class="rh-owner-inquiries-hero-content">

            <span class="rh-owner-inquiries-label">
                Owner Communication Center
            </span>

            <h1>Property Inquiries</h1>

            <p>
                Review tenant messages, reply to inquiries and manage
                property communication from one dashboard.
            </p>

        </div>

        <a
            href="<?php echo esc_url(
                home_url('/my-dashboard/')
            ); ?>"
            class="rh-owner-inquiries-back"
        >
            Back to Dashboard
        </a>

    </div>

    <?php if ($action_message === 'replied') : ?>

        <div class="rh-inquiry-page-message success">
            Reply sent successfully.
        </div>

    <?php elseif ($action_message === 'contacted') : ?>

        <div class="rh-inquiry-page-message success">
            Inquiry marked as contacted.
        </div>

    <?php elseif ($action_message === 'closed') : ?>

        <div class="rh-inquiry-page-message success">
            Inquiry closed successfully.
        </div>

    <?php elseif ($action_message === 'rejected') : ?>

        <div class="rh-inquiry-page-message error">
            Inquiry rejected successfully.
        </div>

    <?php elseif ($action_message === 'failed') : ?>

        <div class="rh-inquiry-page-message error">
            The inquiry could not be updated. Please try again.
        </div>

    <?php elseif ($action_message === 'empty_reply') : ?>

        <div class="rh-inquiry-page-message error">
            Please enter a reply before submitting.
        </div>

    <?php endif; ?>

    <div class="rh-owner-inquiry-stats">

        <div class="rh-owner-inquiry-stat">

            <span class="rh-owner-inquiry-stat-icon blue">
                💬
            </span>

            <div>
                <small>Total Inquiries</small>
                <strong>
                    <?php echo esc_html($total_count); ?>
                </strong>
            </div>

        </div>

        <div class="rh-owner-inquiry-stat">

            <span class="rh-owner-inquiry-stat-icon orange">
                🔔
            </span>

            <div>
                <small>New Inquiries</small>
                <strong>
                    <?php echo esc_html($new_count); ?>
                </strong>
            </div>

        </div>

        <div class="rh-owner-inquiry-stat">

            <span class="rh-owner-inquiry-stat-icon purple">
                ↩️
            </span>

            <div>
                <small>Replied</small>
                <strong>
                    <?php echo esc_html($replied_count); ?>
                </strong>
            </div>

        </div>

        <div class="rh-owner-inquiry-stat">

            <span class="rh-owner-inquiry-stat-icon green">
                ✅
            </span>

            <div>
                <small>Contacted</small>
                <strong>
                    <?php echo esc_html($contacted_count); ?>
                </strong>
            </div>

        </div>

        <div class="rh-owner-inquiry-stat">

            <span class="rh-owner-inquiry-stat-icon gray">
                📁
            </span>

            <div>
                <small>Closed</small>
                <strong>
                    <?php echo esc_html($closed_count); ?>
                </strong>
            </div>

        </div>

    </div>

    <div class="rh-owner-inquiry-toolbar">

        <div>

            <h2>Manage Tenant Messages</h2>

            <p>
                Filter inquiries by status and respond to interested tenants.
            </p>

        </div>

        <div class="rh-owner-inquiry-filters">

            <?php
            $filter_labels = array(
                'all'       => 'All',
                'new'       => 'New',
                'viewed'    => 'Viewed',
                'replied'   => 'Replied',
                'contacted' => 'Contacted',
                'closed'    => 'Closed',
                'rejected'  => 'Rejected',
            );

            foreach ($filter_labels as $filter_key => $filter_label) :

                $filter_url = add_query_arg(
                    'status',
                    $filter_key,
                    home_url('/owner-inquiries/')
                );
                ?>

                <a
                    href="<?php echo esc_url($filter_url); ?>"
                    class="<?php echo $current_filter === $filter_key
                        ? 'active'
                        : ''; ?>"
                >
                    <?php echo esc_html($filter_label); ?>
                </a>

            <?php endforeach; ?>

        </div>

    </div>

    <?php if (!empty($inquiries)) : ?>

        <div class="rh-owner-inquiries-list">

            <?php foreach ($inquiries as $inquiry) : ?>

                <?php

                $property_id = absint($inquiry->property_id);
                $property = get_post($property_id);

                $property_title = $property
                    ? $property->post_title
                    : 'Property Unavailable';

                $property_url = $property
                    ? get_permalink($property_id)
                    : '';

                $property_location = get_post_meta(
                    $property_id,
                    'renthouse_location',
                    true
                );

                $property_price = get_post_meta(
                    $property_id,
                    'renthouse_price',
                    true
                );

                $status = sanitize_key(
                    $inquiry->inquiry_status
                );

                $status_labels = function_exists(
                    'renthouse_get_inquiry_statuses'
                )
                    ? renthouse_get_inquiry_statuses()
                    : array();

                $status_text = $status_labels[$status]
                    ?? ucfirst($status);

                $phone_number = preg_replace(
                    '/[^0-9]/',
                    '',
                    $inquiry->tenant_phone
                );

                $whatsapp_number = $phone_number;

                if (
                    strlen($whatsapp_number) === 10 &&
                    strpos($whatsapp_number, '0') === 0
                ) {
                    $whatsapp_number =
                        '94' . substr($whatsapp_number, 1);
                }

                ?>

                <article class="rh-owner-inquiry-card">

                    <div class="rh-owner-inquiry-card-top">

                        <div class="rh-owner-inquiry-reference">

                            <span>
                                <?php echo esc_html(
                                    $inquiry->inquiry_reference
                                ); ?>
                            </span>

                            <small>
                                Received
                                <?php echo esc_html(
                                    date_i18n(
                                        'M j, Y g:i A',
                                        strtotime(
                                            $inquiry->created_at
                                        )
                                    )
                                ); ?>
                            </small>

                        </div>

                        <span
                            class="rh-owner-inquiry-status status-<?php echo esc_attr(
                                $status
                            ); ?>"
                        >
                            <?php echo esc_html($status_text); ?>
                        </span>

                    </div>

                    <div class="rh-owner-inquiry-property">

                        <div class="rh-owner-inquiry-property-image">

                            <?php if (
                                $property &&
                                has_post_thumbnail($property_id)
                            ) : ?>

                                <?php echo get_the_post_thumbnail(
                                    $property_id,
                                    'medium',
                                    array(
                                        'alt' => esc_attr(
                                            $property_title
                                        ),
                                    )
                                ); ?>

                            <?php else : ?>

                                <div class="rh-owner-inquiry-placeholder">
                                    🏠
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="rh-owner-inquiry-property-details">

                            <span>Property Inquiry</span>

                            <h3>
                                <?php echo esc_html(
                                    $property_title
                                ); ?>
                            </h3>

                            <div class="rh-owner-inquiry-property-meta">

                                <?php if (!empty($property_location)) : ?>

                                    <span>
                                        📍
                                        <?php echo esc_html(
                                            $property_location
                                        ); ?>
                                    </span>

                                <?php endif; ?>

                                <?php if (!empty($property_price)) : ?>

                                    <span>
                                        💰
                                        <?php echo esc_html(
                                            $property_price
                                        ); ?>
                                    </span>

                                <?php endif; ?>

                            </div>

                            <?php if (!empty($property_url)) : ?>

                                <a
                                    href="<?php echo esc_url(
                                        $property_url
                                    ); ?>"
                                    class="rh-owner-view-property"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    View Property
                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                    <div class="rh-owner-inquiry-grid">

                        <div class="rh-owner-inquiry-tenant">

                            <span class="rh-owner-inquiry-section-label">
                                Tenant Details
                            </span>

                            <div class="rh-owner-tenant-profile">

                                <div class="rh-owner-tenant-avatar">
                                    <?php echo esc_html(
                                        strtoupper(
                                            substr(
                                                $inquiry->tenant_name,
                                                0,
                                                1
                                            )
                                        )
                                    ); ?>
                                </div>

                                <div>

                                    <h4>
                                        <?php echo esc_html(
                                            $inquiry->tenant_name
                                        ); ?>
                                    </h4>

                                    <p>
                                        Preferred Contact:
                                        <strong>
                                            <?php echo esc_html(
                                                ucfirst(
                                                    $inquiry->preferred_contact
                                                )
                                            ); ?>
                                        </strong>
                                    </p>

                                </div>

                            </div>

                            <div class="rh-owner-tenant-contact-list">

                                <a
                                    href="tel:<?php echo esc_attr(
                                        $phone_number
                                    ); ?>"
                                >
                                    <span>📞</span>

                                    <div>
                                        <small>Phone Number</small>
                                        <strong>
                                            <?php echo esc_html(
                                                $inquiry->tenant_phone
                                            ); ?>
                                        </strong>
                                    </div>
                                </a>

                                <a
                                    href="mailto:<?php echo esc_attr(
                                        $inquiry->tenant_email
                                    ); ?>"
                                >
                                    <span>✉️</span>

                                    <div>
                                        <small>Email Address</small>
                                        <strong>
                                            <?php echo esc_html(
                                                $inquiry->tenant_email
                                            ); ?>
                                        </strong>
                                    </div>
                                </a>

                                <?php if (!empty($whatsapp_number)) : ?>

                                    <a
                                        href="https://wa.me/<?php echo esc_attr(
                                            $whatsapp_number
                                        ); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <span>💬</span>

                                        <div>
                                            <small>WhatsApp</small>
                                            <strong>Open Chat</strong>
                                        </div>
                                    </a>

                                <?php endif; ?>

                            </div>

                        </div>

                        <div class="rh-owner-inquiry-message">

                            <span class="rh-owner-inquiry-section-label">
                                Tenant Message
                            </span>

                            <div class="rh-owner-inquiry-message-box">

                                <span>“</span>

                                <p>
                                    <?php echo nl2br(
                                        esc_html(
                                            $inquiry->message
                                        )
                                    ); ?>
                                </p>

                            </div>

                            <?php if (
                                !empty($inquiry->owner_reply)
                            ) : ?>

                                <div class="rh-owner-existing-reply">

                                    <small>Your Latest Reply</small>

                                    <p>
                                        <?php echo nl2br(
                                            esc_html(
                                                $inquiry->owner_reply
                                            )
                                        ); ?>
                                    </p>

                                    <?php if (
                                        !empty($inquiry->replied_at)
                                    ) : ?>

                                        <span>
                                            Replied
                                            <?php echo esc_html(
                                                date_i18n(
                                                    'M j, Y g:i A',
                                                    strtotime(
                                                        $inquiry->replied_at
                                                    )
                                                )
                                            ); ?>
                                        </span>

                                    <?php endif; ?>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <?php if (
                        !in_array(
                            $status,
                            array('closed', 'rejected'),
                            true
                        )
                    ) : ?>

                        <form
                            method="POST"
                            class="rh-owner-inquiry-reply-form"
                        >

                            <?php
                            wp_nonce_field(
                                'renthouse_owner_inquiry_action',
                                'renthouse_owner_inquiry_nonce'
                            );
                            ?>

                            <input
                                type="hidden"
                                name="inquiry_id"
                                value="<?php echo esc_attr(
                                    $inquiry->id
                                ); ?>"
                            >

                            <label
                                for="owner_reply_<?php echo esc_attr(
                                    $inquiry->id
                                ); ?>"
                            >
                                Reply to Tenant
                            </label>

                            <textarea
                                id="owner_reply_<?php echo esc_attr(
                                    $inquiry->id
                                ); ?>"
                                name="owner_reply"
                                maxlength="2000"
                                placeholder="Write a clear reply about availability, rental terms or a property visit."
                            ><?php echo esc_textarea(
                                $inquiry->owner_reply
                            ); ?></textarea>

                            <div class="rh-owner-inquiry-actions">

                                <button
                                    type="submit"
                                    name="renthouse_owner_inquiry_action"
                                    value="reply"
                                    class="rh-owner-reply-btn"
                                >
                                    Send Reply
                                </button>

                                <button
                                    type="submit"
                                    name="renthouse_owner_inquiry_action"
                                    value="contacted"
                                    class="rh-owner-contacted-btn"
                                >
                                    Mark Contacted
                                </button>

                                <button
                                    type="submit"
                                    name="renthouse_owner_inquiry_action"
                                    value="close"
                                    class="rh-owner-close-btn"
                                >
                                    Close Inquiry
                                </button>

                                <button
                                    type="submit"
                                    name="renthouse_owner_inquiry_action"
                                    value="reject"
                                    class="rh-owner-reject-btn"
                                    onclick="return confirm('Are you sure you want to reject this inquiry?');"
                                >
                                    Reject
                                </button>

                            </div>

                        </form>

                    <?php else : ?>

                        <div class="rh-owner-inquiry-final-state">

                            <?php if ($status === 'closed') : ?>

                                <span>✅</span>

                                <p>
                                    This inquiry has been closed.
                                </p>

                            <?php else : ?>

                                <span>🚫</span>

                                <p>
                                    This inquiry has been rejected.
                                </p>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                </article>

            <?php endforeach; ?>

        </div>

    <?php else : ?>

        <div class="rh-owner-inquiries-empty">

            <span>💬</span>

            <h2>No Inquiries Found</h2>

            <p>
                Tenant inquiries for your properties will appear here.
            </p>

            <a href="<?php echo esc_url(
                home_url('/my-dashboard/')
            ); ?>">
                Return to Dashboard
            </a>

        </div>

    <?php endif; ?>

</div>


</section>

<?php get_footer(); ?>
