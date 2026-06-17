<?php
/* Template Name: My Dashboard */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
$user_roles   = $current_user->roles;
$user_role    = !empty($user_roles) ? $user_roles[0] : 'subscriber';

$phone        = get_user_meta($user_id, 'renthouse_phone', true);
$display_role = ucwords(str_replace('_', ' ', $user_role));

$is_admin = current_user_can('administrator');
$is_owner = ($user_role === 'property_owner');

/* =========================
   ADMIN STATS
========================= */

$total_users_data  = count_users();
$total_users_count = isset($total_users_data['total_users']) ? intval($total_users_data['total_users']) : 0;

$property_counts = wp_count_posts('property');

$published_properties = isset($property_counts->publish) ? intval($property_counts->publish) : 0;
$pending_properties   = isset($property_counts->pending) ? intval($property_counts->pending) : 0;
$draft_properties     = isset($property_counts->draft) ? intval($property_counts->draft) : 0;

$total_properties_count = $published_properties + $pending_properties + $draft_properties;

/* =========================
   OWNER STATS
========================= */

$owner_total_properties     = 0;
$owner_published_properties = 0;
$owner_pending_properties   = 0;
$owner_paid_properties      = 0;

if ($is_owner || $is_admin) {

    $owner_query_args = array(
        'post_type'      => 'property',
        'post_status'    => array('publish', 'pending', 'draft'),
        'posts_per_page' => -1,
        'fields'         => 'ids',
    );

    if (!$is_admin) {
        $owner_query_args['author'] = $user_id;
    }

    $owner_properties_query = new WP_Query($owner_query_args);

    if (!empty($owner_properties_query->posts)) {
        foreach ($owner_properties_query->posts as $owner_property_id) {

            $owner_total_properties++;

            $property_status = get_post_status($owner_property_id);

            if ($property_status === 'publish') {
                $owner_published_properties++;
            }

            if ($property_status === 'pending') {
                $owner_pending_properties++;
            }

            $payment_status = get_post_meta($owner_property_id, 'renthouse_payment_status', true);

            if ($payment_status === 'paid') {
                $owner_paid_properties++;
            }
        }
    }

    wp_reset_postdata();
}

/* =========================
   RECENT PROPERTIES
========================= */

$recent_property_args = array(
    'post_type'      => 'property',
    'post_status'    => array('publish', 'pending', 'draft'),
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

if (!$is_admin && $is_owner) {
    $recent_property_args['author'] = $user_id;
}

$recent_properties = new WP_Query($recent_property_args);
?>

<section class="dash-pro-page">
    <div class="dash-pro-container">

        <div class="dash-pro-hero">
            <div>
                <div class="dash-pro-pill">⚡ My Dashboard</div>
                <h1>Welcome, <?php echo esc_html($current_user->display_name); ?></h1>
                <p>Manage your rental activity from one clean dashboard.</p>
            </div>

            <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="dash-pro-logout">
                Logout
            </a>
        </div>

        <?php if (isset($_GET['property_deleted']) && $_GET['property_deleted'] === 'success') : ?>
            <div class="dash-notice-success">
                Property moved to trash successfully.
            </div>
        <?php endif; ?>

        <div class="dash-pro-summary">

            <div class="dash-pro-card">
                <div class="dash-pro-icon">👤</div>
                <span>Account Type</span>
                <h3><?php echo esc_html($display_role); ?></h3>
            </div>

            <div class="dash-pro-card">
                <div class="dash-pro-icon">✉️</div>
                <span>Email</span>
                <h3><?php echo esc_html($current_user->user_email); ?></h3>
            </div>

            <div class="dash-pro-card">
                <div class="dash-pro-icon">📱</div>
                <span>Phone</span>
                <h3><?php echo !empty($phone) ? esc_html($phone) : 'Not added'; ?></h3>
            </div>

        </div>

     <?php if ($is_admin) : ?>

<?php

$pending_count =
    wp_count_posts('property')->pending;

$latest_pending_property = get_posts(array(
    'post_type'      => 'property',
    'post_status'    => 'pending',
    'posts_per_page' => 1,
));

?>

<?php if (!empty($latest_pending_property)) : ?>

<?php
$pending_property =
    $latest_pending_property[0];

$owner = get_userdata(
    $pending_property->post_author
);
?>
<div class="rh-admin-notification">
<div class="rh-admin-notification-icon">

    <span
        class="rh-bell-icon"

        <?php if ($pending_count > 0) : ?>

        data-count="<?php echo esc_attr(
            $pending_count
        ); ?>"

        <?php endif; ?>

    >
        🔔
    </span>

