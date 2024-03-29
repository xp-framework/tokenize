Tokenize log
============

## ?.?.? / ????-??-??

## 9.1.0 / 2024-03-24

* Made compatible with XP 12 - @thekid
* Added PHP 8.4 to the test matrix - @thekid
* Merged PR #2: Migrate to new testing library - @thekid

## 9.0.3 / 2021-10-21

* Made library compatible with XP 11 - @thekid

## 9.0.2 / 2021-08-16

* Fixed PHP 8.1 compatibility by declaring `getIterator()` with correct
  return type. See https://wiki.php.net/rfc/internal_method_return_types
  (@thekid)

## 9.0.1 / 2020-10-09

* Fixed reading past end to consistently return `NULL` - @thekid

## 9.0.0 / 2019-11-30

* Dropped support for PHP 5.6, see xp-framework/rfc#334 - @thekid

## 8.1.1 / 2019-11-30

* Added compatibility with XP 10, see xp-framework/rfc#333 - @thekid

## 8.1.0 / 2019-08-10

* Made compatible with PHP 7.4 - refrain using `{}` for string offsets
  (@thekid)

## 8.0.0 / 2017-06-03

* **Heads up:** Dropped PHP 5.5 support - @thekid
* Added forward compatibility with XP 9.0.0 - @thekid

## 7.1.0 / 2016-08-28

* Added forward compatibility with XP 8.0.0 - @thekid

## 7.0.0 / 2016-02-21

* **Adopted semantic versioning. See xp-framework/rfc#300** - @thekid 
* Added version compatibility with XP 7 - @thekid

## 6.6.0 / 2014-12-08

* Extracted from the XP Framework's core - @thekid