Changelog
=============

2.0.0
-------------
#### Laravel 5
- Laravel 5 compatibility. 


1.2.0
-------------
 
#### @foreach improvements
- Added Radic\BladeExtensions\Testings\BladeViewTestingTrait. Provides functionality to call assertion functions in blade views as directive like; @assertTrue(is_int('no')). All assertions the trait's class instance has are callable. 
- Added a lot of tests, most in views. Removed a few non-view tests that weren't really usefull anymore
- Merged @osugregor robinradic/blade-extensions#4 into the develop tree and adjusted a few things to make it work as intended.
- Added regex101.com links for some directives, for both reference and 'testing'

#### Documentation
- Rewritten most of the README
- Written documention for a bunch of things, added to /docs
- Implemented `composer run-script livedoc`, uses [grip](aa) to render Github flavoured markdown on a static server
- Also implemented `composer run-script makedoc` to covert all markdown documentation from /doc to html in /doc/html

#### New directives
- Implemented blade partials, created by :muscle: @crhayes
- Written a few tests for the partials 



0.3.0
-------------
- Added foreach loop testing
- Added @set




0.2.0
-------------
- Renamed BaseLoopManager to LoopManager and made it an abstract class
- LoopManager::newLoop is now abstract and requires override code by the child class
- Changed so that Loopmanager::$stack array items are classes required to be interfaced with LoopStackInteface
- Added some PHPDoc where changes are not likey to occur for planned the stable release
- Updated readme to reflect current progress.

0.1.0
-------------
Initial pre-alpha release
