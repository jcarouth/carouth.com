---
layout: post
title: "Micro Framework and JavaScript Applications"
date: 2012-07-01 21:11
comments: true
categories: 
- Speaking
tags:
- MicroPHP
- Backbone.js
- LoneStarPHP
- lsp12
---
As I mentioned, I was accepted as a speaker at LoneStarPHP 2012 to give a session on MicroPHP Framework and JavaScript Applications. The session went reasonably well and I received some decent feedback both at the conference and on [joind.in](http://joind.in/6351). I will address a couple issues with the talk to, hopefully, inspire you as I intended with this talk. The abstract describing the talk follows.

{% blockquote %}
Small footprint libraries and so-called micro frameworks are a newer development in the PHP community. In this session we'll look at the MicroPHP Manifesto and go over building an application focused on the ideas presented by it. We'll look at a couple micro frameworks and other tools including Slim and Breeze as well as concerns with implementing your frontend with Backbone.js and other techniques. We'll also cover simple ways to organize your application and manage dependencies using Composer.
{% endblockquote %}

And the slides are available on [speakerdeck.com](https://speakerdeck.com/u/jcarouth/p/micro-framework-and-javascript-applications).

{% raw %}
<script async class="speakerdeck-embed" data-id="4fee96a426808700220005c8" data-ratio="1.3333333333333333" src="//speakerdeck.com/assets/embed.js"></script>
{% endraw %}

## Things that need fixing ##

The first thing to address is with the abstract itself. Looking at __two__ micro frameworks in the code and demo portion of the talk was well simply too much content to present in a single 50-minute session. _That is 100% my mistake_. 

Other aspects that were difficult to address within the time limits are fully addressing Composer and code organization. I was able to push code organization tips into the sample code I provide on Github. My original intent was to introduce Composer as a tool to help expose and make it easier to use MicroPHP libraries and frameworks, but I can see that the abstract, as written, makes it seem like I will provide more in-depth information about Composer.

The slides themselves are a resource. They contain highlighted code that can be used to find the important bits in the [example code](http://www.github.com/jcarouth/pomtrac) found on Github.

This brings me to the areas of the talk I need to address should I ever give this session again.

### This talk is supposed to inspire people to explore MicroPHP libraries and frameworks. ###

A 50-minute session is supposed to be used to inspire the attendees to take a pointer from the talk and go out and research and experiment with the concept. It simply is not feasible to truly teach someone even the basics of a topic in just 50-minutes. The very first comment I recieved via joind.in told me I did not convey the message I wished to through this session. The author said, "I am not sure I understood why one would use a micro framework for the PHP side, but a full framework for the JavaScript side." Ignoring that Backbone.js is most assuredly _not_ a "full framework" by any stretch of the imagination, he has a point. It's not that I should not present the concept of using microphp frameworks to expose APIs for a JavaScript frontend to consume, it's that I failed to make it clear that I was not advocating you pick up a single micro framework and solely use it for your entire backend. That is __completely__ not the message I intended to convey.

To clear it up, my point was to use Slim as a way to expose a RESTful API using _existing_ components of an application to handle business logic, etc. The example I use feels too much like a contrived example, and it shows through this comment. That must be cleaned up.

### Having both an introduction to the manifesto and a practical application of a single framework is too much. ###

Orginally I hoped the introductory material on where MicroPHP stands, and some commentary on the manifesto itself, would help steer the focus of the audience to treating Slim less like a replacement for Symfony2, Zend Framework, Kohana, etc., to looking at Slim as a small-footprint library that solves a signgle problem: HTTP request routing. Unfortunately, given the time constraint, I was able to spend enough time on neither the subject of why you would consider MicroPHP nor actually using micro components. That should be addressed by splitting this session into two talks. One more of a soft talk on the concepts. The other a technical introduction to using a collection of libraries.

### Clarity is critical on stage ###

One other comment from joind.in makes it painfully obvious that something I said was not crystal clear. Here it is.

{% blockquote %}
Not very convincing that Slim or MicroPHP is ready for prime-time use, since you said you had to build extensions onto Slim in order to return JSON...
{% endblockquote %}

The author of the comment is referencing a Middleware component for Slim I had to write to deal with content negotiation. This was a very specific implementation decision _I_ made to be more of a REST snob. The author of Slim is working on a much better implementation of looking at the Accept request header to determine what type of payload the client expects to recieve. Since it is under development, I do not see the reason to spend much time on implementing a middleware component for slim that does the same thing. This was, again, a decision I made to support the Accept header instead of the ugly hack of appending ".json" to the URL.

If we are using a framework's support of automatically returning JSON-encoded data based on the Accept request header to determine whether that framework should be used in a production setting, we are dooming any site or application written on top of the Zend Framework version 1.x, since this isn't a feature in the core framework. Personally, I think that is a bit rash.

The result of not being clear is this person has a jaded view of MicroPHP libraries and frameworks. I have failed the community.

# Fin #

For the first time I presented this topic, which I know is one that is hard to stomach for many devs anyway, I think it was a success. It just needs a little tweaking. I hope my commentary here is useful.
