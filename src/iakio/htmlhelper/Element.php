<?php
namespace iakio\htmlhelper;

class Element
{
    protected $tagname;
    protected $children = array();
    protected $attributes = array();

    public function __construct($tagname, $children = array(), $attributes = array())
    {
        $this->tagname = $tagname;
        $this->append($children);
        $this->attr($attributes);
    }


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

    public function append($children)
    {
        if (!is_array($children)) {
            $children = array($children);
        }
        foreach ($children as $child) {
            $this->children[] = $child;
        }
        return $this;
    }

    public function escape($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    public function toString()
    {
        $html = '<' . $this->escape($this->tagname);
        foreach ($this->attributes as $attr => $val) {
            $html .= ' ' . $this->escape($attr);
            if (!is_null($val)) {
                $html .= '="' . $this->escape($val) . '"';
            }
        }
        $html .= '>';
        foreach ($this->children as $child) {
            if (is_scalar($child)) {
                $html .= $this->escape($child);
            } elseif ($child instanceof Element) {
                $html .= $child->toString();
            }
        }
        $html .= '</' . $this->tagname . '>';
        return $html;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
