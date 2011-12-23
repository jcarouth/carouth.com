---
author: jcarouth
date: '2011-09-17 10:15:05'
layout: post
slug: stupid-simple-productivity%e2%80%94my-toolbox-in-2011
status: publish
title: Stupid Simple Productivity—My Toolbox in 2011
wordpress_id: '328'
categories:
- Productivity
---

I'm a fan of efficiency. I constantly evaluate new techniques to enhance the time I spend working, and the time I spend playing. I wanted to share my productivity toolbox in 2011.

# Work Spaces

I've found it's important to keep a clean, organized workspace. When I say that, I'm talking mostly about your physical work area; usually a desk or a table. If you're a coffee shop surfer, you likely don't have the opportunity to clutter up your desk, but it's equally important to organize your travelbag.

That said, I'm going to talk about your virtual workspace instead of your physical one.

Your virtual workspace is one area that I disagree with the general statement that "less is more." I don't suggest a wonton usage of workspaces, but, in my experience, having a separate desktop or workspace for each category of tasks has significantly increased the volume of work I can accomplish. I am, of course, speaking of the "Spaces" feature of Mac OS X and the virtual desktops in Linux windows managers. I don't have enough experience with Windows to suggest a tool to add this functionality, but a quick Google search turned up a few suggestions.

In my case, I typically use four distinct workspaces. Like I mentioned, I split my workspaces up by task. My first workspace is my coding space. I typically have an instance or Vim open (GVim or MacVim) and usually a terminal to interface with data providers or whatever, and a web browser. The web browser is the only thing that crosses spaces, but that's just a reality Ihave to live with.

My second space is where I push my systems administration tasks to. Typically this means I have a terminal open (tmux FTW!) connected to several machines. It's such a party sometimes.

I push all my distractions to my third space. I classify distractions as my email client, my Jabber/IM client, my Twitter client, and other so-called social outlets accessed via web browser--such as Reddit, Google Reader, et cetera. It takes some getting used to, but it's completely within the realm of possibility to  only access this workspace during planned times for interruptions. I'll admit it does put a damper on the meaning of instant messaging, and it's virtually impossible to keep up in IRC, but it's necessary for optimal efficiency.

My final space is reserved for "incidental usage." This can be anything from mockups, to reading materials specific to the project I'm working on, so on and so forth. I try to avoid needing this space, but sometimes it's necessary.

# Organizing communications and files

A major time sink is processing incoming communications and file resources. I won't classify myself as an expert at organization, task management, or the like, but, borrowing from several methodologies, I have come up with a system that works for me.

Following the "inbox" concept prevalent in email systems as well as the Getting Things Done methodology, I have a set of easily-accessed directories that I dump files into when they need work. I also have a mirror of this setup in my email systems. I label my directories with numeric prefixes (for sorting purposes.) I'll admit it's ugly, but it works for me. Here are the directories:

  * 00-inbox
  * 01-actionable
  * 02-follow-up
  * 03-today
  * 04-this-week
  * 05-later
  * 10-someday
  * 20-projects
    * Project1
    * Project2
  * 99-archive

I use these directories to store files I'll need to complete my tasks, and then in the archive I have files I need to keep for whatever reason. The first set of directories corresponds to task planning. Usually I'll have an email or two in a similarly-named folder and I work on my schedule in my editor—more onthat later. The 20-projects directory is for current projects. Once a project is complete (or out of my current scope) I move it to the 99-archive directory.

From the names, you should be able to gather how things are organized. It's a sort of divide and conquer technique for file management. I haven't lost a file yet, and these directories are synced with an online backup as well as to portable storage on a weekly basis. It Just Works.

#  Task Management

I mentioned in the previous section that I schedule tasks in my editor. I subscribe to using the Pomodoro technique. If you are unaware, this technique revolves around scheduling things in "Pomodoros" which are 25-minute work iterations. After each pomodoro, a 5-minute break is taken with every 4th break being 15 minutes. It sounds complicated, but it truly is stupid simple. I use [http://tomato-timer.com](http://tomato-timer.com) to handle the timing. It's free and very portable. If you want more information, I highly recommend [this book](http://pragprog.com/book/snfocus/pomodoro-technique-illustrated) from the Pragmatic Bookshelf for an overview of the technique.

I manage my activity inventory—a fancy term for a running to-do list—in Vimwiki which syncs through an online data storage provider. This allows me to access my inventory from every machine I use. Thanks to some awesome individuals (Travis Swicegood and Matthew Weier O'Phinney) I've managed to integrate vim-task with Vimwiki and I have a clean way of managing task lists. Vimwiki also allows me to create a "today" page in my wiki, where I place my task list for the day and assign pomodoros.

# Odds and Ends

The one issue I haven't solved is a quick way to carry my activity inventory with me. Right now I'm using Remember The Milk and Evernote from my phone, or just plan old fashioned notebook and pen. But this is cumbersome and I'd like to find a way to directly inject my tasks into my synced list. I could possibly accomplish this by syncing my phone to an online provider and manually editing the text file for Vimwiki, but I'm not sure I like that.

The last thing on my list is an issue tracker. It's integrated into my workflow, but not necessarily my other tools. This is an area I'm exploring. If you have tips, please let me know.

# Wrap Up

Productivity is something you can teach yourself in less than a week. These techniques work for me, but they aren't an end all be all solution. I'm constantly evolving my techniques and tools, I just hope my trials can help you.

