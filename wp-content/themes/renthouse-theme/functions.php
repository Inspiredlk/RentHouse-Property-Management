<?php

/* =========================
   LOAD THEME STYLE
========================= */
function renthouse_theme_styles() {
    wp_enqueue_style(
        'renthouse-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_template_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'renthouse_theme_styles');


/* =========================
   THEME SUPPORT
========================= */
function renthouse_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'renthouse_theme_setup');


/* =========================
   PROPERTY CUSTOM POST TYPE
========================= */
function renthouse_register_property_post_type() {

    $labels = array(
        'name'               => 'Properties',
        'singular_name'      => 'Property',
        'menu_name'          => 'Properties',
        'name_admin_bar'     => 'Property',
        'add_new'            => 'Add New Property',
        'add_new_item'       => 'Add New Property',
        'edit_item'          => 'Edit Property',
        'new_item'           => 'New Property',
        'view_item'          => 'View Property',
        'all_items'          => 'All Properties',
        'search_items'       => 'Search Properties',
        'not_found'          => 'No properties found',
        'not_found_in_trash' => 'No properties found in Trash'
    );

    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'properties'),
        'menu_icon'    => 'dashicons-admin-home',
        'supports'     => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => false
    );

    register_post_type('property', $args);
}
add_action('init', 'renthouse_register_property_post_type');


/* =========================
   DISABLE BLOCK EDITOR FOR PROPERTIES
========================= */
function renthouse_disable_block_editor_for_properties($use_block_editor, $post_type) {
    if ($post_type === 'property') {
        return false;
    }

    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'renthouse_disable_block_editor_for_properties', 10, 2);


/* =========================
   HELPER - EXTRACT NUMERIC PRICE
========================= */
function renthouse_extract_price_number($price_text) {

    $number = preg_replace('/[^0-9]/', '', $price_text);

    if (empty($number)) {
        return '';
    }

    return intval($number);
}


