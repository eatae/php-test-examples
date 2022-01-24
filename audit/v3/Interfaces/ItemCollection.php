<?php

namespace Audit\V3\Interfaces;

interface ItemCollection
{
    public function __construct(ItemSpecifier $specifier);

    public function addItem(Item $item, $key = null): void;

    public function deleteItem(int|string $key): void;

    public function getItem(int|string $key): Item;

    public function getAll(): array;

    public function keys(): array;

    public function length(): int;

    public function keyExists($key): bool;

    public function isEmpty(): bool;
}