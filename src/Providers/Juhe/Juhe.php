<?php

/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easyIp\Providers\Juhe;

use GuzzleHttp\Client;
use easyIp\Base\Base;
use easyIp\Contracts\Resolvable;
use easyIp\Exception\ReferenceException;

class Juhe extends Base implements Resolvable
{
    const PROVIDER_NAME = 'Juhe';

    const URL = 'http://apis.juhe.cn/ip/ipNew';

    protected $ip;

    protected $response;

    /**
     * @param string $ip
     *
     * @return array
     *
     * @throws \Exception
     */
    public function parse(string $ip)
    {
        $params = [
            'ip'  => $ip,
            'key' => $this->config['juhe']['key'],
        ];

        $this->ip = $ip;
        $this->response = json_decode((new CLient())->get(static::URL, ['query' => $params])->getBody(), true);

        return $this->check()->format();
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return static::PROVIDER_NAME;
    }

    /**
     * @return $this
     *
     * @throws ReferenceException
     */
    public function check()
    {
        if (200 !== $this->response['resultcode']) {
            throw new ReferenceException($this->response['reason']);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function format()
    {
        if (false === $this->config['format']) {
            return $this->response;
        }

        $result = $this->response['result'];

        return [
            'provider' => static::PROVIDER_NAME,
            'ip'       => $this->ip,
            'postcode' => '',
            'country'  => $result['Country'],
            'province' => $result['Province'],
            'city'     => $result['City'],
            'district' => '',
            'implode'  => implode('', array_splice($result, 0, 3)),
            'location' => [
                'latitude'  => '',
                'longitude' => '',
            ],
        ];
    }
}
