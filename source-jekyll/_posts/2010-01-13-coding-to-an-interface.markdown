---
author: jcarouth
date: '2010-01-13 12:05:18'
layout: post
slug: coding-to-an-interface
status: publish
title: Coding to an Interface
wordpress_id: '153'
comments: true
categories:
- Software Development
tags:
- Best Practice
- Design by Contract
---

In a recent user group presentation the topic of using interfaces to enforce coding standards, ensure component compatibility, etc. was touched upon. The inevitable discussion about the definition of coding to an interface commenced.

## The Literal Definition

Most people when first introduced to the concept of coding to an interface or even "design by contract" type concepts take the literal definition. At this basic level the technique means to use your programming languages OOP interface to define the behavior of the objects you will be using and accept objects that implement that interface where necessary, as illustrated in the following listing.

[code language="php"]interface Deleteable { //some methods }

class Book implements Deleteable { //implementation }

class BookDataSource { public function delete(Deleteable $book) {
$this-&gt;purge($book); } }[/code]

With this arrangement any methods that are necessary to prepare an object for deletion will be implemented in the Book class and the data source will only allow objects that implement the Deleteable interface to be purged from existence.

This technique is employed to allow better unit testing, for polymorphism, to ensure that objects have certain behavior, and a variety of other reasons. Coding to the contract provided by the interface is a great practice.

## An Expanded Definition

While the literal definition above is definitely accurate and valuable, the interface extends into other areas. In modern software projects there are a variety of resourced one can call upon to learn about the behavior and properties of software components. Each of these resources is a part of the contract and useful as an interface to which developers should code.

### Documentation

The most obvious resource for defining behavior and properties is documentation. Whether this is some sort of specification document in a wiki, in a binder, on notecards, on napkins, etc., or code comments documentation is a useful interface as long as it is maintained. Maintenance is the pitfall of using documentation as a contract because it is so often and so easily neglected.

Because documentation is most likely out of date — hey, I code in the real world — it is my last choice for an interface-defining resource. However it's better than having nothing.

### Unit Tests

Thinking about it, unit tests are the ultimate supplemental contract for code. They will immediately notify the developer if the terms of the contract (the assertions) are broken. They also provide usage documentation that will help integration efforts.

## In Your Code

The message I hope to get across with this post is that the concept of design by contract or coding to an interface is broader than the literal implications. Using supplemental contracts for your projects will make your projects better if only for that day in the future when you wonder why you made the decision you did.

