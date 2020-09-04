@extends('_layouts.master')

@php
// Metadata fixup
$page->title = 'PGP Key 4D8BD439';
$page->meta_description = 'Information about PGP key 4D8BD439 used by Jeff Carouth';
$page->template = 'page';
@endphp

@push('meta')
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $page->meta_description }}" />
@endpush

@section('body')
<div class="max-w-5xl mx-auto px-10 py-4 bg-ghost-white">
    <h1>PGP Key</h1>

    <p class="mb-6">I use PGP and encourage you to as well. This page lists my PGP keys and their fingerprints. However, this page should not be considered an authoritative source; this page is for reference only. Please use a fingerprint obtained in person for signing purposes.</p>

    <h2>Active PGP Keys</h2>

    <p class="mb-6">My PGP key is listed below and is also published on <a href="http://hkps.pool.sks-keyservers.net/pks/lookup?op=vindex&search=0xE5DAD6A04D8BD439">the SKS keyservers</a>.</p>

    <img src="/assets/img/pgp-key-4D8BD439.png"
         alt="PGP Key 4D8BD439"
         class="mx-auto">

    <p class="mb-6 text-center"><strong>Key ID:</strong> <a href="/.well-known/4D8BD439.txt">4D8BD439</a></p>

    <h2>Key Signing Policy</h2>

    <p class="mb-6">I believe key signing to be a critical part of building the Web of Trust and in furthering the necessary adoption of encryption. As such, I am willing to sign keys whose fingerprints I have received in person, accompanied by relevant identifying documents.</p>

    <p class="mb-6">If you want me to sign your key here is procedure I wish to follow:</p>

    <ol>
        <li>We meet in person at a pre-arranged time and place.</li>
        <li>You bring the following:
            <ul>
                <li>A printed copy of your key fingeprint (the output of `gpg --fingerprint`). A hand-written copy is acceptable.</li>
                <li>A government-issued photographic ID. Preferably two forms of ID, only one of which should be government-issued.</li>
                <li>The UIDs you want me to sign. It's preferable if at least your primary UID matches your legal name as printed on your photographic ID. I will only sign UIDs you ask me to sign.</li>
            </ul>
        </li>
        <li>If you are also willing to sign my key, I will bring the appropirate documents to comply with this policy.</li>
        <li>I will verify your IDs and mark the printed fingerprint in your presence to indicate it came from you.</li>
        <li>Upon returning home I will retrieve your key from a public keyserver and verify it matches the fingerprint given to me by you. (Please have your key available on the SKS keyservers if possible.)</li>
        <li>I will sign each UID request and encrypt it to your key, sending only the signature on each UID to the corresponding email address.</li>
    </ol>

    <p class="mb-6">Note that I do reserve the right to not sign your key if I am still unsure about your identity. This should be rare, but I will tell you whether you should be able to expect a signed key after we meet.</p>

    <h3>Trust Levels</h3>

    <p class="mb-6">My personal policy for the various trust levels follows:</p>

    <ul>
        <li>sig0 - I do not sign keys at this level.</li>
        <li>sig1 - I will sign company or organization keys at this level. I do not sign personal keys at sig1.</li>
        <li>sig2 - I will sign UIDs that are not associated to an email address (e.g., photo UIDs) as sig2.</li>
        <li>sig3 - A signature pursuant to the procedure outlined above (assuming at least two forms of identification are provided) will be a level 3 signature. I will not sign keys of anyone I have not met in person at this level.</li>
    </ul>

    <h3>Conference signatures</h3>

    <p class="mb-6">I am willing to sign keys at conferences. If you are interested in getting your key signed by me at a conference where there is no formal (official or otherwise) keysigning event, please contact me via Twitter <a href="https://twitter.com/jcarouth">@jcarouth</a> or email. Twitter is preferable as I will likely be paying more attention to that medium than email. I prefer if you contact me prior to a break (lunch, in-between sessions, the after party, etc.) and arrange for us to meet somewhere where we can get through the verification peacefully.</p>

    <p class="mb-6">I will make an effort to sign keys while at the conference, but at a minimum I will sign any keys I've agreed to sign within two weeks of returning home from the conference.</p>
</div>
@endsection
