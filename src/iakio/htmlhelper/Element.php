<?php
namespace iakio\htmlhelper;

class Element
{
    protected $tagname;
    protected $attributes;
    protected $children;

    public function __construct($tagname, $attributes = array(), $children = array())
    {
        $this->tagname = $tagname;
        $this->attributes = $attributes;
        if (is_array($children)) {
            $this->children = $children;
        } else {
            $this->children = array($children);
        }
    }

    public function escape($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    public function toString()
    {
        $html = '<' . $this->escape($this->tagname);
        foreach ($this->attributes as $attr => $val) {
            $html .= ' ' . $this->escape($attr) . '="' . $this->escape($val) . '"';
        }
        $html .= '>';
        foreach ($this->children as $child) {
            if (is_scalar($child)) {
                $html .= $this->escape($child);
            } elseif ($child instanceof Element) {
                $html .= $child->toString();
            } else {
                throw new \InvalidArgumentException(var_export($child, true));
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
