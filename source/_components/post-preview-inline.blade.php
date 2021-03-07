<div class="px-3 py-2 shadow-md">
    <time datetime="{{ $post->getDate()->format('Y-m-d') }}" class="font-serif text-gray-700 text-sm">
        {{ $post->getDate()->format('F j, Y') }}
    </time>

    <h2 class="text-2xl mt-2">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="text-gray-900 font-semibold no-underline"
        >{{ $post->title }}</a>
    </h2>

    <p class="">{!! $post->getExcerpt(200) !!}</p>

    <a
        href="{{ $post->getUrl() }}"
        title="Read more - {{ $post->title }}"
        class="uppercase font-semibold tracking-wide mb-2 no-underline"
    >Read Post</a>
</div>
