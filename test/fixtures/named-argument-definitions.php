<?php
namespace App;

class RegisterOptions
{
    /** @param string $user_name */
    public function __construct(
        array $user_unique_key_arr,
        public readonly string $user_name,
        string $user_visitor_id,
        string $introduction_code,
        string $wx_unionid = '',
        array $other_data = ['user_name' => '$user_name'],
    ) {
        echo $user_name;
    }
}

class ServiceBase
{
    public function __construct($first, $second)
    {
        echo $second;
    }

    public function
    configure(
        array $first = ['$second', 'comma, text'],
        /* $second is the next parameter, not this comment. */
        #[Example('$second')]
        ?string &$second = null,
        ...$third
    ) {
        echo $second;
    }

    public function options(): RegisterOptions
    {
        return new RegisterOptions([], '', '', '');
    }
}

class Service extends ServiceBase
{
}

/** @param string $second */
function &register(
    $first = ['$second', 'comma, text'],
    /* function fake($second) is not a declaration. */
    ?string &$second = null,
    ...$third
) {
    echo $second;
}

function shadowed($first)
{
    $second = 1;
}

function later($second)
{
}
