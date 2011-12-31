---
author: jcarouth
date: '2010-02-05 08:00:09'
layout: post
slug: prodevzf-unittesting
status: publish
title: 'Professional Development with the Zend Framework: Unit Testing'
wordpress_id: '109'
comments: true
categories:
- PHP
---

Testing is most often regarded as a liability by managers because it does not provide any measurable value to a product in the eyes of anyone excepting developers. But the value is definitely measurable and quite obvious if one would take the time to observe project development through the maintenance phase and, quite possibly even more importantly, in multi-developer environments.

# The Zend Framework Test Suite

In the coming sub-sections we will look at the aspects of the framework's test suite that I find most influential to its success.

## Organization

The first thing to notice about the tests directory for the framework is the slim profile. These few files and directories are a testament to the organizational aspect of the suite. This is important because tests that are difficult to find or inappropriately named will not be maintained.

It is completely possible to not use the AllTests method for suite organization which in smaller projects might seem like a burden. But the use of these groupings allows different subsets of tests to be run for a given component with consistent state and configuration.

## Configuration

Since there are developers working on various components, features, and bugs throughout the world it is essential that each be able to have a consistent environment in which to test. This test suite uses a configuration file, TestConfiguration.php, and a helper file, TestHelper.php, to configure the environment through PHP constants and set up include paths, etc., respectively.

Tests that can only be run on a specific machine are almost as useless as no tests at all.

## Verbose Case Naming

Looking at an individual test file you will notice that the cases, or methods, are named to signify exactly what the test will assert. This is incredibly helpful when staring at code after a while. Using an IDE's outline functionality it is simple to find the test that verifies that a useful message is thrown if a class is not found by the factory because it is contained with the testStaticFactoryClassNotFound() method.

## Use of Grouping Comments

PHPUnit uses comments to accomplish some meta-data and grouping functionality. Throughout  the test suite you will run across individual test methods that have a @group annotation which, most of the time, references an issue in the issue tracker. For example a comment might look as follows for a test case that reproduces the issue ZF-2724.

`/** * Handle file not found errors * * @group ZF-2724 * @param int $errnum *
@param string $errstr * @return void */ `

This is another way to run specific tests. Using the command-line test runner's _--group _switch you can specify the group of tests to run as follows.

    
    phpunit --group ZF-2724 .

Which tests to run and which to skip can also be configured using the phpunit.xml configuration file.

## Testing For Backwards Compitability

One of the Zend Framework project's goals is to ensure that no BC breaks occur except in major releases — this should be a common goal for all projects, but that's just my opinion. Throughout the test code you will find cases that both document and expect that the "old way" and the "new and improved way" of accomplishing something are tested.

This is an area often overlooked during major improvement cycles. I know I am guilty of changing something significant or deprecating a method, etc., and then updating my client code to use the new API but leaving other team members out in the cold. I didn't do it purposely, it was just a novice mistake.

The concept to take away is to not delete or rewrite a test case because you add a new API method (unless it's supposed to be a BC break, then by all means). Instead, write a new case to test the improved method while still maintaining the functionality of the older method. You will make the developers that use your code happy.

These are just a few of the many excellent qualities of the Zend Framework test code. I encourage you to share something you found and admire.