/* =========================
   PROPERTY DETAILS META BOX
========================= */
function renthouse_add_property_meta_box() {
    add_meta_box(
        'renthouse_property_details',
        'Property Details',
        'renthouse_property_details_callback',
        'property',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'renthouse_add_property_meta_box');


function renthouse_property_details_callback($post) {

    wp_nonce_field('renthouse_save_property_details', 'renthouse_property_nonce');

    $price          = get_post_meta($post->ID, 'renthouse_price', true);
    $location       = get_post_meta($post->ID, 'renthouse_location', true);
    $bedrooms       = get_post_meta($post->ID, 'renthouse_bedrooms', true);
    $bathrooms      = get_post_meta($post->ID, 'renthouse_bathrooms', true);
    $parking        = get_post_meta($post->ID, 'renthouse_parking', true);
    $property_type  = get_post_meta($post->ID, 'renthouse_property_type', true);
    $phone          = get_post_meta($post->ID, 'renthouse_phone', true);
    $whatsapp       = get_post_meta($post->ID, 'renthouse_whatsapp', true);
    $package        = get_post_meta($post->ID, 'renthouse_package', true);
    $payment_status = get_post_meta($post->ID, 'renthouse_payment_status', true);
    $price_number   = get_post_meta($post->ID, 'renthouse_price_number', true);

    ?>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Price</label>
        <input 
            type="text" 
            name="renthouse_price" 
            value="<?php echo esc_attr($price); ?>" 
            placeholder="Example: Rs. 70,000 / month"
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
        <small>Numeric price auto saved for search filter: <?php echo esc_html($price_number); ?></small>
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Location</label>
        <input 
            type="text" 
            name="renthouse_location" 
            value="<?php echo esc_attr($location); ?>" 
            placeholder="Example: Colombo"
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Bedrooms</label>
        <input 
            type="number" 
            name="renthouse_bedrooms" 
            value="<?php echo esc_attr($bedrooms); ?>" 
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Bathrooms</label>
        <input 
            type="number" 
            name="renthouse_bathrooms" 
            value="<?php echo esc_attr($bathrooms); ?>" 
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Parking</label>
        <input 
            type="text" 
            name="renthouse_parking" 
            value="<?php echo esc_attr($parking); ?>" 
            placeholder="Example: 1"
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Property Type</label>
        <select 
            name="renthouse_property_type"
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
            <option value="">Select Property Type</option>
            <option value="House Rent" <?php selected($property_type, 'House Rent'); ?>>House Rent</option>
            <option value="Apartment" <?php selected($property_type, 'Apartment'); ?>>Apartment</option>
            <option value="Annex" <?php selected($property_type, 'Annex'); ?>>Annex</option>
            <option value="Room" <?php selected($property_type, 'Room'); ?>>Room</option>
            <option value="Villa" <?php selected($property_type, 'Villa'); ?>>Villa</option>
            <option value="Commercial" <?php selected($property_type, 'Commercial'); ?>>Commercial</option>
        </select>
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Phone Number</label>
        <input 
            type="text" 
            name="renthouse_phone" 
            value="<?php echo esc_attr($phone); ?>" 
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">WhatsApp Number</label>
        <input 
            type="text" 
            name="renthouse_whatsapp" 
            value="<?php echo esc_attr($whatsapp); ?>" 
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Selected Package</label>
        <select 
            name="renthouse_package"
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
            <option value="free" <?php selected($package, 'free'); ?>>Free</option>
            <option value="basic" <?php selected($package, 'basic'); ?>>Basic</option>
            <option value="featured" <?php selected($package, 'featured'); ?>>Featured</option>
            <option value="premium" <?php selected($package, 'premium'); ?>>Premium</option>
        </select>
    </p>

    <p style="margin-bottom:18px;">
        <label style="font-weight:600; display:block; margin-bottom:6px;">Payment Status</label>
        <select 
            name="renthouse_payment_status"
            style="width:100%; padding:12px; border:1px solid #cccccc; border-radius:6px;">
            <option value="pending" <?php selected($payment_status, 'pending'); ?>>Pending</option>
            <option value="paid" <?php selected($payment_status, 'paid'); ?>>Paid</option>
            <option value="rejected" <?php selected($payment_status, 'rejected'); ?>>Rejected</option>
        </select>
    </p>

    <?php
}


/* =========================
   SAVE PROPERTY DETAILS
========================= */
function renthouse_save_property_details($post_id) {

    if (!isset($_POST['renthouse_property_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['renthouse_property_nonce'], 'renthouse_save_property_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $price_text   = isset($_POST['renthouse_price']) ? sanitize_text_field($_POST['renthouse_price']) : '';
    $price_number = renthouse_extract_price_number($price_text);

    update_post_meta($post_id, 'renthouse_price', $price_text);
    update_post_meta($post_id, 'renthouse_price_number', $price_number);

    update_post_meta($post_id, 'renthouse_location', sanitize_text_field($_POST['renthouse_location'] ?? ''));
    update_post_meta($post_id, 'renthouse_bedrooms', sanitize_text_field($_POST['renthouse_bedrooms'] ?? ''));
    update_post_meta($post_id, 'renthouse_bathrooms', sanitize_text_field($_POST['renthouse_bathrooms'] ?? ''));
    update_post_meta($post_id, 'renthouse_parking', sanitize_text_field($_POST['renthouse_parking'] ?? ''));
    update_post_meta($post_id, 'renthouse_property_type', sanitize_text_field($_POST['renthouse_property_type'] ?? ''));
    update_post_meta($post_id, 'renthouse_phone', sanitize_text_field($_POST['renthouse_phone'] ?? ''));
    update_post_meta($post_id, 'renthouse_whatsapp', sanitize_text_field($_POST['renthouse_whatsapp'] ?? ''));

    update_post_meta(
        $post_id,
        'renthouse_package',
        strtolower(sanitize_text_field($_POST['renthouse_package'] ?? 'free'))
    );

    update_post_meta(
        $post_id,
        'renthouse_payment_status',
        strtolower(sanitize_text_field($_POST['renthouse_payment_status'] ?? 'pending'))
    );
}
add_action('save_post_property', 'renthouse_save_property_details');


/* =========================
   FRONTEND PROPERTY SUBMISSION
========================= */

function renthouse_handle_frontend_property_submission() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    if (!isset($_POST['renthouse_submit_property'])) {
        return;
    }

    if (!is_user_logged_in()) {
        wp_safe_redirect(home_url('/login/'));
        exit;
    }

    if (
        !isset($_POST['renthouse_property_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash($_POST['renthouse_property_nonce'])
            ),
            'renthouse_submit_property'
        )
    ) {
        wp_die('Security check failed.');
    }

    $current_user = wp_get_current_user();
    $user_roles   = $current_user->roles;
    $user_role    = !empty($user_roles) ? $user_roles[0] : '';

    if (
        $user_role !== 'property_owner' &&
        !current_user_can('administrator')
    ) {
        wp_safe_redirect(home_url('/my-dashboard/'));
        exit;
    }

    $title = sanitize_text_field(
        wp_unslash($_POST['property_title'] ?? '')
    );

    $description = sanitize_textarea_field(
        wp_unslash($_POST['property_description'] ?? '')
    );

    $property_phone = sanitize_text_field(
        wp_unslash($_POST['property_phone'] ?? '')
    );

    $property_whatsapp = sanitize_text_field(
        wp_unslash($_POST['property_whatsapp'] ?? '')
    );

    $selected_package = sanitize_key(
        strtolower(
            wp_unslash($_POST['property_package'] ?? 'free')
        )
    );

    $allowed_packages = array(
        'free',
        'basic',
        'featured',
        'premium',
    );

    if (
        empty($title) ||
        empty($description)
    ) {
        wp_safe_redirect(
            add_query_arg(
                'property_error',
                'empty_fields',
                home_url('/post-ad/')
            )
        );
        exit;
    }

    if (!preg_match('/^07[0-9]{8}$/', $property_phone)) {
        wp_safe_redirect(
            add_query_arg(
                'property_error',
                'invalid_phone',
                home_url('/post-ad/')
            )
        );
        exit;
    }

    if (
        !empty($property_whatsapp) &&
        !preg_match('/^07[0-9]{8}$/', $property_whatsapp)
    ) {
        wp_safe_redirect(
            add_query_arg(
                'property_error',
                'invalid_whatsapp',
                home_url('/post-ad/')
            )
        );
        exit;
    }

    if (!in_array($selected_package, $allowed_packages, true)) {
        $selected_package = 'free';
    }

    $property_id = wp_insert_post(
        array(
            'post_title'   => $title,
            'post_content' => $description,
            'post_status'  => 'pending',
            'post_type'    => 'property',
            'post_author'  => get_current_user_id(),
        ),
        true
    );

    if (is_wp_error($property_id)) {
        wp_safe_redirect(
            add_query_arg(
                'property_error',
                'property_creation_failed',
                home_url('/post-ad/')
            )
        );
        exit;
    }

    $property_price_text = sanitize_text_field(
        wp_unslash($_POST['property_price'] ?? '')
    );

    $property_price_number = renthouse_extract_price_number(
        $property_price_text
    );

    update_post_meta(
        $property_id,
        'renthouse_price',
        $property_price_text
    );

    update_post_meta(
        $property_id,
        'renthouse_price_number',
        $property_price_number
    );

    update_post_meta(
        $property_id,
        'renthouse_location',
        sanitize_text_field(
            wp_unslash($_POST['property_location'] ?? '')
        )
    );

    update_post_meta(
        $property_id,
        'renthouse_bedrooms',
        absint($_POST['property_bedrooms'] ?? 0)
    );

    update_post_meta(
        $property_id,
        'renthouse_bathrooms',
        absint($_POST['property_bathrooms'] ?? 0)
    );

    update_post_meta(
        $property_id,
        'renthouse_parking',
        absint($_POST['property_parking'] ?? 0)
    );

    update_post_meta(
        $property_id,
        'renthouse_property_type',
        sanitize_text_field(
            wp_unslash($_POST['property_type'] ?? '')
        )
    );

    update_post_meta(
        $property_id,
        'renthouse_phone',
        $property_phone
    );

    update_post_meta(
        $property_id,
        'renthouse_whatsapp',
        $property_whatsapp
    );

    update_post_meta(
        $property_id,
        'renthouse_package',
        $selected_package
    );

    update_post_meta(
        $property_id,
        'renthouse_payment_status',
        'pending'
    );

    if (!empty($_FILES['property_image']['name'])) {

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachment_id = media_handle_upload(
            'property_image',
            $property_id
        );

        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($property_id, $attachment_id);
        }
    }

    $payment = renthouse_create_payment_record(
        $property_id,
        get_current_user_id(),
        $selected_package
    );

  if (is_wp_error($payment)) {

    error_log(
        'RentHouse payment creation error: ' .
        $payment->get_error_message()
    );

    wp_trash_post($property_id);

    wp_safe_redirect(
        add_query_arg(
            'property_error',
            'payment_record_failed',
            home_url('/post-ad/')
        )
    );
    exit;
}


    if ((float) $payment->amount > 0) {

        wp_safe_redirect(
            add_query_arg(
                'payment_reference',
                rawurlencode($payment->payment_reference),
                home_url('/payment/')
            )
        );
        exit;
    }

    wp_safe_redirect(
        add_query_arg(
            'submitted',
            'success',
            home_url('/my-dashboard/')
        )
    );
    exit;
}

add_action(
    'template_redirect',
    'renthouse_handle_frontend_property_submission',
    30
);

/* =========================
   COUNT PROPERTIES BY LOCATION
========================= */
function renthouse_get_property_count_by_location($location) {

    $property_count_query = new WP_Query(array(
        'post_type'      => 'property',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => array(
            array(
                'key'     => 'renthouse_location',
                'value'   => $location,
                'compare' => '='
            )
        )
    ));

    $count = $property_count_query->found_posts;

    wp_reset_postdata();

    return $count;
}
/* =========================
   RENTAL MARKET INSIGHTS STATS
========================= */
function renthouse_get_market_insights_stats() {

    $properties = new WP_Query(array(
        'post_type'      => 'property',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => array(
            array(
                'key'     => 'renthouse_price_number',
                'compare' => 'EXISTS'
            )
        )
    ));

    $prices = array();

    if (!empty($properties->posts)) {
        foreach ($properties->posts as $property_id) {
            $price = get_post_meta($property_id, 'renthouse_price_number', true);

            if (!empty($price) && is_numeric($price) && intval($price) > 0) {
                $prices[] = intval($price);
            }
        }
    }

    wp_reset_postdata();

    if (empty($prices)) {
        return array(
            'average' => 0,
            'highest' => 0,
            'lowest'  => 0,
            'count'   => 0
        );
    }

    return array(
        'average' => round(array_sum($prices) / count($prices)),
        'highest' => max($prices),
        'lowest'  => min($prices),
        'count'   => count($prices)
    );
}
/* =========================
   USER ROLES - TENANT / PROPERTY OWNER
========================= */

function renthouse_add_custom_user_roles() {

    add_role(
        'tenant',
        'Tenant',
        array(
            'read' => true,
        )
    );

    add_role(
        'property_owner',
        'Property Owner',
        array(
            'read' => true,
        )
    );
}
add_action('init', 'renthouse_add_custom_user_roles');


/* =========================
   FRONTEND USER REGISTRATION
========================= */

/* =========================
   FRONTEND USER REGISTRATION
========================= */

function renthouse_register_redirect_error($error_code) {
    $redirect_url = wp_get_referer() ? wp_get_referer() : home_url('/register/');

    // Remove old error from URL before adding new error
    $redirect_url = remove_query_arg('register_error', $redirect_url);

    wp_safe_redirect(add_query_arg('register_error', $error_code, $redirect_url));
    exit;
}

function renthouse_handle_user_registration() {

    if (!isset($_POST['renthouse_register_user'])) {
        return;
    }

    if (
        !isset($_POST['renthouse_register_nonce']) ||
        !wp_verify_nonce($_POST['renthouse_register_nonce'], 'renthouse_register_action')
    ) {
        wp_die('Security check failed.');
    }

    $full_name = sanitize_text_field(wp_unslash($_POST['full_name'] ?? ''));
    $email     = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $phone     = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $password  = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role      = sanitize_text_field(wp_unslash($_POST['user_role'] ?? 'tenant'));

    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        renthouse_register_redirect_error('empty_fields');
    }

    if (!is_email($email)) {
        renthouse_register_redirect_error('invalid_email');
    }

    if (email_exists($email)) {
        renthouse_register_redirect_error('email_exists');
    }

    if ($password !== $confirm_password) {
        renthouse_register_redirect_error('password_mismatch');
    }

    if (strlen($password) < 6) {
        renthouse_register_redirect_error('weak_password');
    }

    if (!preg_match('/^07[0-9]{8}$/', $phone)) {
    renthouse_register_redirect_error('invalid_phone');
}

    if (!in_array($role, array('tenant', 'property_owner'), true)) {
        $role = 'tenant';
    }

    $username_base = sanitize_user(current(explode('@', $email)));
    $username = $username_base;

    if (username_exists($username)) {
        $username = $username_base . '_' . wp_generate_password(4, false);
    }

    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        renthouse_register_redirect_error('failed');
    }

    wp_update_user(array(
        'ID'           => $user_id,
        'display_name' => $full_name,
        'first_name'   => $full_name,
        'role'         => $role,
    ));

    update_user_meta($user_id, 'renthouse_phone', $phone);

    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}
