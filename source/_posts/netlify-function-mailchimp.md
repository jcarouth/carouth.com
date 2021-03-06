---
extends: _layouts.post
section: content
title: Custom Mailchimp Subscription Form using Netlify Functions
date: 2021-02-23
description:
featured: false
categories: [Netlify, AlpineJS, Mailchimp]
excerpt: Do you want to connect your Netlify-hosted site to Mailchimp subscription forms without using the embedded forms? Read how you can do it with Netlify Functions and AlpineJS.
twitter_image: netlify-function-mailchimp.png
---
One drawback to static sites is you are often limited in what you can interact with for various reasons. For example, if you want to create a custom signup form and add subscribers to your Mailchimp mailing list through the API, you can't do it directly from the browser. The Mailchimp API does not support CORS requests for "security reasons." (Basically they don't want you exposing your API credentials to the whole world. Which, if I'm being honest, is quite thoughtful of them.)

Taken from Mailchimp's [Marketing API Quick Start](https://mailchimp.com/developer/marketing/guides/quick-start/):
> Because of the potential security risks associated with exposing account API keys, Mailchimp does not support client-side calls to the Marketing API using CORS requests, nor should API keys be used in mobile apps.

If you want to have a subscription form on your static site on Netlify for a Mailchimp list, you have a couple options:

1. Use an embedded form from Mailchimp;
2. Use Netlify Forms and connect your form to Mailchimp via a Zapier Zap.

Number 1. works okay if that's the route you want to go; you can even style the form to match your branding. Number 2. is also a viable option, but has the drawback of needing to sign up for yet another service (and likely pay for it.) Depending on what you're doing that might be an acceptable solution as well.

But if you're like me and working on a project that isn't set to recoup the costs of services like that, I have another solution in mind. We are going to build a small form powered by AlpineJS; which submits to a Netlify Function (really just an AWS Lambda function;) which, in turn, interacts with the Mailchimp API server(less) side.

## The Form

Like any low-friction UI, we want a form that collects the bare minimum amount of information to, hopefully, increase conversions. We will make a form which has one field, "Email", and a button, "Subscribe". That form will look like this:

![Email subscribe form shown near footer of website](/assets/img/posts/netlify-function-mailchimp/form-screenshot.png)

The corresponding markup—styled with TailwindCSS—for this form is show below.

```html
<div class="max-w-4xl md:flex mx-auto py-8 md:space-x-6">
  <div class="w-full md:w-2/5">
    <h3 class="text-3xl md:text-4xl font-semibold">
      Join the Newsletter
    </h3>
    <p class="mt-4 text-lg">
      Get up to date information and other random tidbits from us. You know you want to.
    </p>
  </div>
  <div class="w-full md:w-3/5 mt-8 md:mt-0 flex flex-col justify-center">
    <form name="newsletter-subscribes" method="POST" action="/" data-netlify="true">
      <div class="mb-4 px-2 py-1 bg-white border-4 border-white font-semibold text-gray-800">
        <span>Thanks for subscribing! Check your email to confirm.</span>
      </div>
      <div class="flex">
        <label class="sr-only">Email:</label>
        <input class="flex-1 px-2 py-1 border-0 bg-white text-gray-800" type="email" name="email"
               placeholder="Your Email Address" required>
        
        <button type="submit" class="px-6 py-1 bg-gray-800 text-white">
          <span>Subscribe</span>
        </button>
      </div>
    </form>
  </div>
</div>
```

As written, this form will collect email addresses via Netlify Forms in a form named "newsletter-subscribes". You could wire this up to Mailchimp via Zapier or otherwise process it into email subscribes if that is sufficient for your application.

There are a couple of elements in place because we'll need them for some interaction later: namely the success notification and the button label "Subscribe" is wrapped in a span. I'm jumping ahead of the class a little.

### Interactivity with AlpineJS

Assuming you have installed AlpineJS and configured it, the basic interaction we need to add to this form is to handle the submit event and show/hide a message. To start with we need a data object. I'm going to introduce a loading state for use with a slower connection to the server. For now, the submit button will toggle the loading state on and off with each press.

