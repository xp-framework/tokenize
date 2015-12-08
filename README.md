Tokenize
========

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-framework/tokenize.svg)](http://travis-ci.org/xp-framework/tokenize)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Required PHP 5.5+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-5_5plus.png)](http://php.net/)
[![Supports PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.png)](http://php.net/)
[![Supports HHVM 3.4+](https://raw.githubusercontent.com/xp-framework/web/master/static/hhvm-3_4plus.png)](http://hhvm.com/)
[![Latest Stable Version](https://poser.pugx.org/xp-framework/tokenize/version.png)](https://packagist.org/packages/xp-framework/tokenize)

Tokenizing text

```php
use text\StringTokenizer;
use text\StreamTokenizer;

// Supports strings and streams
$tokens= new StringTokenizer('He asked: Can you parse this?', ' .?!,;:', true);
$tokens= new StringTokenizer($file->in(), ' .?!,;:', true);

// Can iterate using foreach...
foreach ($tokens as $token) {
  Console::writeLine($token);
}

/// ...or with an iterator API
while ($tokens->hasMoreTokens()) {
  Console::writeLine($tokens->nextToken());
}

// Returns: ["He", " ", "asked", ":", " ", "Can", " ", "you", " ", "parse", " ", "this", "?"]
```