add_action('template_redirect', 'renthouse_handle_user_registration');

/* =========================
   FRONTEND USER LOGIN
========================= */

function renthouse_login_redirect_error($error_code) {
    $redirect_url = wp_get_referer() ? wp_get_referer() : home_url('/login/');
    $redirect_url = remove_query_arg('login_error', $redirect_url);

    wp_safe_redirect(add_query_arg('login_error', $error_code, $redirect_url));
    exit;
}

function renthouse_handle_user_login() {

    if (!isset($_POST['renthouse_login_user'])) {
        return;
    }

    if (
        !isset($_POST['renthouse_login_nonce']) ||
        !wp_verify_nonce($_POST['renthouse_login_nonce'], 'renthouse_login_action')
    ) {
        wp_die('Security check failed.');
    }

    $email_or_username = sanitize_text_field(wp_unslash($_POST['email_or_username'] ?? ''));
    $password          = $_POST['password'] ?? '';

    if (empty($email_or_username) || empty($password)) {
        renthouse_login_redirect_error('empty_fields');
    }

    /* Allow login using email or username */
    if (is_email($email_or_username)) {
        $user = get_user_by('email', $email_or_username);

        if (!$user) {
            renthouse_login_redirect_error('invalid_login');
        }

        $login_name = $user->user_login;
    } else {
        $login_name = $email_or_username;
    }

    $credentials = array(
        'user_login'    => $login_name,
        'user_password' => $password,
        'remember'      => true,
    );

    $signon_user = wp_signon($credentials, false);

    if (is_wp_error($signon_user)) {
        renthouse_login_redirect_error('invalid_login');
    }

    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}
add_action('template_redirect', 'renthouse_handle_user_login');

/* =========================
   BLOCK WP-ADMIN FOR NON-ADMIN USERS
========================= */

function renthouse_block_wp_admin_for_non_admins() {

    if (
        is_admin() &&
        !current_user_can('administrator') &&
        !(defined('DOING_AJAX') && DOING_AJAX)
    ) {
        wp_safe_redirect(home_url('/my-dashboard/'));
        exit;
    }
}
add_action('admin_init', 'renthouse_block_wp_admin_for_non_admins');


/* =========================
   HIDE ADMIN BAR FOR NON-ADMIN USERS
========================= */

function renthouse_hide_admin_bar_for_non_admins() {

    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'renthouse_hide_admin_bar_for_non_admins');

/* =========================
   DASHBOARD PROPERTY DELETE
========================= */

function renthouse_handle_dashboard_property_delete() {

    if (!is_user_logged_in()) {
        return;
    }

    if (!isset($_GET['renthouse_delete_property'], $_GET['property_id'], $_GET['renthouse_delete_nonce'])) {
        return;
    }

    $property_id = intval($_GET['property_id']);

    if (!$property_id || get_post_type($property_id) !== 'property') {
        wp_safe_redirect(home_url('/my-dashboard/'));
        exit;
    }

    if (!wp_verify_nonce($_GET['renthouse_delete_nonce'], 'renthouse_delete_property_' . $property_id)) {
        wp_die('Security check failed.');
    }

    $current_user_id = get_current_user_id();
    $property_author = intval(get_post_field('post_author', $property_id));

    $is_admin = current_user_can('administrator');
    $is_owner = ($property_author === $current_user_id);

    if (!$is_admin && !$is_owner) {
        wp_die('You are not allowed to delete this property.');
    }

    wp_trash_post($property_id);

    wp_safe_redirect(add_query_arg('property_deleted', 'success', home_url('/my-dashboard/')));
    exit;
}
add_action('template_redirect', 'renthouse_handle_dashboard_property_delete');
/* =========================
   DASHBOARD PROPERTY UPDATE
========================= */

