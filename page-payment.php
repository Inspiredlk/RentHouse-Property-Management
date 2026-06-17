<?php
/* Template Name: Payment Page */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

$payment_reference = isset($_GET['payment_reference'])
    ? sanitize_text_field(wp_unslash($_GET['payment_reference']))
    : '';

if (empty($payment_reference)) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

$payment = renthouse_get_payment_by_reference($payment_reference);

if (!$payment) {
    wp_die('Payment record not found.');
}

$current_user_id = get_current_user_id();
$is_admin        = current_user_can('administrator');

if (!$is_admin && intval($payment->owner_id) !== $current_user_id) {
    wp_die('You are not allowed to access this payment.');
}

$property_id    = intval($payment->property_id);
$property_title = get_the_title($property_id);
$package_name   = ucwords(str_replace('_', ' ', $payment->package));
$status_name    = ucwords(str_replace('_', ' ', $payment->payment_status));

get_header();
?>

<section class="rh-payment-page">
    <div class="rh-payment-container">

        <div class="rh-payment-hero">
            <div>
                <span class="rh-payment-eyebrow">Secure Payment</span>

                <h1>Complete Your Advertisement Payment</h1>

                <p>
                    Select your preferred payment method and complete the payment
                    for your rental advertisement package.
                </p>
            </div>

            <div class="rh-payment-secure">
                🔒 Secure Payment
            </div>
        </div>

        <?php if (isset($_GET['payment_submitted']) && $_GET['payment_submitted'] === 'success') : ?>
            <div class="rh-payment-success">
                <strong>Payment proof submitted successfully.</strong>
                <span>Your payment is now waiting for admin verification.</span>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['payment_error'])) : ?>

            <div class="rh-payment-error">
                <?php
                $payment_error = sanitize_key($_GET['payment_error']);

                if ($payment_error === 'missing_fields') {
                    echo 'Please enter the bank reference and upload your payment slip.';
                } elseif ($payment_error === 'invalid_file') {
                    echo 'Please upload a valid JPG, PNG or PDF payment slip.';
                } elseif ($payment_error === 'upload_failed') {
                    echo 'Payment slip upload failed. Please try again.';
                } else {
                    echo 'Something went wrong. Please try again.';
                }
                ?>
            </div>

        <?php endif; ?>

        <div class="rh-payment-layout">

            <div class="rh-payment-main">

                <?php if ($payment->payment_status === 'paid') : ?>

                    <div class="rh-payment-complete-card">
                        <div class="rh-payment-complete-icon">✓</div>

                        <h2>Payment Completed</h2>

                        <p>
                            This advertisement payment has already been completed.
                        </p>

                        <a href="<?php echo esc_url(home_url('/my-dashboard/')); ?>">
                            Go to Dashboard
                        </a>
                    </div>

                <?php elseif ($payment->payment_status === 'proof_submitted') : ?>

                    <div class="rh-payment-review-card">
                        <div class="rh-payment-review-icon">⌛</div>

                        <h2>Verification Pending</h2>

                        <p>
                            Your payment proof has been submitted.
                            The administrator will verify it before activating the package.
                        </p>

                        <a href="<?php echo esc_url(home_url('/my-dashboard/')); ?>">
                            Back to Dashboard
                        </a>
                    </div>

                <?php else : ?>

                    <div class="rh-payment-method-card">

                        <div class="rh-payment-section-heading">
                            <span>1</span>

                            <div>
                                <h2>Choose Payment Method</h2>
                                <p>Select bank transfer or card payment.</p>
                            </div>
                        </div>

                        <div class="rh-payment-method-tabs">

                            <button
                                type="button"
                                class="rh-method-tab active"
                                data-target="bank-payment-panel"
                            >
                                <span class="rh-method-icon">🏦</span>

                                <span>
                                    <strong>Bank Transfer</strong>
                                    <small>Upload your payment slip</small>
                                </span>
                            </button>

                            <button
                                type="button"
                                class="rh-method-tab"
                                data-target="card-payment-panel"
                            >
                                <span class="rh-method-icon">💳</span>

                                <span>
                                    <strong>Card Payment</strong>
                                    <small>Secure online checkout</small>
                                </span>
                            </button>

                        </div>

                        <div id="bank-payment-panel" class="rh-method-panel active">

                            <div class="rh-payment-section-heading">
                                <span>2</span>

                                <div>
                                    <h2>Bank Transfer Details</h2>
                                    <p>Transfer the exact amount to the account below.</p>
                                </div>
                            </div>

                            <div class="rh-bank-details">

                                <div>
                                    <small>Bank Name</small>
                                    <strong>Bank details will be configured by admin</strong>
                                </div>

                                <div>
                                    <small>Account Holder</small>
                                    <strong>Rent House Sri Lanka</strong>
                                </div>

                                <div>
                                    <small>Account Number</small>
                                    <strong>Not configured</strong>
                                </div>

                                <div>
                                    <small>Branch</small>
                                    <strong>Not configured</strong>
                                </div>

                            </div>

                            <div class="rh-bank-warning">
                                Use your payment reference when making the transfer:
                                <strong><?php echo esc_html($payment->payment_reference); ?></strong>
                            </div>

                            <form
                                method="POST"
                                enctype="multipart/form-data"
                                class="rh-proof-form"
                            >

                                <?php
                                wp_nonce_field(
                                    'renthouse_submit_payment_proof_action',
                                    'renthouse_payment_proof_nonce'
                                );
                                ?>

                                <input
                                    type="hidden"
                                    name="payment_id"
                                    value="<?php echo esc_attr($payment->id); ?>"
                                >

                                <input
                                    type="hidden"
                                    name="payment_reference"
                                    value="<?php echo esc_attr($payment->payment_reference); ?>"
                                >

                                <div class="rh-proof-grid">

                                    <div class="rh-payment-field">
                                        <label>Bank Transaction Reference</label>

                                        <input
                                            type="text"
                                            name="bank_reference"
                                            placeholder="Example: TXN9845321"
                                            required
                                        >
                                    </div>

                                    <div class="rh-payment-field">
                                        <label>Upload Payment Slip</label>

                                        <input
                                            type="file"
                                            name="payment_slip"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            required
                                        >

                                        <small>
                                            Accepted: JPG, PNG or PDF. Maximum 5 MB.
                                        </small>
                                    </div>

                                </div>

                                <div class="rh-payment-field">
                                    <label>Payment Note</label>

                                    <textarea
                                        name="payment_note"
                                        placeholder="Optional note about your bank transfer"
                                    ></textarea>
                                </div>

                                <button
                                    type="submit"
                                    name="renthouse_submit_payment_proof"
                                    class="rh-submit-proof-btn"
                                >
                                    Submit Payment Proof
                                </button>

                            </form>

                        </div>

                        <div id="card-payment-panel" class="rh-method-panel">

                            <div class="rh-card-payment-box">
                                <div class="rh-card-visual">
                                    <span>Rent House Sri Lanka</span>
                                    <strong>•••• •••• •••• 4582</strong>
                                    <small>SECURE CARD PAYMENT</small>
                                </div>

                                <h2>Card Payment</h2>

                                <p>
                                    Card payment will be processed through the configured
                                    secure payment gateway.
                                </p>

                                <div class="rh-gateway-notice">
                                    A merchant gateway account and live credentials must be
                                    configured before actual card payments can be accepted.
                                </div>

                                <button type="button" class="rh-card-disabled-btn" disabled>
                                    Gateway Configuration Required
                                </button>
                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

            <aside class="rh-payment-summary">

                <span class="rh-summary-label">Payment Summary</span>

                <h2><?php echo esc_html($property_title); ?></h2>

                <div class="rh-summary-image">
                    <?php if (has_post_thumbnail($property_id)) : ?>

                        <?php echo get_the_post_thumbnail(
                            $property_id,
                            'medium_large'
                        ); ?>

                    <?php else : ?>

                        <div class="rh-summary-placeholder">🏠</div>

                    <?php endif; ?>
                </div>

                <div class="rh-summary-row">
                    <span>Package</span>
                    <strong><?php echo esc_html($package_name); ?></strong>
                </div>

                <div class="rh-summary-row">
                    <span>Payment Reference</span>
                    <strong><?php echo esc_html($payment->payment_reference); ?></strong>
                </div>

                <div class="rh-summary-row">
                    <span>Status</span>

                    <strong class="rh-payment-status rh-status-<?php echo esc_attr($payment->payment_status); ?>">
                        <?php echo esc_html($status_name); ?>
                    </strong>
                </div>

                <div class="rh-summary-total">
                    <span>Total Amount</span>

                    <strong>
                        LKR <?php echo esc_html(number_format((float) $payment->amount, 2)); ?>
                    </strong>
                </div>

                <div class="rh-summary-security">
                    🔒 Payment information is securely processed.
                </div>

            </aside>

        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('.rh-method-tab');
    const panels = document.querySelectorAll('.rh-method-panel');

    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');

            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            panels.forEach(function (panel) {
                panel.classList.remove('active');
            });

            this.classList.add('active');

            const targetPanel = document.getElementById(targetId);

            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });
});
</script>

<?php get_footer(); ?>