@extends('_layouts.master')

@push('meta')
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $page->meta_description }}" />
@endpush

@section('body')
<div class="max-w-5xl mx-auto px-10 py-4 bg-ghost-white">
    @yield('page-content')
</div>
@endsection
