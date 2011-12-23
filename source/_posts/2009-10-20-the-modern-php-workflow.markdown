---
author: jcarouth
date: '2009-10-20 14:55:51'
layout: post
slug: the-modern-php-workflow
status: publish
title: The Modern PHP Workflow
wordpress_id: '99'
categories:
- PHP
tags:
- Agile Development
- Continuous Integration
- php|architect
- Unit Testing
---

This article was originally published in November 2008 by
[php|architect](http://www.phparch.com/magazine/index/86).

Over time we have all seen projects that become great success stories and our
fair share of projects that become epic failures. Some of this can be blamed
on the idea behind the project but I challenge you to consider that part of
failure can be attributed to a lack of constant supervision of the project.
This is not to say that any one person is in charge of ensuring a project is
on target with the original goals, or even that a project manager is
responsible for testing the project throughout development. Rather, I'd like
you to consider the work flow used on those failed projects and compare it
with a more modern approach to development. While this won't guarantee the
success of every project, using proven tools and methods such as unit testing
with PHPUnit, an automated build system such as Phing, and a continuous
integration server such as Xinc will greatly improve the quality and
timeliness of your future projects.

# Preparations

In order to follow along with this article you will need to equip yourself
with the proper tools. Luckily between pear and the pecl obtaining these tools
is the matter of a few characters typed into the command line. Note that
thorough installation instructions can be found on the websites for each of
the tools which are http://www.phpunit.de for PHPUnit,
http://xinc.googlecode.com for Xinc, and http://phing.info for Phing.

# The Foundation: PHPUnit

Personally before I began my journey into the world of “Agile” development
practices, specifically unit testing, I was already familiar with the basic
concepts behind why it is a good idea but I was a little intimidated by the
seemingly steep learning curve. If you're anything like me you have thought
about the amount of additional time your projects will take because of the
added burden of writing tests, you think that testing is something reserved
for the extra weeks you tacked on to the schedule for this project and comes
in the flavor of “Try out this application and see if you can break it.” or
worse yet you think that your code is so impressively impeccable that you
could not possibly benefit from writing these silly little tests. I am here to
tell you that I was wrong in all of those assumptions. It took a while for me
to realize the benefit and I will not try to convince you that it took no time
at all to adapt my thought process to testing, but I can tell you that as a
result I am more confident in my code, my projects are easier to maintain, and
my clients and employers are much more satisfied with my work.

The toughest part of getting started with unit testing is deciding where to
being your journey of learning how to test your applications. To help you
along we are going to work together to develop an application to track the
whereabouts of various items needed for school as a collegiate student. For
this purpose we are going to assume that our student needs to track his
notebooks, his textbooks, his planner, and his laptop which can be in his desk
or in his backpack. Over the course of this example I may introduce a few bugs
--some purposely, some otherwise--if there is any doubt in your mind about the
code, assume it is for example sake.

Coupled with unit testing the technique of test-driven development is thrown
into the mix and we're going drive the development of our application with
testing. The principle behind test-driven development (TDD) is that we first
write tests that describe how our code functions, more specifically how it is
used, and then we write the code that allows the tests to pass. This might
seem counter-intuitive at first, but we write failing tests first then make
the code conform to our tests thus making our tests the contract to which we
design our code. Coding the opposite direction generally leads to bending test
code to fit the workings of your code base which in turn will lead to massive
refactoring and potential code hernias in the future. If you aren't familiar
with the term “code hernia” it is essentially a fragment of code that is in
place that may be difficult to understand, most likely causes awkward use of
the code base or API, and is only explained by lengthy comment blocks. The
maintenance nightmare associated with such awkward code is exactly the type of
problem we hope to solve by unit testing our code.

We will start by looking at the various places an object (textbook, notebook,
planner, or laptop) can be located. It should be obvious at this point that
each of these locations is merely a container that can accept a student's
belongings, thus we will work on creating the base container class that each
location will extend. We will call our parent class Container and work on the
core functionality that should be present in each concrete container. In the
real world containers have a maximum amount of material which they will be
able to hold, so we will first implement size constraints on our containers.
Let's get our first unit test going:

[code]class ContainerTest extends PHPUnit_Framework_TestCase { public function
testSizeOfContentsIsZeroOnStart() { $container = new Container();
$this->assertEquals(0, $container->getSizeOfContents(); } }[/code]

Now we must implement our Container class:

[code]class Container { public function getSizeOfContents() { } }[/code]

Obviously, this is going to fail when we test it, but in the spirit of TDD we
will run the test anyway as follows:

[code]> phpunit test-1.php

PHPUnit 3.3.3 by Sebastian Bergmann.

F

Time: 0 seconds

There was 1 failure:

1) testSizeOfContentsIsZeroOnStart(ContainerTest)

Failed asserting that <null> matches expected value <integer:0>.

/home/dev/modernphpworkflow/code/test-1.php:9

FAILURES!

Tests: 1, Assertions: 1, Failures: 1.[/code]

This is really easy to fix so we will update the getSizeOfContents() method to
the following:

[php]public function getSizeOfContents()

{

return 0;

}[/php]

Now when we run our unit test we expect that our code will pass the test.

[code]> phpunit test-1.php

PHPUnit 3.3.3 by Sebastian Bergmann.

.

Time: 0 seconds

OK (1 test, 1 assertion)[/code]

This is the point where most people think test driven development is a waste
of time. The code I wrote to pass the test is obviously not what the final
code should be. In fact it is so simple that by writing it I have possibly
proven that I have no idea what I am doing when I work on this project.
However by religiously only writing code in your class that will cause the
tests to pass will force you to think about what you are writing and how it
will fill a need in the grand scheme of the project. Let's move on. We now
know that when we first instantiate our container class that the container
will tell us its size is 0. What happens when we add an object to the
container? What will it report as its size then?

[php]public function testGetSizeOfContainerAfterAddingObject()

{

$container = new Container();

$container->addObject('object1');

$this->assertEquals(1, $container->getSizeOfContents());

} [/php]

[code]> phpunit test-2.php

PHPUnit 3.3.3 by Sebastian Bergmann.

.F

Time: 0 seconds

There was 1 failure:

1) testGetSizeOfContainerAfterAddingObject(ContainerTest)

