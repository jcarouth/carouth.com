---
extends: _layouts.post
section: content
title: "Windows 10 Development Environment: Setting up Git"
date: 2020-05-10
description: 
featured: true
categories: [Development, Windows10, git, PGP]
excerpt: I haven't really used Windows since 2008 or so but I recently built a new PC and wanted to see what it would be like to work on Windows. This article covers how I set up git natively in PowerShell.
published: true
---
I recently built a PC for myself and decided that after a long time of not using Windows I would give it a shot. I think I switched to a Linux desktop around the time Vista came out and have been using Linux and OS X professionally and personally since then. Over the summer of 2019 I played around with building a development environment on a computer I was setting up for my son, but didn't give it the attention it needed and abandoned that project quickly. Fast forward to today and I have a machine I'd like to build into a usable environment for me so I wanted to do things "right." The first order of business is to have the ability to write this blog.

## Requirements

This blog uses Jigsaw and the source is hosted in Github. To work on it effectively I need the ability to edit Markdown, PHP, and JavaScript files. But before I get there I need to pull the source down from Github. So I decided to start there.

The short checklist includes:

- [ ] Configure SSH and set up my SSH keys
- [ ] Set up GPG for signing git commits
- [ ] Install git for use in a terminal
- [ ] Pull down the source and open it in an editor

I am saving setting up PHP and such for another day.

## Configuring SSH keys

Without getting into SSH key management suffice it to say that I have a couple of keys that I use in different scenarios to connect/auth with various services. The main concern for this step is to configure SSH with an identity file that is attached to my Github profile. For ease of understanding we'll assume it is named `id_rsa-github`. I did a lot of searching to try and figure out how to configure SSH on a Windows machine. Last time I went through this the default answer was "Install putty," but I had hopes I could natively ssh from a shell.

