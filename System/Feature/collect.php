<?php
use System\Feature\Collection;

function collect(Array $item)
{
    return new Collection($item);
}