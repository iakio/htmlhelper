HtmlHelper
=======================
[![Build Status](https://travis-ci.org/iakio/htmlhelper.svg?branch=master)](https://travis-ci.org/iakio/htmlhelper)

Simple secure HtmlHelper.

Features:
-----------------------

* Auto escaping.
* Fluent interface.

Usage:
-----------------------

```php
<?php
require 'vendor/autoload.php';

use iakio\htmlhelper\HtmlHelper;
$html = new HtmlHelper;

echo $html->h1('Hello, World'), "\n";
// <h1>Hello, World</h1>

echo $html->a('set attributes', ['href' => 'http://github.com']), "\n";
// <a href="http://github.com">set attributes</a>

echo $html->a()
    ->append('fluent')
    ->append(' interface')
    ->attr('href', 'http://github.com'), "\n";
// <a href="http://github.com">fluent interface</a>

echo $html->span(['Auto <escape>', $html->i('& nested tag')]), "\n";
// <span>Auto &lt;escape&gt;<i>&amp; nested tag</i></span>
```
