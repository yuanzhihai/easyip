<?php
/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


namespace easyIp;


class Service extends \think\Service
{
    public function register()
    {
        $this->app->bind('easyIp', EasyIp::class);
    }

    public function boot()
    {

    }
}