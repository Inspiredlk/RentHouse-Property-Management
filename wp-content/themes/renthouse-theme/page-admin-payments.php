<?php
/* Template Name: Admin Payments Page */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

if (!current_user_can('administrator')) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

global $wpdb;

$payments_table = $wpdb->prefix . 'renthouse_payments';

$allowed_filters = array(
    'all',
    'pending',
    'proof_submitted',
    'processing',
    'paid',
    'rejected',
    'failed',
    'cancelled',
    'refunded',
);

$current_filter = isset($_GET['status'])
    ? sanitize_key(wp_unslash($_GET['status']))
    : 'all';

if (!in_array($current_filter, $allowed_filters, true)) {
    $current_filter = 'all';
}

if ($current_filter === 'all') {

    $payments = $wpdb->get_results(
        "SELECT *
         FROM {$payments_table}
         WHERE amount > 0
         ORDER BY id DESC"
    );

} else {

    $payments = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT *
             FROM {$payments_table}
             WHERE payment_status = %s
             AND amount > 0
             ORDER BY id DESC",
            $current_filter
        )
    );
}

$payment_counts = array();
foreach ($allowed_filters as $status) {

    if ($status === 'all') {

        $payment_counts[$status] = (int) $wpdb->get_var(
            "SELECT COUNT(*)
             FROM {$payments_table}
             WHERE amount > 0"
        );

    } else {

        $payment_counts[$status] = (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*)
                 FROM {$payments_table}
                 WHERE payment_status = %s
                 AND amount > 0",
                $status
            )
        );
    }
}
get_header();
?>

