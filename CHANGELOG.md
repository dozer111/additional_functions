## 2.0.0
#### Changed function names
* `floatval_normalized` => `normalizeFloatval`
* `implode_and_normalize` => `normalizeImplode`


## 2.1.0
* added [truncateNumber()](https://github.com/dozer111/additional_functions/blob/master/src/textProcessing/strings.php#L93) function


## 2.2 
* added [toArray()](https://github.com/dozer111/additional_functions/blob/master/src/variable_and_type_related_extensions/variable_handling.php#L73)


## 2.2.1 
* fix truncateNumber() function, which return wrong value when number had e
```php
// was
$number = 123.12313123131e5;
$res = truncateNumber($number); //123
// fixed
$res = truncateNumber($number); //123e5
```
























