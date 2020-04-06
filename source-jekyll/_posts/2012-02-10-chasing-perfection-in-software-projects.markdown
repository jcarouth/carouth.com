---
layout: post
title: "Chasing Perfection in Software Projects"
date: 2012-02-10 18:18
comments: true
author: Jeff Carouth
categories: [Software Developemnt]
tags:
- Code
---

Some questions are universal between both new and experienced developers. Sometimes experience leads us to assume we have the answer to a question, even if that question has no actual answer.

One such question is, "how can I write perfect code?" Some readers will laugh at the notion, others will think of their favorite techniques and acronyms such as DRY, SOLID, or even YAGNI and consider those to be a measure of some level of perfection. Neither group is wrong.

The problem isn't with software developers, it isn't with clients or customers, nor is it with anyone else. The question is flawed. The question assumes there is a state of code that will be impervious to any situation thrown at it. While some of the greatest minds in software engineering are attacking problems in process to aid developers in dealing with a wide array of changes, problems, and situations, writing code that will be perfect is impossible.

Now that we've gotten past the idea that we can ever truly achieve flawless software I'd like to take on the task of defining my thoughts on chasing perfect software.

## My Thoughts on Perfection

I treat code quality a bit like normalizing a relational schema. There are "perfect forms" of software increasing in complexity and stability, but there is also the possibility that deperfecting–you know, like denormalizing–is the correct action to take for your software project.

### Perfect Software Works

The first level of perfect software is a functional piece of software. Funtional software accomplishes its goal consistently. If we're talking about some e-commerce platform, the ideal piece of software would allow store owners, managers, or administrators to enter products, prices, and inventory into a system and then allow customers to purchase those products. But to be considered the first level of perfect, the software must do with very little error.

In an ideal world, the error margin would be 0%. However, there will be issues, so I still consider the software first level of perfect if it performs as intended 95% of the time based on wholly unscientific calculations.

This definition of perfect is incomplete because it favors the happy case, meaning it only takes into account ideal input and conditions.

### Perfect Software Validates and Filters

To get to the next level of perfection, software must validate data and expectations and filter data as necessary. When talking about validation I favor extreme paranoia. Always assume the input you have is not only completely wrong, but possibly maliciously wrong. 

Personally, I think the term input validation is a bit misguiding. Input doesn't solely refer to data coming from your UI, it's data coming from any source other than the method or function working with the data. That means you need to be sure the data coming from your UI is fine; the data coming out of your database is as expected; the data coming from a webservice is valid. Trust no data source.

### Perfect Software is Testable

This is a big part of making great software. However, when I say testable software I could be talking about any number of levels of testability and any type of tests. Specifically, I am speaking about unit testing.

Whatever your feelings towards unit tests might be, writing code that is testable will greatly improve the quality of the project. I dare say that such a practice will improve a project even if not a single test is written. *I do not advocate this practice, however.*

You might ask, "what makes code testable?" That's a great question. I've blabbered on and on about the idea of testable code in the December 2009 issue of php|architect, and more recently my friend Chris Hartjes published a book on the subject of testable code entitled, ["The Grumpy Programmer's Guide To Buliding Testable Applications In PHP"](http://www.grumpy-testing.com/). It's well worth the investment if this is a topic of interest to you.

### Perfect Software is Documented

Oh documentation. The bane of many a software developer's existence. It's a difficult area for many because we're taught silly things about writing documentation and then we get frustrated with the utter uselessness of most documentation. The important thing to take away is that your code should have documentation to help you or whomever gets the pleasure of maintaining the project in the future.

Good documentation should show the reader how to use the code being documented to accomplish a goal. With any sort of luck the goal will be apparent by the name of the code block, function, etc. being documented, but in the real world that isn't always the case.

You can start with [phpDocumentor](http://www.phpdoc.org), but my absolute favorite documentation is unit tests. If a test suite is grown over time with each bugfix, edge case, etc., the unit tests should tell me a lot about how the code is intended to be used. This doesn't mean I won't change the intention, but I have a good idea at the outset what I should and should not expect.

### Finally, Perfect Software is the Software You Have Right Now

In an ideal world, all the levels above will be completed for every piece of software out there. But at the end of the day, the most perfect software solution to any given project is the software that you have written, provided it accomplishes the goal. 

This isn't my way of saying, don't strive for excellence. It's my way of saying software must constantly evolve, but you should realize that the pursuit of perfection is a long journey. Release what works then fix the blemishes. 


