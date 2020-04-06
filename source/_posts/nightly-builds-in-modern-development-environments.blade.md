---
extends: _layouts.post
section: content
title: Nightly Builds in Modern Development Environments
date: 2020-04-02
categories: [Process, Testing, "Continuous Integration"]
excerpt: Are nightly builds a thing of the past? Or should you consider running one in your modern software development project?
featured: false
published: true
---

Recently a friend of mine, Jonathan Sundquist, tweeted:

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Ok hive mind, specifically those in testing or devops, what is your thoughts on nightly builds? Is there really a benefit from them if you are running your test suite already with every pull request? <a href="https://twitter.com/grmpyprogrammer?ref_src=twsrc%5Etfw">@grmpyprogrammer</a> <a href="https://twitter.com/dragonmantank?ref_src=twsrc%5Etfw">@dragonmantank</a> think you both might have insights to this.</p>&mdash; Jonathan Sundquist (@jsundquist) <a href="https://twitter.com/jsundquist/status/1245720315616993280?ref_src=twsrc%5Etfw">April 2, 2020</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

As I have worked on several teams and projects where we developed a process from the ground up as well as on teams where an established continuous integration process was in place I decided I would share my thoughts in blog form rather than a threaded tweet.

Let's start from the foundation of the question. In order to know if you should consider a nightly build you need to step back and define the goals of your build process. This will vary greatly depending on many factors including your product, your team size, your team structure, your application architecture, et cetera. Some examples of goals: integrate changes from many development teams into a shippable package for QA by a team on the other side of the planet; run the larger, long-running integration test suite that can't reasonable be run frequently; or re-establish a stable starting point for work to commence the next day.

## Nightly Builds

## Continuous Integration

## Opinion