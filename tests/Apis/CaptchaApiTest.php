<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 10/5/17
 * Time: 2:11 PM
 */

namespace Cyclos\Tests\Apis;

use Cyclos\Api;
use Cyclos\Apis\CaptchaApi;
use PHPUnit\Framework\TestCase;

class CaptchaApiTest extends TestCase
{
    /**
     * @var CaptchaApi
     */
    public $captcha;

    public function setUp()
    {
        parent::setUp();

        $this->captcha = Api::getCaptcha();
    }

    public function tearDown()
    {
        unset($this->payments);

        parent::tearDown();
    }

    public function testGenerate()
    {
        $this->assertTrue(is_numeric($this->captcha->generate()->now()->getBody()));
    }

    public function testGetImage()
    {
        $captchaId = $this->captcha->generate()->now()->getBody();

        ($this->captcha->getImage($captchaId)->isAllCool());
    }
}
