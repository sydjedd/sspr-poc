<?php
// TODO faire une class security et y inclure cette fonction

function escape_string_recursively($object)
{
    if (is_array($object)) {
        return (array_map('sanitize_recursive', $object));
    }

    return htmlspecialchars($object);
}

$tableau = escape_string_recursively($tableau);
