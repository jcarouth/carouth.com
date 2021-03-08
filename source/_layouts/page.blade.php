@extends('_layouts.master')

@push('meta')
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $page->meta_description }}" />
@endpush

@section('body')
<div class="max-w-6xl mx-auto px-3 py-8 bg-ghost-white">
    @yield('page-content')
</div>
@endsection
