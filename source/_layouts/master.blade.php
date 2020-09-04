<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}</title>


        <meta name="description" content="{{ $page->getPageDescription() }}">

        <meta property="og:site_name" content="Jeff Carouth">
        <meta property="og:type" content="{{ $page->meta_type ?? 'website' }}" />
        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:locale" content="en_US">
        <meta property="og:url" content="{{ $page->getUrl() }}">
        <meta property="og:description" content="{{ $page->getPageDescription() }}">

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@jcarouth">
        <meta name="twitter:creator" content="@jcarouth">
        <meta name="twitter:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}">
        <meta name="twitter:description" content="{{ $page->getPageDescription() }}">

        @stack('meta')

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.png">
        <link href="/articles/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        <script>
            WebFontConfig = {
                google: {
                    families: [
                        'Montserrat:300,400,600,800',
                        'Source+Serif+Pro:400,600,700',
                    ]
                }
            };
            (function() {
                var wf = document.createElement('script');
                wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf,s);
            })();
        </script>
        <script async src="https://kit.fontawesome.com/1a42bd7d7c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

        @if ($page->production)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-2213019-6"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-2213019-6');
        </script>

        @endif
    </head>

    <body class="flex flex-col min-h-screen bg-platinum text-smoky-black leading-normal font-sans">
        <header class="flex items-center h-12 bg-smoky-black text-ghost-white" role="banner">
            <div class="flex justify-between container max-w-6xl mx-auto px-3">
                <div class="text-2xl text-ghost-white">
                    <a href="/">
                        <img class="h-6 fill-current" src="/assets/img/jc-logo.svg" alt="JC logo" />
                    </a>
                </div>
                <div class="block h-6">
                    <div class="inline-block">
                        <a class="text-ghost-white font-normal" href="/articles">Articles</a>
                    </div>
                </div>
            </div>

        </header>

        <main role="main" class="flex-auto">
            @yield('body')
        </main>

        <footer class=" pt-10 pb-8 bg-smoky-black text-ghost-white text-center text-sm" role="contentinfo">
            <div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://twitter.com/jcarouth" aria-label="@jcarouth on Twitter"><i class="fab fa-twitter fill-current"></i></a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://github.com/jcarouth" aria-label="jcarouth on Github"><i class="fab fa-github"></i></a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://linkedin.com/in/jcarouth" aria-label="jcarouth profile on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://www.instagram.com/jcarouth/" aria-label="jcarouth on Instagram"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="mailto:jcarouth@gmail.com" aria-label="Email Jeff Carouth"><i class="far fa-envelope"></i></a>
                </div>
            </div>

            <span class="block mt-8">
                &copy; 2016&ndash;{{ date('Y') }} Jeff Carouth
            </span>
        </footer>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>

        @stack('scripts')
    </body>
</html>
