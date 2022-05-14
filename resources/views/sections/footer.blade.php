<footer class="section bg-black text-white text-center">
    <div class="container mx-auto">
        <div class="lg:flex items-center gap-x-10">
            <div class="lg:w-1/3 mb-8 lg:mb-0 order-2">
                <?php echo Thumbnails\attachment(get_field('footer_logo', 'options'), 'large', ['class' => 'mx-auto img-fluid', 'alt' => get_field('business_name', 'options')]); ?>
            </div>
            <div class="lg:w-1/3 mb-8 lg:mb-0">
                <a href="tel:<?php echo preg_replace('/[^\d]/', '', get_field('phone', 'options')); ?>" class="btn-link text-3xl xl:text-5xl">
                    <?php the_field('phone', 'options'); ?>
                </a>
            </div>

            <div class="lg:w-1/3 mb-8 lg:mb-0 order-3">
                <a class="btn-link text-3xl xl:text-5xl" href="mailto:<?php the_field('contact_email', 'options'); ?>">
                    <?php the_field('contact_email', 'options'); ?>
                </a>
            </div>
        </div>
    </div>
</footer>
