```php
<?php
/* Template Name: Edit Property Page */

/* =========================
   LOGIN PROTECTION
========================= */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}


/* =========================
   GET PROPERTY ID
========================= */

$property_id = isset($_GET['property_id'])
    ? absint($_GET['property_id'])
    : 0;

if (
    !$property_id ||
    get_post_type($property_id) !== 'property'
) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}


/* =========================
   OWNER / ADMIN PERMISSION
========================= */

$current_user_id = get_current_user_id();

$property_author = absint(
    get_post_field('post_author', $property_id)
);

if (
    !current_user_can('administrator') &&
    $property_author !== $current_user_id
) {
    wp_die('You are not allowed to edit this property.');
}


/* =========================
   LOAD PROPERTY DATA
========================= */

$property_post = get_post($property_id);

if (!$property_post) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

$title = $property_post->post_title;

$description = wp_strip_all_tags(
    $property_post->post_content
);

$description = html_entity_decode(
    $description,
    ENT_QUOTES,
    get_bloginfo('charset')
);


/* =========================
   LOAD PROPERTY META
========================= */

$price = get_post_meta(
    $property_id,
    'renthouse_price',
    true
);

$location = get_post_meta(
    $property_id,
    'renthouse_location',
    true
);

$bedrooms = get_post_meta(
    $property_id,
    'renthouse_bedrooms',
    true
);

$bathrooms = get_post_meta(
    $property_id,
    'renthouse_bathrooms',
    true
);

$parking = get_post_meta(
    $property_id,
    'renthouse_parking',
    true
);

$type = get_post_meta(
    $property_id,
    'renthouse_property_type',
    true
);

$phone = get_post_meta(
    $property_id,
    'renthouse_phone',
    true
);

$whatsapp = get_post_meta(
    $property_id,
    'renthouse_whatsapp',
    true
);

$package = get_post_meta(
    $property_id,
    'renthouse_package',
    true
);

$payment_status = get_post_meta(
    $property_id,
    'renthouse_payment_status',
    true
);

if (empty($package)) {
    $package = 'free';
}

if (empty($payment_status)) {
    $payment_status = 'pending';
}


/* =========================
   NORMALIZE PHONE NUMBERS
========================= */

$normalize_phone = function ($number) {

    $number = preg_replace(
        '/[^0-9]/',
        '',
        (string) $number
    );

    if (
        strlen($number) === 11 &&
        substr($number, 0, 2) === '94'
    ) {
        return '0' . substr($number, 2);
    }

    if (
        strlen($number) === 9 &&
        substr($number, 0, 1) === '7'
    ) {
        return '0' . $number;
    }

    return $number;
};

$phone = $normalize_phone($phone);

$whatsapp = $normalize_phone($whatsapp);


/* =========================
   CURRENT IMAGE
========================= */

$current_image_url = get_the_post_thumbnail_url(
    $property_id,
    'medium_large'
);

get_header();
?>

<section class="edit-property-page">

    <div class="edit-property-container">

        <!-- HERO -->
        <div class="edit-property-hero">

            <div>
                <span>Owner Dashboard</span>

                <h1>Edit Property Advertisement</h1>

                <p>
                    Update your rental advertisement details.
                    After editing, the advertisement will be sent
                    for administrator review again.
                </p>
            </div>

            <a
                href="<?php echo esc_url(home_url('/my-dashboard/')); ?>"
                class="edit-hero-back"
            >
                Back to Dashboard
            </a>

        </div>


        <!-- SUCCESS MESSAGE -->
        <?php
        if (
            isset($_GET['updated']) &&
            sanitize_key(wp_unslash($_GET['updated'])) === 'success'
        ) :
        ?>

            <div class="edit-property-success">
                <strong>Property updated successfully.</strong>
                <span>
                    Your advertisement is now waiting for administrator review.
                </span>
            </div>

        <?php endif; ?>


        <!-- ERROR MESSAGE -->
        <?php if (isset($_GET['property_error'])) : ?>

            <div class="edit-property-error">

                <?php
                $error = sanitize_key(
                    wp_unslash($_GET['property_error'])
                );

                if ($error === 'empty_fields') {

                    echo 'Please fill all required fields.';

                } elseif ($error === 'invalid_phone') {

                    echo 'Phone number must contain 10 digits and start with 07.';

                } elseif ($error === 'invalid_whatsapp') {

                    echo 'WhatsApp number must contain 10 digits and start with 07.';

                } elseif ($error === 'update_failed') {

                    echo 'The property could not be updated. Please try again.';

                } elseif ($error === 'payment_update_failed') {

                    echo 'The payment information could not be updated. Please try again.';

                } elseif ($error === 'image_upload_failed') {

                    echo 'The new property image could not be uploaded. Please use a JPG or PNG image.';

                } else {

                    echo 'Something went wrong. Please try again.';
                }
                ?>

            </div>

        <?php endif; ?>


        <!-- PROPERTY STATUS -->
        <div class="edit-property-status-bar">

            <div>
                <small>Advertisement Status</small>

                <strong>
                    <?php
                    echo esc_html(
                        ucwords(
                            str_replace(
                                '_',
                                ' ',
                                get_post_status($property_id)
                            )
                        )
                    );
                    ?>
                </strong>
            </div>

            <div>
                <small>Package</small>

                <strong>
                    <?php
                    echo esc_html(
                        ucwords(
                            str_replace('_', ' ', $package)
                        )
                    );
                    ?>
                </strong>
            </div>

            <div>
                <small>Payment</small>

                <strong>
                    <?php if ($package === 'free') : ?>

                        No Payment Required

                    <?php else : ?>

                        <?php
                        echo esc_html(
                            ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $payment_status
                                )
                            )
                        );
                        ?>

                    <?php endif; ?>
                </strong>
            </div>

        </div>


        <!-- EDIT FORM -->
        <form
            class="edit-property-form"
            method="POST"
            enctype="multipart/form-data"
        >

            <?php
            wp_nonce_field(
                'renthouse_update_property_action',
                'renthouse_update_property_nonce'
            );
            ?>

            <input
                type="hidden"
                name="property_id"
                value="<?php echo esc_attr($property_id); ?>"
            >


            <!-- PROPERTY INFORMATION -->
            <div class="edit-form-section">

                <div class="edit-section-title">
                    <span>1</span>

                    <div>
                        <h2>Property Information</h2>
                        <p>Update the main details of your advertisement.</p>
                    </div>
                </div>

                <div class="edit-form-row">

                    <div class="edit-form-group">

                        <label for="property_title">
                            Property Title
                        </label>

                        <input
                            id="property_title"
                            type="text"
                            name="property_title"
                            value="<?php echo esc_attr($title); ?>"
                            required
                        >

                    </div>

                    <div class="edit-form-group">

                        <label for="property_price">
                            Rental Price
                        </label>

                        <input
                            id="property_price"
                            type="text"
                            name="property_price"
                            value="<?php echo esc_attr($price); ?>"
                            placeholder="Example: Rs. 85,000 / month"
                            required
                        >

                    </div>

                </div>

                <div class="edit-form-group">

                    <label for="property_description">
                        Description
                    </label>

                    <textarea
                        id="property_description"
                        name="property_description"
                        required
                    ><?php echo esc_textarea($description); ?></textarea>

                </div>

            </div>


            <!-- PROPERTY DETAILS -->
            <div class="edit-form-section">

                <div class="edit-section-title">
                    <span>2</span>

                    <div>
                        <h2>Property Details</h2>
                        <p>Update the location and property facilities.</p>
                    </div>
                </div>

                <div class="edit-form-row">

                    <div class="edit-form-group">

                        <label for="property_location">
                            Location
                        </label>

                        <input
                            id="property_location"
                            type="text"
                            name="property_location"
                            value="<?php echo esc_attr($location); ?>"
                            required
                        >

                    </div>

                    <div class="edit-form-group">

                        <label for="property_type">
                            Property Type
                        </label>

                        <select
                            id="property_type"
                            name="property_type"
                            required
                        >
                            <option value="">
                                Select Type
                            </option>

                            <option
                                value="House Rent"
                                <?php selected($type, 'House Rent'); ?>
                            >
                                House Rent
                            </option>

                            <option
                                value="Apartment"
                                <?php selected($type, 'Apartment'); ?>
                            >
                                Apartment
                            </option>

                            <option
                                value="Annex"
                                <?php selected($type, 'Annex'); ?>
                            >
                                Annex
                            </option>

                            <option
                                value="Room"
                                <?php selected($type, 'Room'); ?>
                            >
                                Room
                            </option>

                            <option
                                value="Villa"
                                <?php selected($type, 'Villa'); ?>
                            >
                                Villa
                            </option>

                            <option
                                value="Commercial"
                                <?php selected($type, 'Commercial'); ?>
                            >
                                Commercial
                            </option>
                        </select>

                    </div>

                </div>

                <div class="edit-form-row three">

                    <div class="edit-form-group">

                        <label for="property_bedrooms">
                            Bedrooms
                        </label>

                        <input
                            id="property_bedrooms"
                            type="number"
                            name="property_bedrooms"
                            min="0"
                            value="<?php echo esc_attr($bedrooms); ?>"
                            required
                        >

                    </div>

                    <div class="edit-form-group">

                        <label for="property_bathrooms">
                            Bathrooms
                        </label>

                        <input
                            id="property_bathrooms"
                            type="number"
                            name="property_bathrooms"
                            min="0"
                            value="<?php echo esc_attr($bathrooms); ?>"
                            required
                        >

                    </div>

                    <div class="edit-form-group">

                        <label for="property_parking">
                            Parking
                        </label>

                        <input
                            id="property_parking"
                            type="number"
                            name="property_parking"
                            min="0"
                            value="<?php echo esc_attr($parking); ?>"
                            required
                        >

                    </div>

                </div>

            </div>


            <!-- CONTACT DETAILS -->
            <div class="edit-form-section">

                <div class="edit-section-title">
                    <span>3</span>

                    <div>
                        <h2>Contact Details</h2>
                        <p>Update the contact numbers shown to tenants.</p>
                    </div>
                </div>

                <div class="edit-form-row">

                    <div class="edit-form-group">

                        <label for="property_phone">
                            Phone Number
                        </label>

                        <input
                            id="property_phone"
                            type="tel"
                            name="property_phone"
                            value="<?php echo esc_attr($phone); ?>"
                            maxlength="10"
                            pattern="07[0-9]{8}"
                            inputmode="numeric"
                            placeholder="0771234567"
                            required
                        >

                        <small>
                            Enter 10 digits starting with 07.
                        </small>

                    </div>

                    <div class="edit-form-group">

                        <label for="property_whatsapp">
                            WhatsApp Number
                        </label>

                        <input
                            id="property_whatsapp"
                            type="tel"
                            name="property_whatsapp"
                            value="<?php echo esc_attr($whatsapp); ?>"
                            maxlength="10"
                            pattern="07[0-9]{8}"
                            inputmode="numeric"
                            placeholder="0771234567"
                        >

                        <small>
                            Optional. Enter 10 digits starting with 07.
                        </small>

                    </div>

                </div>

            </div>


            <!-- PACKAGE AND IMAGE -->
            <div class="edit-form-section">

                <div class="edit-section-title">
                    <span>4</span>

                    <div>
                        <h2>Package & Image</h2>
                        <p>
                            Update the advertisement package or property image.
                        </p>
                    </div>
                </div>

                <div class="edit-form-row">

                    <div class="edit-form-group">

                        <label for="property_package">
                            Advertisement Package
                        </label>

                        <select
                            id="property_package"
                            name="property_package"
                        >
                            <option
                                value="free"
                                <?php selected($package, 'free'); ?>
                            >
                                Free Ad
                            </option>

                            <option
                                value="basic"
                                <?php selected($package, 'basic'); ?>
                            >
                                Basic Ad — LKR 750
                            </option>

                            <option
                                value="featured"
                                <?php selected($package, 'featured'); ?>
                            >
                                Featured Ad — LKR 1,500
                            </option>

                            <option
                                value="premium"
                                <?php selected($package, 'premium'); ?>
                            >
                                Premium Ad — LKR 3,000
                            </option>
                        </select>

                        <small>
                            Changing to a paid package will redirect you
                            to the payment page.
                        </small>

                    </div>

                    <div class="edit-form-group">

                        <label for="property_image">
                            Change Featured Image
                        </label>

                        <?php if (!empty($current_image_url)) : ?>

                            <div class="edit-current-image">

                                <img
                                    src="<?php echo esc_url($current_image_url); ?>"
                                    alt="<?php echo esc_attr($title); ?>"
                                >

                                <span>Current property image</span>

                            </div>

                        <?php endif; ?>

                        <input
                            id="property_image"
                            type="file"
                            name="property_image"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small>
                            Leave empty to keep the current image.
                            Accepted: JPG, PNG or WEBP.
                        </small>

                    </div>

                </div>

            </div>


            <!-- ACTIONS -->
            <div class="edit-property-actions">

                <a
                    href="<?php echo esc_url(home_url('/my-dashboard/')); ?>"
                    class="edit-back-btn"
                >
                    Back to Dashboard
                </a>

                <button
                    type="submit"
                    name="renthouse_update_property"
                    class="edit-submit-btn"
                >
                    Update Property
                </button>

            </div>

        </form>

    </div>

</section>

<?php get_footer(); ?>
```
