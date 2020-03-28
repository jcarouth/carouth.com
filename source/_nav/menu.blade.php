<nav class="hidden lg:flex items-center justify-end text-lg">
    <a title="{{ $page->siteName }} Blog" href="/articles"
        class="ml-6 text-gray-200 hover:text-blue-600 {{ $page->isActive('/articles') ? 'active text-blue-600' : '' }}">
        Articles
    </a>

    <a title="{{ $page->siteName }} About" href="/about"
        class="ml-6 text-gray-200 hover:text-blue-600 {{ $page->isActive('/about') ? 'active text-blue-600' : '' }}">
        About
    </a>

    <a title="{{ $page->siteName }} PGP Key" href="/pgp"
        class="ml-6 text-gray-200 hover:text-blue-600 {{ $page->isActive('/pgp') ? 'active text-blue-600' : '' }}">
        PGP Key
    </a>
</nav>
