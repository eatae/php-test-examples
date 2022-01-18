<?php
namespace UserStore\Tests;

use PHPUnit\Framework\TestCase;
use UserStore\UserStore;


class UserStoreTest extends TestCase
{
    private UserStore $store;
    private array $user;
    private string $userName = 'Alice';
    private string $userEmail = 'alice@mail.com';
    private string $userPass = '12345';

    public function setUp(): void
    {
        $this->store = new UserStore();
        $this->user = [
            'name' => $this->userName,
            'email' => $this->userEmail,
            'pass' => $this->store->passwordHash($this->userPass),
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * Get User
     * @throws \Exception
     */
    public function testGetUser(): void
    {
        // set user
        $this->store->addUser(
            $this->userName,
            $this->userEmail,
            $this->store->passwordHash($this->userPass)
        );
        // get user
        $savedUser = $this->store->getUser($this->userEmail);

        $this->assertEquals($this->user, $savedUser);
    }

    /**
     * Add User - short pass
     */
    public function testAddUser_ShortPass(): void
    {
        $this->expectException(\Exception::class);
        $this->store->addUser('Short Pass', 'short@mail.com', '123');
        $this->fail('Ожидалось исключение из-за короткого пароля');
    }

    /**
     * Add User - duplicate
     */
    public function testAddUser_Duplicate(): void
    {
        $duplicateName = 'DuplicateName';
        try {
            $this->store->addUser($this->userName, $this->userEmail, $this->userPass);
            $this->store->addUser($duplicateName, $this->userEmail, $this->userPass);
            self::fail('Здесь должно быть вызвано исключение.');
        } catch (\Exception $e) {
            $constraint = $this->logicalAnd(
                $this->logicalNot($this->containsEqual($duplicateName)),
                $this->isType('array')
            );
            self::assertThat($this->store->getUser($this->userEmail), $constraint);
        }
    }


}