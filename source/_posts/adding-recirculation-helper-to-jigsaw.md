---
extends: _layouts.post
section: content
title: Adding Reciriculation Helper to Jigsaw Blog
date: 2020-03-31
description: How to add a recirculation helper to drive readers to relevant/fresh content
featured: true
categories: [Blogging, Jigsaw]
excerpt: In the process of transitioning my blog from Jekyll to Jigsaw I worked on a re-design. One feature I wanted was the ability to recommend relevant and fresh content to readers. To accomplish this I created a helper to pull posts into a recirculation modules. This is how I did it.
---

I haven't blogged in a quite a few years. There are a lot of reasons for this which I'll spare you from but one reason was I let the version and set up of my blogging engine [Jekyll](https://jekyllrb.com/) lapse to the point where it was unusable. I wasn't actually able to blog. This was all my fault as I made several attempts over the years to build in a custom theme and made a bunch of changes to it that I never pushed out. Then it got to the point where I couldn't. A couple friends of mine recently re-launched their blogs in new tech and I got the itch to do that as well. After some research I decided [Jigsaw by Tighten](https://jigsaw.tighten.co/) was the "platform" I wanted to use.

## The Reciculation Design

I hope to increase my blog production (don't we all?) so one of the goals I had for this re-design was to think about how to better funnel people to articles I've written. The traditional view of a time-oriented list (an archive) works, but some of what I write I hope to be more evergreen than stuff written specifically for the time period it was written. To accomplish this goal I decided I wanted to include a recirculation module in my post presentation. You can probably see it at the bottom of this post, but here is the basic design I created in [Figma](https://www.figma.com/).

![Screenshot of recirculation design from Figma](/assets/img/posts/adding-recirculation/recirc-figma.png) {.mx-auto}

Talking through the design, I built the idea of a "Post Card" component which would surface on the site to link readers to a post. In this recirculation I wanted to include a barebones presentation of the articles to include the title, the excerpt, and a read button. For content I wanted to include three articles with weighted sources. In order I want recent articles in the same categories as the current post, recent featured articles, and then a fallback of recent articles to fill out the collection.

I used the (Blog Starter Template)[] for Jigsaw so I already had the concept of "featured" articles available to me as an example for what I needed to do. I took that concept from the master template and started looking for a way to build a helper which would give me the view into the post data I needed.

```php
// Featured posts from the index blade template
@foreach ($posts->where('featured', true) as $featuredPost)
    @include('_components.post-card')
@endforeach
```

## Implementation

I started with the knowledge that I could build a helper in the `config.php` file which would attach itself to the current page as a method, just like how `$page->getExcerpt()` works. This is the route I chose to go to add this functionality. I configured a new method in `config.php` named `getRecircPosts`:

```php
//config.php
<?php

return [
    //...snip...

    //helpers
    'getExcerpt' => function ($page, $length = 255) {
        //...snip
    },
    'getRecircPosts' => function ($page) {
    },
];
```

This will allow me to pull the reciculation post collection from a page object.

```php
$page->getRecircPosts();
```

The next step in my process involved digging through "what is a Page" in Jigsaw. I was thinking about this as a model in some ways so I was attempting to find a way augment a method like `findRelatedBy('categories')`. I _could_ add this in the `config.php` I think, but I feel like that would actually be a waste of time. I abandoned this thought process and decided to just write some code.

My first attempt involved building an array of posts procedurally and then pulling the first three items from that. I didn't save it but it looked roughly like this:

```php
'getRecircPosts' => function ($page) {
    // where do I get posts from?
    $recircs = $posts->filter(function ($post) use($page) {
        return !empty(array_intersect($post->categories, $page->categories));
    });

    $recircs->push($page->getNext());
    $recircs->push($page->getPrevious());

    $recircs->concat($posts->take(3 - $recircs->count()));

    return $recircs;
}
```

I don't know if that will work or not, but suffice it to say the original I actually wrote did not work. I also had that looming question of how do I get all the posts? The answer to that question was staring me in the face all the way up at the top of the `config.php` file as well as in the featured posts example I was looking at in the index blade template: the posts collection.

Since I have access to the posts collection within a blade template, I can simply pass it to the `getRecircPosts` method when I call it:

```php
$recircPosts = $page->getRecircPosts($posts);
```

This led me to an aha moment in how to clean up that implementation. Since `posts` is a collection (in more than one sense) I can chain a set of filters to build the collection I want and then take the first `n` posts from that result:

```php
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
```

In this "algorithm" I am building a collection using `concat` onto an empty `Collection` to add articles by category first, then featured articles, and finally adding 10 articles from the Posts collection. I then go through and reject any Posts in that collection which are the current `$page` as it would be silly to recirculate someone to the page they are on. Then I de-duplicate the collection using `unique` and take the first three.

I include this recirculation component at the bottom of my posts page as follows:

```php
@if ($recircs = $page->getRecircPosts($posts))
<div class="max-w-5xl mx-auto px-6 py-10">
    <h4 class="mb-8 text-2xl uppercase font-light">More to Read</h4>
    <div class="md:flex">
        @foreach ($recircs as $recircPost)
            @include('_components.post-card')
        @endforeach
    <div>
</div>
@endif
```

I will probaby iterate on this in the future, but for now this is working as expected.