<?php

return [
    'baseUrl' => 'http://localhost:8000',
    'production' => false,
    'siteName' => 'Jeff Carouth',
    'siteDescription' => 'Software Engineering Leader',
    'siteAuthor' => 'Jeff Carouth',

    // collections
    'collections' => [
        'posts' => [
            'author' => 'Jeff Carouth', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => 'articles/{filename}',
        ],
        'categories' => [
            'path' => '/articles/categories/{filename}',
            'posts' => function ($page, $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->categories ? in_array($page->getFilename(), $post->categories, true) : false;
                });
            },
        ],
    ],

    // helpers
    'getDate' => function ($page) {
        return Datetime::createFromFormat('U', $page->date);
    },
    'getExcerpt' => function ($page, $length = 255) {
        if ($page->excerpt) {
            return $page->excerpt;
        }

        $content = preg_split('/<!-- more -->/m', $page->getContent(), 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $content[0];
        }

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
    'isActive' => function ($page, $path) {
        return ends_with(trimPath($page->getPath()), trimPath($path));
    },
    'getRecircPosts' => function ($page, $allPosts) {
        return collect()
            ->concat(
                $allPosts->filter(function ($post) use($page) {
                    if (!$page->categories || !$post->categories) {
                        return false;
                    }
                    return !empty(array_intersect($page->categories, $post->categories));
                })
            )
            ->concat(
                $allPosts->where('featured', true)
            )
            ->concat(
                $allPosts->take(10)
            )
            ->reject(function ($value, $key) use($page) {
                return $page->getPath() == $value->getPath();
            })
            ->unique()
            ->take(3);
    }
];
