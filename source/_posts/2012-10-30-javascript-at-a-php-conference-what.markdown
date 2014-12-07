---
layout: post
title: "JavaScript at a PHP Conference. What?"
date: 2012-10-30 08:31
comments: true
categories: 
- Conferences
- JavaScript
tags:
- JavaScript
- ZendCon2012
---
Last week at [ZendCon 2012](http://zendcon.com) I presented a session titled "JavaScript for the PHP Developer in 2012." Interestingly this was not a talk I originally intended to submit, but I thought it might be a fun topic for the conference. 

You might be thinking, but ZendCon is a PHP conference, what is the relevance of a JavaScript talk there? Simply put the idea of a purely PHP developer--when talking about the web--is rare these days. Hybrid and generalist programming, or polyglots if you want to be a hipster, is the type of developer you want to be. Don't just trust me, trust many other developers much smarter than me. (Seriously, Google it.)

So, I sent in this proposal and it was selected. I was then tasked with figuring out a coherent progression from PHP mindset to a modern-day JavaScript developer. This was no easy task, and I still don't think I got it 100% correct.

## The Talk ##

I gave this talk on Wednesday morning at 11:00AM. Imagine my surprise when the room was mostly full by 10:45. By 10:50 there were no seats left. One of the ZendCon staff kindly retrieved more chairs to give the people congregating in the back of the room a place to sit. Those chairs filled and yet still more people showed up. It would be easy for me to take this as an ego boost, but I recognize the people weren't there to hear me, they were there to hear about JavaScript.

The session (slides below) started out with the basics of JavaScript including arrays and objects with emphasis on the translation of concepts from PHP. I spent a considerable amount of time on the idea of "almost everything in JS is an object" and on the Constructor Function pattern because it is important for OOP-minded PHP developers to understand how to construct similar "objects" in JS.

I then moved on to organizational patterns including how to namespace code and the famous--or infamous, as it were--JavaScript Module Pattern. After the talk I received several comments from attendees about the module pattern and how it will help them organize code better. That was the point, so I'm glad it came across in tact.

Then came the porition I wasn't sure on, but knew I should include: tools for development. I picked several tools and frameworks that I have personally used to highlight the transition from similar tools in the PHP ecosystem. These are [require.js](http://requirejs.org), [Backbone.js](http://backbonejs.org), [QUnit](http://qunitjs.com), and [GRUNT](http://gruntjs.com/). These translate to autoloading, MVC-ish frameworks/libraries, unit testing, and build tools in PHP.

## The Slides ##

{% raw %}
<script async class="speakerdeck-embed" data-id="5087862bdb554a000202d458" data-ratio="1.3333333333333333" src="//speakerdeck.com/assets/embed.js"></script>
{% endraw %}

## The Reaction ##

After this talk, several people approached me over the next day and a half to discuss the ideas I presented further. There is literally nothing that could have been more flattering than to have inspired conversation and questions in attendees. Don't get me wrong, five stars on joind.in is great, but knowing a session I gave led someone to improve his or her development skills is much better.

I did not get the amount of feedback I hoped for on joind.in. ZendCon has paper evaluation forms and doesn't push joind.in ratings as a conference, so it's up to the speakers to encourage--or beg--attendees to take a few moments to comment electronically. I clearly need to work on my pitch.

However, [the comments I did receive](http://joind.in/7022) are overwhelmingly positive, but shed some light on one critical shortfall of this particular presentation: the breadth of the information. Since I took attendees from basics to tools, there is quite a bit to digest. Part of this is intentional, as the subject of JavaScript for PHP developers is quite vast, but if I give this talk again I'll likely try to split on JavaScript (the langauge) for PHP developers, and translating PHP development practices to JavaScript. This will make it easier for attendees to digest the material, I think.

## Going Forward ##

If you were able to attend and haven't had the opportunity to rate and comment on joind.in, please take a few moments to do so now. I will greatly appreciate any comments you have to offer.

If you were not able to attend, hopefully the slides are content-rich enough to provide some value to you and this post of my thoughts leads you to some JavaScript enlightenment.

I'm going to follow this up at some point with a post on books to read, but to get the gist of the material I suggest checking out [JavaScript Patterns by Stoyan Stefanov](http://www.amazon.com/JavaScript-Patterns-Stoyan-Stefanov/dp/0596806752) and [Eloquent JavaScript by Marijn Haverbeke](http://www.amazon.com/Eloquent-JavaScript-Modern-Introduction-Programming/dp/1593272820/). These two books are essential reading for anyone looking to understand patterns in JavaScript. Additionally there is an e-book, [Learning JavaScript Design Patterns by Addy Osmani](http://addyosmani.com/resources/essentialjsdesignpatterns/book/) which is a great resource to have bookmarked as you explore development practices in JS.
