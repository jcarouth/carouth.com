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

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@jcarouth">
        <meta name="twitter:creator" content="@jcarouth">
        <meta name="twitter:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}">
        <meta name="twitter:description" content="{{ $page->getPageDescription() }}">
        <meta name="twitter:image" content="{{ $page->baseUrl }}/assets/img/social/twitter-cards/{{ $page->twitter_image ?? 'default.png' }}">

        @stack('meta')

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.png">
        <link href="/articles/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preconnect" href="https://www.googletagmanager.com">

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&family=Source+Serif+Pro:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

        @if ($page->production)
          <script async src="https://www.googletagmanager.com/gtag/js?id=G-KC6CXHYETJ"></script>
          <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-KC6CXHYETJ');
          </script>
          <script src="https://cdn.usefathom.com/script.js" data-site="JEIDMECV" defer></script>
        @endif
    </head>

    <body class="flex flex-col min-h-screen bg-ghost-white text-smoky-black leading-normal font-sans" data-ga-template="{{ $page->template }}">
        <header class="flex items-center h-12 bg-smoky-black text-ghost-white" role="banner" data-ga-module="header">
            <div class="flex justify-between container max-w-6xl mx-auto px-3">
                <div class="text-2xl text-ghost-white">
                    <a href="/" data-ga-click data-ga-element="header_link" data-ga-item="logo">
                        <img class="h-6 fill-current" src="/assets/img/jc-logo.svg" alt="JC logo" />
                    </a>
                </div>
                <div class="block h-6">
                    <div class="inline-block">
                        <a class="text-ghost-white font-normal" href="/articles/" data-ga-click data-ga-element="header_link">Articles</a>
                    </div>
                </div>
            </div>
        </header>

        <main role="main" class="h-full mb-auto" data-ga-module="body">
            @yield('body')
        </main>

        <footer class="pt-10 pb-8 bg-smoky-black text-ghost-white text-center text-sm" role="contentinfo" data-ga-click data-ga-module="footer">
            <div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://twitter.com/jcarouth" aria-label="@jcarouth on Twitter" data-ga-click data-ga-element="footer_link">
                        <svg class="w-8 h-8 fill-current"><use xlink:href="/assets/build/icons/spritemap.svg#sprite-twitter"></use></svg>
                    </a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://github.com/jcarouth" aria-label="jcarouth on Github" data-ga-click data-ga-element="footer_link">
                        <svg class="w-8 h-8 fill-current"><use xlink:href="/assets/build/icons/spritemap.svg#sprite-github"></use></svg>
                    </a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://linkedin.com/in/jcarouth" aria-label="jcarouth profile on LinkedIn" data-ga-click data-ga-element="footer_link">
                        <svg class="w-8 h-8 fill-current"><use xlink:href="/assets/build/icons/spritemap.svg#sprite-linkedin-in"></use></svg>
                    </a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="https://www.instagram.com/jcarouth/" aria-label="jcarouth on Instagram" data-ga-click data-ga-element="footer_link">
                        <svg class="w-8 h-8 fill-current"><use xlink:href="/assets/build/icons/spritemap.svg#sprite-instagram"></use></svg>
                    </a>
                </div>
                <div class="inline-block mx-2 text-4xl">
                    <a class="text-ghost-white" href="mailto:jcarouth@gmail.com" aria-label="Email Jeff Carouth" data-ga-click data-ga-element="footer_link">
                        <svg class="w-8 h-8 fill-current"><use xlink:href="/assets/build/icons/spritemap.svg#sprite-envelope"></use></svg>
                    </a>
                </div>
            </div>

            <span class="block mt-8">
                &copy; {{ date('Y') }} Jeff Carouth
            </span>
        </footer>

        <script defer src="{{ mix('js/main.js', 'assets/build') }}"></script>
        @stack('scripts')
    </body>
</html>