Failed asserting that <integer:0> matches expected value <integer:1>.

/home/jcarouth/modernphpworkflow/code/test-2.php:16

FAILURES!

Tests: 2, Assertions: 2, Failures: 1.[/code]

Fixing our code base to pass the test will look like this:

[php]class Container

{

private $_contents;

public function __construct()

{

$this->_contents = array();

}

public function getSizeOfContents()

{

return count($this->_contents);

}

public function addObject($obj)

{

$this->_contents[] = $obj;

}

}[/php]

You can see that we have enforced this behavior with our tests. In the second
test we wrote we know that on instantiation the size of the container must be
0. Therefore adding a single object to the container would require that the
size of the container increase by a one. We could, for good measure, amend our
test to test the addition of increasing numbers of items and the effect these
additions have on the size of the container. However we know that the
relationship is a one to one. One additional object added means the size
increases by one.

Back to the size constraint; our container must be able to know its maximum
size and know whether the item(s) being added will exceed that size. Our first
stab might look like this:

[php]public function testGetSetMaximumSize()

{

$container = new Container();

$this->assertNull($container->getMaximumSize());

$container->setMaximumSize(5);

$this->assertEquals(5, $this->getMaximumSize());

}[/php]

However, we must think about the users of this container class. Is it
reasonable to force the code to set the maximum value in the manner shown? I
do not think I would want to use the container object if it required adding
the line $container->setMaximumSize(5); in all code that uses a maximum size.
I would much rather pass the size in as a configuration parameter. I'll change
my test code to model this change in design:

[php]public function testGetSetMaximumSize()

{

$containerWithNoMax = new Container();

$this->assertNull($container->getMaximumSize());

$containerWithMax = new Container(array('max' => 5));

$this->assertEquals(5, $this->getMaximumSize());

}[/php]

This test is run. It fails. Now we write the code to pass the test:

[php]class Container

{

private $_contents;

private $_options;

public function __construct($options = null)

{

$this->setOptions($options)

$this->contents = array();

}

public function setOptions($options)

{

if(null === $options)

$options = array();

$defaults = array(

'max' => null

);

$options = array_merge($options, $defaults);

$this->options = $options;

}

public function getMaximumSize()

{

return $this->_options['max'];

}

//rest of code

}[/php]