function renthouse_handle_dashboard_property_update() {

    if (
        !isset($_SERVER['REQUEST_METHOD']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
    ) {
        return;
    }

    if (!isset($_POST['renthouse_update_property'])) {
        return;
    }

    if (!is_user_logged_in()) {
        wp_safe_redirect(home_url('/login/'));
        exit;
    }

    if (
        !isset($_POST['renthouse_update_property_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash($_POST['renthouse_update_property_nonce'])
            ),
            'renthouse_update_property_action'
        )
    ) {
        wp_die('Security check failed.');
    }

    $property_id = absint($_POST['property_id'] ?? 0);

    if (
        !$property_id ||
        get_post_type($property_id) !== 'property'
    ) {
        wp_safe_redirect(home_url('/my-dashboard/'));
        exit;
    }

    $current_user_id = get_current_user_id();

    $property_author = absint(
        get_post_field('post_author', $property_id)
    );

    if (
        !current_user_can('administrator') &&
        $property_author !== $current_user_id
    ) {
        wp_die('You are not allowed to update this property.');
    }

    $title = sanitize_text_field(
        wp_unslash($_POST['property_title'] ?? '')
    );

    $description = sanitize_textarea_field(
        wp_unslash($_POST['property_description'] ?? '')
    );

    $property_phone = sanitize_text_field(
        wp_unslash($_POST['property_phone'] ?? '')
    );

    $property_whatsapp = sanitize_text_field(
        wp_unslash($_POST['property_whatsapp'] ?? '')
    );

    $selected_package = sanitize_key(
        strtolower(
            wp_unslash($_POST['property_package'] ?? 'free')
        )
    );

    if (empty($title) || empty($description)) {

        wp_safe_redirect(
            add_query_arg(
                array(
                    'property_id'    => $property_id,
                    'property_error' => 'empty_fields',
                ),
                home_url('/edit-property/')
            )
        );

        exit;
    }

    if (!preg_match('/^07[0-9]{8}$/', $property_phone)) {

        wp_safe_redirect(
            add_query_arg(
                array(
                    'property_id'    => $property_id,
                    'property_error' => 'invalid_phone',
                ),
                home_url('/edit-property/')
            )
        );

        exit;
    }

    if (
        !empty($property_whatsapp) &&
        !preg_match('/^07[0-9]{8}$/', $property_whatsapp)
    ) {

        wp_safe_redirect(
            add_query_arg(
                array(
                    'property_id'    => $property_id,
                    'property_error' => 'invalid_whatsapp',
                ),
                home_url('/edit-property/')
            )
        );

        exit;
    }

    $package_prices = renthouse_get_package_prices();

    if (!array_key_exists($selected_package, $package_prices)) {
        $selected_package = 'free';
    }

    $updated_post = wp_update_post(
        array(
            'ID'           => $property_id,
            'post_title'   => $title,
            'post_content' => $description,
            'post_status'  => 'pending',
        ),
        true
    );

    if (is_wp_error($updated_post)) {

        wp_safe_redirect(
            add_query_arg(
                array(
                    'property_id'    => $property_id,
                    'property_error' => 'update_failed',
                ),
                home_url('/edit-property/')
            )
        );

        exit;
    }

    $price_text = sanitize_text_field(
        wp_unslash($_POST['property_price'] ?? '')
    );

    $price_number = renthouse_extract_price_number(
        $price_text
    );

    update_post_meta(
        $property_id,
        'renthouse_price',
        $price_text
    );

    update_post_meta(
        $property_id,
        'renthouse_price_number',
        $price_number
    );

    update_post_meta(
        $property_id,
        'renthouse_location',
        sanitize_text_field(
            wp_unslash($_POST['property_location'] ?? '')
        )
    );

    update_post_meta(
        $property_id,
        'renthouse_bedrooms',
        absint($_POST['property_bedrooms'] ?? 0)
    );

    update_post_meta(
        $property_id,
        'renthouse_bathrooms',
        absint($_POST['property_bathrooms'] ?? 0)
    );

    update_post_meta(
        $property_id,
        'renthouse_parking',
        absint($_POST['property_parking'] ?? 0)
    );

    update_post_meta(
        $property_id,
        'renthouse_property_type',
        sanitize_text_field(
            wp_unslash($_POST['property_type'] ?? '')
        )
    );

    update_post_meta(
        $property_id,
        'renthouse_phone',
        $property_phone
    );

    update_post_meta(
        $property_id,
        'renthouse_whatsapp',
        $property_whatsapp
    );

    update_post_meta(
        $property_id,
        'renthouse_package',
        $selected_package
    );

    if (!empty($_FILES['property_image']['name'])) {

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachment_id = media_handle_upload(
            'property_image',
            $property_id
        );

        if (is_wp_error($attachment_id)) {

            wp_safe_redirect(
                add_query_arg(
                    array(
                        'property_id'    => $property_id,
                        'property_error' => 'image_upload_failed',
                    ),
                    home_url('/edit-property/')
                )
            );

            exit;
        }

        set_post_thumbnail(
            $property_id,
            $attachment_id
        );
    }

    global $wpdb;

    $payment_table = $wpdb->prefix . 'renthouse_payments';

    $new_amount = (float) renthouse_get_package_price(
        $selected_package
    );

    $payment = renthouse_get_payment_by_property(
        $property_id
    );

    if (!$payment) {

        $payment = renthouse_create_payment_record(
            $property_id,
            $property_author,
            $selected_package
        );

        if (is_wp_error($payment)) {

            wp_safe_redirect(
                add_query_arg(
                    array(
                        'property_id'    => $property_id,
                        'property_error' => 'payment_update_failed',
                    ),
                    home_url('/edit-property/')
                )
            );

            exit;
        }

    } else {

        $existing_amount = (float) $payment->amount;

        $can_update_payment =
            $payment->payment_status !== 'paid' ||
            $existing_amount <= 0;

        if ($can_update_payment) {

            $new_payment_status = $new_amount > 0
                ? 'pending'
                : 'paid';

            $payment_update_data = array(
                'package'        => $selected_package,
                'amount'         => $new_amount,
                'payment_status' => $new_payment_status,
                'updated_at'     => current_time('mysql'),
            );

            $payment_update_formats = array(
                '%s',
                '%f',
                '%s',
                '%s',
            );

            if ($new_amount <= 0) {

                $payment_update_data['paid_at'] =
                    current_time('mysql');

                $payment_update_formats[] = '%s';
            }

            $payment_updated = $wpdb->update(
                $payment_table,
                $payment_update_data,
                array(
                    'id' => absint($payment->id),
                ),
                $payment_update_formats,
                array(
                    '%d',
                )
            );

            if ($payment_updated === false) {

                wp_safe_redirect(
                    add_query_arg(
                        array(
                            'property_id'    => $property_id,
                            'property_error' => 'payment_update_failed',
                        ),
                        home_url('/edit-property/')
                    )
                );

                exit;
            }

            if ($new_amount > 0) {

                $wpdb->query(
                    $wpdb->prepare(
                        "UPDATE {$payment_table}
                         SET paid_at = NULL
                         WHERE id = %d",
                        absint($payment->id)
                    )
                );
            }

            update_post_meta(
                $property_id,
                'renthouse_payment_status',
                $new_payment_status
            );

            update_post_meta(
                $property_id,
                'renthouse_payment_amount',
                $new_amount
            );

            $payment = renthouse_get_payment_by_property(
                $property_id
            );
        }
    }

    if (!$payment || is_wp_error($payment)) {

        wp_safe_redirect(
            add_query_arg(
                array(
                    'property_id'    => $property_id,
                    'property_error' => 'payment_update_failed',
                ),
                home_url('/edit-property/')
            )
        );

        exit;
    }

    if (
        $new_amount > 0 &&
        $payment->payment_status !== 'paid'
    ) {

        wp_safe_redirect(
            add_query_arg(
                'payment_reference',
                rawurlencode($payment->payment_reference),
                home_url('/payment/')
            )
        );

        exit;
    }

    wp_safe_redirect(
        add_query_arg(
            array(
                'property_id' => $property_id,
                'updated'     => 'success',
            ),
            home_url('/edit-property/')
        )
    );

    exit;
}

add_action(
    'template_redirect',
    'renthouse_handle_dashboard_property_update',
    30
);

/* ==================================================
   RENT HOUSE PAYMENT SYSTEM - CORE
================================================== */

/* =========================
   PACKAGE PRICES
========================= */

function renthouse_get_package_prices() {
    return array(
        'free'     => 0,
        'basic'    => 750,
        'featured' => 1500,
        'premium'  => 3000,
    );
}

function renthouse_get_package_price($package) {

    $package = sanitize_key(strtolower($package));
    $prices  = renthouse_get_package_prices();

    return isset($prices[$package])
        ? floatval($prices[$package])
        : 0;
}


/* =========================
   PAYMENT STATUSES
========================= */

function renthouse_get_payment_statuses() {
    return array(
        'pending'         => 'Pending Payment',
        'proof_submitted' => 'Proof Submitted',
        'processing'      => 'Processing',
        'paid'            => 'Paid',
        'rejected'        => 'Rejected',
        'failed'          => 'Failed',
        'cancelled'       => 'Cancelled',
        'refunded'        => 'Refunded',
    );
}


/* =========================
   CREATE PAYMENT TABLE
========================= */

function renthouse_create_payments_table() {

    global $wpdb;

    $table_name      = $wpdb->prefix . 'renthouse_payments';
    $charset_collate = $wpdb->get_charset_collate();

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $sql = "CREATE TABLE {$table_name} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        payment_reference varchar(100) NOT NULL,
        property_id bigint(20) unsigned NOT NULL,
        owner_id bigint(20) unsigned NOT NULL,
        package varchar(50) NOT NULL,
        amount decimal(12,2) NOT NULL DEFAULT 0.00,
        currency varchar(10) NOT NULL DEFAULT 'LKR',
        payment_method varchar(50) DEFAULT NULL,
        payment_status varchar(50) NOT NULL DEFAULT 'pending',
        bank_reference varchar(150) DEFAULT NULL,
        slip_attachment_id bigint(20) unsigned DEFAULT NULL,
        gateway_name varchar(100) DEFAULT NULL,
        gateway_transaction_id varchar(255) DEFAULT NULL,
        gateway_response longtext DEFAULT NULL,
        admin_note text DEFAULT NULL,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        paid_at datetime DEFAULT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY payment_reference (payment_reference),
        KEY property_id (property_id),
        KEY owner_id (owner_id),
        KEY payment_status (payment_status)
    ) {$charset_collate};";

    dbDelta($sql);

    return $wpdb->get_var(
        $wpdb->prepare(
            'SHOW TABLES LIKE %s',
            $table_name
        )
    ) === $table_name;
}


