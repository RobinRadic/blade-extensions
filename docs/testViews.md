Testing/Asserting Views content
-------------------------------
- [BladeViewTestingTrait](docs/testViews.html) enables all assertWhatever methods from your test class in your view as directives.
```php
@assertTrue(is_array($testArray))
@assertArrayHasKey(0, $testArray)
@assertTrue($testArray[0]['index'] === 0)
```
```php
// Inside your test class
public function testMyAwesomeView(){
    View::make('awesome', ['testArray' => $someArray])->render();
}
```