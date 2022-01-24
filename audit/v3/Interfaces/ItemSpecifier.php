<?php

namespace Audit\V3\Interfaces;

interface ItemSpecifier
{
    public function isValid(Item $item): bool;
}