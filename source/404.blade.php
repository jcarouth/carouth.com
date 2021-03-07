@extends('_layouts.master')

@php
// Metadata fixup
$page->title = 'Page not found';
$page->meta_description = 'The page you requested cannot be found.';
$page->template = 'error_404';
@endphp

@section('body')
    <div class="container mx-auto max-w-6xl h-full bg-ghost-white text-smoky-black pt-16 px-8 md:pt-32">
        <h1 class="flex leading-none md:text-6xl space-x-6 text-5xl">
            <svg class="h-40 w-40 fill-current">
                <use xlink:href="/assets/build/icons/spritemap.svg#sprite-meh-rolling-eyes"></use>
            </svg>
            <span class="block">404</span>
        </h1>
        <h2 class="text-3xl uppercase sm:mt-10">Page not found.</h2>

        <p class="mt-10">
            Well isn't this embarassing. The page you wanted to see doesn't exist. This is probably my fault. I moved a
            lot of stuff around
            when I released this version of my blog. I don't know if I can give you what you are looking for. The best I
            can do is offer you
            some suggestions of content I do have.
        </p>

        <p class="mt-4 pb-10">
            If that doesn't work for you, head <a href="/" data-ga-element="body_link">back to the homepage</a> or check
            out a <a href="/articles" data-ga-element="body_link">full list of articles</a>.
        </p>
    </div>

    @if ($recircs = $page->getRecircPosts($posts))
        <div class="bg-platinum py-10">
            <div class="max-w-6xl mx-auto px-10">
                <h4 class="text-2xl uppercase font-light">More to Read</h4>
                <div class="mt-8 md:flex md:space-x-6">
                    @foreach ($recircs as $recircPost)
                        <div class="mt-4 bg-ghost-white rounded-lg p-6 md:w-1/3">
                            <h2 class="text-3xl mt-2 leading-tight">
                                <a class="no-underline" href="{{ $recircPost->getUrl() }}"
                                   title="Read {{ $recircPost->title }}"
                                   data-ga-click data-ga-element="recirculation_link" data-ga-item="title"
                                >
                                    {{ $recircPost->title }}
                                </a>
                            </h2>

                            <p class="mt-6">{!! $recircPost->getExcerpt() !!}</p>

                            <a class="block mt-4 w-40 py-3 px-6 bg-dark-cerulean text-center text-ghost-white font-semibold uppercase tracking-wide rounded-lg no-underline"
                               href="{{ $recircPost->getUrl() }}"
                               title="Read - {{ $recircPost->title }}"
                               data-ga-click data-ga-element="recirculation_link" data-ga-item="button"
                            >
                                Read Post
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
