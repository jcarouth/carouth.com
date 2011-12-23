---
author: jcarouth
date: '2009-11-05 18:50:16'
layout: post
slug: maintainable-unit-tests-with-phpunit-revised
status: publish
title: Maintainable Unit Tests with PHPUnit Revised
wordpress_id: '134'
categories:
- PHP
tags:
- PHPUnit
- Unit Testing
---

# One Step Back

In my previous post I chose an example that did not illustrate my point. In
this post I will address the issues with previous post, specifically those
brought to light by [Matthew Weier
O'Phinney](http://weierophinney.net/matthew) in his
[comment](http://carouth.com/2009/11/05/maintainable-unit-tests-with-
phpunit/#comment-76).

His first point is that changing the method signature on a constructor should
and will break any client code, thus modifications will be necessary to the
tests. I agree with this wholeheartedly and my choice of using a constructor
was obviously flawed. Let's just chalk this one up to not having had my coffee
as I typed that post…

His second point deals with using the tools available to you within the
framework. Specifically he mentions the use of the setUp() method which
executes prior to each test case and is normally used to establish required
state, set up fixtures, etc. I already committed to the constructor example so
I carried it through this segment of the code. It was, again, a bad decision.

So this post will serve as a replacement for the old post to better illustrate
my point.

# Maintainable Tests

Great unit testing is a learned skill. Unfortunately the motivation developers
have for dabbling in writing unit tests for an application usually comes from
someone else, e.g., his or her boss, a fellow team member, etc. This leads to
writing tests just to have tests which, in my opinion at least, is no better
than not having tests in the first place.

A non-maintainable code base is know to be a problem. The corollary, a non-
maintainable test suite is a huge problem, is also true. If you cannot
maintain your test suite, what is the point? Any time a unit test reaches
beyond a single or violates the DRY principle a development team could find
that the test suite is verging on a non-maintainable state.

## Testing Units More Than Once

If a requirement or business rule is tested more than once in the test suite,
as is the case in the following example, any changes become difficult to
manage. In this example the business requirement that changed is that all cars
start with five gallons of gas before they arrive at your showroom. Thus a
brand new car, i.e., the default constructed car, will not have an empty gas
tank and should be able to start—unless something else is wrong, but I am a
programmer not a mechanic.

[code language="php"]class CarTest extends PHPUnit_Framework_TestCase {
protected $_car;

public function setUp() { $this->_car = new Car(); }

public function testGasolinePresentBeforeStarting() {
$this->setExpectedException('GasTankEmptyException'); $this->_car->start(); }

public function testCarStartsAfterFillup() { $fuelVessel = $this->getMock(
'GasolineContainer', array('dispense') ); //set expectation on fuelContainer
to give 10 //gallons of fuel when dispense is called

try { $this->_car->start(); $this->fail( 'Empty gas tank but no exception
caught' ); } catch(GasTankEmptyException $e) {
$this->_car->addGasoline($fuelVessel); }

$this->_car->start(); $this->assertTrue($this->_car->isRunning()); } }[/code]

This change is not necessarily a regression because code that used the Car
object before should still work as intended the cars will just start from
scratch with some gasoline. Since we changed this requirement both tests in
the above code will fail. The first will fail because we assumed a brand new
car object would have no gasoline in the tank. The same for the second test.
The code repeats itself, and so does my explanation.

Avoiding the duplication in the second test by immediately filling up the car
with gasoline solves the problem of having to dig through the unit test and
makes the second test case a true unit test. As it stands above, it tests two
units: 1) that a car with an empty tank throws a specific exception and 2)
that after adding gasoline to the car it will start.

## Using the Tools Correctly

I knew about setUp() and tearDown() but I was trying too hard to come up with
a fancy solution to my problem. The problem, as it should have been explained
previously, occurs when a test case has groups of tests that require different
configurations of the UUT. For example, sticking with our Car class, we have
several tests that require a stock instance of Car while a group of others
needs a car with a special engine. We can accomplish this as follows:

[code language="php"]class CarTest extends PHPUnit_Framework_TestCase {
protected $_car;

public function setUp() { $this->_car = new Car(); }

public function testSomethingWithAStockCar() { //work $this->assert(…); }

public function testSomethingElseWithStockCar() { //same as above }

public function testCarWithDifferentEngine() { //mock/stub of engine: $engine
$this->_car->setEngine($engine); }

public function testCarWithDifferentEngineAgain() { //mock/stub of engine:
$engine $this->_car->setEngine($engine); } }[/code]

Assuming I abstract the creation of the mock engine into a helper method, I
still have a lot of duplicated code and I still have to call the setEngine()
method in each test. That's absurd. One solution is to create a new test case
for the different configuration; I'll call it CarWithEngineBTest.

[code language="php"]class CarWithEngineBTest extends
PHPUnit_Framework_TestCase { protected $_car; public function setUp() {
$engine = $this->getMock('EngineB'); //…configure mock object… $this->_car =
new Car(); $this->_car->setEngine($engine); }

//test cases that need this configuration }[/code]

And remove these specific tests from the previous test case. This probably
isn't the only way to solve this issue, but it does seem better than my
previous factory method "solution".

The example still isn't perfect, but I couldn't come up with a better one. You
are more than welcomed to weigh in.

  *[DRY]: Don't Repeat Yourself

