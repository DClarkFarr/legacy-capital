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
                    <div class="lg:w-2/5 xl:w-1/3 py-6">
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
                    <div class="lg:w-2/5 2xl:w-1/3 py-6">
                        <div
                            class="max-w-[550px] bg-dark-2 text-white pt-10 px-6 lg:px-14 pb-4 rounded-lg mx-auto -mb-[200px]">
                            <h3 class="font-bold text-4xl mb-6">
                                Contact Us Now
                            </h3>
                            <?php echo do_shortcode('[contact-form-7 id="29" title="Home Page Form"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section about-us">
            <div class="container pt-20">
                <div class="lg:flex gap-x-8 items-center">
                    <div class="w-2/4 lg:text-left lg:w-1/2 mx-auto lg:text-right mb-8">
                        <?php echo Thumbnails\attachment(get_field('about_us_image'), 'large', ['class' => 'img-fluid block ml-auto']); ?>
                    </div>
                    <div class="lg:w-1/2 text-center lg:text-left">
                        <div class="mx-auto max-w-[500px]">
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

        <section class="section cta bg-primary-dark">
            <div class="container">
                <div class="p-10 lg:px-20 text-center text-white text-4xl leading-relaxed">
                    <?php echo nl2br(get_field('cta_text')); ?>
                </div>
            </div>
        </section>

        <section class="section process">
            <div class="container">
                <div class="lg:flex items-center lg:mx-32 mx-10 mb-12">
                    <div class="lg:w-5/12 order-3 mb-8">
                        <?php echo Thumbnails\attachment(get_field('process_image'), 'large', ['class' => 'mx-auto']); ?>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="lg:pl-10 text-center lg:text-left">
                            <h2 class="text-dark text-5xl mb-6 font-thin">
                                <?php the_field('process_title'); ?>
                            </h2>
                            <p class="text-light-5 leading-relaxed text-xl">
                                <?php the_field('process_text'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="w-1/12">

                    </div>

                </div>

                <div class="lg:flex lg:mx-32 mx-10 mb-6">
                    <?php 
                    $count = 0;
                    while(have_rows('steps')){ the_row(); $count++;
                        ?>
                    <div
                        class="step max-w-[350px] lg:max-w-[400] mx-auto lg:w-1/4 shrink-0 mb-8 p-6 border-t border-t-4 <?php echo $count === 1 ? 'border-t-primary' : 'border-t-neutral-200'; ?>">
                        <h4 class="text-xl mb-4">
                            STEP <?php echo $count; ?>
                        </h4>
                        <p class="text-sm text-light-5">
                            <?php the_sub_field('text'); ?>
                        </p>
                    </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    @endwhile
@endsection
