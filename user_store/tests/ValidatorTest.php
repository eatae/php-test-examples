<?php

namespace UserStore\Tests;

use PHPUnit\Framework\TestCase;
use UserStore\UserStore;
use UserStore\Validator;


class ValidatorTest extends TestCase
{
    private Validator $validator;
    private string $userName = 'Bob';
    private string $userEmail = 'bob@mail.com';
    private string $userPass = '12345';

    public function setUp(): void
    {
        $store = new UserStore();
        $store->addUser($this->userName, $this->userEmail, $this->userPass);
        $this->validator = new Validator($store);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }


    public function testValidateUser_Find(): void
    {
        $this->assertFalse(
            $this->validator->validateUser('notCorrectEmail', '12345')
        );
        $this->assertFalse(
            $this->validator->validateUser('bob@mail.com', '123')
        );
        $this->assertTrue(
            $this->validator->validateUser('bob@mail.com', '12345')
        );
    }


    public function testValidate_FalsePass(): void
    {
        $mockStore = $this->createMock(UserStore::class);
        $this->validator = new Validator($mockStore);

        // ожидаем один вызов метода notifyPasswordFailure()
        // которому передаётся email
        $mockStore->expects($this->once())
            ->method('notifyPasswordFailure')
            ->with($this->userEmail);

        // ожидаем ноль или больше вызовов метода getUser()
        // который вернёт занчение
        $mockStore->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue([
                    'name' => $this->userName,
                    'email' => $this->userEmail,
                    'pass' => $this->userPass
                ]
            ));

        $this->validator->validateUser($this->userEmail, 'wrongPass');
    }



}