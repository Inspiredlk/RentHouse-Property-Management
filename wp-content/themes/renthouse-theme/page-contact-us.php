<?php get_header(); ?>

<section class="contact-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Need help finding a rental house? Contact Rent House Sri Lanka.</p>
    </div>
</section>

<section class="contact-section">
    <div class="container contact-wrapper">

        <div class="contact-info-box">
            <h2>Get In Touch</h2>
            <p class="contact-intro">
                We are here to help tenants and landlords connect easily across Sri Lanka.
            </p>

            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div>
                    <h4>Phone</h4>
                    <p>+94 77 123 4567</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">📧</div>
                <div>
                    <h4>Email</h4>
                    <p>info@renthousesrilanka.lk</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div>
                    <h4>Address</h4>
                    <p>Colombo, Sri Lanka</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">⏰</div>
                <div>
                    <h4>Working Hours</h4>
                    <p>Monday - Saturday, 9.00 AM - 6.00 PM</p>
                </div>
            </div>
        </div>

        <div class="contact-form-box">
            <h2>Send Message</h2>

            <form action="#" method="post" class="contact-form">
                <div class="form-row">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>

                <div class="form-row">
                    <input type="text" name="phone" placeholder="Phone Number">
                    <select name="subject">
                        <option value="">Select Subject</option>
                        <option value="tenant">I am looking for a house</option>
                        <option value="landlord">I want to post a property</option>
                        <option value="pricing">Pricing inquiry</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <textarea name="message" placeholder="Write your message here..." required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

    </div>
</section>

<section class="map-section">
    <div class="container">
        <iframe 
            src="https://www.google.com/maps?q=Colombo%20Sri%20Lanka&output=embed"
            loading="lazy">
        </iframe>
    </div>
</section>

<?php get_footer(); ?>