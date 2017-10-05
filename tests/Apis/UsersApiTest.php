<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 10/5/17
 * Time: 4:44 PM
 */

namespace Cyclos\Tests\Apis;

use Cyclos\Api;
use Cyclos\Apis\UsersApi;
use PHPUnit\Framework\TestCase;

class UsersApiTest extends TestCase
{
    /**
     * @var UsersApi
     */
    public $users;

    public function setUp()
    {
        parent::setUp();

        $this->users = Api::getUsers();
    }

    public function tearDown()
    {
        unset($this->users);

        parent::tearDown();
    }

    public function testGettingGroupsForUserRegistration()
    {
        $this->assertTrue($this->users->getGroupsForUserRegistration()->isAllCool());
    }
}
