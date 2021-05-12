<?php

/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


namespace yzh52521\EasyIp\Providers\Tencent;

use GuzzleHttp\Client;
use yzh52521\EasyIp\Base\Base;
use yzh52521\EasyIp\Contracts\Resolvable;
use yzh52521\EasyIp\Exception\ReferenceException;

class Tencent extends Base implements Resolvable
{
    const PROVIDER_NAME = 'Tencent';

    const URL = 'https://apis.map.qq.com/ws/location/v1/ip';

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
            'key' => $this->config['tencent']['key'],
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

        $result = $this->response['result'];

        return [
            'provider' => static::PROVIDER_NAME,
            'ip' => $this->ip,
            'postcode' => $result['ad_info']['adcode'],
            'country' => $result['ad_info']['nation'],
            'province' => $result['ad_info']['province'],
            'city' => $result['ad_info']['city'],
            'district' => $result['ad_info']['district'],
            'implode' => implode('', array_splice($result['ad_info'], 0, 4)),
            'location' => [
                'latitude' => $result['location']['lat'],
                'longitude' => $result['location']['lng'],
            ],
        ];
    }
}