You might have noticed, but I am betting that you did not catch the mistake in
the above code. On line 22 of the previous listing I used the array_merge()
function to populate the options array with the default options for cases
where the user of the code does not want to override any/all of the options.
However, in my haste to get the code out I forgot that the values that appear
in the latter of the parameters to array_merge will overwrite values with the
same key in previous parameters. Thus the code above will not honor the
options given to it. Be honest with yourself; suppose it is a Friday and you
have been working long hours lately to get to feature complete, would you have
caught this mistake without wasting anymore time than it takes to run the unit
test? It is possible, but the unit test code caught it immediately and I was
able to correct the code saving myself debugging time in the future.

[code]> phpunit test-2.php

PHPUnit 3.3.3 by Sebastian Bergmann.

..F

Time: 0 seconds

There was 1 failure:

1) testGetSetMaximumSize(ContainerTest)

Failed asserting that <null> matches expected value <integer:5>.

/home/jcarouth/modernphpworkflow/code/test-2.php:24

FAILURES!

Tests: 3, Assertions: 4, Failures: 1.[/code]

For example's sake we are going to make our Container class throw an exception
if an object is added to the container which would put the container over
maximum capacity; whether this is truly exceptional behavior is a matter for
another day. PHPUnit allows several ways to test the exceptions that are
expected in your code. I am partial to using the setExpectedException()
method. When attempting to add an object we want our code to throw an
ContainerAtMaximumException which in this example is assumed to simply be a
subclass of the standard PHP Exception class. In the ContainerTest suite we
add a test method that expects an exception to be raised, run the test,
correct the failure by throwing the exception, and then run the test to verify
our code behaves according to the contract.

[php]public function testAddTooManyObjectsThrowsException()

{

$container = new Container(array('max' => 1));

$container->add('valid');

$this->setExpectedException('ContainerAtMaximumException');

$container->add('over');

}[/php]

I mentioned there are additional options in PHPUnit for testing exceptions.
The first is similar to the method above, but involves a special comment, and
the other is a more traditional approach.

[php]/**

* @expectedException ContainerAtMaximumException  
*/  
public function testAddTooManyObjectsThrowsException()

{

//code that should throw exception

}

public function testAddTooManyObjectsThrowsException()

{

try

{

//code that should throw exception

}

catch(ContainerAtMaximumException $e)

{

return;

}

$this->fail('Expected exception ContainerAtMaximumException');

}[/php]

I prefer the first method introduced because the comment method seems easy to
lose in larger test suites and the last method is a lot more typing. Yes, like
most programmers I am lazy.

I would like to take this time to indoctrinate with the mantra that should
closely match your process when developing projects especially on projects
with more than one developer: "Code. Test. Update. Test. Check in. Repeat."
What this means is that when developing you should write the code for the
feature you are developing or the bug you are fixing and then test your
solution. Once you are satisfied with the solution you should update your
working copy of the code from your source code management system and then run
the tests again. Once these all pass you are clear to check in your code and
smile because you did your part in not breaking the build that is coming in
the next section.

# The Catalyst: Phing

At this point we have a small code base that is tested via unit tests, but we
are relying on human interaction to run the tests. As a developer there is one
thing you should be painfully aware of: human interaction will fail. Thus as
developers we have created tools that will aid in completed complex tasks with
little-to-no effort on our part. Phing is one of those tools. If you are not
familiar with project building--which I will have to admit is not something
that is commonly brought up when speaking of PHP development--at the basic
level building a project consists of running a series of tasks to package,
test, deploy, document, etc your code base.

Phing is based on Apache Ant and uses XML build files to trigger tasks that
are written in PHP classes which handle everything from packaging (PEAR
packages included) to running PHPLint to filesystem operations to running unit
tests. The latter is the most interesting for the purposes of this article,
but the power of Phing is something that should not be overlooked.

It is common practice in development teams to have a "snapshot" build on a
regular basis that represents the current state of the code that is checked in
the source control. It is not unreasonable that the code in a build contains
bugs but a problem is present if the code inside source control is extremely
unstable or contains fatal errors. With the unit tests most of the fatal
errors will be caught prior to check in (remember our mantra from the last
section) and thus will not be in the build. However per Murphy's Law it is
inevitable that bugs will creep into the build by a missed part of the mantra.
Suppose that a person completes their feature, runs the tests, and then checks
in their code. In the time this person was working on their feature, another
developer checked in a patch to a bug in a library used by the first developer
in the new feature. Without the update and unit tests this fact is overlooked
until the time comes for the daily build. Once the build runs (sans unit
tests, mind you) the snapshot is deployed to the quality assurance team who
then discovers the fatal error and cannot test the new feature or the bug
fixes that are effected by the error. This is where Phings ability to
conditionally halt the build if unit tests do not pass becomes invaluable.