</div>

    <div class="rh-admin-notification-content">

        <span>
            New Property Submitted
        </span>

        <h3>
            <?php echo esc_html(
                $pending_property->post_title
            ); ?>
        </h3>

        <p>
            Owner:
            <?php echo esc_html(
                $owner->display_name
            ); ?>
        </p>

    </div>

    <a
        href="<?php echo esc_url(
            home_url('/admin-properties/')
        ); ?>"
        class="rh-review-btn"
    >
        Review Now
    </a>

</div>

<?php endif; ?>

            <div class="dash-pro-title">
                <h2>Admin Overview</h2>
                <p>Monitor users, rental advertisements and approval status.</p>
            </div>

            <div class="dash-pro-stats-grid">

                <div class="dash-stat-card">
                    <span>Total Users</span>
                    <h3><?php echo esc_html($total_users_count); ?></h3>
                    <p>Registered users on the platform.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Total Properties</span>
                    <h3><?php echo esc_html($total_properties_count); ?></h3>
                    <p>All submitted rental advertisements.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Published Ads</span>
                    <h3><?php echo esc_html($published_properties); ?></h3>
                    <p>Currently live rental listings.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Pending Ads</span>
                    <h3><?php echo esc_html($pending_properties); ?></h3>
                    <p>Waiting for admin approval.</p>
                </div>

            </div>

        <?php elseif ($is_owner) : ?>

            <div class="dash-pro-title">
                <h2>Owner Overview</h2>
                <p>Track your rental advertisements, payment status and approval progress.</p>
            </div>

            <div class="dash-pro-stats-grid">

                <div class="dash-stat-card">
                    <span>My Properties</span>
                    <h3><?php echo esc_html($owner_total_properties); ?></h3>
                    <p>Total advertisements submitted by you.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Published</span>
                    <h3><?php echo esc_html($owner_published_properties); ?></h3>
                    <p>Your live rental advertisements.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Pending</span>
                    <h3><?php echo esc_html($owner_pending_properties); ?></h3>
                    <p>Waiting for admin approval.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Paid Ads</span>
                    <h3><?php echo esc_html($owner_paid_properties); ?></h3>
                    <p>Featured or premium paid ads.</p>
                </div>

            </div>

        <?php else : ?>
            <?php

global $wpdb;

$tenant_inquiry_count = $wpdb->get_var(
    $wpdb->prepare(
        "
        SELECT COUNT(*)
        FROM {$wpdb->prefix}renthouse_inquiries
        WHERE tenant_id = %d
        AND inquiry_status = 'replied'
        ",
        get_current_user_id()
    )
);

?>

            <div class="dash-pro-title">
                <h2>Tenant Overview</h2>
                <p>Search rentals, save properties and manage your rental activity.</p>
            </div>

            <div class="dash-pro-stats-grid">

                <div class="dash-stat-card">
                    <span>Saved Properties</span>
                    <h3>0</h3>
                    <p>Your favourite rental listings.</p>
                </div>

                <div class="dash-stat-card">
                    <span>My Inquiries</span>
                  <h3><?php echo esc_html($tenant_inquiry_count); ?></h3>
                    <p>Rental requests sent by you.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Reviews</span>
                    <h3>0</h3>
                    <p>Your rental feedback history.</p>
                </div>

                <div class="dash-stat-card">
                    <span>Profile</span>
                    <h3><?php echo !empty($phone) ? '80%' : '60%'; ?></h3>
                    <p>Profile completion status.</p>
                </div>

            </div>

        <?php endif; ?>


        <div class="dash-pro-title">
            <h2><?php echo ($is_admin || $is_owner) ? 'Quick Actions' : 'Tenant Actions'; ?></h2>
            <p>Access the most important tools from your dashboard.</p>
        </div>

        <div class="dash-pro-actions">

            <?php if ($is_admin || $is_owner) : ?>

                <a href="<?php echo esc_url(home_url('/post-ad/')); ?>" class="dash-pro-action-card">
                    <div class="dash-pro-action-icon">📣</div>
                    <h3>Post New Property</h3>
                    <p>Create a rental advertisement and select your package.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/properties/')); ?>" class="dash-pro-action-card">
                    <div class="dash-pro-action-icon">🏠</div>
                    <h3>View Properties</h3>
                    <p>Browse published rental advertisements.</p>
                </a>

                <?php if ($is_admin) : ?>

    <a
        href="<?php echo esc_url(home_url('/admin-payments/')); ?>"
        class="dash-pro-action-card"
    >
        <div class="dash-pro-action-icon">💳</div>

        <h3>Payment Verification</h3>

        <p>
            Review payment slips and approve advertisement payments.
        </p>
    </a>

