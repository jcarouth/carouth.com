@extends('_layouts.master')

@php
$page->meta_type = 'article';
$page->template = 'post';
@endphp

@push('meta')
<meta property="article:published_time" content="{{ date('c', $page->date) }}">
<meta property="article:modified_time" content="{{ date('c', $page->getModifiedTime()) }}">
@endpush

@section('body')
    <div class="max-w-6xl mx-auto px-3 py-8 bg-ghost-white">
        @if ($page->cover_image)
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
        @endif
        <time datetime="{{ $page->getDate()->format('Y-m-d') }}" class="font-light tracking-wider uppercase">{{ $page->getDate()->format('F j, Y') }}</time>
        <h1 class="mt-4 text-4xl leading-tight">{{ $page->title }}</h1>

        <div class="post-content mt-6" v-pre>
            @yield('content')
        </div>

        <nav class="flex justify-between text-sm md:text-base my-12">
            <div>
                @if ($previous = $page->getPrevious())
                    <a class="no-underline" href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}" data-ga-click data-ga-element="post_navigation" data-ga-item="title">
                        &LeftArrow; {{ $previous->title }}
                    </a>
                @endif
            </div>

            <div>
                @if ($next = $page->getNext())
                    <a class="no-underline" href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}" data-ga-click data-ga-element="post_navigation" data-ga-item="title">
                        {{ $next->title }} &RightArrow;
                    </a>
                @endif
            </div>


        </nav>
    </div>
    @if ($recircs = $page->getRecircPosts($posts))
    <div class="bg-platinum py-10">
        <div class="max-w-6xl mx-auto px-3 md:px-10">
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
