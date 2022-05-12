@extends('layouts.app')

@section('content')
    @while (have_posts())
        @php the_post() @endphp
        <h2>The home of it allll</h2>
        <br>
        My page view is

        @include('partials.content-page')

        still going strong
    @endwhile
@endsection