/* =========================
   CHECK PAYMENT TABLE
========================= */

function renthouse_payment_database_check() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'renthouse_payments';

    $table_exists = $wpdb->get_var(
        $wpdb->prepare(
            'SHOW TABLES LIKE %s',
            $table_name
        )
    );

    if ($table_exists !== $table_name) {

        $created = renthouse_create_payments_table();

        if ($created) {
            update_option(
                'renthouse_payment_db_version',
                '1.1'
            );
        }
    }
}
add_action(
    'init',
    'renthouse_payment_database_check',
    20
);


/* =========================
   PAYMENT REFERENCE
========================= */

function renthouse_generate_payment_reference() {

    return 'RHSL-' .
        gmdate('Ymd-His') .
        '-' .
        strtoupper(
            wp_generate_password(6, false, false)
        );
}


/* =========================
   GET PAYMENT BY PROPERTY
========================= */

function renthouse_get_payment_by_property($property_id) {

    global $wpdb;

    $property_id = intval($property_id);

    if (!$property_id) {
        return null;
    }

    $table_name = $wpdb->prefix . 'renthouse_payments';

    return $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$table_name}
             WHERE property_id = %d
             ORDER BY id DESC
             LIMIT 1",
            $property_id
        )
    );
}


/* =========================
   GET PAYMENT BY REFERENCE
========================= */

function renthouse_get_payment_by_reference($reference) {

    global $wpdb;

    $reference = sanitize_text_field($reference);

    if (empty($reference)) {
        return null;
    }

    $table_name = $wpdb->prefix . 'renthouse_payments';

    return $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$table_name}
             WHERE payment_reference = %s
             LIMIT 1",
            $reference
        )
    );
}


/* =========================
   CREATE PAYMENT RECORD
========================= */
function renthouse_create_payment_record(
    $property_id,
    $owner_id,
    $package
) {

    global $wpdb;

    $property_id = absint($property_id);
    $owner_id    = absint($owner_id);
    $package     = sanitize_key(strtolower($package));

    if (
        !$property_id ||
        !$owner_id ||
        get_post_type($property_id) !== 'property'
    ) {
        return new WP_Error(
            'invalid_payment_data',
            'Invalid property or owner information.'
        );
    }

    $prices = renthouse_get_package_prices();

    if (!array_key_exists($package, $prices)) {
        return new WP_Error(
            'invalid_package',
            'Invalid package selected: ' . $package
        );
    }

    $existing_payment = renthouse_get_payment_by_property(
        $property_id
    );

    if ($existing_payment) {
        return $existing_payment;
    }

    $table_name = $wpdb->prefix . 'renthouse_payments';

    $table_exists = $wpdb->get_var(
        $wpdb->prepare(
            'SHOW TABLES LIKE %s',
            $table_name
        )
    );

    if ($table_exists !== $table_name) {
        return new WP_Error(
            'payment_table_missing',
            'Payment database table does not exist.'
        );
    }

    $amount = (float) renthouse_get_package_price($package);

    $payment_reference = renthouse_generate_payment_reference();

    $payment_status = $amount > 0
        ? 'pending'
        : 'paid';

    $now = current_time('mysql');

    $insert_data = array(
        'payment_reference' => $payment_reference,
        'property_id'       => $property_id,
        'owner_id'          => $owner_id,
        'package'           => $package,
        'amount'            => $amount,
        'currency'          => 'LKR',
        'payment_status'    => $payment_status,
        'created_at'        => $now,
        'updated_at'        => $now,
    );

    $insert_formats = array(
        '%s',
        '%d',
        '%d',
        '%s',
        '%f',
        '%s',
        '%s',
        '%s',
        '%s',
    );

    /*
     * Free package only.
     * Paid packages must keep paid_at as database NULL.
     */
    if ($amount <= 0) {
        $insert_data['paid_at'] = $now;
        $insert_formats[]       = '%s';
    }
$inserted = $wpdb->insert(
    $table_name,
    $insert_data,
    $insert_formats
);

if ($inserted === false) {
    return new WP_Error(
        'payment_creation_failed',
        !empty($wpdb->last_error)
            ? $wpdb->last_error
            : 'Payment record could not be created.'
    );
}

/* Save payment ID immediately */
$payment_id = (int) $wpdb->insert_id;

update_post_meta(
    $property_id,
    'renthouse_payment_reference',
    $payment_reference
);

update_post_meta(
    $property_id,
    'renthouse_payment_amount',
    $amount
);

update_post_meta(
    $property_id,
    'renthouse_payment_status',
    $payment_status
);

$payment = $wpdb->get_row(
    $wpdb->prepare(
        "SELECT *
         FROM {$table_name}
         WHERE id = %d
         LIMIT 1",
        $payment_id
    )
);

if (!$payment) {
    return new WP_Error(
        'payment_fetch_failed',
        'Payment was created but could not be loaded.'
    );
}

return $payment;
}

/* =========================
   UPDATE PAYMENT STATUS
========================= */

function renthouse_update_payment_status(
    $payment_id,
    $new_status,
    $admin_note = ''
) {

    global $wpdb;

    $payment_id = intval($payment_id);
    $new_status = sanitize_key($new_status);
    $admin_note = sanitize_textarea_field($admin_note);

    $allowed_statuses = array_keys(
        renthouse_get_payment_statuses()
    );

    if (
        !$payment_id ||
        !in_array($new_status, $allowed_statuses, true)
    ) {
        return false;
    }

    $table_name = $wpdb->prefix . 'renthouse_payments';

    $payment = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$table_name}
             WHERE id = %d
             LIMIT 1",
            $payment_id
        )
    );

    if (!$payment) {
        return false;
    }

    $update_data = array(
        'payment_status' => $new_status,
        'admin_note'     => $admin_note,
        'updated_at'     => current_time('mysql'),
    );

    $update_format = array(
        '%s',
        '%s',
        '%s',
    );

    if ($new_status === 'paid') {
        $update_data['paid_at'] = current_time('mysql');
        $update_format[]        = '%s';
    }

    $updated = $wpdb->update(
        $table_name,
        $update_data,
        array(
            'id' => $payment_id,
        ),
        $update_format,
        array(
            '%d',
        )
    );

    if ($updated === false) {
        return false;
    }

    update_post_meta(
        intval($payment->property_id),
        'renthouse_payment_status',
        $new_status
    );

    return true;
}

/* ==================================================
   PAYMENT PROOF SUBMISSION HANDLER
================================================== */

