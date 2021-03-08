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

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&family=Source+Serif+Pro:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @if ($page->production)
          <script src="https://cdn.usefathom.com/script.js" data-site="JEIDMECV" defer></script>
        @endif
    </head>

    <body class="flex flex-col min-h-screen bg-ghost-white text-smoky-black leading-normal font-sans" data-ga-template="{{ $page->template }}">
        <header class="py-4 bg-smoky-black text-ghost-white" role="banner" data-ga-module="header">
            <div x-data="{isOpen: false}" class="flex justify-between flex-wrap container max-w-6xl mx-auto px-3 items-center">
                <div class="flex-shrink-0 text-2xl text-ghost-white">
                    <a href="/" data-ga-click data-ga-element="header_link" data-ga-item="logo" aria-label="Jeff Carouth Home">
                        <svg class="w-14 h-6 fill-current">
                            <use xlink:href="/assets/build/icons/spritemap.svg#sprite-jc-mark-solid"></use>
                        </svg>
                    </a>
                </div>

                <button @click="isOpen = !isOpen" type="button" class="flex justify-center items-center lg:hidden focus:outline-none" aria-label="Open Navigation Menu">
                    <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current text-white">
                        <use xlink:href="/assets/build/icons/spritemap.svg#sprite-menu"></use>
                    </svg>

                    <svg x-cloak x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current text-white">
                        <use xlink:href="/assets/build/icons/spritemap.svg#sprite-x"></use>
                    </svg>
                </button>

                <nav class="w-full mt-6 lg:mt-0 flex-grow lg:flex lg:items-center lg:w-auto hidden" :class="{ 'block': isOpen, 'hidden': !isOpen}">
                    <ul class="my-0 pl-0 lg:flex flex-1 justify-end items-center space-y-4 lg:space-y-0 lg:space-x-6 list-none ">
                        <li class="pl-4">
                            <a class="no-underline" title="{{ $page->siteName }} Blog" href="/articles/">Articles</a>
                        </li>
                        <li class="pl-4">
                            <a class="no-underline" title="{{ $page->siteName }} About" href="/about/">About</a>
                        </li>
                        <li class="pl-4">
                            <a class="no-underline" title="{{ $page->siteName }} PGP Key" href="/pgp/">PGP Key</a>
                        </li>
                    </ul>
                </nav>
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
