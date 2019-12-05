<?php

/**
 * Internet input sanitizer.
 * @param string $data input data.
 * @return string sanitized output.
 */
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    return $data;
}

?>