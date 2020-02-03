---
author: jcarouth
date: '2009-11-18 11:41:33'
layout: post
slug: stubbing-an-interface
status: publish
title: Stubbing an Interface
wordpress_id: '141'
comments: true
categories:
- PHP
tags:
- Data Sources
- Interfaces
- Unit Testing
---

One of the topics I talk about frequently is coding to an interface. There is an abundance of evidence why one might choose to do so but today I'd like to talk about one benefit in terms of unit testing—another topic I love to talk about. To illustrate the benefit I will use an example of having the data source coded against the interface thereby allowing the consumer of the data source to ignore the specifics behind how data is stored, e.g., in a relational database or in a key-value store, and concentrate solely on requesting the appropriate data. Before I get to the code, however, I think it's important that I define some of the scope of this post.

## Goals of a Unit Test Suite

Other than exercising a substantial portion of your code a unit test suite must be capable of running quickly lest it be a burden on development. Having a burdensome, slow-running test suite will only encourage developers to ignore it and only run it when absolutely necessary. This, in turn, will make maintenance of the test suite more difficult and probably result in fragile or poor tests which ultimately will leave a bad taste in the developer's mouth about unit testing, and we wouldn't want that, now would we?

One sure-fire way to decrease the speed of a test suite is to make it rely on real-world data sources such as your relational database or even a web service. Imagine a test suite for an application that relies on Twitter's availability. I can assure you that I would not want to run that test suite. The fail whale is annoying enough on the web. But I digress. Being able to emulate a data storage source is paramount to the speed of a unit test. Stubbing is one technique employed to do such a thing.

## A Data Source Interface

A basic data source needs the implement the standard CRUD methods and can be defined as follows:

[code language="php"]interface ICrudDataSource { public function create(array
$data);

public function read($id);

public function update($id, array $data);

public function delete($id); } [/code]

If this were a real interface there would be PHPDoc blocks to indicate the behavior of the methods and parameter types, but for the sake of the example I omit them. Now we can implement this interface in our database table class and define the behavior for each of the methods in terms of how our chosen rdbms will understand them, e.g., create() is an INSERT statement, read() is a SELECT statement, so on and so forth.

We can then use this class in our unit tests and it will actually test that the database vendor correctly implemented the INSERT, SELECT, UPDATE, and DELETE statements and that we are calling them appropriately. While I do think the latter should be tested when we look at the database abstraction implementation, the former is not necessary and will only slow down tests that _use_ the data source code but _don't directly depend on it_ being a database, for example. In such a case a simple array-based storage mechanism will work.

## Array-based Stub for Unit Testing

Thus, we implement the ICrudDataSource interface in a stub that is used for our unit tests that need to interact with the data storage but necessarily need to interact with the specific data storage used in production.

[code language="php"]class UserDataStorageStub implements ICrudDataSource {
protected $_store;

public function __construct() { $this->_store = array(); }

public function create(array $data) { if (!$this->exists($data['id'])) {
$this->_store[$data['id']] = $data; return true; }

return false; }

public function read($id) { if ($this->exists($id)) { return
$this->_store[$id]; }

return false; }

public function update($id, array $data) { if (!$this->exists($id)) { return
false; }

$this->_store[$id] = $data; }

public function delete($id) { unset($this->_store[$id]); }

private function exists($id) { return array_key_exists($id, $this->_store); }
}[/code]

With this array-based implementation the unit tests will be fast regardless of the availability of the actual data source or the load on that data source. This stub, or a stub that extends this one, can also be easily pre-populated with test data to allow for testing with fixed data (although this can lead to very brittle tests if done lackadaisically).

  *[CRUD]: Create, read, update, and delete

