---
pagination:
    collection: posts
    perPage: 6
---
@extends('_layouts.master')

@php
// Metadata fixup
$page->meta_description = 'Articles written by Jeff Carouth';
$page->template = 'content_hub';
@endphp

@section('body')
    <div class="max-w-6xl mx-auto px-3 py-8 bg-ghost-white" >
        <h1 class="mt-8">Articles</h1>

        <div class="lg:w-5/6 mt-8 divide-y-2 divide-y-gray-100">
            @foreach ($pagination->items as $post)
            <div class="py-6" data-ga-element="post_card">
                <time datetime="{{ $post->getDate()->format('Y-m-d') }}" class="mt-0 font-serif text-gray-700 text-sm">
                    {{ $post->getDate()->format('F j, Y') }}
                </time>
                <h2 class="mt-2 leading-tight">
                    <a class="no-underline" href="{{ $post->getUrl() }}" title="Read {{ $post->title }}" data-ga-click data-ga-item="title">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="max-w-3xl mt-6 mb-0">{!! $post->getExcerpt() !!}</p>
            </div>
            @endforeach
        </div>

        @if ($pagination->pages->count() > 1)
        <div class="flex justify-center" data-ga-element="pagination_nav">
            <nav class="flex text-base my-8 mx-auto">
                @if ($previous = $pagination->previous)
                    <a
                        href="{{ $previous }}"
                        title="Previous Page"
                        class="bg-gray-100 hover:bg-gray-300 rounded mr-3 px-5 py-3 no-underline"
                        data-ga-click data-ga-item="link"
                    >&LeftArrow;</a>
                @endif

                @foreach ($pagination->pages as $pageNumber => $path)
                    <a
                        href="{{ $path }}"
                        title="Go to Page {{ $pageNumber }}"
                        class="bg-gray-100 hover:bg-gray-300 rounded mr-3 px-5 py-3 no-underline"
                        data-ga-click data-ga-item="link"
                    >{{ $pageNumber }}</a>
                @endforeach

                @if ($next = $pagination->next)
                    <a
                        href="{{ $next }}"
                        title="Next Page"
                        class="bg-gray-100 hover:bg-gray-300 rounded mr-3 px-5 py-3 no-underline"
                        data-ga-click data-ga-item="link"
                    >&RightArrow;</a>
                @endif
            </nav>
        </div>
        @endif
    </div>
@stop
