<?php
/* Template Name: Post Ad Page */

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/login/'));
    exit;
}

$current_user = wp_get_current_user();
$user_roles   = $current_user->roles;
$user_role    = !empty($user_roles) ? $user_roles[0] : '';

if ($user_role !== 'property_owner' && !current_user_can('administrator')) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

get_header();

$selected_package = isset($_GET['package']) ? sanitize_text_field($_GET['package']) : 'free';
?>

<section class="post-ad-page">
    <div class="container">

        <div class="post-ad-hero">
            <span>Post Your Property</span>
            <h1>Submit Your Rental Property Advertisement</h1>
            <p>Fill the form below and submit your property ad for admin review.</p>
        </div>

        <?php if (isset($_GET['submitted']) && $_GET['submitted'] === 'success') : ?>
            <div class="post-success-message">
                <h3>Property Submitted Successfully!</h3>
                <p>Your property ad has been submitted for admin review. It will appear on the website after approval.</p>
            </div>
        <?php endif; ?>

        <form class="post-ad-form" method="POST" enctype="multipart/form-data">

            <?php wp_nonce_field('renthouse_submit_property', 'renthouse_property_nonce'); ?>

            <div class="form-section">
                <h2>Property Information</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Property Title</label>
                        <input 
                            type="text" 
                            name="property_title" 
                            required 
                            placeholder="Example: 3 Bedroom House For Rent"
                        >
                    </div>

                    <div class="form-group">
                        <label>Rental Price</label>
                        <input 
                            type="text" 
                            name="property_price" 
                            required 
                            placeholder="Example: Rs. 85,000 / month"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea 
                        name="property_description" 
                        required 
                        placeholder="Write a clear description about your property"
                    ></textarea>
                </div>
            </div>

            <div class="form-section">
                <h2>Property Details</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Location</label>
                        <input 
                            type="text" 
                            name="property_location" 
                            required 
                            placeholder="Example: Maharagama"
                        >
                    </div>

                    <div class="form-group">
                        <label>Property Type</label>
                        <select name="property_type" required>
                            <option value="">Select Type</option>
                            <option value="House Rent">House Rent</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Annex">Annex</option>
                            <option value="Room">Room</option>
                            <option value="Villa">Villa</option>
                            <option value="Commercial">Commercial</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Bedrooms</label>
                        <input 
                            type="number" 
                            name="property_bedrooms" 
                            min="0" 
                            required 
                            placeholder="Example: 3"
                        >
                    </div>

                    <div class="form-group">
                        <label>Bathrooms</label>
                        <input 
                            type="number" 
                            name="property_bathrooms" 
                            min="0" 
                            required 
                            placeholder="Example: 2"
                        >
                    </div>

                    <div class="form-group">
                        <label>Parking</label>
                        <input 
                            type="number" 
                            name="property_parking" 
                            min="0" 
                            required 
                            placeholder="Example: 1"
                        >
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>Contact Details</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input 
                            type="tel" 
                            name="property_phone" 
                            required 
                            pattern="07[0-9]{8}"
                            maxlength="10"
                            inputmode="numeric"
                            placeholder="Example: 0771234567"
                        >
                        <small>Enter 10 digits, starting with 07.</small>
                    </div>

                    <div class="form-group">
                        <label>WhatsApp Number</label>
                        <input 
                            type="tel" 
                            name="property_whatsapp" 
                            pattern="07[0-9]{8}"
                            maxlength="10"
                            inputmode="numeric"
                            placeholder="Example: 0771234567"
                        >
                        <small>Optional. Use 10 digits, starting with 07.</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>Package & Image</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Selected Package</label>
                        <select name="property_package">
                            <option value="free" <?php selected($selected_package, 'free'); ?>>Free Ad</option>
                            <option value="basic" <?php selected($selected_package, 'basic'); ?>>Basic Ad</option>
                            <option value="featured" <?php selected($selected_package, 'featured'); ?>>Featured Ad</option>
                            <option value="premium" <?php selected($selected_package, 'premium'); ?>>Premium Ad</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Featured Image</label>
                        <input 
                            type="file" 
                            name="property_image" 
                            accept="image/*"
                        >
                    </div>
                </div>
            </div>

            <button type="submit" name="renthouse_submit_property" class="submit-property-btn">
                Submit Property Ad
            </button>

        </form>

    </div>
</section>

<?php get_footer(); ?>