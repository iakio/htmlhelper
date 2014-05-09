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
            $h->tag('a')
                ->attr('href', 'https://github.com/')
                ->append('github')
                ->toString()
        );
    }

    public function test_call()
    {
        $h = new HtmlHelper();
        $this->assertEquals(
            '<a href="https://github.com/">git &amp; hub</a>',
            $h->a('git & hub')
                ->attr('href', 'https://github.com/')
                ->toString()
        );
    }

    public function test_attribute_without_value()
    {
        $h = new HtmlHelper();
        $this->assertEquals(
            '<option checked />',
            $h->option("", "checked")->toString()
        );
        $this->assertEquals(
            '<input type="checkbox" checked />',
            $h->input("", array('type' => 'checkbox', 'checked' => null))->toString()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_invalid_argument_exception()
    {
        $h = new HtmlHelper();
        $h->a()->attr(array(), "a");
    }
}
