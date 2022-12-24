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
    <meta name="description" content="@yield('meta_description', 'Laravel Starter')">
    <meta name="author" content="@yield('meta_author', 'FasTrax Infotech')">
    @yield('meta')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}

    <style>
        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-off-canvas sidebar-lg-show">
    @include('backend.includes.header')

    <div class="app-body">
        @include('backend.includes.sidebar')

        <main class="main">
            @include('includes.partials.read-only')
            @include('includes.partials.logged-in-as')
            {{--  {!! Breadcrumbs::render() !!}  --}}

            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="content-header">
                        @yield('page-header')
                    </div>
                    <!--content-header-->

                    @include('includes.partials.messages')
                    @yield('content')
                </div>
                <!--animated-->
            </div>
            <!--container-fluid-->
        </main>
        <!--main-->

    </div>
    <!--app-body-->

    @include('backend.includes.footer')

    <!--Start  JS Scripts ================================== -->

    {{ script('js/datatables.full.min.js') }}

    <!-- JS Scripts in vendor folder be compiled in vendor.js -->
    {{-- script(mix('js/vendor.js')) --}}

    <!-- JS Scripts (Vue or React) in resources folder be compiled in frontend.js -->
    {{-- script(mix('js/backend.js')) --}}

    <!-- includes js files which determine specifications of table-->
    @isset($js)
        @foreach($js as $j)
            {!! script(asset('js/backend/'. $j. '.js')) !!}
        @endforeach
    @endif

    <!-- includes js from blade pages -->
    @yield('pagescript')
    <!-- END JS Scripts ================================== -->
</body>

</html>