Taking the advice I give a lot of people I decided to just try it. I had installed a program called the [Windows Terminal](https://www.microsoft.com/en-us/p/windows-terminal-preview/9n0dx20hk701?activetab=pivot:overviewtab) (which appears to be in some sort of preview period) to allow me to open various terminals including PowerShell. So I started there, opened up a PowerShell and typed in `ssh` fully expecting an error. Instead I was greeted with ssh usage.

Next step was trying to figure out where to put the config. On Linux/OS X I have a file in `~/.ssh/config` that configures some of my preferred options for SSH and also any host-specific things like usernames and managing identity files. Much to my delight the file I ended up creating is at `~/.ssh/config` (which is actually `C:\Users\jcaro\.ssh\config` on my machine) and is identical to the one I have in my dotfiles.

At this point I was feeling rather confident so I copied in my SSH key and made sure it was configured as the default IdentityFile for `Host *` and sent the ssh test command `ssh -T git@github.com`. It worked! But I had to input the passphrase on the key every time. I was expecting to be able to put this into `ssh-agent` which was not working.

### The OpenSSH Authenticat Agent (ssh-agent)

I tried to run `ssh-add ~/.ssh/id_rsa-github` with hopes my lucky streak would continue, but it failed.

```
PS C:\Users\jcaro> ssh-add C:\Users\jcaro\.ssh\id_rsa-github
Error connecting to agent: No such file or directory
```

After a little research I learned that the ssh-agent was not running. The documentation on github seems to point to either using the shell provided by GitHub Desktop or adding some code to handle running the agent on load when you open bash or a Git shell. I was hoping for something a little more "native" to the PowerShell environment, so my search continued.

I landed on a page which suggested I look for a service `ssh-agent`.

```
PS C:\Users\jcaro> Get-Service ssh-agent

Status   Name               DisplayName
------   ----               -----------
Stopped  ssh-agent          OpenSSH Authentication Agent
```

This was my problem. The OpenSSH Authentication Agent was not running. In fact it is disabled.

```
PS C:\Users\jcaro> Get-Service ssh-agent | Select StartType

StartType
---------
Disabled
```

The remedy for this is to set it to automatically start. (You could choose Manual if you wanted to go through the trouble of manually starting the agent whenever you needed it.) To do so you need to launch a PowerShell as an Administrator and run:

```
PS C:\WINDOWS\system32> Get-Service -Name ssh-agent | Set-Service -StartupType Automatic
```

You might have to run `Start-Service ssh-agent` if it doesn't automatically start in your current terminal, but after doing that it seems to be working flawlessly for me. A final check and I confirm ssh is configured the way I need it to be for GitHub.

```
PS C:\Users\jcaro> ssh -T git@github.com
warning: agent returned different signature type ssh-rsa (expected rsa-sha2-512)
Hi jcarouth! You've successfully authenticated, but GitHub does not provide shell access.
```

## GNU Privacy Guard for Windows

I like to sign all of my commits. I've never had occasion to need to prove that I actually wrote one of them but it's a nice gesture nonetheless. To do that I use a [PGP Key](https://carouth.com/pgp/) where I've built some trust with fellow community members. I set out to figure out how to set this up to work in the Windows CLI.

I landed on the [Gpg4win project homepage](https://gpg4win.org/index.html) and went ahead and downloaded the installer. Went through the installtion and checked the boxes I thought sounded reasonable and then had the project installed. I opened up Kleopatra and imported my existing key file. So far so good.

Now I knew I needed to have gpg commands available to me in PowerShell, and building on my previous success, I opened a new terminal window, crossed my fingers, and executed:

```
PS C:\Users\jcaro> gpg --version
gpg: The term 'gpg' is not recognized as the name of a cmdlet, function, script file, or operable program.
Check the spelling of the name, or if a path was included, verify that the path is correct and try again.
```

It didn't work. Also `which gpg` and `echo $PATH` are not helpful in case that's what you're thinking. However `$Env:Path` does what I needed and, as expected, the bin directory created by the Gpg4Win installer was not listed. Adding it is fairly straightforward and did the trick.

```
PS C:\Users\jcaro> Set-Item -Path Env:Path -Value ($Env:Path + ";C:\Program Files (x86)\GnuPG\bin")

PS C:\Users\jcaro> gpg --version
gpg (GnuPG) 2.2.19
libgcrypt 1.8.5
Copyright (C) 2019 Free Software Foundation, Inc.
License GPLv3+: GNU GPL version 3 or later <https://gnu.org/licenses/gpl.html>
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.

Home: C:/Users/jcaro/AppData/Roaming/gnupg
Supported algorithms:
Pubkey: RSA, ELG, DSA, ECDH, ECDSA, EDDSA
Cipher: IDEA, 3DES, CAST5, BLOWFISH, AES, AES192, AES256, TWOFISH,
        CAMELLIA128, CAMELLIA192, CAMELLIA256
Hash: SHA1, RIPEMD160, SHA256, SHA384, SHA512, SHA224
Compression: Uncompressed, ZIP, ZLIB, BZIP2
```

## Setting up Git

Making good progress, the next step is to get `git` set up and configured. Obtaining the installer is a simple [download](https://git-scm.com/downloads) away. There was a maze of options in the installer (way more than I am used to with `brew install git` or `apt-get install git`) but I survived okay. After doing this `git` was available in PowerShell and all I needed to do was configure it.

My standard configuration involves setting up the global config which I have a `.gitconfig` file in my dotfiles and I just copied it over to `~/.gitconfig` and edited it to remove some OS X-specific things (such as Kaleidoscope as a merge/diff tool.) If I did not have this the basic config would look like this:

```
git config --global user.name "Jeff Carouth"
git config --global user.email "jcarouth@gmail.com"
git config --global commit.gpgsign true
```

The one thing I had to add since I do not have it set up in my shared dotfiles for some reason is to actually set the signing key:

```
gpg --list-secret-keys --keyid-format LONG
git config --global user.signingkey <key-id-from-previous-command>
```

## Getting the source

Now I just needed to pull down the blog source, and, given I wrote this article on this newly-configured machine, that was a success.

```
PS C:\Users\jcaro\projects> git clone git@github.com:jcarouth/carouth.com.git
Cloning into 'carouth.com'...
remote: Enumerating objects: 16, done.
remote: Counting objects: 100% (16/16), done.
remote: Compressing objects: 100% (12/12), done.
remote: Total 5376 (delta 3), reused 9 (delta 3), pack-reused 5360
Receiving objects: 100% (5376/5376), 2.96 MiB | 4.02 MiB/s, done.
Resolving deltas: 100% (3056/3056), done.

PS C:\Users\jcaro\projects> code .
```

## gpg: skipped "...": No secret key

After editing this portion of the article I attempted to commit but was met with an error stating my secret key could not be found and thus was skipped. This was very confusing considering the output of `gpg --list-secret-keys --keyid-format LONG` clearly shows the key configured correctly and that same ID is the one I configured with git. Did quite a bit of searching around and figured out the problem is the the GPG executable git is trying to use. The problematic output is:

```
PS C:\Users\jcaro\projects\carouth.com> git config --global user.signingkey E5DAD6A04D8BD439
PS C:\Users\jcaro\projects\carouth.com> git commit -m "Add Win10 git set up post"
gpg: skipped "E5DAD6A04D8BD439": No secret key
gpg: signing failed: No secret key
error: gpg failed to sign the data
fatal: failed to write commit object
```

To fix this I had to look up the path of the gpg.exe program installed by Gpg4win. 

```
PS C:\Users\jcaro\projects\carouth.com> Get-Command gpg | Select Source

Source
------
C:\Program Files (x86)\Gpg4win\..\GnuPG\bin\gpg.exe
```

Then tell git to use this executable as the `gpg.program`:

```
PS C:\Users\jcaro\projects\carouth.com> git config --global gpg.program "C:\Program Files (x86)\GnuPG\bin\gpg.exe"
PS C:\Users\jcaro\projects\carouth.com> git commit -m "Add Win10 git set up post"
[add-win10-git a1375aa] Add Win10 git set up post
 1 file changed, 186 insertions(+)
 create mode 100644 source/_posts/windows10-dev-environment-git.md
```

 At that point I was able to update this post and push the changes.

```
PS C:\Users\jcaro\projects\carouth.com> git push origin add-win10-git
Warning: Permanently added the RSA host key for IP address '140.82.114.4' to the list of known hosts.
Enumerating objects: 8, done.
Counting objects: 100% (8/8), done.
Delta compression using up to 12 threads
Compressing objects: 100% (5/5), done.
Writing objects: 100% (5/5), 5.71 KiB | 5.71 MiB/s, done.
Total 5 (delta 3), reused 0 (delta 0), pack-reused 0
remote: Resolving deltas: 100% (3/3), completed with 3 local objects.
remote:
remote: Create a pull request for 'add-win10-git' on GitHub by visiting:
remote:      https://github.com/jcarouth/carouth.com/pull/new/add-win10-git
remote:
To github.com:jcarouth/carouth.com.git
 * [new branch]      add-win10-git -> add-win10-git
```

## Git set up in PowerShell: Success

Overall I am satisified with this configuration/set up. While it isn't quite as seamless a transition from OS X to PowerShell in Windows 10 I think it is workable. Hopefully this will help someone else moving to Windows 10 if they want a similar experience. The next step for me is to figure out if this works seamlessly with VS Code and/or other editors/IDEs like PHPStorm or RubyMine.
