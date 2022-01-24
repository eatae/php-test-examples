<?php

namespace Audit\V3;

use Audit\V3\Interfaces\Item;
use Audit\V3\Interfaces\ItemCollection;
use Audit\V3\Interfaces\ItemSpecifier;

class BaseItemCollection implements ItemCollection
{
    protected array $items = [];
    protected ItemSpecifier $specifier;

    public function __construct(ItemSpecifier $specifier)
    {
        $this->specifier = $specifier;
    }

    public function addItem(Item $item, $key = null): void
    {
        if (! $this->specifier->isValid($item)) {
            throw new \Exception("Item is not valid");
        }
        if (isset($this->items[$key])) {
            throw new \Exception("Key $key already in use.");
        }

        if ($key == null) {
            $this->items[] = $item;
        }
        else {
            $this->items[$key] = $item;
        }
    }

    public function deleteItem(int|string $key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
        else {
            throw new \Exception("Invalid key $key.");
        }
    }

    public function getItem(int|string $key): Item
    {
        if (!isset($this->items[$key])) {
            throw new \Exception("Key $key is not exists.");
        }
        return $this->items[$key];
    }

    public function getAll(): array
    {
        return $this->items;
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }

    public function length(): int
    {
        return count($this->items);
    }

    public function keyExists($key): bool
    {
        return isset($this->items[$key]);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}