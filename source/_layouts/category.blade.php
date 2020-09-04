@extends('_layouts.master')

@php
$page->template = 'content_hub';
@endphp

@push('meta')
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    <h1>{{ $page->title }}</h1>

    <div class="text-2xl border-b border-blue-200 mb-6 pb-10">
        @yield('content')
    </div>

    @foreach ($page->posts($posts) as $post)
        @include('_components.post-preview-inline')

        @if (! $loop->last)
            <hr class="w-full border-b mt-2 mb-6">
        @endif
    @endforeach

    @include('_components.newsletter-signup')
@stop
