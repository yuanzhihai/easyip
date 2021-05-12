<?php

/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easyIp\Providers\Baidu;

use GuzzleHttp\Client;
use easyIp\Base\Base;
use easyIp\Contracts\Resolvable;
use easyIp\Exception\ReferenceException;

class Baidu extends Base implements Resolvable
{
    const PROVIDER_NAME = 'Baidu';

    const URL = 'https://api.map.baidu.com/location/ip';

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
            'ip' => $ip,
            'ak' => $this->config['baidu']['ak'],
            'coor' => $this->config['baidu']['coor'],
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
        if (0 !== $this->response['status']) {
            throw new ReferenceException($this->response['message']);
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

        $result = $this->response['content'];

        $country = false !== strpos($this->response['address'], 'CN') ? '中国' : '';

        return [
            'provider' => static::PROVIDER_NAME,
            'ip' => $this->ip,
            'postcode' => '',
            'country' => $country,
            'province' => $result['address_detail']['province'],
            'city' => $result['address_detail']['city'],
            'district' => $result['address_detail']['district'] ?: '',
            'implode' => ($country ? '中国' : '').$result['address'],
            'location' => [
                'latitude' => $result['point']['y'],
                'longitude' => $result['point']['x'],
            ],
        ];
    }
}
