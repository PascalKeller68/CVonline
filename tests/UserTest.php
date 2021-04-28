<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();

        $user->setEmail('test@test.fr')
            ->setName('testName')
            ->setLastName('testLastName')
            ->setPassword('password')
            ->setConfirmPassword('password');

        $this->assertTrue($user->getEmail() === 'test@test.fr');
        $this->assertTrue($user->getName() === 'testName');
        $this->assertTrue($user->getLastName() === 'testLastName');
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getConfirmPassword() === 'password');
    }

    public function testIsFalse()
    {
        $user = new User();

        $user->setEmail('test@test.fr')
            ->setName('testName')
            ->setLastName('testLastName')
            ->setPassword('password')
            ->setConfirmPassword('password');

        $this->assertFalse($user->getEmail() === 'False@test.fr');
        $this->assertFalse($user->getName() === 'FalseName');
        $this->assertFalse($user->getLastName() === 'FalseLastName');
        $this->assertFalse($user->getPassword() === 'Falsepassword');
        $this->assertFalse($user->getConfirmPassword() === 'Falsepassword');
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getName());
        $this->assertEmpty($user->getLastName());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getConfirmPassword());
    }
}
