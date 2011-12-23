---
author: jcarouth
date: '2011-11-07 10:00:39'
layout: post
slug: using-magic-for-good
status: publish
title: Using magic for good
wordpress_id: '348'
categories:
- PHP
---

Magic functionality in programming languages can be helpful. But it also
provides an easy way for developers to make maintenance a nightmare and
confuse even the original author just days after the code is authored.
Yesterday, a developer I met at ZendCon, Joshua, Tweeted most likely out of
frustration caused by such magic functionality.

I responded
that I found what I consider to be a good use case for certain magic
functionality in PHP. At the end of the conversation, Joshua agreed that the
so-called magic functions can be used for good but it is often wielded
inappropriately which leads to frustrations such as what inspired his tweet
above.

##A use casefor __call()

PHP has a magic metho named __call(). If you aren't familiar, __call()
provides method overloading functionality for PHP classes/objects. This is
often used for implementing proxy functionality among other things but I
thought it might be useful for deprecating methods after extracting their
feature from a class.

In this situation we had a classic case of a class that does more than one
thing and an obvious need to extract the second class. When working on the
refactoring we have two choices: 1) we can remove the methods and find/replace
all calls to those functions from any client code, or 2) leave the methods
exposed and available to the client code, but implement the new refactored
class inside these methods. I propose that we can use the __call() method to
continue to provide/expose these methods while allowing time to fully
deprecate and remove the methods.

    
    class PersonMapper 
    {
        public function find($id) 
        {
            //do something related to people
        }  
        //...snip...
        public function __call($method, $args)
        {
            if (false === stripos($method, 'building')) {
                throw new Exception('Unknown method ' . $method);
            }
            trigger_error(
                'Using deprecated method ' . $method . ' on object of ' . __CLASS__,
                E_USER_DEPRECATED //NOTE: PHP 5.3.0+ required
            );
            $newObj = new Foo();
            call_user_func_array(array($newObj, $method), $args);
        }
    }

  
As you can see in the __call() method, I first check to see if the called
method matches the criteria for the deprecated methods. If it does we trigger
a warning (to show up in development logs) and then call the method on an
instance of the new class.

## There you have it.

Magic for good and no Harry Potter involved.

