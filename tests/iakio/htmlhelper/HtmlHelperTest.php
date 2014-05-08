<?php
namespace iakio\htmlhelper;
require __DIR__ . '/../../../vendor/autoload.php';

class HtmlHelperTest extends \PHPUnit_Framework_TestCase
{
    public function test_tag()
    {
        $h = new HtmlHelper();
        $this->assertEquals(
            '<a href="https://github.com/">github</a>',
            $h->tag('a', ['href' => 'https://github.com/'], 'github')
        );
    }

    public function test_call()
    {
        $h = new HtmlHelper();
        $this->assertEquals(
            '<a href="https://github.com/">git &amp; hub</a>',
            $h->a(['href' => 'https://github.com/'], 'git & hub')
        );
    }

    public function test_call_static()
    {
        $this->assertEquals(
            '<a href="https://github.com/">git<b>hub</b></a>',
            HtmlHelper::a(['href' => 'https://github.com/'], [
                'git',
                HtmlHelper::b([], 'hub')
            ])
        );
    }

    public function test_map()
    {
        $h = new HtmlHelper();
        $this->assertEquals(
            '<li class="item-1">One</li>'
            . '<li class="item-2">Two</li>'
            . '<li class="item-3">Three</li>',
            $h->map(['One', 'Two', 'Three'], function ($key , $val) use ($h) {
                return $h->li(['class' => 'item-' . ($key + 1)], $val);
            })
        );
    }
}
