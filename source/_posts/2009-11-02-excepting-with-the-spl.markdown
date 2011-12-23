---
author: jcarouth
date: '2009-11-02 09:44:26'
layout: post
slug: excepting-with-the-spl
status: publish
title: Excepting with the SPL
wordpress_id: '117'
categories:
- PHP
tags:
- Beginner
- Best Practice
- Input Validation
---

In my opinion  proper use of error handling within an application is the mark
of seasoned, professional developer. It is far too often that I see code that
explodes on every error or, even worse, does not consider that errors will
occur during runtime.

One area that I like to make use of exceptions is unexpected input, especially
in terms of function/method arguments. A lot of times the standard practice
seems to be to return _FALSE_ for invalid input, but the boolean value false
should be reserved for boolean indication. Likewise, _NULL_ should have a
special connotation, semantically speaking.

In this first example, a repository (or mapper) is attempting to find a user
with an id—let's assume it is a database id—that should be an integer. (_This
code uses the Zend_Db_Table component to abstract queries, etc._)

[code language="php"]class UserRepository implements IRepository { public
function fetchById($id) { $data = $this->getDbTable() ->find($id) ->current();

if (null === $data) { return null; }

return new User($data->toArray()); } }[/code]

Notice there is no validation performed on the _$id_ parameter which is pushed
directly into the database table query. Granted the _Zend_Db_ component will
handle this error with minimal pain, i.e., you should be fairly protected
against a SQL injection attack, but you know that your database table uses an
integer for the ID column thus your application should only respond positively
to an  integer value for _$id_.

[code language="php"]public function fetchById($id) { if (!is_int($id)) {
return false; } //…snip }[/code]

My first attempt (above) at validation uses the native _is_int()_ validation
function to check if the value supplied for _$id_ is an integer. If it is not
the function returns false. There is plenty of precedent behind using the
value _FALSE_ as the error state, but it is **blatantly not semantic**.
_FALSE_ is obviously not the user object I asked for, but it does not indicate
what went wrong.

Finally, I decide to use the _Zend_Validate_ component—for this trivial
example it may be overkill, but it does the job nonetheless—to validate my
input parameter for the user's ID property. Also notice that I am now throwing
an exception object, specifically an _InvalidArgumentException_.

[code language="php"]public function fetchById($id) { $validator = new
Zend_Validate_Int(); if (!$validator->isValid($id)) { throw new
InvalidArgumentException( 'User ID must be an integer. ); } //…snip }[/code]

The _InvalidArgumentException_ exception is [one of
many](http://www.php.net/manual/en/spl.exceptions.php) defined in the SPL as
an extension of a logic exception. The reason for using such an exception
class would be to improve the readability and usefulness of client code. When
I use the _UserRepository_ object, my client code will look as follows. When
an invalid argument, i.e., a non integer is given to the _fetchById()_ method
it is obvious which code path will execute.

[code language="php"]try { $repository = new UserRepository(); $user =
$repository->fetchById("jcarouth"); } catch(InvalidArgumentException $e) {
//we passed an invalid argument, i.e., a non-integer } catch(Exception $e) {
//some other }[/code]

  *[SPL]: Standard PHP Library

