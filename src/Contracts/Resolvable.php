<?php

/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace yzh52521\EasyIp\Contracts;

interface Resolvable
{
    /**
     * @param string $ip
     *
     * @return array
     */
    public function parse(string $ip);

    /**
     * @return string
     */
    public function getProviderName();
}
