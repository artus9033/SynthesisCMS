@php
    $additionalGeneratedTitlePart = trim(View::yieldContent('title'));
    if(strlen($additionalGeneratedTitlePart) > 0){
        $additionalGeneratedTitlePart = " - " . $additionalGeneratedTitlePart;
    }
@endphp

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-language" content="{!! App::getLocale() !!}">
<meta name="viewport" content="width=device-width, initial-scale=0.7">
<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="synthesiscms-dynamic-url-handler-start-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerStartTag !!}">
<meta name="synthesiscms-dynamic-url-handler-end-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerEndTag !!}">
<meta name="synthesiscms-public-root" content="{{ url('/') }}">
<meta name="synthesiscms-asset-root" content="{{ asset('/') }}">

<meta property="og:url" content="{{ \Url::current() }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $title }}{{ $additionalGeneratedTitlePart }}" />
<meta property="og:description" content="{{trim(View::yieldContent('title'))}}" />
<!-- make it possible to specify desc, img -->
<meta property="og:image" content="url('/favicon.ico')" />

<meta name="description" content="{{trim(View::yieldContent('title'))}}">

<title>{{ $title }}{{ $additionalGeneratedTitlePart }}</title>
<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>

<!-- TODO: implement no-print class from gutenberg in the CMS -->
<link rel="stylesheet" href="https://unpkg.com/gutenberg-css@0.4" media="print">
<link rel="stylesheet" href="https://unpkg.com/gutenberg-css@0.4/dist/themes/oldstyle.min.css" media="print">

<!-- Fonts -->
<link type="text/css" rel="stylesheet" href="{!! asset("fonts/open-sans/font.css") !!}">

<!-- Libraries -->
<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/clipboard.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/synthesiscms-js-utils.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/dragula.js') !!}"></script>
<script type="text/javascript" src="{!! asset('overlayscrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

<!-- Stylesheets -->
<link href="{!! asset('css/app.css') !!}" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="{!! asset("css/dragula.css") !!}">
<link type="text/css" rel="stylesheet" href="{!! asset("fonts/material-icons/material-icons.css") !!}">
<link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}" media="screen,projection"/>
<link type="text/css" href="{!! asset('overlayscrollbars/css/OverlayScrollbars.min.css') !!}" rel="stylesheet"/>