<?php else : ?>

    <a
    href="<?php echo esc_url(
        home_url('/my-dashboard/#my-properties')
    ); ?>"
    class="dash-pro-action-card"
>
    <div class="dash-pro-action-icon">💳</div>

    <h3>My Payments</h3>

    <p>
        View advertisement payment status and package details.
    </p>
</a>


<?php endif; ?>

               <?php
$owner_new_inquiries = function_exists(
    'renthouse_get_owner_inquiry_count'
)
    ? renthouse_get_owner_inquiry_count(
        get_current_user_id(),
        'new'
    )
    : 0;
?>

<a
    href="<?php echo esc_url(
        home_url('/owner-inquiries/')
    ); ?>"
    class="dash-pro-action-card"
>
    <div class="dash-pro-action-icon">💬</div>

    <?php if ($owner_new_inquiries > 0) : ?>

        <span class="dash-inquiry-count">
            <?php echo esc_html($owner_new_inquiries); ?>
        </span>

    <?php endif; ?>

    <h3>Inquiries</h3>

    <p>
        View and reply to tenant inquiries for your properties.
    </p>


</a>

<?php if ($is_admin) : ?>

<a
    href="<?php echo esc_url(
        home_url('/admin-properties/')
    ); ?>"
    class="dash-pro-action-card"
>

    <div class="dash-pro-action-icon">
        🏠
    </div>

    <h3>Property Approvals</h3>

    <p>
        Review and approve pending property advertisements.
    </p>

</a>

<?php endif; ?>

            <?php else : ?>

                <a href="<?php echo esc_url(home_url('/properties/')); ?>" class="dash-pro-action-card">
                    <div class="dash-pro-action-icon">🔎</div>
                    <h3>Find Rentals</h3>
                    <p>Search houses, apartments, annexes and rooms.</p>
                </a>

               

<a
    href="<?php echo esc_url(
        home_url('/my-inquiries/')
    ); ?>"
    class="dash-pro-action-card"
>

    <div class="dash-pro-action-icon">
        💬
    </div>

    <?php if ($tenant_inquiry_count > 0) : ?>

        <span class="dash-inquiry-count">
            <?php echo esc_html(
                $tenant_inquiry_count
            ); ?>
        </span>

    <?php endif; ?>

    <h3>My Inquiries</h3>

    <p>
        View inquiry status and owner replies.
    </p>

</a>

                <div class="dash-pro-action-card">
                    <div class="dash-pro-action-icon">⭐</div>
                    <h3>My Reviews</h3>
                    <p>Your tenant feedback and reviews will appear here soon.</p>
                </div>

                <div class="dash-pro-action-card">
                    <div class="dash-pro-action-icon">❤️</div>
                    <h3>Saved Properties</h3>
                    <p>Your favourite rental listings will appear here soon.</p>
                </div>

            <?php endif; ?>

        </div>


        <?php if ($is_admin || $is_owner) : ?>

           <div
    class="dash-pro-title dash-table-title"
    id="my-properties"
>
    <h2>
        <?php echo $is_admin
            ? 'Recent Properties'
            : 'My Properties'; ?>
    </h2>

    <p>
        <?php echo $is_admin
            ? 'Latest rental advertisements submitted to the platform.'
            : 'Your latest submitted rental advertisements.'; ?>
    </p>
</div>

<div class="dash-property-panel">

                <?php if ($recent_properties->have_posts()) : ?>

                    <div class="dash-property-table">

                        <div class="dash-property-row dash-property-head">
                            <span>Property</span>
                            <span>Status</span>
                            <span>Package</span>
                            <span>Payment</span>
                            <span>Action</span>
                        </div>

                        <?php while ($recent_properties->have_posts()) : $recent_properties->the_post();

                            $property_id = get_the_ID();
$status      = get_post_status($property_id);
$package     = get_post_meta(
    $property_id,
    'renthouse_package',
    true
);

if (empty($package)) {
    $package = 'free';
}

/* Load payment status from post meta */
$payment = get_post_meta(
    $property_id,
    'renthouse_payment_status',
    true
);

if (empty($payment)) {
    $payment = 'pending';
}

