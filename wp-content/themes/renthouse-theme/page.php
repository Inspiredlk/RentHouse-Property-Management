<?php get_header(); ?>

<section class="standard-page">
    <div class="container">

        <?php while (have_posts()) : the_post(); ?>

            <div class="standard-page-card">

                <?php if (has_post_thumbnail()) : ?>
                    <div class="standard-page-featured-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>

                <div class="standard-page-inner">

                    <h1><?php the_title(); ?></h1>

                    <div class="standard-page-content">
                        <?php the_content(); ?>
                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>
</section>

<?php get_footer(); ?>