function renthouse_handle_payment_proof_submission() {

    if (!is_user_logged_in()) {
        return;
    }

    if (!isset($_POST['renthouse_submit_payment_proof'])) {
        return;
    }

    if (
        !isset($_POST['renthouse_payment_proof_nonce']) ||
        !wp_verify_nonce(
            $_POST['renthouse_payment_proof_nonce'],
            'renthouse_submit_payment_proof_action'
        )
    ) {
        wp_die('Security check failed.');
    }

    global $wpdb;

    $payment_id        = intval($_POST['payment_id'] ?? 0);
    $payment_reference = sanitize_text_field(
        wp_unslash($_POST['payment_reference'] ?? '')
    );

    $bank_reference = sanitize_text_field(
        wp_unslash($_POST['bank_reference'] ?? '')
    );

    $payment_note = sanitize_textarea_field(
        wp_unslash($_POST['payment_note'] ?? '')
    );

    $table_name = $wpdb->prefix . 'renthouse_payments';

    $payment = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$table_name}
             WHERE id = %d
             AND payment_reference = %s
             LIMIT 1",
            $payment_id,
            $payment_reference
        )
    );

    if (!$payment) {
        wp_die('Payment record not found.');
    }

    if (
        !current_user_can('administrator') &&
        intval($payment->owner_id) !== get_current_user_id()
    ) {
        wp_die('You are not allowed to update this payment.');
    }

    if (
        empty($bank_reference) ||
        empty($_FILES['payment_slip']['name'])
    ) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    'payment_reference' => $payment_reference,
                    'payment_error'     => 'missing_fields',
                ),
                home_url('/payment/')
            )
        );

        exit;
    }

    $file = $_FILES['payment_slip'];

    $allowed_mime_types = array(
        'image/jpeg',
        'image/png',
        'application/pdf',
    );

    if (
        empty($file['type']) ||
        !in_array($file['type'], $allowed_mime_types, true) ||
        intval($file['size']) > 5 * 1024 * 1024
    ) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    'payment_reference' => $payment_reference,
                    'payment_error'     => 'invalid_file',
                ),
                home_url('/payment/')
            )
        );

        exit;
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $attachment_id = media_handle_upload(
        'payment_slip',
        intval($payment->property_id)
    );

    if (is_wp_error($attachment_id)) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    'payment_reference' => $payment_reference,
                    'payment_error'     => 'upload_failed',
                ),
                home_url('/payment/')
            )
        );

        exit;
    }

    $updated = $wpdb->update(
        $table_name,
        array(
            'payment_method'    => 'bank_transfer',
            'payment_status'    => 'proof_submitted',
            'bank_reference'    => $bank_reference,
            'slip_attachment_id'=> $attachment_id,
            'admin_note'        => $payment_note,
            'updated_at'        => current_time('mysql'),
        ),
        array(
            'id' => $payment_id,
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
        ),
        array(
            '%d',
        )
    );

    if ($updated === false) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    'payment_reference' => $payment_reference,
                    'payment_error'     => 'update_failed',
                ),
                home_url('/payment/')
            )
        );

        exit;
    }

    update_post_meta(
        intval($payment->property_id),
        'renthouse_payment_status',
        'proof_submitted'
    );

    wp_safe_redirect(
        add_query_arg(
            array(
                'payment_reference' => $payment_reference,
                'payment_submitted' => 'success',
            ),
            home_url('/payment/')
        )
    );

    exit;
}
add_action(
    'template_redirect',
    'renthouse_handle_payment_proof_submission'
);

/* ==================================================
   ADMIN PAYMENT VERIFICATION HANDLER
================================================== */

function renthouse_handle_admin_payment_verification() {

    if (
        !isset($_SERVER['REQUEST_METHOD']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
    ) {
        return;
    }

    if (!isset($_POST['renthouse_admin_payment_action'])) {
        return;
    }

    if (
        !is_user_logged_in() ||
        !current_user_can('administrator')
    ) {
        wp_die('You are not allowed to perform this action.');
    }

    if (
        !isset($_POST['renthouse_admin_payment_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash(
                    $_POST['renthouse_admin_payment_nonce']
                )
            ),
            'renthouse_admin_payment_action'
        )
    ) {
        wp_die('Security check failed.');
    }

    global $wpdb;

    $payment_id = absint($_POST['payment_id'] ?? 0);

    $action = sanitize_key(
        wp_unslash(
            $_POST['renthouse_admin_payment_action'] ?? ''
        )
    );

    $admin_note = sanitize_textarea_field(
        wp_unslash($_POST['admin_note'] ?? '')
    );

    if (
        !$payment_id ||
        !in_array($action, array('approve', 'reject'), true)
    ) {
        wp_safe_redirect(
            add_query_arg(
                'payment_action',
                'failed',
                home_url('/admin-payments/')
            )
        );
        exit;
    }

    $payments_table = $wpdb->prefix . 'renthouse_payments';

    $payment = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$payments_table}
             WHERE id = %d
             LIMIT 1",
            $payment_id
        )
    );

    if (!$payment) {
        wp_safe_redirect(
            add_query_arg(
                'payment_action',
                'failed',
                home_url('/admin-payments/')
            )
        );
        exit;
    }

    $property_id = absint($payment->property_id);

    if ($action === 'approve') {

        $updated = renthouse_update_payment_status(
            $payment_id,
            'paid',
            $admin_note
        );

        if (!$updated) {
            wp_safe_redirect(
                add_query_arg(
                    'payment_action',
                    'failed',
                    home_url('/admin-payments/')
                )
            );
            exit;
        }

        update_post_meta(
            $property_id,
            'renthouse_payment_status',
            'paid'
        );

        update_post_meta(
            $property_id,
            'renthouse_payment_verified_by',
            get_current_user_id()
        );

        update_post_meta(
            $property_id,
            'renthouse_payment_verified_at',
            current_time('mysql')
        );

        wp_safe_redirect(
            add_query_arg(
                'payment_action',
                'approved',
                home_url('/admin-payments/')
            )
        );
        exit;
    }

    if ($action === 'reject') {

        $updated = renthouse_update_payment_status(
            $payment_id,
            'rejected',
            $admin_note
        );

        if (!$updated) {
            wp_safe_redirect(
                add_query_arg(
                    'payment_action',
                    'failed',
                    home_url('/admin-payments/')
                )
            );
            exit;
        }

        update_post_meta(
            $property_id,
            'renthouse_payment_status',
            'rejected'
        );

        wp_safe_redirect(
            add_query_arg(
                'payment_action',
                'rejected',
                home_url('/admin-payments/')
            )
        );
        exit;
    }
}

add_action(
    'template_redirect',
    'renthouse_handle_admin_payment_verification',
    40
);

/* ==================================================
   ADMIN BANK SETTINGS HANDLER
================================================== */

function renthouse_handle_admin_bank_settings() {

    if (
        !isset($_SERVER['REQUEST_METHOD']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
    ) {
        return;
    }

    if (!isset($_POST['renthouse_save_bank_settings'])) {
        return;
    }

    if (
        !is_user_logged_in() ||
        !current_user_can('administrator')
    ) {
        wp_die('You are not allowed to perform this action.');
    }

    if (
        !isset($_POST['renthouse_bank_settings_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash(
                    $_POST['renthouse_bank_settings_nonce']
                )
            ),
            'renthouse_save_bank_settings_action'
        )
    ) {
        wp_die('Security check failed.');
    }

    $bank_name = sanitize_text_field(
        wp_unslash($_POST['renthouse_bank_name'] ?? '')
    );

    $account_holder = sanitize_text_field(
        wp_unslash($_POST['renthouse_account_holder'] ?? '')
    );

    $account_number = preg_replace(
        '/[^0-9]/',
        '',
        wp_unslash(
            $_POST['renthouse_account_number'] ?? ''
        )
    );

    $branch_name = sanitize_text_field(
        wp_unslash($_POST['renthouse_branch_name'] ?? '')
    );

    $payment_instructions = sanitize_textarea_field(
        wp_unslash(
            $_POST['renthouse_payment_instructions'] ?? ''
        )
    );

    if (
        empty($bank_name) ||
        empty($account_holder) ||
        empty($account_number) ||
        empty($branch_name) ||
        empty($payment_instructions)
    ) {
        wp_safe_redirect(
            add_query_arg(
                'bank_settings',
                'error',
                home_url('/admin-bank-settings/')
            )
        );
        exit;
    }

    update_option(
        'renthouse_bank_name',
        $bank_name
    );

    update_option(
        'renthouse_bank_account_holder',
        $account_holder
    );

    update_option(
        'renthouse_bank_account_number',
        $account_number
    );

    update_option(
        'renthouse_bank_branch',
        $branch_name
    );

    update_option(
        'renthouse_bank_instructions',
        $payment_instructions
    );

    wp_safe_redirect(
        add_query_arg(
            'bank_settings',
            'saved',
            home_url('/admin-bank-settings/')
        )
    );

    exit;
}

add_action(
    'template_redirect',
    'renthouse_handle_admin_bank_settings',
    40
);

/* ==================================================
   RENTHOUSE INQUIRY SYSTEM - DATABASE
================================================== */