All this talk of tasks and running unit tests makes Phing sound like a
complicated beast. Truthfully it is a complicated beast but because of the
simple complexity of XML we are able to tame Phing with a simple text editor.
For our build we merely want to run the unit tests contained in the tests
directory and then package the code inside library into a zip file called
build-latest.zip. These are modest tasks that could probably be scripted in a
matter of minutes but because Phing is such an extensible tool we are going to
use it so that adoption is not a hassle down the line.

To create the build script we need a PHPUnit task, a Zip task, and the FileSet
type. We add these tasks inside a build target which will be called,
creatively, "build."

[xml]<?xml version="1.0" encoding="UTF-8"?>

<project basedir="." default="build" name="container">

<target name="build" description="Runs the test suite and creates the latest
build">

<phpunit haltonfailure="true" haltonerror="true">

<batchtest>

<fileset dir="tests">

<include name="*Test.php" />

</fileset>

</batchtest>

</phpunit>

<zip destfile="builds/build-latest.zip">

<fileset dir="library">

<include name="**/**" />

</fileset>

</zip>

</target>

</project> [/xml]

This build file, upon being run by the command "phing build," will run all
tests inside the directory tests that match the pattern *Test.php. If all
tests pass, the script will continue on and create, if necessary, a zip file
that represents the latest code. The beauty is that if any unit test fails or
has an error the build-latest.zip file will not be updated.

We now have test code that represents a contract with which our library code
must comply and a build script which ensures that our contract is enforced
upon the library code on a regular basis. This, however, merely skims the
surface of the capabilities of Phing. One of my favorite tasks in Phing is the
CoverageReport task. Coupled with the phpunit task (assuming the attribute
codecoverage is set to true) this task is capable of generating a report of
the amount of code in the library that is covered by the unit tests. While it
is theoretically impossible to achieve 100% code coverage (and even if the
report says you have 100% you may not really have total coverage) it is
encouraging to know that at a minimum the lines in your library are being run
by the unit tests and should be functional according to that contract.

The only problem left to solve is that we must remember to run build script.
We could add a scheduled task that would handle this for us, but suppose we
want something more advanced. A scheduled task will run the build on the given
interval no matter what. Chances are during the lifetime of a project there
will be times when no work is being completed on that project so running a
build script does not make sense. We need a way to determine if changes have
been made to the project which would warrant a build. Enter Xinc, a continuous
integration server written in PHP5.

# Automation: Xinc Continuous Integration Server

To fully reap the benefits afforded by a continuous integration server such as
Xinc one must understand the problem the server attempts to solve. In a multi-
developer environment features, dependencies, and even bugs are added at an
alarming pace. The difficulty associated with ensuring that a project will
function when compiled together is what is being termed integration.
Continuous, as it implies, means frequently occurring. Therefore a continuous
integration server handles compiling the code base, external libraries, and
other dependencies together on a frequent basis. The benefit should be obvious
at this point. Combined with the tools outlined in the previous section a
continuous integration server can automatically trigger build scripts to run
when it is known that changes have been made to the code base.

In our theatrical number Xinc represents the director that gives cues to Phing
who then runs through the lines of the test suite to ensure that the code is
functional in regards to the requirements. But that is not all Xinc is capable
of. Xinc holds historical data regarding the builds that have been performed
on the project including metrics about unit tests, number of passed builds and
failed builds, and can even create deliverables in the form of archive files.
The power of a CI server is in the rapid feedback provided to all developers,
product managers, project managers, etc involved in a project.

