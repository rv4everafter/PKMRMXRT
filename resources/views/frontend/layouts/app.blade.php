<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'TNB ONCE')">
        <meta name="author" content="@yield('meta_author', 'Ravi Patel (rvpatel1190@gmail.com)')">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}
        {{ style('css/jquery-ui.css') }}
        {{ style('css/vis.css') }}
        <style>
        .error{
        color:red
        }
        </style>
        @stack('after-styles')
    </head>
    <body>
        <div id="app">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')

            <div class="container">
                @include('includes.partials.messages')
                @yield('content')
            </div><!-- container -->
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/frontend.js')) !!}
        {!! script('js/jquery.validate.js') !!}
        {!! script('js/jquery-ui.js') !!}
        {!! script('js/vis.js') !!}
        <script>
        $(document).ready(function($){
            $( ".dateofbirth" ).datepicker({ dateFormat: 'dd-mm-yy', maxDate: '0', changeYear: true, changeMonth: true});
        });
        </script>
        @stack('after-scripts')
        
        @include('includes.partials.ga')
    </body>
</html>
