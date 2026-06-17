<?php
/* Template Name: Login Page */


if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
}

get_header();
?>

<section class="auth-page login-page">
    <div class="container">

        <div class="auth-layout">

            <div class="auth-info-panel">
                <span>Welcome Back</span>
                <h1>Login to your account</h1>
                <p>
                    Continue your rental journey, manage property advertisements, send inquiries, and access your Rent House Sri Lanka dashboard.
                </p>

                <div class="auth-benefits">
                    <div>🏠 Manage your rental ads</div>
                    <div>🔎 Continue searching homes</div>
                    <div>💬 Track rental inquiries</div>
                    <div>⭐ Manage your activity</div>
                </div>
            </div>

            <div class="auth-form-card">

                <span class="auth-badge">Login</span>
                <h2>Welcome back</h2>
                <p>Login to continue to your dashboard.</p>

                <?php if (isset($_GET['login_error'])) : ?>
                    <div class="auth-error">
                        <?php
                        $error = sanitize_text_field($_GET['login_error']);

                        if ($error === 'empty_fields') {
                            echo 'Please enter your login details.';
                        } elseif ($error === 'invalid_login') {
                            echo 'Invalid email/username or password.';
                        } else {
                            echo 'Login failed. Please try again.';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <div class="auth-error form-live-error" style="display:none;"></div>

                <form method="post" id="renthouse-login-form" novalidate>

                    <?php wp_nonce_field('renthouse_login_action', 'renthouse_login_nonce'); ?>

                    <div class="auth-field">
                        <label>Email or Username</label>
                        <input 
                            type="text" 
                            name="email_or_username" 
                            id="login_email_or_username"
                            placeholder="Enter email or username"
                            autocomplete="username"
                            required
                        >
                        <small class="field-error" id="login_user_error"></small>
                    </div>

                    <div class="auth-field">
                        <label>Password</label>
                        <div class="password-field-wrap">
                            <input 
                                type="password" 
                                name="password" 
                                id="login_password" 
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button" class="password-toggle" data-target="login_password">👁</button>
                        </div>
                        <small class="field-error" id="login_password_error"></small>
                    </div>

                    <button type="submit" name="renthouse_login_user" class="auth-submit-btn">
                        Login
                    </button>

                </form>

                <div class="auth-switch">
                    Don’t have an account?
                    <a href="<?php echo esc_url(home_url('/register/')); ?>">Create account</a>
                </div>

            </div>

        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('renthouse-login-form');
    const userInput = document.getElementById('login_email_or_username');
    const password = document.getElementById('login_password');

    const userError = document.getElementById('login_user_error');
    const passwordError = document.getElementById('login_password_error');
    const formLiveError = document.querySelector('.form-live-error');

    const toggles = document.querySelectorAll('.password-toggle');

    function setFieldError(input, errorElement, message) {
        if (!input || !errorElement) return;

        if (message) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            input.classList.add('input-error');
        } else {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
            input.classList.remove('input-error');
        }
    }

    function showFormError(message) {
        if (!formLiveError) return;
        formLiveError.textContent = message;
        formLiveError.style.display = 'block';
    }

    function hideFormError() {
        if (!formLiveError) return;
        formLiveError.textContent = '';
        formLiveError.style.display = 'none';
    }

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = '🙈';
            } else {
                input.type = 'password';
                this.textContent = '👁';
            }
        });
    });

    function validateUserField() {
        if (!userInput) return true;

        if (userInput.value.trim() === '') {
            setFieldError(userInput, userError, 'Email or username is required.');
            return false;
        }

        setFieldError(userInput, userError, '');
        return true;
    }

    function validatePasswordField() {
        if (!password) return true;

        if (password.value.trim() === '') {
            setFieldError(password, passwordError, 'Password is required.');
            return false;
        }

        setFieldError(password, passwordError, '');
        return true;
    }

    if (userInput) {
        userInput.addEventListener('input', function () {
            validateUserField();
            hideFormError();
        });
    }

    if (password) {
        password.addEventListener('input', function () {
            validatePasswordField();
            hideFormError();
        });
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            const userValid = validateUserField();
            const passwordValid = validatePasswordField();

            if (!userValid || !passwordValid) {
                event.preventDefault();
                showFormError('Please correct the highlighted fields.');
                return;
            }

            hideFormError();
        });
    }

    if (window.location.search.includes('login_error=')) {
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }
});
</script>

<?php get_footer(); ?>