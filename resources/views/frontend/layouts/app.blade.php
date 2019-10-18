<!DOCTYPE html>
@langrtl
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description"
              content="@yield('meta_description', 'Unknown and unwanted phone calls and text messages happen every single day. If you are trying to figure out who is behind a phone number, then our reverse phone number lookup is the perfect place to begin. Simply type the phone number into the search bar and then click the button to begin your search. We will do our best to locate the owner\'s name, age, address, and much more!')">
        <meta name="author" content="@yield('meta_author', 'E.Shala')">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/frontend/icons/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/frontend/icons/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/frontend/icons/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('icons/site.webmanifest')}}">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    @if (App::environment('production'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103830016-2"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());

                gtag('config', 'UA-103830016-2');
            </script>
    @endif
    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}
        {{ style(mix('css/custom-frontend.css')) }}

        @stack('after-styles')
    </head>
    <body>
    @include('includes.partials.demo')

    <div id="app">
        @include('includes.partials.logged-in-as')
        @include('frontend.includes.nav')

        <div class="container">
            @include('includes.partials.messages')
            @yield('content')
        </div><!-- container -->
    </div><!-- #app -->
    @include('frontend.includes.footer')

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/frontend.js')) !!}
    {!! script(mix('js/front-global.js')) !!}
    @stack('after-scripts')

    @include('includes.partials.ga')
    </body>
    </html>