```html
<div x-data="{ loading: false }">
  ...
  <div class="...">
    <form>
      <div>...</div>
      <div class="flex">
        ...
        <button @click.prevent="loading = !loading">
          <span x-cloak x-show="loading">Loading...</span>
          <span x-show="!loading">Subscribe</span>
        </button>
      </div>
    </form>
  </div>
</div>
```

The next step is to add an actual submit state that does something other than just toggles the loading property. When I'm working with something like this I try and take as many variables out of the picture as possible. I want to effectively stub the real responses I want to get from my endpoint with code. In this case I have a couple of conditional responses:

1. The user subscribes and is a new subscriber
2. The user is already subscribed
3. The user attempts to subscribe but fails for some reason

To stub this behavior in my code I will use three different email addresses.

1. new@email
2. existing@email
3. error@email

These magic strings will handle the state within my alpine data object. Speaking of the data object I'm going to extract it and build from there.

```html
<script>
  let subscribeForm = function() {
    return {
      loading: false
    }
  }
</script>

<div x-data="subscribeForm()">
  ...
</div>
```

Now to make use of my plan, I need to swap out the simple expression for my click handler with a function. I will name it `submit()` to make it easier to connect the dots mentally.

```html
<script>
  let subscribeForm = function() {
    ...
    submit() {
      this.loading = !this.loading;
    }
  }
</script>

<div x-data="subscribeForm()">
  ...
  <form>
    <button @click.prevent="submit()">...</button>
  </form>
</div>
```

To wire the form's UI to the data object we will need a couple more properties. Namely we need one property to bind to the email input field, `email`, and we need a second to store a message indicating whether the sign up was successful or resulted in an error, `message`. The message will be bound to the element which currently reads "Thanks for subscribing! Check your email to confirm.".

```html
<div class="max-w-4xl md:flex mx-auto py-8 md:space-x-6">
  ...
  <div>
    <form">
      <div x-cloak x-show="message" class="mb-4 px-2 py-1 bg-white border-4 border-white font-semibold text-gray-800">
        <span x-text="message">Thanks for subscribing! Check your email to confirm.</span>
      </div>
      <div class="flex">
        <label class="sr-only">Email:</label>
        <input x-model="email" class="flex-1 px-2 py-1 border-0 bg-white text-gray-800" type="email" name="email"
               placeholder="Your Email Address" required>
        ...
      </div>
    </form>
  </div>
</div>
```
We need to update our data object to reflect the additional pieces of data, email and message, as well as improve the submit handler to something that can let us test the form. For this step we can use the hardcoded email addresses outlined above to return messages in place of actual handling. That looks as follows.

```javascript
let subscribeForm = function() {
  return {
    email: null,
    loading: false,
    message: '',
    submit() {
      this.loading = true;

      if (this.email === 'new@email') {
          this.message = 'You have been subscribed. Please check your email.';
      } else if (this.email === 'existing@email') {
          this.message = 'You are already subscribed.';
      } else {
          this.message = 'Error. Just an error.';
      }
      
      this.loading = false;
    }
  }
}
```

At this point our front end is modeled as far as we can go without a real endpoint to hit, so we will move on to the function.

## Setting up for the function

To process the form we will create an endpoint to accept a POST request named `subscribe`. In Netlify this will be a synchronous Lambda function written in JavaScript.

To create a function you need a directory to hold the source and then to specify where that is in your build configuration in Netlify. For my sites I use a netlify.toml file so I will add it there

```ini
[build]
command = "npm run prod"
functions = "functions"
publish = "build_production"
environment = { PHP_VERSION = "7.4" }
```

When the site builds it will take the contents of the directory `./functions/` and put build those as functions answering at `POST /.netlify/<function-name>`. You can write functions in either JavaScript or Go. I chose JavaScript. For this particular endpoint I am going to use the Mailchimp Marketing SDK which is available as a node package. 

