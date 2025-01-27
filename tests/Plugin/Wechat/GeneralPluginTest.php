<?php

namespace Yansongda\Pay\Tests\Plugin\Wechat;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Provider\Wechat;
use Yansongda\Pay\Rocket;
use Yansongda\Pay\Tests\Stubs\Plugin\WechatGeneralPluginStub;
use Yansongda\Pay\Tests\TestCase;

class GeneralPluginTest extends TestCase
{
    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $plugin = new WechatGeneralPluginStub();

        $result = $plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertInstanceOf(RequestInterface::class, $radar);
        self::assertEquals('POST', $radar->getMethod());
        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'yansongda/pay'), $radar->getUri());
    }

    public function testPartner()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider']);

        $plugin = new WechatGeneralPluginStub();

        $result = $plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertInstanceOf(RequestInterface::class, $radar);
        self::assertEquals('POST', $radar->getMethod());
        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_SERVICE].'yansongda/pay/partner'), $radar->getUri());
    }
}
