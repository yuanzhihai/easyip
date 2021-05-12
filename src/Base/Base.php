<?php

/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easyIp\Base;

class Base
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
