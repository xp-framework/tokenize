Tokenize
========

[![Build status on GitHub](https://github.com/xp-framework/tokenize/workflows/Tests/badge.svg)](https://github.com/xp-framework/tokenize/actions)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Requires PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.svg)](http://php.net/)
[![Supports PHP 8.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-8_0plus.svg)](http://php.net/)
[![Latest Stable Version](https://poser.pugx.org/xp-framework/tokenize/version.svg)](https://packagist.org/packages/xp-framework/tokenize)

Tokenizing text

```php
use text\{StringTokenizer, StreamTokenizer};
use io\File;

// Supports strings and streams
$tokens= new StringTokenizer('He asked: Can you parse this?', ' .?!,;:', true);
$tokens= new StreamTokenizer((new File('parse-me.txt'))->in(), ' .?!,;:', true);

// Can iterate using foreach...
foreach ($tokens as $token) {
  Console::writeLine($token);
}

// ...or with an iterator API
while ($tokens->hasMoreTokens()) {
  Console::writeLine($tokens->nextToken());
}

// Returns: ["He", " ", "asked", ":", " ", "Can", " ", "you", " ", "parse", " ", "this", "?"]
```