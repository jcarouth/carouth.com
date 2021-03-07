---
extends: _layouts.post 
section: content 
title: Fathom Analytics Goals on non-Production Environments
date: 2021-03-07
description:
featured: false 
categories: [Fathom]
excerpt: I switched to Fathom Analytics from Google Analytics and needed a way to test goals in non-production environments. With a simple override I can do just that.
---
When I decided to switch my personal sites from Google Analytics to Fathom I needed a way to try and capture some of the data I use to make decisions about what to feature with UI elements and where they should live based on how much they are interacted with on the site. I decided to use Goals to replicate this custom event tracking at a base level. However, I only want to include Fathom in production environments and thus a hardcoded call to `window.fathom.goal(...)` would break components in local testing. Here is the low-effort solution I am using.

## The Problem

Suppose you have a component on your page and you want to attach a goal to clicking on a button. That might look something like this:

```html
<div>
    <button>Interact With Me Please</button>
</div>
```

To track how often that button is pressed, you can set up a goal in Fathom and attach a click handler to it, per the documentation:

```html
<div>
  <button onclick="fathom.trackGoal('GOAL_ID', 0);">Interact With Me Please</button>
</div>
```

In the head of the template for my site I include the fathom script conditionally based on the environment. Using the Blade templating language that might look like this:

```html
@if ($page->production)
  <script src="https://cdn.usefathom.com/script.js" data-site="SITE_ID" defer></script>
@endif
```

With all of this combined, in non-production environments the `fathom` object won't exist on the window and thus the click handler will fail due to the undefined method trackGoal on the undefined fathom. Clicking on the button will throw a ReferenceError:

```
Uncaught ReferenceError: fathom is not defined
```

## The Solution

In local environments it could be useful to be able to debug and see which actions trigger which goals in Fathom. To make this work all we have to do is substitute and object for the global `fathom` object which has a method `trackGoal`. I decided to take in the params and out put them into the console.

```html
<head>
  <!-- snip -->
  @if ($page->production)
    <script src="https://cdn.usefathom.com/script.js" data-site="BSPWFCNX" defer></script>
  @else
    <script>
      window.fathom = {
        trackGoal(goal, value) { console.log(`Fathom goal track goal:${goal} value:${value}`); },
      }
    </script>
  @endif
  <!-- snip -->
</head>
```

Now any time we call the window.fathom.trackGoal(...) method the goal we are tracking will be output in the console log for us to inspect. Our code works in the local environment and should behave as expected in production as well.