The nice thing about the Netlify ecosystem is it can deploy your functions as an ["Unbundled JavaScript functions"](https://docs.netlify.com/functions/build-with-javascript/#unbundled-javascript-function-deploys) whereby the build bot will analyze the function source and pull required dependencies from your `node_modules` directory. This means you can manage dependencies all in one place and don't have to worry about a separate build process for your functions.

### Creating our first function

The simplest Lambda function we can create is a handler which returns an HTTP 200 OK every time. That is what we will start with. I will create a function named hello-how-are-you which responds with HTTP 200 and a nice message.

```javascript
exports.handler = async function(event, context) {
  return {
    statusCode: 200, 
    body: JSON.stringify({message: "I am okay, thanks for asking."})
  }
}
```

Saving that under `functions/hello-hello-how-are-you.js` and building/deploying it allows the following:

```bash
me@computer-machine$ curl -v 'http://localhost:39065/.netlify/functions/hello-how-are-you' -H "Content-Type: application/json" -d "{}"
*   Trying 127.0.0.1:39065...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 39065 (#0)
> POST /.netlify/functions/hello-how-are-you HTTP/1.1
> Host: localhost:39065
> User-Agent: curl/7.68.0
> Accept: */*
> Content-Type: application/json
> Content-Length: 2
>
* upload completely sent off: 2 out of 2 bytes
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< x-powered-by: Express
< date: Tue, 23 Feb 2021 01:12:39 GMT
< connection: close
< transfer-encoding: chunked
<
* Closing connection 0
{"message":"I am okay, thanks for asking."}
```

### Connect the form to this function

With a functional function we can now replace the hardcoded handling of temporary email addresses with a legitimate HTTP request to this function. We will use the [Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API) to do this. (If you happen to already have axios or something else, you could use that just as well.)

We will configure our data object with the endpoint location for the subscribe function. I have renamed it from `hello-how-are-you` to `subscribe` because, while it was cute, it isn't a good name for this function. The rest of the new code is basically boilerplate fetch.

```javascript
let subscribeForm = function() {
  return {
    config: {
      subscribeEndpoint: '/.netlify/functions/subscribe'
    },
    ...,
    submit() {
      this.loading = true;
      
      let self = this;

      fetch(this.config.subscribeEndpoint, {
        method: 'POST',
        body: JSON.stringify({ email: this.email }),
        headers: { 'Content-Type': 'application/json' }
      })
        .then(r => r.json())
        .then(data => {
          self.message = data.message;
        })
        .catch(e => {
          self.message = 'Bummer.';
        })
        .finally(() => {
          self.loading = false;
        })
    }
  }
}
```

All together this now "works". It doesn't do anything interesting like actually subscribe people to a list. But it does post a request and burn Lambda execution time. So there's that.

## Make the Subscribe Function Actually Subscribe

Now we are going to turn our attention to fleshing out the subscribe endpoint to really talk to Mailchimp.

### Dependencies for interacting with Mailchimp

To get this out of the way, we need two node packages to make this work: `@mailchimp/mailchimp_marketing` and `crypto`. The first one, for obvious reasons. The second beacuse I want to use an endpoint that requires a md5 hash of one input.

In the Mailchimp Marketing API docs I found and endpoint to "[Add or update list member](https://mailchimp.com/developer/marketing/api/list-members/add-or-update-list-member/)" which is exactly what I want to use. The two URL parameters required are a `list_id` and a `subscriber_hash` which is the MD5 hash of the lowercase version of the list member's email address. That's what we need `crypto` or a similar package to do.

Installing these via NPM is easy enough, and that's all we need to do to be able to use these in our function.

```bash
npm install @mailchimp/mailchimp_marketing crypto
```

### Configure Mailchimp SDK in the function

We will now update the `functions/subscribe.js` file to require and configure the Mailchimp Marketing API SDK. I will be pulling the API key, Mailchimp server region identifier, and the Mailchimp list id from the ENV. These can be configured either in `netlify.toml` or from within the Netlify UI.

```javascript
const mailchimp = require('@mailchimp/mailchimp_marketing')

const { MAILCHIMP_API_KEY, MAILCHIMP_SERVER_PREFIX, MAILCHIMP_LIST_ID } = process.env

mailchimp.setConfig({
  apiKey: MAILCHIMP_API_KEY,
  server: MAILCHIMP_SERVER_PREFIX,
})

exports.handler = async function(event, context) {
  return {
    statusCode: 200, 
    body: JSON.stringify({message: "I am okay, thanks for asking."})
  }
}
```

There is one gotcha to this whole process. Everyone's favorite feature, CORS. Luckily this is fairly straightforward to handle by responding to a preflight/OPTIONS request with an ok status with appropriate headers we can save ourselves a ton of headaches.

```javascript
//...
const headers = {
  "Access-Control-Allow-Origin": "*",
  "Access-Control-Allow-Headers": "Content-Type",
  "Access-Control-Allow-Methods": "OPTIONS,POST,GET",
}

exports.handler = async function(event, context) {
  // Hello our dear friend, CORS. Nice to see you.
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 204,
      headers
    }
  }
  
  //...snip...
}
```

### Send the request to the add or update API endpoint

The call to `mailchimp.lists.setListMember` needs a list id and a subscriber hash (which is the MD5 hash of the email address) as well as a sepcification for a parameter named `status_if_new`. This allows us to attempt to subscribe any email address and if the address is already registered as part of the list it will do nothing. If they are a new subscriber it will give them the status specified. We are going to use `status_if_new: 'pending'` so that new subscribers will get a confirmation email before they are officially on the list.

```javascript
const mailchimp = require('@mailchimp/mailchimp_marketing')
const crypto = require('crypto')

//...

exports.handler = async function(event, context) {
  //...
  const { email } = JSON.parse(event.body)
  const subscriberHash = crypto.createHash('md5').update(email).digest('hex')
  
  try {
    const response = await mailchimp.lists.setListMember(
      MAILCHIMP_LIST_ID,
      subscriberHash,
      {
        email_address: email,
        status_if_new: 'pending',
      },
      { skipMergeValidation: true }
    )
    
    return {
      statusCode: 200,
      headers,
      body: JSON.stringify({
        status: response.status,
        email: response.email_address,
      })
    }
  } catch (e) {
      return {
        statusCode: 400,
        headers,
        body: JSON.stringify({
          status: 'error',
          error: e.response.body.title,
        })
      }
  }
}
```

With this in place when the Mailchimp API responds with an error it is handled in the catch and will return the error message if we want to use that. Otherwise it returns a successful response and includes the email address from Mailchimp as well as that address' status ('pending', 'suscribed', 'unsubscribed', etc.) This could be useful in the future.

## Adjust Form Submit Handler for Response from Function

We need to do a little clean up of our form submit handler. Earlier we assumed we'd get a message back from the function and simply display that. But that ended up not making a lot of sense to bloat the function with message handling that really belongs as part of the UI.

```javascript
let subscribeForm = function() {
  return {
    ...,
    submit() {
      this.loading = true;
      
      let self = this;

      fetch(this.config.subscribeEndpoint, {
        method: 'POST',
        body: JSON.stringify({ email: this.email }),
        headers: { 'Content-Type': 'application/json' }
      })
        .then(r => r.json())
        .then(data => {
          if (data.status === 'pending') {
            self.message = 'You have been subscribed. Please check your email to confirm.';
          } else if (data.status === 'subscribed') {
            self.message = 'You are already subscribed. Thank you for being a subscriber!';
          } else {
            self.message = 'We could not subscribe you. Please try again.';
          }
        })
        .catch(e => {
          self.message = 'We could not subscribe you. Please try again.';
        })
        .finally(() => {
          self.loading = false;
        })
    }
  }
}
```

## Putting it All Together

I'll leave a final copy of the form and the function as built for this article below. I made a working copy which differs slightly and put it in a [Github repository jcarouth/netlify-mailchimp-alpinejs](https://github.com/jcarouth/netlify-mailchimp-alpinejs) if you wanted to play with it in a Jigsaw site environment.

One major difference in this blog version from the Github version is that I wanted to make my component flexible to support form specific lists in the Github version. So it has a form field to set the list id rather than only using the ENV variable. Otherwise it is identical. You would need to supply your own Mailchimp API Key, server prefix, and list id for it to do anything besides produce the error state.

```javascript
// functions/subscribe.js
const mailchimp = require('@mailchimp/mailchimp_marketing')
const crypto = require('crypto')

const { MAILCHIMP_API_KEY, MAILCHIMP_SERVER_PREFIX, MAILCHIMP_LIST_ID } = process.env

mailchimp.setConfig({
  apiKey: MAILCHIMP_API_KEY,
  server: MAILCHIMP_SERVER_PREFIX,
})

const headers = {
  "Access-Control-Allow-Origin": "*",
  "Access-Control-Allow-Headers": "Content-Type",
  "Access-Control-Allow-Methods": "OPTIONS,POST,GET",
}

exports.handler = async function(event, context) {
  // Hello our dear friend, CORS. Nice to see you.
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 204,
      headers
    }
  }
  
  const { email } = JSON.parse(event.body)
  const subscriberHash = crypto.createHash('md5').update(email).digest('hex')
  
  try {
    const response = await mailchimp.lists.setListMember(
      MAILCHIMP_LIST_ID,
      subscriberHash,
      {
        email_address: email,
        status_if_new: 'pending',
      },
      { skipMergeValidation: true }
    )
    
    return {
      statusCode: 200,
      headers,
      body: JSON.stringify({
        status: response.status,
        email: response.email_address,
      })
    }
  } catch (e) {
      return {
        statusCode: 400,
        headers,
        body: JSON.stringify({
          status: 'error',
          error: e.response.body.title,
        })
      }
  }
}
```

```html
<!-- form.html -->
<script>
  let subscribeForm = function() {
    return {
      config: {
        subscribeEndpoint: '/.netlify/functions/subscribe'
      },
      email: null,
      loading: false,
      message: '',
      submit() {
        this.loading = true;

        let self = this;

        fetch(this.config.subscribeEndpoint, {
          method: 'POST',
          body: JSON.stringify({ email: this.email }),
          headers: { 'Content-Type': 'application/json' }
        })
          .then(r => r.json())
          .then(data => {
            if (data.status === 'pending') {
              self.message = 'You have been subscribed. Please check your email to confirm.';
            } else if (data.status === 'subscribed') {
              self.message = 'You are already subscribed. Thank you for being a subscriber!';
            } else {
              self.message = 'We could not subscribe you. Please try again.';
            }
          })
          .catch(e => {
            self.message = 'We could not subscribe you. Please try again.';
          })
          .finally(() => {
            self.loading = false;
          })
      }
    }
  }
</script>

<div x-data="subscribeForm()" class="max-w-4xl md:flex mx-auto py-8 md:space-x-6">
  <div class="w-full md:w-2/5">
    <h3 class="text-3xl md:text-4xl font-semibold">
      Join the Newsletter
    </h3>
    <p class="mt-4 text-lg">
      Get up to date information and other random tidbits from us. You know you want to.
    </p>
  </div>
  <div class="w-full md:w-3/5 mt-8 md:mt-0 flex flex-col justify-center">
    <form name="newsletter-subscribes" method="POST" action="/" data-netlify="true">
      <div x-cloak x-show="message" class="mb-4 px-2 py-1 bg-white border-4 border-white font-semibold text-gray-800">
        <span x-text="message">Thanks for subscribing! Check your email to confirm.</span>
      </div>
      <div class="flex">
        <label class="sr-only">Email:</label>
        <input x-model="email" class="flex-1 px-2 py-1 border-0 bg-white text-gray-800" type="email" name="email"
               placeholder="Your Email Address" required>
        
        <button @click.prevent="loading = !loading">
          <span x-cloak x-show="loading">Loading...</span>
          <span x-show="!loading">Subscribe</span>
        </button>
      </div>
    </form>
  </div>
</div>
```
