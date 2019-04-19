<?php

/** @var Fake $extension */
$extension->bar();

function hello($extension) {
    /** @var Extension $extension */
    $extension->foo();
}

$extension->bar();