/* Load latest database payment record */
$payment_record = null;
$payment_url    = '';

if (function_exists('renthouse_get_payment_by_property')) {

    $payment_record = renthouse_get_payment_by_property(
        $property_id
    );
}

if ($payment_record) {

    $payment = sanitize_key(
        $payment_record->payment_status
    );

    if (!empty($payment_record->payment_reference)) {

        $payment_url = add_query_arg(
            'payment_reference',
            $payment_record->payment_reference,
            home_url('/payment/')
        );
    }
}$edit_url = add_query_arg(
    array(
        'property_id' => $property_id,
    ),
    home_url('/edit-property/')
);

$delete_url = wp_nonce_url(
    add_query_arg(
        array(
            'renthouse_delete_property' => '1',
            'property_id'                => $property_id,
        ),
        home_url('/my-dashboard/')
    ),
    'renthouse_delete_property_' . $property_id,
    'renthouse_delete_nonce'
);
                        ?>

                            <div class="dash-property-row">
                                <span>
                                    <strong><?php echo esc_html(get_the_title()); ?></strong>
                                    <small><?php echo esc_html(get_the_date()); ?></small>
                                </span>

                                <span>
                                    <em class="dash-badge dash-badge-<?php echo esc_attr($status); ?>">
                                        <?php echo esc_html(ucfirst($status)); ?>
                                    </em>
                                </span>

                                <span><?php echo esc_html(ucfirst($package)); ?></span>

                                
<span class="dash-payment-column">

    <?php if ($package === 'free') : ?>

        <em class="dash-badge dash-badge-free">
            No Payment Required
        </em>

    <?php elseif ($payment === 'paid') : ?>

        <em class="dash-badge dash-badge-paid">
            Paid
        </em>

    <?php elseif ($payment === 'proof_submitted') : ?>

        <em class="dash-badge dash-badge-proof_submitted">
            Verification Pending
        </em>

    <?php elseif ($payment === 'rejected') : ?>

        <em class="dash-badge dash-badge-rejected">
            Payment Rejected
        </em>

    <?php elseif ($payment === 'processing') : ?>

        <em class="dash-badge dash-badge-processing">
            Processing
        </em>

    <?php else : ?>

        <em class="dash-badge dash-badge-pending">
            Pending Payment
        </em>

    <?php endif; ?>

</span>



                                
<span class="dash-action-buttons">

    <?php if ($status === 'publish') : ?>

        <a
            href="<?php echo esc_url(
                get_permalink($property_id)
            ); ?>"
            class="dash-view-link"
        >
            View
        </a>

    <?php elseif ($status === 'pending') : ?>

        <span class="dash-disabled-link">
            Waiting Approval
        </span>

    <?php else : ?>

        <span class="dash-disabled-link">
            Draft
        </span>

    <?php endif; ?>


    <?php if (!$is_admin && $package !== 'free') : ?>

        <?php if (
            $payment === 'pending' &&
            !empty($payment_url)
        ) : ?>

            <a
                href="<?php echo esc_url($payment_url); ?>"
                class="dash-pay-link"
            >
                Pay Now
            </a>

        <?php elseif (
            $payment === 'rejected' &&
            !empty($payment_url)
        ) : ?>

            <a
                href="<?php echo esc_url($payment_url); ?>"
                class="dash-resubmit-link"
            >
                Resubmit Payment
            </a>

        <?php elseif ($payment === 'proof_submitted') : ?>

            <span class="dash-verification-link">
                Verification Pending
            </span>

        <?php elseif ($payment === 'processing') : ?>

            <span class="dash-processing-link">
                Processing
            </span>

        <?php elseif ($payment === 'paid') : ?>

            <span class="dash-paid-link">
                Payment Complete
            </span>

        <?php endif; ?>

    <?php endif; ?>


    <a
        href="<?php echo esc_url($edit_url); ?>"
        class="dash-edit-link"
    >
        Edit
    </a>

    <a
        href="<?php echo esc_url($delete_url); ?>"
        class="dash-delete-link"
        onclick="return confirm(
            'Are you sure you want to delete this property?'
        );"
    >
        Delete
    </a>

</span>

                            </div>

                        <?php endwhile; wp_reset_postdata(); ?>

                    </div>

                <?php else : ?>

                    <div class="dash-empty-state">
                        <h3>No properties yet</h3>
                        <p>Your submitted rental advertisements will appear here.</p>
                        <a href="<?php echo esc_url(home_url('/post-ad/')); ?>">Post your first property</a>
                    </div>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>