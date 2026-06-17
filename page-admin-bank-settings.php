<?php
/* Template Name: Admin Bank Settings Page */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

if (!current_user_can('administrator')) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

$bank_name = get_option(
    'renthouse_bank_name',
    ''
);

$account_holder = get_option(
    'renthouse_bank_account_holder',
    ''
);

$account_number = get_option(
    'renthouse_bank_account_number',
    ''
);

$branch_name = get_option(
    'renthouse_bank_branch',
    ''
);

$payment_instructions = get_option(
    'renthouse_bank_instructions',
    'Transfer the exact advertisement fee and upload your payment slip.'
);

get_header();
?>

<section class="rh-bank-settings-page">

```
<div class="rh-bank-settings-container">

    <div class="rh-bank-settings-hero">

        <div>
            <span>Admin Control Center</span>

            <h1>Bank Payment Settings</h1>

            <p>
                Manage the bank account details shown to property owners
                on the advertisement payment page.
            </p>
        </div>

        <a
            href="<?php echo esc_url(
                home_url('/my-dashboard/')
            ); ?>"
            class="rh-bank-back-btn"
        >
            Back to Dashboard
        </a>

    </div>

    <?php
    if (
        isset($_GET['bank_settings']) &&
        sanitize_key(
            wp_unslash($_GET['bank_settings'])
        ) === 'saved'
    ) :
    ?>

        <div class="rh-bank-success">
            Bank payment settings saved successfully.
        </div>

    <?php endif; ?>

    <?php
    if (
        isset($_GET['bank_settings']) &&
        sanitize_key(
            wp_unslash($_GET['bank_settings'])
        ) === 'error'
    ) :
    ?>

        <div class="rh-bank-error">
            Bank payment settings could not be saved.
        </div>

    <?php endif; ?>

    <div class="rh-bank-settings-grid">

        <div class="rh-bank-settings-card">

            <div class="rh-bank-card-title">
                <span>🏦</span>

                <div>
                    <h2>Bank Account Details</h2>

                    <p>
                        These details will appear on the owner payment page.
                    </p>
                </div>
            </div>

            <form method="POST" class="rh-bank-settings-form">

                <?php
                wp_nonce_field(
                    'renthouse_save_bank_settings_action',
                    'renthouse_bank_settings_nonce'
                );
                ?>

                <div class="rh-bank-form-row">

                    <div class="rh-bank-form-group">

                        <label for="renthouse_bank_name">
                            Bank Name
                        </label>

                        <input
                            id="renthouse_bank_name"
                            type="text"
                            name="renthouse_bank_name"
                            value="<?php echo esc_attr($bank_name); ?>"
                            placeholder="Example: Commercial Bank"
                            required
                        >

                    </div>

                    <div class="rh-bank-form-group">

                        <label for="renthouse_account_holder">
                            Account Holder
                        </label>

                        <input
                            id="renthouse_account_holder"
                            type="text"
                            name="renthouse_account_holder"
                            value="<?php echo esc_attr(
                                $account_holder
                            ); ?>"
                            placeholder="Example: Rent House Sri Lanka"
                            required
                        >

                    </div>

                </div>

                <div class="rh-bank-form-row">

                    <div class="rh-bank-form-group">

                        <label for="renthouse_account_number">
                            Account Number
                        </label>

                        <input
                            id="renthouse_account_number"
                            type="text"
                            name="renthouse_account_number"
                            value="<?php echo esc_attr(
                                $account_number
                            ); ?>"
                            placeholder="Example: 1234567890"
                            inputmode="numeric"
                            required
                        >

                    </div>

                    <div class="rh-bank-form-group">

                        <label for="renthouse_branch_name">
                            Branch
                        </label>

                        <input
                            id="renthouse_branch_name"
                            type="text"
                            name="renthouse_branch_name"
                            value="<?php echo esc_attr(
                                $branch_name
                            ); ?>"
                            placeholder="Example: Maharagama"
                            required
                        >

                    </div>

                </div>

                <div class="rh-bank-form-group">

                    <label for="renthouse_payment_instructions">
                        Payment Instructions
                    </label>

                    <textarea
                        id="renthouse_payment_instructions"
                        name="renthouse_payment_instructions"
                        placeholder="Enter bank transfer instructions"
                        required
                    ><?php echo esc_textarea(
                        $payment_instructions
                    ); ?></textarea>

                </div>

                <div class="rh-bank-form-actions">

                    <button
                        type="submit"
                        name="renthouse_save_bank_settings"
                        class="rh-bank-save-btn"
                    >
                        Save Bank Settings
                    </button>

                </div>

            </form>

        </div>

        <aside class="rh-bank-preview-card">

            <span class="rh-bank-preview-label">
                Payment Page Preview
            </span>

            <h2>Bank Transfer Details</h2>

            <div class="rh-bank-preview-item">
                <small>Bank Name</small>
                <strong>
                    <?php echo esc_html(
                        !empty($bank_name)
                            ? $bank_name
                            : 'Not configured'
                    ); ?>
                </strong>
            </div>

            <div class="rh-bank-preview-item">
                <small>Account Holder</small>
                <strong>
                    <?php echo esc_html(
                        !empty($account_holder)
                            ? $account_holder
                            : 'Not configured'
                    ); ?>
                </strong>
            </div>

            <div class="rh-bank-preview-item">
                <small>Account Number</small>
                <strong>
                    <?php echo esc_html(
                        !empty($account_number)
                            ? $account_number
                            : 'Not configured'
                    ); ?>
                </strong>
            </div>

            <div class="rh-bank-preview-item">
                <small>Branch</small>
                <strong>
                    <?php echo esc_html(
                        !empty($branch_name)
                            ? $branch_name
                            : 'Not configured'
                    ); ?>
                </strong>
            </div>

            <div class="rh-bank-preview-note">
                <?php echo esc_html($payment_instructions); ?>
            </div>

        </aside>

    </div>

</div>
```

</section>

<?php get_footer(); ?>
