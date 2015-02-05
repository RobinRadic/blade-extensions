<?php namespace Radic\BladeExtensions\Helpers;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package        Blade Extensions
 * @version        1.2.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://radic.nl
 */
class LoopItem
{

    protected $items = [];

    protected $data;

    protected $parentLoop;

    /**
     * @param LoopItem $parentLoop
     * {@inheritdocs}
     */
    public function setParentLoop(LoopItem $parentLoop)
    {
        $this->parentLoop     = $parentLoop;
        $this->data['parent'] = $parentLoop;
    }

    public function __construct($items)
    {
        $this->setItems($items);
    }

    public function setItems($items)
    {
        if (isset($data)) {
            return;
        }
        $this->items = $items;
        $total       = count($items);
        $this->data  = array(
            'index1'    => 1,
            'index'     => 0,
            'revindex1' => $total,
            'revindex'  => $total - 1,
            'first'     => true,
            'last'      => false,
            'odd'       => false,
            'even'      => true,
            'length'    => $total
        );
    }

    public function __get($key)
    {
        return $this->data[$key];
    }

    public function before()
    {
        if ($this->data['index'] % 2 == 0) {
            $this->data['odd']  = false;
            $this->data['even'] = true;
        } else {
            $this->data['odd']  = true;
            $this->data['even'] = false;
        }
        if ($this->data['index'] == 0) {
            $this->data['first'] = true;
        } else {
            $this->data['first'] = false;
        }
        if ($this->data['revindex'] == 0) {
            $this->data['last'] = true;
        } else {
            $this->data['last'] = false;
        }
    }

    public function after()
    {
        $this->data['index']++;
        $this->data['index1']++;
        $this->data['revindex']--;
        $this->data['revindex1']--;
    }
}
