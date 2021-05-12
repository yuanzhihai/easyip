<?php

/*
 * This file is part of the yzh52521/easyip.
 *
 * (c) yzh52521 <396751927@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easyIp\Providers\Taobao;

use easyIp\Exception\ReferenceException;
use GuzzleHttp\Client;
use easyIp\Base\Base;
use easyIp\Contracts\Resolvable;

class Taobao extends Base implements Resolvable
{
    const PROVIDER_NAME = 'Taobao';

    const URL = 'http://ip.taobao.com/service/getIpInfo.php';

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
        if (!$this->response) {
            throw new ReferenceException('服务器无响应!');
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

        $result = $this->response['data'];

        return [
            'provider' => static::PROVIDER_NAME,
            'ip' => $this->ip,
            'postcode' => '',
            'country' => $result['country'],
            'province' => $result['region'],
            'city' => $result['city'],
            'district' => $result['area'],
            'implode' => $result['country'].$result['region'].$result['city'],
            'location' => [
                'latitude' => '',
                'longitude' => '',
            ],
        ];
    }
}
