<?php
namespace iakio\htmlhelper;

class HtmlHelper
{
    public function tag($tagname, $children = array(), $attributes = array())
    {
        return new Element($tagname, $children, $attributes);
    }

    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);
        return call_user_func_array(array($this, 'tag'), $arguments);
    }
}
