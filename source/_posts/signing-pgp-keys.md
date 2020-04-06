---
extends: _layouts.post
section: content
title: Signing PGP Keys
date: 2014-05-25
featured: true
categories: [Security]
excerpt: Signatures and trust make PGP keys and the network of keyservers useful. In this post I will walk you through how I sign PGP keys to hopefully help you in your process.
---
At the [php\[tek\] keysigning and PGP open space](http://carouth.com/blog/2014/05/04/keysigning-at-php-tek-2014/) the question of how to actually sign keys came up. I had planned to write this post anyway, but now seems like as good a time as any. What follows is my process for verifying keys and how I go about signing after I've verified.

## Verification

As far as verifying a person's key I have two different pieces of information I need to verify. The first is the key itself, to ensure that it is the key the person wants me to sign; and the second is the person's identity, to ensure that that person is identified by the UID(s) on the key. There is also a slight difference depending on signing context. If I'm signing the key in the context of a keysigning party or other organized signing event, my strategy or procedure is slightly different than if I'm signing a person's key individually. I will outline both below.

### Verifying a key individually

When someone asks me to verify his or her key, I ask that person to provide me a written or printed copy of the key's fingerprint, ID, size, type and UID(s) they want me to sign. That last requirement is a fuzzy requirement. It's easiest to use the [OpenPGP key paper slip generator](http://openpgp.quelltextlich.at/slip.html) and bring the slip with you. 

The reason I ask for a paper copy of this information is to ensure the key I eventually sign is actually the key you want me to sign. If you provide the key information electronically, there is a chance someone altered the information. Getting it directly from you, in person, on paper is the best way I know to ensure it is your key details.

After you give me your key information on paper, I will ask you, "is this the ID, fingerprint, and details of the PGP key you want me to sign?" I do this to get a verbal confirmation that you checked the information against your local copy of your key. Once you confirm this I will initial the paper slip so I know I asked.

The next step is to verify that you are the person you say you are. This requires checking identification. While it is placing some level of trust in the various governments of the world, I require checking one photo identification that is government issued. This could be a driver's license, an identification card, a passport, or similar. While I don't possess the ability to truly verify the authenticity of every government-issued identification card, I am willing to accept these on "faith."

I then request a second form of identification. This could be as simple as a business card from your company or something similar. When at conferences, I will accept your conference badge if it was printed by the conference as these are typically based on billing information or at least require some forethought if you are trying to dupe me. When not at a conference anything will do, with or without picture. Just some form of secondary identification.

After all of that, I will place a mark by each UID I am asked to sign indicating the ID matches. For picture UIDs I will check them later but I only sign photo UIDs at level 2.

The final verification happens later when I actually go to sign the key. I will cover that in the Signing section below.

### Verifying a key in a group setting

In a group setting, such as a keysigning party, the paper slips are often not required based on how the party is organized. If keys are submitted ahead of time and printed in a list form verifying that the key matches can be as simple as each person reading off his or her key information. If the key information read aloud matches that person's information on the sheet I consider that good enough as verification.

The rest of the verification is the same as individual verification.

## Signing

After going through all the work of verification, I have extreme motivation to actually sign the key. This seems to be in contrast to other people who simply fail to follow through.

There is one caveat here. It is possible to go through the work and still not be convinced the key belongs to the person you met for one reason or another. For me this could happen if I don't think the ID card is real, the photo doesn't look enough like the person, or the secondary ID doesn't match.

When I get ready to sign the key, I pull in a copy from the keyservers or via a shared key ring if provided by the event or similar. I then check the fingerprint and key details for the key I obtained against the initialed slip or party worksheet. If these all match, I'm ready to sign.

The actual process for signing is the same for both single- and multiple-UID keys. The amount of work is a little different. The process looks like this:

- Import key into keyring
- Verify fingerprint and details match paper slip
- Use `gpg` to sign UID
- Export signed public key
- Encrypt exported key for the UID signed
- Email the encrypted, signed key to the email address associated with the signed UID

The following sections will show the specific commands needed to accomplish this process.

### Single UID

Importing the key into my keyring is accomplished with the `--import` command. Suppose we are working with a key for UID/email address someone@example.com.

```bash
gpg --import someone@example.com
```

I could, of course, replace the 'someone@example.com' with the key ID, or even import from a file or from the paste buffer.

Now to actually sign, the `--sign-key` command is used.

```bash
gpg --ask-cert-level --sign-key someone@example.com
```

This will bring up the gpg interface which should look as follows:

```bash
→ gpg --ask-cert-level --sign-key someone@example.com

pub  2048R/521A3B7C  created: 2014-03-31  expires: 2018-03-31  usage: SC
                     trust: unknown       validity: unknown
sub  2048R/EA195394  created: 2014-03-31  expires: 2018-03-31  usage: E
[ unknown] (1). Someone Special <someone@example.com>


pub  2048R/521A3B7C  created: 2014-03-31  expires: 2018-03-31  usage: SC
                     trust: unknown       validity: unknown
 Primary key fingerprint: B25F 2DAA 8C20 927D 5A72  A239 656E C97E 53FB 2C6D

     Someone Special <someone@example.com>

This key is due to expire on 2018-03-31.
How carefully have you verified the key you are about to sign actually belongs
to the person named above?  If you don't know what to answer, enter "0".

   (0) I will not answer. (default)
   (1) I have not checked at all.
   (2) I have done casual checking.
   (3) I have done very careful checking.

Your selection? (enter `?' for more information):
```

Answer this prompt following your policy. For this example case I will sign with level 3 since I did some careful checking. Some people have the policy to only sign level three if they have known the person for several years. Others are more lax. I suggesting picking a policy for yourself and sticking to it. This is the best way to ensure people know what it means when you sign something at each level.

Entering '3' will then proceed with the signing process.

```bash
Your selection? (enter `?' for more information): 3
Are you sure that you want to sign this key with your
key "Jeff Carouth <jcarouth@gmail.com>" (4D8BD439)

I have checked this key very carefully.

Really sign? (y/N)
```

Entering 'y' will prompt you to enter the passphrase for your private key and complete the signing for this single-UID key.

```bash
Really sign? (y/N) Y

You need a passphrase to unlock the secret key for
user: "Jeff Carouth <jcarouth@gmail.com>"
4096-bit RSA key, ID 4D8BD439, created 2014-03-22

```

Now the key is signed by me. To check this signature you can use `--list-sigs`.

```bash
→ gpg --list-sigs someone@example.com
gpg: checking the trustdb
gpg: 3 marginal(s) needed, 1 complete(s) needed, PGP trust model
gpg: depth: 0  valid:   1  signed:   0  trust: 0-, 0q, 0n, 0m, 0f, 1u
gpg: next trustdb check due at 2015-08-18
pub   2048R/521A3B7C 2014-03-31 [expires: 2018-03-31]
uid                  Someone Special <someone@example.com>
sig 3        521A3B7C 2014-03-31  Someone Special <someone@example.com>
sig 3        4D8BD439 2014-05-25  Jeff Carouth <jcarouth@gmail.com>
sub   2048R/EA195394 2014-03-31 [expires: 2018-03-31]
sig          521A3B7C 2014-03-31  Someone Special <someone@example.com>
```

As you can see, the key for 'someone@example.com' now has a signature from me listed on the key. The key is now considered signed. The next step is to distribute this signed key, which will be covered below.

### Multiple UIDs

A key with multiple UIDs slightly complicates this process, because if you sign all UIDs at once and send the signed key to one or all of them, you lose the security of knowing the person has access to each email address. In essence you are giving away signatures for free without knowing if the person actually owns the addresses or the private key.

Signing each UID actually follows the same process, but it must be done one time for each UID. The process starts a little differently, in that the first prompt you will see asks if you want to sign all the UIDs.

```bash
→ gpg --sign-key --ask-cert-level someone@example.com

pub  2048R/521A3B7C  created: 2014-03-21  expires: never       usage: SCEA
                     trust: unknown       validity: unknown
[ unknown] (1). Someone Special <someone@example.com>
[ unknown] (2)  Someone Special <someone@something.net>

Really sign all user IDs? (y/N)
```

Answering this question 'N' will then give you the 'gpg>' prompt.

```bash
Really sign all user IDs? (y/N) N
Hint: Select the user IDs to sign

gpg>
```

This is where you select the UID, by number, you wish to sign. In our case we will sign the first UID first, so we enter 1.

```bash
gpg> 1

pub  2048R/521A3B7C  created: 2014-03-21  expires: never       usage: SCEA
                     trust: unknown       validity: unknown
[ unknown] (1)* Someone Special <someone@example.com>
[ unknown] (2)  Someone Special <someone@something.net>

gpg>
```

The next step is to tell gpg we want to sign the selected UID with the `sign` command which is the same process as above but instead of exiting, it will drop you into the `gpg>` prompt. The command you want is to `save` and it will write the signature to the key.

Now you follow the procedure for exporting and encrypting the public key just as in a single-UID situation. After doing this you want to remove the key from your keyring using the `--delete-key`.

```bash
→ gpg --delete-key someone@example.com
gpg (GnuPG) 1.4.16; Copyright (C) 2013 Free Software Foundation, Inc.
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.


pub  2048R/521A3B7C 2014-03-21 Someone Special <someone@example.com>

Delete this key from the keyring? (y/N) Y
```

Now that key will be removed from your keyring. You then import the key again which will not have the signature you made above on the first UID and complete the same process for each of the other UIDs you are signing.

Once you are finished signing all UIDs, follow the same process for distributing the signed key back to its owner.

## Distributing the signed key

My process for distributing a signed key involves exporting the key into ascii-armored form, encrypting that file for the UID you signed, and emailing the encrypted, signed key to the email address for the UID. Doing this, I am checking two different things: 1) that the person I talked to actually has access to the email address associated with the UID; and 2) that the person who can access the email address has access to the private key for that UID. If neither of those two things are true, my signature will never make it onto a public key server.

The first step in this process is to export the signed public key and then encrypt it for the.

```bash
gpg --armor --export someone@example.com > ~/tmp/someone_at_example.com.asc
gpg --sign --encrypt --recipient someone@example.com ~/tmp/someone_at_example.com.asc
```

Alternatively, all in one:

```bash
gpg -a --export someone@example.com | gpg -se -r someone@example.com > ~/tmp/someone_at_example.com.asc.pgp
```

This should create a file located at `~/tmp/someone_at_example.com.asc.pgp` which is the encrypted, ascii-armored, signed public key for someone@example.com. Someone with access to the private key for that UID should be able to decrypt the file and no one else. It is also a signed file, meaning the person who receives it can verify it came from me by checking the signature.

At this point you should have an encrypted, signed public key file for each UID you signed. To distribute the key back to its owner all you have to do is email that file to the person (at the UID email address.)

The alternative here is to not encrypt the file and simply push it up to a keyserver. I advise against this because it reduces the confidence in the person actually owning the key and email address.

## Receiving a signed key

If you are on the receiving end of this exchange of signed keys you should push the signed key up to the keyserver. But, to do that you must first decrypt it.

```bash
gpg --decrypt someone_at_example.com.asc.pgp
```

Decrypting the file should create one named `someone_at_example.com.asc` which can then be imported into your keychain and pushed to the key server.

```bash
gpg --import someone_at_example.com.asc
gpg --send-keys 521A3B7C
```

Now your UID(s) which were signed in that file should be updated on the key servers. Note that you can do this any number of times and it won't overwrite your key, it will simply update it. So if you have, for exmaple, three UIDs and you get three separate key files to three different emails, you can run this import and send-keys process for each one, or you can import them all and then send afterwards.

## Fin

Signing PGP keys is important and while it might seem somewhat complicated is actually just a few steps. I highly encourage you to participate in keysigning events at a conference near you, or to sign keys of people you know outside of a larger event. Hopefully the above explanation of the process helps.
