<?php
namespace iakio\htmlhelper;

class Element
{
    /**
     * http://www.w3.org/TR/html5/syntax.html#void-elements
     */
    static $void_elements = array(
            'area',
            'base',
            'br',
            'col',
            'embed',
            'hr',
            'img',
            'input',
            'keygen',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr'
    );

    protected $tagname;
    protected $children = array();
    protected $attributes = array();
    protected $is_void = false;

    /**
     * @param string               $tagname
     * @param array|string|Element $children
     * @param array|string         $attributes
     */
    public function __construct($tagname, $children = array(), $attributes = array())
    {
        $this->tagname = strtolower($tagname);
        $this->is_void = in_array($this->tagname, static::$void_elements);
        $this->append($children);
        $this->attr($attributes);
    }

    /**
     * Set attributes
     *
     * $name_or_attrs is array of name and value pair of attributes, or
     * string of attribute name.
     * $value is attribute value if $name_or_attrs is string, or null
     * if attribute has no value. (e.g. `<option checked>`)
     *
     * @param  array|string $name_or_attrs
     * @param  string|null  $value
     * @return self
     */
    public function attr($name_or_attrs, $value = null)
    {
        if (is_array($name_or_attrs)) {
            if (!is_null($value)) {
                throw new \InvalidArgumentException("Invalid attribute name " . var_export($name_or_attrs, true));
            }
        } else {
            if (!is_scalar($name_or_attrs)) {
                throw new \InvalidArgumentException("Invalid attribute name " . var_export($name_or_attrs, true));
            }
            $name_or_attrs = array($name_or_attrs => $value);
        }
        foreach ($name_or_attrs as $name => $value) {
            if (!is_null($value) && !is_scalar($value)) {
                throw new \InvalidArgumentException("Invalid attribute value. Value must scalar or NULL. " . var_export($value, true));
            }
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Append children
     *
     * $children is string or Element object or array of those.
     *
     * @param  array|string|Element $children
     * @return self
     */
    public function append($children)
    {
        if (empty($children)) {
            return;
        }
        if ($this->is_void) {
            throw new \LogicException($this->tagname . " can't have any content");
        }
        if (!is_array($children)) {
            $children = array($children);
        }
        foreach ($children as $child) {
            $this->children[] = $child;
        }

        return $this;
    }

    /**
     * Escape HTML special characters.
     *
     * @param  string $str
     * @return string
     */
    public function escape($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Convert Element to HTML string.
     *
     * @return string
     */
    public function toString()
    {
        $html = '<' . $this->escape($this->tagname);
        foreach ($this->attributes as $attr => $val) {
            $html .= ' ' . $this->escape($attr);
            if (!is_null($val)) {
                $html .= '="' . $this->escape($val) . '"';
            }
        }
        $innerhtml = '';
        foreach ($this->children as $child) {
            if (is_scalar($child)) {
                $innerhtml .= $this->escape($child);
            } elseif ($child instanceof Element) {
                $innerhtml .= $child->toString();
            }
        }
        if ($this->is_void) {
            $html .= ' />';
        } else {
            $html .= '>' . $innerhtml . '</' . $this->tagname . '>';
        }

        return $html;
    }

    /**
     * Magic method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
