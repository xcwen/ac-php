<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Testing\Concerns;

use Hyperf\Testing\Http\Client;
use Hyperf\Testing\Http\TestResponse;

use function Hyperf\Support\make;

trait MakesHttpRequests
{

    protected  Test $test ;
    protected ?Option $options = null;
    protected ?int $value = null;
}
