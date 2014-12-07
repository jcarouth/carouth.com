---
author: jcarouth
date: '2010-01-25 08:00:10'
layout: post
slug: development-mise-en-place
status: publish
title: Development Mise en Place
wordpress_id: '160'
comments: true
---

Culinary artists have a French phrase "mise en place" — literally, putting in place — that teaches a cook to have his or her workstation ready in terms of ingredients and equipment. As a developer applying the mise en place concept to project developer simply makes sense.

# Mise en Place is not Big Design Up Front

When thinking about this concept my first reaction was that it sounds a lot like a methodology we are trying to forget. The idea is not to get absolutely everything ready for the entire project at once, rather it is to prepare the tools, the functional requirements, the goals, etc. for an individual component before starting actual work.

A meal is composed of several "dishes" if you will. Normally you have a protein source, a vegetable, a salad, and maybe some bread. Each of these is a component of the overall meal and each can be prepared by a different cook. Now, I won't bore you with the names of each of the types of cooks — besides that is a great use for Wikipedia — but as developers we sometimes have the luxury of separating components and giving them to different team members or even to different teams.

## Preparing Your Workstation

I don't mean your literal desk or even  your computer. I mean getting your project or component in order. The first part of mise en place involves building the tools used for your project. For example, getting the build system in order, or creating the test suite directories and bootstrap files. You have a better idea of the tasks that must be accomplished, but doing them all before you even start actually coding will benefit you in the long run.

After you get your high-level tools built and your environments configured you can start by gathering all the specifications for your portion of the component or project. This might be user stories, interface mock-ups, et cetera. Once you have the requirements you can create any tests, tools, or other components you need until you feel you are truly prepared to build the functional project code.

I like to break my work into small tasks. As such, I prepare my mise en place only for an individual unit of work by creating issues, bug reports, or feature requests in the issue tracker, writing the unit tests I hope to be able to pass as part of my development mise en place — which is why I employ TDD frequently, and generating some sample documentation for the individual component. Once I'm done with my work I'll go back and modify the documentation if something happened to change along the way. In this way, my documentation is as up-to-date as can be expected.

How do you practice the concept of Mise en Place?