<section class="admin-payments-page">

    <div class="admin-payments-container">

        <div class="admin-payments-hero">

            <div>

                <span class="admin-payments-badge">
                    Admin Control Center
                </span>

                <h1>Payment Verification</h1>

                <p>
                    Review advertisement payments, verify uploaded slips
                    and approve or reject payment submissions.
                </p>

            </div>

            <a
                href="<?php echo esc_url(home_url('/my-dashboard/')); ?>"
                class="admin-payments-back"
            >
                Back to Dashboard
            </a>

        </div>

        <?php if (isset($_GET['payment_action'])) : ?>

            <?php
            $payment_action = sanitize_key(
                wp_unslash($_GET['payment_action'])
            );
            ?>

            <?php if ($payment_action === 'approved') : ?>

                <div class="admin-payment-notice success">
                    Payment approved successfully.
                </div>

            <?php elseif ($payment_action === 'rejected') : ?>

                <div class="admin-payment-notice rejected">
                    Payment rejected successfully.
                </div>

            <?php elseif ($payment_action === 'failed') : ?>

                <div class="admin-payment-notice error">
                    Payment update failed. Please try again.
                </div>

            <?php endif; ?>

        <?php endif; ?>

        <div class="admin-payment-stats">

            <div class="admin-stat-card">
                <span>Total Payments</span>
                <strong>
                    <?php echo esc_html($payment_counts['all']); ?>
                </strong>
            </div>

            <div class="admin-stat-card orange">
                <span>Pending Proofs</span>
                <strong>
                    <?php echo esc_html(
                        $payment_counts['proof_submitted']
                    ); ?>
                </strong>
            </div>

            <div class="admin-stat-card green">
                <span>Approved Payments</span>
                <strong>
                    <?php echo esc_html($payment_counts['paid']); ?>
                </strong>
            </div>

            <div class="admin-stat-card red">
                <span>Rejected Payments</span>
                <strong>
                    <?php echo esc_html($payment_counts['rejected']); ?>
                </strong>
            </div>

        </div>

        <div class="admin-payment-filters">

            <?php foreach ($allowed_filters as $status) : ?>

                <?php
                $filter_url = add_query_arg(
                    'status',
                    $status,
                    home_url('/admin-payments/')
                );

                $filter_label = $status === 'all'
                    ? 'All'
                    : ucwords(str_replace('_', ' ', $status));
                ?>

                <a
                    href="<?php echo esc_url($filter_url); ?>"
                    class="<?php echo $current_filter === $status
                        ? 'active'
                        : ''; ?>"
                >
                    <?php echo esc_html($filter_label); ?>

                    <span>
                        <?php echo esc_html(
                            $payment_counts[$status]
                        ); ?>
                    </span>
                </a>

            <?php endforeach; ?>

        </div>

        <?php if (!empty($payments)) : ?>

            <div class="admin-payment-list">

                <?php foreach ($payments as $payment) : ?>

                    <?php
                    $property_id = absint($payment->property_id);
                    $owner_id    = absint($payment->owner_id);

                    $property_title = get_the_title($property_id);

                    $owner = get_userdata($owner_id);

                    $owner_name = $owner
                        ? $owner->display_name
                        : 'Unknown Owner';

                    $owner_email = $owner
                        ? $owner->user_email
                        : '';

                    $slip_url = '';

                    if (!empty($payment->slip_attachment_id)) {
                        $slip_url = wp_get_attachment_url(
                            absint($payment->slip_attachment_id)
                        );
                    }

                    $status_label = ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $payment->payment_status
                        )
                    );

                    $package_label = ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $payment->package
                        )
                    );
                    ?>

                    <article class="admin-payment-card">

                        <div class="admin-payment-card-top">

                            <div>

                                <span class="admin-payment-reference">
                                    <?php echo esc_html(
                                        $payment->payment_reference
                                    ); ?>
                                </span>

                                <h2>
                                    <?php echo esc_html(
                                        $property_title
                                            ? $property_title
                                            : 'Deleted Property'
                                    ); ?>
                                </h2>

                                <p>
                                    Submitted by
                                    <strong>
                                        <?php echo esc_html($owner_name); ?>
                                    </strong>

                                    <?php if (!empty($owner_email)) : ?>
                                        · <?php echo esc_html($owner_email); ?>
                                    <?php endif; ?>
                                </p>

                            </div>

                            <span class="admin-status-badge status-<?php echo esc_attr(
                                $payment->payment_status
                            ); ?>">
                                <?php echo esc_html($status_label); ?>
                            </span>

                        </div>

                        <div class="admin-payment-info-grid">

                            <div>
                                <small>Package</small>
                                <strong>
                                    <?php echo esc_html($package_label); ?>
                                </strong>
                            </div>

                            <div>
                                <small>Amount</small>
                                <strong>
                                    LKR
                                    <?php echo esc_html(
                                        number_format(
                                            (float) $payment->amount,
                                            2
                                        )
                                    ); ?>
                                </strong>
                            </div>

                            <div>
                                <small>Payment Method</small>
                                <strong>
                                    <?php
                                    echo esc_html(
                                        !empty($payment->payment_method)
                                            ? ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $payment->payment_method
                                                )
                                            )
                                            : 'Not Submitted'
                                    );
                                    ?>
                                </strong>
                            </div>

                            <div>
                                <small>Bank Reference</small>
                                <strong>
                                    <?php echo esc_html(
                                        !empty($payment->bank_reference)
                                            ? $payment->bank_reference
                                            : 'Not Submitted'
                                    ); ?>
                                </strong>
                            </div>

                            <div>
                                <small>Created</small>
                                <strong>
                                    <?php echo esc_html(
                                        mysql2date(
                                            'M j, Y g:i A',
                                            $payment->created_at
                                        )
                                    ); ?>
                                </strong>
                            </div>

                            <div>
                                <small>Updated</small>
                                <strong>
                                    <?php echo esc_html(
                                        mysql2date(
                                            'M j, Y g:i A',
                                            $payment->updated_at
                                        )
                                    ); ?>
                                </strong>
                            </div>

                        </div>

                        <?php if (!empty($payment->admin_note)) : ?>

                            <div class="admin-payment-existing-note">
                                <small>Current Note</small>

                                <p>
                                    <?php echo esc_html(
                                        $payment->admin_note
                                    ); ?>
                                </p>
                            </div>

                        <?php endif; ?>

                        <div class="admin-payment-card-actions">

                            <div class="admin-payment-view-actions">

                                <?php if ($property_id && get_post($property_id)) : ?>

                                    <a
                                        href="<?php echo esc_url(
                                            get_edit_post_link($property_id)
                                        ); ?>"
                                        class="admin-action-btn property"
                                        target="_blank"
                                    >
                                        View Property
                                    </a>

                                <?php endif; ?>

                                <?php if (!empty($slip_url)) : ?>

                                    <a
                                        href="<?php echo esc_url($slip_url); ?>"
                                        class="admin-action-btn slip"
                                        target="_blank"
                                        rel="noopener"
                                    >
                                        View Payment Slip
                                    </a>

                                <?php else : ?>

                                    <span class="admin-no-slip">
                                        No slip uploaded
                                    </span>

                                <?php endif; ?>

                            </div>

                            <?php if (
                                in_array(
    $payment->payment_status,
    array(
        'proof_submitted',
        'processing',
    ),
    true
)
                            ) : ?>

                                <form
                                    method="POST"
                                    class="admin-payment-review-form"
                                >

                                    <?php
                                    wp_nonce_field(
                                        'renthouse_admin_payment_action',
                                        'renthouse_admin_payment_nonce'
                                    );
                                    ?>

                                    <input
                                        type="hidden"
                                        name="payment_id"
                                        value="<?php echo esc_attr(
                                            $payment->id
                                        ); ?>"
                                    >

                                    <textarea
                                        name="admin_note"
                                        placeholder="Add verification note or rejection reason"
                                    ><?php echo esc_textarea(
                                        $payment->admin_note
                                    ); ?></textarea>

                                    <div class="admin-review-buttons">

                                        <button
                                            type="submit"
                                            name="renthouse_admin_payment_action"
                                            value="approve"
                                            class="admin-approve-btn"
                                            onclick="return confirm('Approve this payment?');"
                                        >
                                            Approve Payment
                                        </button>

                                        <button
                                            type="submit"
                                            name="renthouse_admin_payment_action"
                                            value="reject"
                                            class="admin-reject-btn"
                                            onclick="return confirm('Reject this payment?');"
                                        >
                                            Reject Payment
                                        </button>

                                    </div>

                                </form>

                            <?php else : ?>

                               <div class="admin-payment-locked-message">

    <?php if ($payment->payment_status === 'paid') : ?>

        Payment has been verified and approved.

    <?php elseif ($payment->payment_status === 'rejected') : ?>

        Payment was rejected. Waiting for the property owner to submit a new payment proof.

    <?php elseif ($payment->payment_status === 'pending') : ?>

        Waiting for the property owner to submit payment proof.

    <?php else : ?>

        No verification action is currently available.

    <?php endif; ?>

</div>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else : ?>

            <div class="admin-payments-empty">

                <div>💳</div>

                <h2>No Payments Found</h2>

                <p>
                    There are no payment records matching this filter.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php get_footer(); ?>