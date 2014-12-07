---
layout: post
title: "Mocks and OOD"
date: 2013-12-31 18:18
comments: true
categories: 
- Testing
tags:
- PHPUnit
- Object-Oriented
- OOD
---
For [Day Camp 4 Developers: PHP Master Series Vol. III](http://daycamp4developers.com) I presented a talk on leveraging testing to inform object-oriented design, stressing how we can use tests for exploration of the interfaces/roles and messages objects in our application should fulfill, pass, and receive. In a [comment](https://joind.in/talk/view/10116#comment-38979) I received a great question:

{% blockquote %}
I am curious to hear your thoughts on verifying that specific methods are called (on mocks) within the implementation of test. This approach goes beyond testing the interface/contract of a method to test the internal *implementation* of the method as well. From an O-O perspective, this approach appears to break encapsulation and I was curious to hear your thoughts on if this is a worthwhile tradeoff.
{% endblockquote %}

This is a frequent question that comes up with respect to unit testing since it does seem initially dirty to be exposing your tests to the implementation behind the "black box" you are trying to test. In other words, you have to not only know about the collaborators your object under test uses as dependencies, but you also have to know exactly what part(s) of those collaborator's API your object uses and sometimes with what context. This can seem and be incredibly brittle and cumbersome.

So, what are my thoughts on this topic? It's unrealistic to expect you can create completely independent objects for everything, so dependencies will exist. Your job as a test-conscience developer is to think hard about the mocking and stubbing you are doing. The power of those objects is to allow you to figure out if the interface the collaborators are exposing makes sense for your object under test. If you have to mock several methods on five different collaborators (which in vanilla PHPUnit Mock Object code would result in about 1,000 lines of code) then you likely have some refactoring to do.

That said, however, the nature of what I was talking about dictates that you need to be aware of not only the object you are designing (and testing, therefore) but also its collaborators. So you do need to stub out the collaborator's methods. Notice I am saying stub instead of mock. As long as you are able to create stubs that have no actual mock expectations, you are not, in my opinion, introducing any overt smell in your tests (or committing a heinous crime against the OOP community).

If you happen to be using mock objects and setting expectations that get verified, yes you are testing the internals of the method, but more importantly you are testing that a message gets communicated to the correct collaborator. This is also not detrimental to your testing or OOP efforts. The important thing is to look at the dependency and relationship between your object and the collaborator and make sure it's actually message passing and not feature envy or worse.

I hope that clears up the original question and helps someone else who might have a similar question.