function renthouse_create_inquiries_table() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    $charset_collate = $wpdb->get_charset_collate();

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $sql = "CREATE TABLE {$table_name} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        inquiry_reference varchar(100) NOT NULL,
        property_id bigint(20) unsigned NOT NULL,
        tenant_id bigint(20) unsigned NOT NULL,
        owner_id bigint(20) unsigned NOT NULL,
        tenant_name varchar(150) NOT NULL,
        tenant_email varchar(190) NOT NULL,
        tenant_phone varchar(30) NOT NULL,
        preferred_contact varchar(30) NOT NULL DEFAULT 'phone',
        message text NOT NULL,
        owner_reply text NULL,
        inquiry_status varchar(40) NOT NULL DEFAULT 'new',
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        replied_at datetime NULL,
        closed_at datetime NULL,
        PRIMARY KEY (id),
        UNIQUE KEY inquiry_reference (inquiry_reference),
        KEY property_id (property_id),
        KEY tenant_id (tenant_id),
        KEY owner_id (owner_id),
        KEY inquiry_status (inquiry_status)
    ) {$charset_collate};";

    dbDelta($sql);

    return $wpdb->get_var(
        $wpdb->prepare(
            'SHOW TABLES LIKE %s',
            $table_name
        )
    ) === $table_name;
}


/* ==================================================
   CHECK INQUIRY TABLE
================================================== */

function renthouse_inquiry_database_check() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    $table_exists = $wpdb->get_var(
        $wpdb->prepare(
            'SHOW TABLES LIKE %s',
            $table_name
        )
    );

    if ($table_exists !== $table_name) {

        $created = renthouse_create_inquiries_table();

        if ($created) {
            update_option(
                'renthouse_inquiry_db_version',
                '1.0'
            );
        }
    }
}

add_action(
    'init',
    'renthouse_inquiry_database_check',
    25
);


/* ==================================================
   INQUIRY STATUSES
================================================== */

function renthouse_get_inquiry_statuses() {

    return array(
        'new'       => 'New Inquiry',
        'viewed'    => 'Viewed',
        'replied'   => 'Replied',
        'contacted' => 'Contacted',
        'closed'    => 'Closed',
        'rejected'  => 'Rejected',
    );
}


/* ==================================================
   GENERATE INQUIRY REFERENCE
================================================== */

function renthouse_generate_inquiry_reference() {

    return 'RH-INQ-' .
        gmdate('Ymd-His') .
        '-' .
        strtoupper(
            wp_generate_password(5, false, false)
        );
}


/* ==================================================
   GET INQUIRY BY ID
================================================== */

function renthouse_get_inquiry_by_id($inquiry_id) {

    global $wpdb;

    $inquiry_id = absint($inquiry_id);

    if (!$inquiry_id) {
        return null;
    }

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    return $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$table_name}
             WHERE id = %d
             LIMIT 1",
            $inquiry_id
        )
    );
}


/* ==================================================
   GET OWNER INQUIRY COUNT
================================================== */

function renthouse_get_owner_inquiry_count(
    $owner_id,
    $status = ''
) {

    global $wpdb;

    $owner_id = absint($owner_id);

    if (!$owner_id) {
        return 0;
    }

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    if (!empty($status)) {

        $status = sanitize_key($status);

        return (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*)
                 FROM {$table_name}
                 WHERE owner_id = %d
                 AND inquiry_status = %s",
                $owner_id,
                $status
            )
        );
    }

    return (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE owner_id = %d",
            $owner_id
        )
    );
}


/* ==================================================
   GET TENANT INQUIRY COUNT
================================================== */

function renthouse_get_tenant_inquiry_count(
    $tenant_id,
    $status = ''
) {

    global $wpdb;

    $tenant_id = absint($tenant_id);

    if (!$tenant_id) {
        return 0;
    }

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    if (!empty($status)) {

        $status = sanitize_key($status);

        return (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*)
                 FROM {$table_name}
                 WHERE tenant_id = %d
                 AND inquiry_status = %s",
                $tenant_id,
                $status
            )
        );
    }

    return (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table_name}
             WHERE tenant_id = %d",
            $tenant_id
        )
    );
}


/* ==================================================
   CHECK RECENT DUPLICATE INQUIRY
================================================== */

function renthouse_has_recent_duplicate_inquiry(
    $property_id,
    $tenant_id
) {

    global $wpdb;

    $property_id = absint($property_id);
    $tenant_id   = absint($tenant_id);

    if (!$property_id || !$tenant_id) {
        return false;
    }

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    $recent_inquiry = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id
             FROM {$table_name}
             WHERE property_id = %d
             AND tenant_id = %d
             AND created_at >= DATE_SUB(%s, INTERVAL 10 MINUTE)
             ORDER BY id DESC
             LIMIT 1",
            $property_id,
            $tenant_id,
            current_time('mysql')
        )
    );

    return !empty($recent_inquiry);
}
/* ==================================================
   TENANT INQUIRY SUBMISSION HANDLER
================================================== */

function renthouse_handle_inquiry_submission() {

    if (
        !isset($_SERVER['REQUEST_METHOD']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
    ) {
        return;
    }

    if (!isset($_POST['renthouse_submit_inquiry'])) {
        return;
    }

    $property_id = absint(
        $_POST['property_id'] ?? 0
    );

    $redirect_url = $property_id
        ? get_permalink($property_id)
        : home_url('/properties/');

    if (!is_user_logged_in()) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'login_required',
                $redirect_url
            )
        );

        exit;
    }

    if (
        !isset($_POST['renthouse_inquiry_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash(
                    $_POST['renthouse_inquiry_nonce']
                )
            ),
            'renthouse_submit_inquiry_action'
        )
    ) {
        wp_die('Security check failed.');
    }

    if (
        !$property_id ||
        get_post_type($property_id) !== 'property' ||
        get_post_status($property_id) !== 'publish'
    ) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'invalid_property',
                home_url('/properties/')
            )
        );

        exit;
    }

    $current_user = wp_get_current_user();
    $tenant_id    = get_current_user_id();

    $user_roles = (array) $current_user->roles;

    $is_tenant = in_array(
        'tenant',
        $user_roles,
        true
    );

    if (
        !$is_tenant &&
        !current_user_can('administrator')
    ) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'tenant_only',
                $redirect_url
            )
        );

        exit;
    }

    $owner_id = absint(
        get_post_field(
            'post_author',
            $property_id
        )
    );

    if (!$owner_id) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'owner_not_found',
                $redirect_url
            )
        );

        exit;
    }

    if (
        $tenant_id === $owner_id &&
        !current_user_can('administrator')
    ) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'own_property',
                $redirect_url
            )
        );

        exit;
    }

    $tenant_name = sanitize_text_field(
        wp_unslash(
            $_POST['tenant_name'] ??
            $current_user->display_name
        )
    );

    $tenant_email = sanitize_email(
        wp_unslash(
            $_POST['tenant_email'] ??
            $current_user->user_email
        )
    );

    $tenant_phone = sanitize_text_field(
        wp_unslash(
            $_POST['tenant_phone'] ?? ''
        )
    );

    $preferred_contact = sanitize_key(
        wp_unslash(
            $_POST['preferred_contact'] ?? 'phone'
        )
    );

    $message = sanitize_textarea_field(
        wp_unslash(
            $_POST['inquiry_message'] ?? ''
        )
    );

    $allowed_contact_methods = array(
        'phone',
        'whatsapp',
        'email',
    );

    if (
        empty($tenant_name) ||
        empty($tenant_email) ||
        empty($tenant_phone) ||
        empty($message)
    ) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'empty_fields',
                $redirect_url
            )
        );

        exit;
    }

    if (!is_email($tenant_email)) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'invalid_email',
                $redirect_url
            )
        );

        exit;
    }

    if (!preg_match('/^07[0-9]{8}$/', $tenant_phone)) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'invalid_phone',
                $redirect_url
            )
        );

        exit;
    }

    if (
        !in_array(
            $preferred_contact,
            $allowed_contact_methods,
            true
        )
    ) {
        $preferred_contact = 'phone';
    }

    if (mb_strlen($message) < 10) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'message_too_short',
                $redirect_url
            )
        );

        exit;
    }

    if (mb_strlen($message) > 1500) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'message_too_long',
                $redirect_url
            )
        );

        exit;
    }

    if (
        function_exists(
            'renthouse_has_recent_duplicate_inquiry'
        ) &&
        renthouse_has_recent_duplicate_inquiry(
            $property_id,
            $tenant_id
        )
    ) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'duplicate',
                $redirect_url
            )
        );

        exit;
    }

    global $wpdb;

    $table_name =
        $wpdb->prefix . 'renthouse_inquiries';

    $table_exists = $wpdb->get_var(
        $wpdb->prepare(
            'SHOW TABLES LIKE %s',
            $table_name
        )
    );

    if ($table_exists !== $table_name) {

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'database_error',
                $redirect_url
            )
        );

        exit;
    }

    $inquiry_reference =
        renthouse_generate_inquiry_reference();

    $now = current_time('mysql');

    $inserted = $wpdb->insert(
        $table_name,
        array(
            'inquiry_reference' => $inquiry_reference,
            'property_id'       => $property_id,
            'tenant_id'         => $tenant_id,
            'owner_id'          => $owner_id,
            'tenant_name'       => $tenant_name,
            'tenant_email'      => $tenant_email,
            'tenant_phone'      => $tenant_phone,
            'preferred_contact' => $preferred_contact,
            'message'           => $message,
            'inquiry_status'    => 'new',
            'created_at'        => $now,
            'updated_at'        => $now,
        ),
        array(
            '%s',
            '%d',
            '%d',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
        )
    );

    if ($inserted === false) {

        error_log(
            'RentHouse inquiry insert error: ' .
            $wpdb->last_error
        );

        wp_safe_redirect(
            add_query_arg(
                'inquiry_error',
                'save_failed',
                $redirect_url
            )
        );

        exit;
    }

    update_user_meta(
        $tenant_id,
        'renthouse_phone',
        $tenant_phone
    );

