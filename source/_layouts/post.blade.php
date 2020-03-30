@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    <div class="max-w-5xl mx-auto px-10 py-4 bg-ghost-white">
        @if ($page->cover_image)
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
        @endif
        <p class="font-light tracking-wider uppercase">{{ date('F j, Y', $page->date) }}</p>
        <h1 class="mt-4 text-4xl leading-tight">{{ $page->title }}</h1>

        <div class="mt-6 pb-4" v-pre>
            @yield('content')
        </div>

        {{--
        <nav class="flex justify-between text-sm md:text-base">
            <div>
                @if ($next = $page->getNext())
                    <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
                        &LeftArrow; {{ $next->title }}
                    </a>
                @endif
            </div>

            <div>
                @if ($previous = $page->getPrevious())
                    <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
                        {{ $previous->title }} &RightArrow;
                    </a>
                @endif
            </div>
        </nav>
        --}}
    </div>
    @if ($recircs = $page->getRecircPosts($posts))
    <div class="max-w-5xl mx-auto px-6 py-10">
        <h4 class="mb-8 text-2xl uppercase font-light">More to Read</h4>
        <div class="md:flex">
            @foreach ($recircs as $recircPost)
            <div class="mt-4 bg-ghost-white rounded-lg p-6 md:w-1/3 md:mx-3">
                <h2 class="text-3xl mt-2 leading-tight">
                    <a href="{{ $recircPost->getUrl() }}" title="Read {{ $recircPost->title }}" class="">
                        {{ $recircPost->title }}
                    </a>
                </h2>

                <p class="mt-6">{!! $recircPost->getExcerpt() !!}</p>

                <a class="block mt-4 w-40 py-3 px-6 bg-dark-cerulean text-center text-ghost-white font-semibold uppercase tracking-wide rounded-lg" href="{{ $recircPost->getUrl() }}" title="Read - {{ $recircPost->title }}">
                    Read Post
                </a>
            </div>
            @endforeach
        <div>
    </div>
    @endif
@endsection
