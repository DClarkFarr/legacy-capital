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
                <h2 class="text-center text-6xl font-semibold mb-20">
                    <?php the_field('sell_home_title'); ?>
                </h2>

                <div class="lg:flex items-start text-center">
                    <div class="max-w-[400px] lg:mt-10 mb-10 mx-auto">
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
                    <div class="max-w-[400px] lg:mt-2 mb-10 mx-auto">
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
                    <div class="max-w-[400px] lg:mt-10 mb-10 mx-auto">
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
    @endwhile
@endsection
