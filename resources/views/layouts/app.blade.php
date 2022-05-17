<?php
enqueue_favicon();
?>
<a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
</a>

@include('sections.header')

<main id="main" class="main">
    @yield('content')

    <div class="hidden">
        <!-- put dynamic classes here so tailwind can find them -->
        <div class="form-control form-group max-w-full py-4 py-5"></div>
    </div>
</main>

@hasSection('sidebar')
    <aside class="sidebar">
        @yield('sidebar')
    </aside>
@endif

@include('sections.footer')
