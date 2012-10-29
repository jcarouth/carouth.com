---
layout: post
title: "ZendCon 2012 Wrap Up"
date: 2012-10-28 10:38
comments: true
categories: 
- Conferences
tags:
- ZendCon
---
After all the travel, check ins, check outs, schedule decisions, meals, receptions, tutorials, and presentations are over there's still a lingering feeling of being inspiration. If you manage to make it through a conference without finding at least something to fire you up and inspire you to create or learn, you are doing it wrong. I wanted to write a brief wrap-up to highlight some of the inspiration I'm bringing home. (You'll notice I'm writing this a few days after the end of the event. I'm just not reaching the point where I'm not a zombie from exhaustion.)

## Modules and Components ##

Zend Framework 2 was clearly--and rightfully--a theme found in many of the sessions at ZendCon this year. One of the coolest parts, in my opinion, the team has been working on is providing infrastructure and patterns for creating real modules to be consumed by ZF2 applications. [Evan Coury](https://twitter.com/evandotpro) said it best in one of his sessions by mentioning that he worked on modules for ZF2 because ZF1 "supported" modules in theory but in practice the implementation was not widely used and had some signficiant design flaws. Take a look at the [slides and video](http://blog.evan.pro/introduction-to-modules-in-zend-framework-2-talk-at-zendcon-2012) from his session, "Introduction to Modules in Zend Framework 2.0."

The other major take away from the ZF2 and related talks is the idea of components. If you're like me, you remember ZF1 being billed as an at-will framework, meaning you can use any of the framework components, e.g., Zend_Db, the MVC implementeation, etc., at will without having to use the rest of the stack. This is a powerful concept and is something the team has made even easier in version 2.0. The power of this concept became abundantly clear with sessions such as the joint presentation given by [Stefan Koopmanschap](https://twitter.com/skoop) and [Enrico Zimuel](https://twitter.com/ezimuel) titled ["Zend Framework 2 and Symfony2: The Perfect Team"](https://speakerdeck.com/skoop/zend-framework-2-and-symfony2-the-perfect-team-zendcon) and [Ryan Weaver's](https://twitter.com/Weaverryan) presentation ["Easily Integrate Zend Framework 2 and Other Libraries Using Composer."](https://speakerdeck.com/weaverryan/the-wonderful-world-of-composer-and-zf2)

Take a look at the components ZF2 and Symfony2 offer. I have a feeling you might be able to use at least one in your project today. If this isn't inspiration to get out and experiment I don't know what is.

## Testing and Profiling as a Practice ##

(_Full disclosure: one of my sessions was on testing, specifically mocks and fixtures within unit and integration tests. It's a subject I am passionate about._)

It is encouraging to see emphasis on development practices such as testing and profiling at a conference such as ZendCon. While it occasionally seems like a repetative subject, if the focus is on better techniques for each as opposed to reasons why I think these sessions are still valuable.

In addition to my session on using mocking frameworks and fixtures in tests, the creator of PHPUnit, [Sebastian Bergmann](https://twitter.com/s_bergmann), presented a session on ["PHPUnit Best Practices"](http://thephp.cc/dates/2012/zendcon/phpunit-best-practices) as well as a session on ["Living With Legacy."](http://thephp.cc/dates/2012/zendcon/living-with-legacy) Both of these sessions provide insight into writing better tests as well as the common situation of writing tests for legacy PHP applications.

If you do not know how your code performs, and even if you have an idea, profiling is an invaluable tool in tweaking code for better experience as well as finding bugs that you might not otherwise be able to gain insight into. The author and maintainer of [XDebug](http://xdebug.org/), [Derick Rethans](https://twitter.com/derickr), presented ["Profiling PHP Applications"](http://derickrethans.nl/talks/profiling-zendcon12) which covers this exact topic using the XDebug library. His realistic examples make the concept much easier to digest than simple documentation ever can.

[Ilia Alshanetsky](https://twitter.com/iliaa) presented ["Bottleneck Analyis"](http://ilia.ws/files/zendcon2012_bottlenecks.pdf) which took attendees through possible application bottlenecks from the outside in. It is important as web application developers to remember that the code is only one portion of the delivery from the server to the client and having the tools to examine each of these layers is critical to creating a responsive or performant application.

## The Hallway Track ##

The hallway track is one of the most important benefits of attending a conference. Personally speaking, I had many great conversations outside of the presentation rooms. At one point I had a 30-minute discussion with an attendee about the idea of transferring applications from mainframe to web and the requisite paradigm shifts and approaches to improving the interface with code.

I also spent considerable time talking with several people about deployment and systems architecture approaches. While this isn't a direct responsibility of mine, I have spent a considerable amount of time in this arena--yes like a circus if I'm doing it--and having more experienced people to bounce ideas off of and learn from their approaches is invaluable. I already have several areas I want to improve based solely on a 15-minute conversation next to an escalator. You can't put a price on that.

## The Uncon ##

As usual the ZendCon UnCon was top notch. [Michelangelo van Dam](https://twitter.com/DragonBe) did another impressive job organizing and running the uncon, as well as contributing. I attended his UnCon session on the benefits of community titled ["Community Works!"](https://speakerdeck.com/dragonbe/community-works-zendcon-2012) I mentioned this in my comments on joind.in, but if you did not get a chance to hear this session--and I know you did not since I was the only one in the audience--you missed out greatly. Even if you are already engaged in the community it was inspirational to say the least.

There was a much tweeted and successful uncon session by [Lorna Jane Mitchell](https://twitter.com/lornajane) titled ["Git + Github: everything you need to know!"](https://speakerdeck.com/lornajane/git-githu) I did not attend this session, but from the buzz on Twitter and in the hallways I would say it has inspired and opened doors for many attendees.

# Fin #

I am a much better developer for having attended ZendCon 2012. I was proud to be a part of the conversation with my two sessions (which I'll write about in another post) and as an attendee. If you were unable to attend this year I hope these insights provide some value and I urge you to start planning for next year. I dont expect ZendCon 2013 to be anything less than purely awesome.

To the Zend team, the ZF2 team, the team at S&S Media, the exhibitors, the sponsors, the speakers, and most importantly the attendees, I thank you all for the memories. I hope to catch up with you soon.
