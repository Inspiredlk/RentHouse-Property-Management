<?php
/* Template Name: Register Page */


if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/my-dashboard/'));
    exit;
} 

get_header();
?>

<section class="auth-page register-page">
    <div class="container">

        <div class="auth-layout">

            <div class="auth-info-panel">
                <span>Join Rent House Sri Lanka</span>
                <h1>Create your account</h1>
                <p>
                    Register as a tenant to search and request rentals, or register as a property owner to publish and manage rental advertisements.
                </p>

                <div class="auth-benefits">
                    <div>🏠 Post and manage rental ads</div>
                    <div>🔎 Search homes faster</div>
                    <div>💬 Send booking inquiries</div>
                    <div>⭐ Review rental experiences</div>
                </div>
            </div>

            <div class="auth-form-card">

                <span class="auth-badge">Register</span>
                <h2>Start your rental journey</h2>
                <p>Create an account to continue.</p>

                <?php if (isset($_GET['register_error'])) : ?>
                    <div class="auth-error">
                        <?php
                        $error = sanitize_text_field($_GET['register_error']);

                        if ($error === 'empty_fields') {
                            echo 'Please fill all required fields.';
                        } elseif ($error === 'invalid_email') {
                            echo 'Please enter a valid email address.';
                        } elseif ($error === 'email_exists') {
                            echo 'This email is already registered.';
                        } elseif ($error === 'password_mismatch') {
                            echo 'Passwords do not match.';
                        } elseif ($error === 'weak_password') {
                            echo 'Password must be at least 6 characters.';
                        } elseif ($error === 'invalid_phone') {
                            echo 'Please enter a valid Sri Lankan phone number.';
                        } else {
                            echo 'Registration failed. Please try again.';
                        }
                        ?>
                    </div>
                <?php endif; ?>

               <div class="auth-error form-live-error" style="display:none;"></div>

                <form method="post" id="renthouse-register-form" novalidate>

                    <?php wp_nonce_field('renthouse_register_action', 'renthouse_register_nonce'); ?>

                    <div class="auth-field">
                        <label>Full Name</label>
                        <input 
                            type="text" 
                            name="full_name" 
                            placeholder="Enter your full name" 
                            autocomplete="name"
                            required
                        >
                    </div>

                    <div class="auth-field">
                        <label>Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="example@email.com" 
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="auth-field">
    <label>Phone Number</label>
    <input 
        type="tel" 
        name="phone" 
        id="register_phone"
        placeholder="07XXXXXXXX"
        autocomplete="tel"
        pattern="07[0-9]{8}"
        maxlength="10"
        inputmode="numeric"
        required
    >
    <small class="auth-help-text">Enter 10 digits, starting with 07.</small>
    <small class="field-error" id="phone_error"></small>
</div>

                    <div class="auth-field">
    <label>Password</label>
    <div class="password-field-wrap">
        <input 
            type="password" 
            name="password" 
            id="register_password" 
            placeholder="Create a password" 
            autocomplete="new-password"
            minlength="6"
            required
        >
        <button type="button" class="password-toggle" data-target="register_password">👁</button>
    </div>
    <small class="auth-help-text">Use at least 6 characters.</small>
    <small class="field-error" id="password_error"></small>
</div>

                    <div class="auth-field">
    <label>Confirm Password</label>
    <div class="password-field-wrap">
        <input 
            type="password" 
            name="confirm_password" 
            id="register_confirm_password" 
            placeholder="Confirm your password" 
            autocomplete="new-password"
            minlength="6"
            required
        >
        <button type="button" class="password-toggle" data-target="register_confirm_password">👁</button>
    </div>
    <small class="field-error" id="confirm_password_error"></small>
</div>

                    <div class="auth-field">
                        <label>Account Type</label>
                        <select name="user_role" required>
                            <option value="tenant">Tenant - I want to find a rental</option>
                            <option value="property_owner">Property Owner - I want to post ads</option>
                        </select>
                    </div>

                    <button type="submit" name="renthouse_register_user" class="auth-submit-btn">
                        Create Account
                    </button>

                </form>

                <div class="auth-switch">
                    Already have an account?
                    <a href="<?php echo esc_url(home_url('/login/')); ?>">Login here</a>
                </div>

            </div>

        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('renthouse-register-form');

    const phone = document.getElementById('register_phone');
    const password = document.getElementById('register_password');
    const confirmPassword = document.getElementById('register_confirm_password');

    const phoneError = document.getElementById('phone_error');
    const passwordError = document.getElementById('password_error');
    const confirmPasswordError = document.getElementById('confirm_password_error');

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

    /* Password show / hide */
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

    function validatePhoneField() {
        if (!phone) return true;

        const phonePattern = /^07[0-9]{8}$/;

        if (phone.value.trim() === '') {
            setFieldError(phone, phoneError, 'Phone number is required.');
            return false;
        }

        if (!phonePattern.test(phone.value)) {
            setFieldError(phone, phoneError, 'Phone number must be 10 digits and start with 07.');
            return false;
        }

        setFieldError(phone, phoneError, '');
        return true;
    }

    function validatePasswordField() {
        if (!password) return true;

        if (password.value.trim() === '') {
            setFieldError(password, passwordError, 'Password is required.');
            return false;
        }

        if (password.value.length < 6) {
            setFieldError(password, passwordError, 'Password must be at least 6 characters.');
            return false;
        }

        setFieldError(password, passwordError, '');
        return true;
    }

    function validateConfirmPasswordField() {
        if (!confirmPassword || !password) return true;

        if (confirmPassword.value.trim() === '') {
            setFieldError(confirmPassword, confirmPasswordError, 'Please confirm your password.');
            return false;
        }

        if (password.value !== confirmPassword.value) {
            setFieldError(confirmPassword, confirmPasswordError, 'Passwords do not match.');
            return false;
        }

        setFieldError(confirmPassword, confirmPasswordError, '');
        return true;
    }

    if (phone) {
        phone.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            validatePhoneField();
            hideFormError();
        });
    }

    if (password) {
        password.addEventListener('input', function () {
            validatePasswordField();
            validateConfirmPasswordField();
            hideFormError();
        });
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', function () {
            validateConfirmPasswordField();
            hideFormError();
        });
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            const phoneValid = validatePhoneField();
            const passwordValid = validatePasswordField();
            const confirmPasswordValid = validateConfirmPasswordField();

            if (!phoneValid || !passwordValid || !confirmPasswordValid) {
                event.preventDefault();
                showFormError('Please correct the highlighted fields.');
                return;
            }

            hideFormError();
        });
    }

    /* Clean backend error query from URL after showing once */
    if (window.location.search.includes('register_error=')) {
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }
});
</script>
<?php get_footer(); ?>