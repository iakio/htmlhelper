<?php
namespace iakio\htmlhelper;

class HtmlHelper
{
    /**
     * Create new Element
     *
     * $children is string or Element object or array of those.
     * $attributes is array of name and value pair of attributes. or
     * string of attribute name. (e.g. `<option checked>`)
     *
     * @param string               $tagname
     * @param array|string|Element $children
     * @param array|string         $attributes
     *
     * @return Element
     */
    public static function tag($tagname, $children = array(), $attributes = array())
    {
        return new Element($tagname, $children, $attributes);
    }

    /**
     * Magic method. Shortcut of tag()
     *
     * @param string       $name
     * @param array|string $arguments
     *
     * @return Element
     */
    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);

        return call_user_func_array(array($this, 'tag'), $arguments);
    }


    public static function __callStatic($name, $arguments)
    {
        array_unshift($arguments, $name);

        return call_user_func_array('static::tag', $arguments);
    }
}
