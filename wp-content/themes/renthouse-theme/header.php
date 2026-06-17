<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container navbar">

        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            Rent House Sri Lanka
        </a>

        <!-- Navigation Menu -->
        <nav class="menu">

            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>

            <a href="<?php echo esc_url(home_url('/properties/')); ?>">Properties</a>

            <a href="<?php echo esc_url(home_url('/pricing/')); ?>">Pricing</a>

            <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Us</a>

            <!-- Guide Dropdown -->
            <div class="nav-dropdown">
                <a href="#" class="dropdown-toggle">Guide ▾</a>

                <div class="dropdown-menu">
                    <a href="<?php echo esc_url(home_url('/tenant-guide/')); ?>">Tenant Guide</a>
                    <a href="<?php echo esc_url(home_url('/landlord-guide/')); ?>">Landlord Guide</a>
                </div>
            </div>

            <a href="<?php echo esc_url(home_url('/advertisement/')); ?>">Advertisement</a>

            <!-- Language Dropdown -->
            <div class="nav-dropdown">
                <a href="#" class="dropdown-toggle">Language ▾</a>

                <div class="dropdown-menu">
                    <a href="<?php echo esc_url(home_url('/')); ?>">English</a>
                    <a href="<?php echo esc_url(home_url('/si/')); ?>">සිංහල</a>
                </div>
            </div>

            <!-- Auth Buttons -->
            <?php if (is_user_logged_in()) : ?>

                <?php
                $current_user = wp_get_current_user();
                $user_roles   = $current_user->roles;
                $user_role    = !empty($user_roles) ? $user_roles[0] : '';
                ?>

                <a href="<?php echo esc_url(home_url('/my-dashboard/')); ?>" class="nav-dashboard-btn">
                    My Dashboard
                </a>

                <?php if ($user_role === 'property_owner' || current_user_can('administrator')) : ?>
                    <a href="<?php echo esc_url(home_url('/post-ad/')); ?>" class="post-btn">
                        Post Ad
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="nav-logout-btn">
                    Logout
                </a>

            <?php else : ?>

                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="nav-login-btn">
                    Login
                </a>

                <a href="<?php echo esc_url(home_url('/register/')); ?>" class="nav-register-btn">
                    Register
                </a>

                <a href="<?php echo esc_url(home_url('/post-ad/')); ?>" class="post-btn">
                    Post Ad
                </a>

            <?php endif; ?>

        </nav>
    </div>
</header>