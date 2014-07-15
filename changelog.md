### Todo
- Implement remaining planned features: set, debug, array
- Write unit tests / remove potential bugs / more testing
- Add PHPDoc where missing
- Generate API documentation
- And some minor stuff

### Changelog


##### 0.3.0
- Added foreach loop testing
- Added @set

##### 0.2.0
- Renamed BaseLoopManager to LoopManager and made it an abstract class
- LoopManager::newLoop is now abstract and requires override code by the child class
- Changed so that Loopmanager::$stack array items are classes required to be interfaced with LoopStackInteface
- Added some PHPDoc where changes are not likey to occur for planned the stable release
- Updated readme to reflect current progress.

##### 0.1.0
Initial pre-alpha release