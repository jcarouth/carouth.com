---
author: jcarouth
date: '2011-06-11 10:54:12'
layout: post
slug: snipmate-via-pathogen-woes
status: publish
title: snipMate via Pathogen woes
wordpress_id: '277'
categories:
- Vim
tags:
- pathogen
- snipmate
- vim
---

In my quest to become more proficient with Vim I came across many people touting the joys of using SnipMate. I thought I should give it a try and pulled it into my configuration via Pathogen. That's where the fun stopped. I spent a few hours trying to get it to work and followed the advice on many blogs. I was able to see that the necessary .vim scripts were parsed and that the `<tab>` key was mapped correctly. But I could not get the snippets towork.

After symbolically linking the files into the root of my .vim directory, snipMate worked like a champ. It blew my mind, I just wanted it to work.

Then I figured it out. Part of one of the blogs I followed had me add `letg:snippets_dir = $HOME . "/.vim/snippets"` to my .vimrc file. The issue I was having was staring me in the face. Before I symbolically linked the snippets directory into my .vim directory, snipMate couldn't find any snippet definitions to use, so it obviously wouldn't work.

My solution is to instead add .vim/snippets to the rtp. Works like a champ. I now have the default snippets and my custom snippets.

`let rtp += $HOME . "/.vim/snippets"`

