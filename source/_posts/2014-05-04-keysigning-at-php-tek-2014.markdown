---
layout: post
title: "Keysigning at php[tek] 2014"
date: 2014-05-04 18:49:27 -0500
comments: true
categories: 
- GPG/PGP
---
With the introduction of [keybase.io](http://keybase.io), many people, myself included, are being introduced or re-introduced to the idea of cryptographic privacy through encryption and decryption using PGP keys. Keybase.io is nice, but there is an existing world, or Web of Trust that should also be considered. This is especially true as Keybase.io does not follow the same principles in terms of the Web of Trust and could arguably be competing with the ideas. That argument or discussion is for another day.

This post is about my desire to include keysigning at PHP conferences. As [php\[tek\]](http://tek.phparch.com) is the next conference for me, I hope to start there. What I am proposing is an unofficial keysigning event at php[tek] 2014.

## Keysigning Party

There are several existing protocols a keysigning party could follow. There are also some good ideas I am discussing with [Joshua Thijssen](https://twitter.com/JayTaph) but for the time being, given the timeline, I would like to follow the following procedure:

1. Any interested individuals email me a copy of your public key (details and instructions below).
2. I will compile these keys into a keyring. From that keyring I will generate a list of participating individuals and bring copies with me to php[tek] 2014.
3. At a pre-arranged time and place all participating individuals will gather and verify their own fingerprint as well as all identities and fingerprints of the other participants.
4. After the event and/or after php[tek] participants will sign and distribute keys they have verified at the event. Please do so before July 31, 2014.

### How to participate

#### Generate a key pair

If you do not have a key pair, now is the time to generate one. There are numerous resources online to help you with this process including [PGP Setup by Phil Dibowitz](http://www.phildev.net/pgp/gpgkeygen.html) and [Creating the Perfect GPG Keypair by Alex Cabal](https://alexcabal.com/creating-the-perfect-gpg-keypair/). Follow either of those guides, or find a different one you prefer.

The basic command to do this is:

```
gpg --gen-key
```

#### Email your public key

Email a copy of your public key to me (my email address is listed on [my github profile](https://github.com/jcarouth)). To do this you need to export your public key as follows:

```
$ gpg --armor --export you@example.com > you_at_example_key.txt
```

Make sure you replace 'you@example.com' with your email address and you can name the file anything you like.

At this time you should also upload your public key to a keyserver. This makes it easier on people trying to find your key later and is a good idea if you want to actually use your key for email encryption and such. Do that by issuing this command:

```
$ gpg --keyserver hkp://pool.sks-keyservers.net --send-keys you@example.com
```

#### Print a copy of your key information

At the party you will need to know your key size, key id, and key fingerprint. You can obtain this information by running the command which follows. You should print the output and bring it with you to the event.

```
$ gpg --fingerprint you@example.com
```

Alternatively, there is an [online tool](http://openpgp.quelltextlich.at/slip.html) that can generate a set of key fingerprint cards for you. (This assumes your key is available publicly via a keyserver.) 

#### Show up at php[tek] and participate in the keysigning

Now all you have to do is make it to the conference and participate. The actual keysigning will happen after the event. **Note: No computers are allowed to be used during the keysigning party.** This might seems strange, but it helps eliminate distractions, making the whole thing happen as quickly as possible, and it avoids the possibility of nefarious access to your keys–think keyloggers, over the shoulder, etc.

I will post a second blog post detailing how to go about signing keys including links to more thorough documentation.

#### For more information

For much more information about the concept in general, as well as a reference to another keysigning event, please see the [SCALE12x Keysigning Party page](https://www.socallinuxexpo.org/scale12x/pgp-key-signing-party).

### Please participate

By participating in this event you will help grow the overall Web of Trust as well as increase the strength of that web within the PHP community. If you have questions or concerns, email me, find me on twitter [@jcarouth](https://twitter.com/jcarouth), leave a comment here, or hop into #phpmentoring on Freenode.
