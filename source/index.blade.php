@extends('_layouts.master')

@php
$page->meta_description = 'Website of Jeff Carouth, a software engineering leader.';
$page->template = 'homepage';
@endphp

@push('meta')
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $page->meta_description }}" />
@endpush

@section('body')
    <div class="pt-12 pb-40 bg-rifle-green text-ghost-white text-center">
        <span class="block p-0 text-4xl uppercase">Jeff Carouth</span>
        <hr class="block w-32 border-t-4 my-4 mx-auto border-ghost-white">
        <span class="block mt-4 uppercase">Software Engineering Leader</span>
    </div>

    <img class="w-56 h-56 mx-auto -mt-32 border-platinum border-4 rounded-lg"
        src="https://pbs.twimg.com/profile_images/451352320932999168/CBZuXgB8_400x400.jpeg"
        alt="Black and white profile photo of Jeff Carouth">

    <div class="max-w-4xl mx-auto px-3 md:px-8 pb-10">
        <p class="mt-12 text-center font-serif">
            I am a software engineering manager at Ziff Media Group. I lead teams and develop for the web. I live in Texas with
            my wife, two children, one dog, and two cats. These are my stories.
        </p>

        @php($featured = $posts->where('featured', true)->take(3))

        @foreach ($featured as $featuredPost)
            <div class="w-full mt-12 p-6 bg-gray-100 rounded-lg shadow-md" data-ga-click data-ga-element="post_card">
                <span class="block text-dark-cerulean text-2xl uppercase font-semibold">
                    <svg class="inline w-5 h-6 align-text-top fill-current"><use xlink:href="/assets/build/icons/spritemap.svg#sprite-file-alt"></use></svg>
                    Blog
                </span>
                @if ($featuredPost->cover_image)
                    <img src="{{ $featuredPost->cover_image }}" alt="{{ $featuredPost->title }} cover image" class="mb-6">
                @endif

                <p class="mt-6 font-sans text-smoky-black font-light uppercase">
                    {{ $featuredPost->getDate()->format('M j, Y') }}
                </p>

                <h2 class="text-3xl mt-2 leading-tight">
                    <a class="no-underline" href="{{ $featuredPost->getUrl() }}" title="Read {{ $featuredPost->title }}" class="" data-ga-click data-ga-item="title">
                        {{ $featuredPost->title }}
                    </a>
                </h2>

                <p class="mt-8">{!! $featuredPost->getExcerpt() !!}</p>

                <a class="block mt-4 w-40 py-3 px-6 bg-dark-cerulean text-center text-ghost-white font-semibold uppercase tracking-wide rounded-lg no-underline"
                    href="{{ $featuredPost->getUrl() }}"
                    title="Read - {{ $featuredPost->title }}"
                    data-ga-click data-ga-item="button"
                >
                    Read Post
                </a>
            </div>
        @endforeach

        <div class="mt-12 space-y-6">
        @foreach ($posts->where('featured', false)->take(6)->chunk(2) as $row)
            <div class="md:flex md:flex-row md:space-x-6 space-y-6 md:space-y-0">
                @foreach ($row as $post)
                    <div class="w-full md:w-1/2 md:flex md:items-stretch">
                        @include('_components.post-preview-inline')
                    </div>
                @endforeach
            </div>
        @endforeach
        </div>

        <div class="mt-12">
            <div class="md:w-1/3 md:mx-auto py-2 bg-gray-100 border-2 border-gray-200 text-center">
                <a href="/articles/" class="block no-underline text-lg font-semibold">All Articles</a>
            </div>
        </div>
    </div>
@stop
