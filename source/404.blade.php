@extends('_layouts.master')

@php
// Metadata fixup
$page->title = 'Page not found';
$page->meta_description = 'The page you requested cannot be found.';
$page->template = 'error_404';
@endphp

@section('body')
    <div class="container mx-auto max-w-5xl h-full bg-ghost-white text-smoky-black pt-16 px-8 md:pt-32">
        <div class="text-center">
            <h1 class="text-5xl leading-none md:text-6xl"><i class="far fa-meh-rolling-eyes"></i> 404</h1>
            <h2 class="text-3xl text-center uppercase sm:mt-10">Page not found.</h2>
        </div>

        <p class="mt-10">
            Well isn't this embarassing. The page you wanted to see doesn't exist. This is probably my fault. I moved a lot of stuff around
            when I released this version of my blog. I don't know if I can give you what you are looking for. The best I can do is offer you
            some suggestions of content I do have.
        </p>

        <p class="mt-4 pb-10">
            If that doesn't work for you, head <a href="/" data-ga-element="body_link">back to the homepage</a> or check out a <a href="/articles" data-ga-element="body_link">full list of articles</a>.
        </p>
    </div>
    @if ($recircs = $page->getRecircPosts($posts))
    <div class="max-w-5xl mx-auto px-6 py-10" data-ga-element="recirculation">
        <div class="md:flex">
            @foreach ($recircs as $recircPost)
            <div class="mt-4 bg-ghost-white rounded-lg p-6 md:w-1/3 md:mx-3">
                <h2 class="text-3xl mt-2 leading-tight">
                    <a href="{{ $recircPost->getUrl() }}" title="Read {{ $recircPost->title }}" class="" data-ga-item="title">
                        {{ $recircPost->title }}
                    </a>
                </h2>

                <p class="mt-6">{!! $recircPost->getExcerpt() !!}</p>

                <a class="block mt-4 w-40 py-3 px-6 bg-dark-cerulean text-center text-ghost-white font-semibold uppercase tracking-wide rounded-lg"
                    href="{{ $recircPost->getUrl() }}"
                    title="Read - {{ $recircPost->title }}"
                    data-ga-item="button"
                >
                    Read Post
                </a>
            </div>
            @endforeach
        <div>
    </div>
    @endif
@endsection
