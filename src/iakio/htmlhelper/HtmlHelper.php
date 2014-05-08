<?php
namespace iakio\htmlhelper;

class HtmlHelper
{
    public static function tag($tagname, $attributes = array(), $children = array())
    {
        return new Element($tagname, $attributes, $children);
    }

    public static function map($iter, $callback)
    {
        $html = '';
        foreach ($iter as $key => $val) {
            $html .= $callback($key, $val);
        }
        return $html;
    }

    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);
        return call_user_func_array(array($this, 'tag'), $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        array_unshift($arguments, $name);
        return call_user_func_array(array('iakio\\htmlhelper\\HtmlHelper', 'tag'), $arguments);
    }
}
