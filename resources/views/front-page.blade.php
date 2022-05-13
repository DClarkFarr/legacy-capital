@extends('layouts.app')

@section('content')
    @while (have_posts())
        @php the_post() @endphp

        <div class="banner px-12 py-12 text-center bg-cover flex flex-col w-full justify-center lg:min-h-[600px] bg-center"
            style="background-image: url('<?php echo wp_get_attachment_image_url(get_field('banner_image'), 'original'); ?>');">
            <h1 class="text-white text-4xl lg:text-7xl font-bold mb-2">
                <?php the_field('banner_title'); ?>
            </h1>

            <p class="lead text-center text-white font-normal mb-8 text-2xl">
                <?php the_field('banner_lead'); ?>
            </p>

            <div class="text-center">
                <button class="btn btn-lg btn-primary rounded-none">
                    SELL YOUR HOME
                </button>
            </div>
        </div>

        <section class="sell-home section">
            <div class="container mx-auto">
                <h2 class="text-center text-4xl lg:text-6xl font-semibold mb-20">
                    <?php the_field('sell_home_title'); ?>
                </h2>

                <div class="lg:flex items-start text-center relative">
                    <div class="background hidden lg:block z-10 absolute top-2 inset-x-1/6">
                        <img src="@asset('images/sell-home-lines.png')" class="block w-full">
                    </div>
                    <div class="max-w-[400px] z-20 lg:mt-10 mb-10 mx-auto">
                        <div class="circle bg-primary p-8 mb-2 lg:mb-10 rounded-full inline-block">
                            <img class="inline-block" src="@asset('images/sell-home-1.png')" />
                        </div>
                        <h3 class="text-2xl text-dark font-semibold mb-2">
                            <?php the_field('sell_home_title_1'); ?>
                        </h3>
                        <p class="text-gray mx-auto max-w-[300px]">
                            <?php the_field('sell_home_text_1'); ?>
                        </p>
                    </div>
                    <div class="max-w-[400px] z-20 lg:mt-2 mb-10 mx-auto">
                        <div class="circle bg-primary p-12 mb-2 lg:mb-4 rounded-full inline-block">
                            <img class="inline-block" src="@asset('images/sell-home-2.png')" />
                        </div>
                        <h3 class="text-2xl text-dark font-semibold mb-2">
                            <?php the_field('sell_home_title_2'); ?>
                        </h3>
                        <p class="text-gray mx-auto max-w-[300px]">
                            <?php the_field('sell_home_text_2'); ?>
                        </p>
                    </div>
                    <div class="max-w-[400px] z-20 lg:mt-10 mb-10 mx-auto">
                        <div class="circle bg-primary p-8 mb-2 lg:mb-10 rounded-full inline-block">
                            <img class="inline-block" src="@asset('images/sell-home-3.png')" />
                        </div>
                        <h3 class="text-2xl text-dark font-semibold mb-2">
                            <?php the_field('sell_home_title_3'); ?>
                        </h3>
                        <p class="text-gray mx-auto max-w-[300px]">
                            <?php the_field('sell_home_text_3'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section bg-primary-soft text-white">
            <div class="container">
                <div class="lg:flex justify-center gap-x-10">
                    <div class="lg:w-1/3 py-6">
                        <div class="lg:mr-10 max-w-[500px] mx-auto">
                            <h3 class="font-bold text-4xl mb-6">
                                <?php the_field('homeowners_title'); ?>
                            </h3>

                            <div class="mb-6">
                                <?php the_field('homeowners_text'); ?>
                            </div>

                            <div class="btn btn-dark btn-lg text-lg px-12 rounted-none">
                                About Us
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/3 py-6">
                        <div
                            class="max-w-[500px] bg-dark-2 text-white pt-10 px-6 lg:px-14 pb-4 rounded-lg mx-auto -mb-[200px]">
                            <h3 class="font-bold text-4xl mb-6">
                                Contact Us Now
                            </h3>
                            <?php echo do_shortcode('[contact-form-7 id="29" title="Home Page Form"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container h-24"></div>
        </section>

        <section class="section about-us">
            <div class="container">
                <div class="lg:flex gap-x-8 items-center">
                    <div class="w-1/4 lg:text-left lg:w-1/2 mx-auto lg:text-right">
                        <?php echo Thumbnails\attachment(get_field('about_us_image'), 'large', ['class' => 'img-fluid block ml-auto']); ?>
                    </div>
                    <div class="w-1/2">
                        <div class="max-w-[500px]">
                            <h3 class="text-dark font-normal mb-6 text-5xl">
                                <?php the_field('about_us_title'); ?>
                            </h3>

                            <div>
                                <?php the_field('about_us_text'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endwhile
@endsection