As mentioned, obtaining Xinc CI server is easily accomplished through PEAR.
After installed per the directions on the website (http://xinc.googlecode.com)
you will notice that you have a daemon that runs on your build server as well
as a web front end to the CI server. The daemon is responsible for checking
your configured projects for changes according to the schedule, running the
builders associated with the project, and then running any publishers for the
project being integrated. Bear with me while we knock out the terminology.

Projects are defined using XML configuration files. These files are then
parsed by the Xinc daemon and appropriate actions taken according to the rules
set forth in the XML file. The most common configuration sets up a project
that is given a schedule property, a modificationset, at least one builder,
and a success and failure publisher as outlined by the following configuration
file:

[xml]<?xml version="1.0"?>

<xinc engine="Sunrise">

<project name="ExampleProject">

<property name="dir" value="${projectdir}/${project.name}" />

<schedule interval="240" />

<modificationset>

<svn directory="${dir}" update="true" />

</modificationset>

<builders>

<phingbuilder buildfile="${dir}/build.xml" />

</builders>

<publishers>

<onfailure>

<email to="you@email.com" subject="Build failed" message="Build of project
failed" />

</onfailure>

<onsuccess>

<email to="you@email.com" subject="Build success" message="Build of project
was successful" />

</onsuccess>

</publishers>

</project>

</xinc>[/xml]

Starting inside the project element, the first element encountered is a
property element. Properties become handy to simplify using long or complex
values throughout the remainder of the file. In this example we set a property
called dir which makes use of two of the built-in properties to compile the
directory that represents the working copy of our project "ExampleProject."
The value, in our example, for the dir property will be
/var/xinc/projects/ExampleProject. Other useful built-in properties include
build.number, and build.timestamp. As you will see later, these properties can
be used to generate deliverables or snapshots as we discussed earlier in the
section regarding Phing.

The schedule element, as its name might imply, tells the Xinc daemon the
frequency that the repository should be checked for changes in seconds. In our
example Xinc will check the repository every four minutes. If there is an
update to the repository, the working copy in the project directory will be
updated and the builders started. The schedule element is useless without the
modificationset element because the modificationset element contains the
information about what tasks can trigger a build. Currently Xinc support two
modificationsets: buildalways and svn. The buildalways modificationset will
always trigger a build on the interval by faking a positive modification. If
we removed the svn element in our example and replaced it with the tag
<buildalways /> every four minutes a build would be triggered. The svn
modificationset will check the repository associated with the working copy
located in the path given in the directory attribute for changes. If changes
are detected, a build will be triggered. Optional attributes for the svn
modificationset include a username and password attribute, and an update
attribute. In our example, each time modifications are detected to the
repository, our working copy will be updated with those changes.

The builders element contains all builder tasks or build scripts that will be
run when modifications are detected. Currently the only supported build task
is a Phing task. It is important to note that properties, such as the
build.number property discussed above, available in Xinc configuration files
will be available to phing build scripts as xinc.property (e.g.
xinc.build.number). Keep this under consideration when writing build scripts
that will be used by Xinc.

Our final element to the project is the publishers element. The main
publishers available are phingpublisher, email, deliverable, artifact, and
documentation. As their names imply a phingbuilder and email publisher will
run a Phing script and send an email, respectively. The deliverable publisher
is used to create a downloadable copy of the successfully built code base.
Using an alias a build-latest.tar file, for example, can be created in
addition to the specific build number file. Files created by the deliverable
publisher will be available on the Xinc web interface. The artifact publisher
is used to create build-specific reports or historical build information that
will also be available for download on the web interface. Combined with
running PHPUnit test code coverage analysis, this can be used to provide the
code coverage report for each build. The documentation publisher will register
a phpdocumentor directory and make it available on the web interface.

Each of the phingpublisher, email, deliverable, artifact, and documentation
publishers can be children any of the onsuccess, onfailure, or onrecovery
publishers. The children of the onsuccess publisher will only be executed when
a build is successful. The opposite is true for the onfailure publisher. The
onrecovery publisher executes its child publishers only when a failed build is
recovered and is made successful.

Once you have decided which publishers you wish to run and have your project
configuration file in the proper directory (on linux the default is
/etc/xinc/conf.d) and the daemon is started you can head over to the Xinc web
front end (which defaults to http://localhost:8080) and view your CI server.
Assuming your configuration is correct you will notice your project listed and
it should have a build status indicator (hopefully it is successful.)

# Conclusion

The Modern PHP Workflow consists of tools that help answer the questions about
the stability of your code and will enable you to continuously build
successful products. With a PHPUnit test suite each line of your code serves a
purpose and is proven time and again to function as intended, Phing helps you
automate the process of running tests on code and packaging code for
deployment or testing, and Xinc automates the integration of your work with
your team member's work to provide instant feedback and create solid final
products. This modern approach to development with PHP is proven to increase
quality and even productivity.

