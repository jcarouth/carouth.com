---
pagination:
    collection: posts
    perPage: 12
---
@extends('_layouts.master')

@php
// Metadata fixup
$page->meta_description = 'Articles written by Jeff Carouth';
$page->template = 'content_hub';
@endphp

@push('meta')
@endpush

@section('body')
    <div class="max-w-5xl mx-auto px-10 pt-4 pb-12 bg-ghost-white">
        <h1 class="mt-8 mb-12">Articles</h1>

        @foreach ($pagination->items as $post)
        <div class="mt-4 bg-ghost-white rounded-lg border-4 p-6">
            <h2 class="text-3xl mt-2 leading-tight">
                <a href="{{ $post->getUrl() }}" title="Read {{ $post->title }}" class="">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="mt-6">{!! $post->getExcerpt() !!}</p>

            <a class="block mt-4 w-40 py-3 px-6 bg-dark-cerulean text-center text-ghost-white font-semibold uppercase tracking-wide rounded-lg" href="{{ $post->getUrl() }}" title="Read - {{ $post->title }}">
                Read Post
            </a>
        </div>
        @endforeach

        @if ($pagination->pages->count() > 1)
        <div class="flex justify-center">
            <nav class="flex text-base my-8 mx-auto">
                @if ($previous = $pagination->previous)
                    <a
                        href="{{ $previous }}"
                        title="Previous Page"
                        class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3"
                    >&LeftArrow;</a>
                @endif

                @foreach ($pagination->pages as $pageNumber => $path)
                    <a
                        href="{{ $path }}"
                        title="Go to Page {{ $pageNumber }}"
                        class="bg-gray-200 hover:bg-gray-400 text-blue-700 rounded mr-3 px-5 py-3 {{ $pagination->currentPage == $pageNumber ? 'text-blue-600' : '' }}"
                    >{{ $pageNumber }}</a>
                @endforeach

                @if ($next = $pagination->next)
                    <a
                        href="{{ $next }}"
                        title="Next Page"
                        class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3"
                    >&RightArrow;</a>
                @endif
            </nav>
        </div>
        @endif
    </div>
@stop