/* EMAIL NOTIFICATION */

$owner = get_user_by(
    'id',
    $owner_id
);

if (
    $owner &&
    !empty($owner->user_email)
) {

    $property_title = get_the_title(
        $property_id
    );

    $subject =
        'New Property Inquiry - ' .
        $property_title;

    $email_message =
        "Property: " .
        $property_title .
        "\n\n" .

        "Tenant: " .
        $tenant_name .
        "\n" .

        "Email: " .
        $tenant_email .
        "\n" .

        "Phone: " .
        $tenant_phone .
        "\n\n" .

        "Message:\n" .
        $message;

    wp_mail(
        $owner->user_email,
        $subject,
        $email_message
    );
}

    wp_safe_redirect(
        add_query_arg(
            array(
                'inquiry_submitted' => 'success',
                'inquiry_reference' => rawurlencode(
                    $inquiry_reference
                ),
            ),
            $redirect_url
        )
    );

    exit;
}

add_action(
    'template_redirect',
    'renthouse_handle_inquiry_submission',
    35
);
/* ==================================================
   OWNER INQUIRY ACTION HANDLER
================================================== */

function renthouse_handle_owner_inquiry_action() {

    if (
        !isset($_SERVER['REQUEST_METHOD']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
    ) {
        return;
    }

    if (!isset($_POST['renthouse_owner_inquiry_action'])) {
        return;
    }

    if (!is_user_logged_in()) {
        wp_safe_redirect(home_url('/login/'));
        exit;
    }

    if (
        !isset($_POST['renthouse_owner_inquiry_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash(
                    $_POST['renthouse_owner_inquiry_nonce']
                )
            ),
            'renthouse_owner_inquiry_action'
        )
    ) {
        wp_die('Security check failed.');
    }

    global $wpdb;

    $table_name = $wpdb->prefix . 'renthouse_inquiries';

    $inquiry_id = absint(
        $_POST['inquiry_id'] ?? 0
    );

    $action = sanitize_key(
        wp_unslash(
            $_POST['renthouse_owner_inquiry_action'] ?? ''
        )
    );

    $owner_reply = sanitize_textarea_field(
        wp_unslash(
            $_POST['owner_reply'] ?? ''
        )
    );

    $redirect_url = home_url('/owner-inquiries/');

    $allowed_actions = array(
        'reply',
        'contacted',
        'close',
        'reject',
    );

    if (
        !$inquiry_id ||
        !in_array($action, $allowed_actions, true)
    ) {
        wp_safe_redirect(
            add_query_arg(
                'inquiry_action',
                'failed',
                $redirect_url
            )
        );
        exit;
    }

    $inquiry = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT *
             FROM {$table_name}
             WHERE id = %d
             LIMIT 1",
            $inquiry_id
        )
    );

    if (!$inquiry) {
        wp_safe_redirect(
            add_query_arg(
                'inquiry_action',
                'failed',
                $redirect_url
            )
        );
        exit;
    }

    $current_user_id = get_current_user_id();

    $is_admin = current_user_can('administrator');

    $is_owner = absint($inquiry->owner_id) === $current_user_id;

    if (!$is_admin && !$is_owner) {
        wp_die('You are not allowed to update this inquiry.');
    }

    if (
        in_array(
            $inquiry->inquiry_status,
            array('closed', 'rejected'),
            true
        )
    ) {
        wp_safe_redirect(
            add_query_arg(
                'inquiry_action',
                'failed',
                $redirect_url
            )
        );
        exit;
    }

    $now = current_time('mysql');

    if ($action === 'reply') {

        if (empty($owner_reply)) {
            wp_safe_redirect(
                add_query_arg(
                    'inquiry_action',
                    'empty_reply',
                    $redirect_url
                )
            );
            exit;
        }

        if (mb_strlen($owner_reply) < 3) {
            wp_safe_redirect(
                add_query_arg(
                    'inquiry_action',
                    'empty_reply',
                    $redirect_url
                )
            );
            exit;
        }

        if (mb_strlen($owner_reply) > 2000) {
            wp_safe_redirect(
                add_query_arg(
                    'inquiry_action',
                    'failed',
                    $redirect_url
                )
            );
            exit;
        }

        $updated = $wpdb->update(
            $table_name,
            array(
                'owner_reply'    => $owner_reply,
                'inquiry_status' => 'replied',
                'replied_at'     => $now,
                'updated_at'     => $now,
            ),
            array(
                'id' => $inquiry_id,
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
            ),
            array(
                '%d',
            )
        );

        $result_message = 'replied';

    } elseif ($action === 'contacted') {

        $updated = $wpdb->update(
            $table_name,
            array(
                'inquiry_status' => 'contacted',
                'updated_at'     => $now,
            ),
            array(
                'id' => $inquiry_id,
            ),
            array(
                '%s',
                '%s',
            ),
            array(
                '%d',
            )
        );

        $result_message = 'contacted';

    } elseif ($action === 'close') {

        $updated = $wpdb->update(
            $table_name,
            array(
                'inquiry_status' => 'closed',
                'closed_at'      => $now,
                'updated_at'     => $now,
            ),
            array(
                'id' => $inquiry_id,
            ),
            array(
                '%s',
                '%s',
                '%s',
            ),
            array(
                '%d',
            )
        );

        $result_message = 'closed';

    } else {

        $updated = $wpdb->update(
            $table_name,
            array(
                'inquiry_status' => 'rejected',
                'closed_at'      => $now,
                'updated_at'     => $now,
            ),
            array(
                'id' => $inquiry_id,
            ),
            array(
                '%s',
                '%s',
                '%s',
            ),
            array(
                '%d',
            )
        );

        $result_message = 'rejected';
    }

    if ($updated === false) {

        error_log(
            'RentHouse inquiry update error: ' .
            $wpdb->last_error
        );

        wp_safe_redirect(
            add_query_arg(
                'inquiry_action',
                'failed',
                $redirect_url
            )
        );
        exit;
    }

    wp_safe_redirect(
        add_query_arg(
            'inquiry_action',
            $result_message,
            $redirect_url
        )
    );

    exit;
}

add_action(
    'template_redirect',
    'renthouse_handle_owner_inquiry_action',
    40
);