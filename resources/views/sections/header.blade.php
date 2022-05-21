<header class="banner bg-white">
    <div class="container mx-auto">
        <div class="lg:flex w-full items-end py-1 text-center lg:text-left">
            <a class="brand max-w-[160px]" href="{{ home_url('/') }}">
                <?php echo Thumbnails\attachment(get_field('logo', 'options'), 'medium', ['class' => 'img-fluid mx-auto', 'lazy' => false]); ?>
            </a>

            @if (has_nav_menu('primary_navigation'))
                <nav class="nav-primary ml-auto pb-3" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
                    {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
                </nav>
            @endif
        </div>

    </div>
</header>
