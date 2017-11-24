<?php
declare(strict_types = 1);

use \PHPUnit\Framework\TestCase;
use Core\Model\Read;

/**
 * @covers \Core\Model\Read
 */
class ReadTest extends TestCase
{
    /**
     * @covers \Core\Model\Read::__construct
     */
    public function testConstructor(): void
    {
        $testRead = new \MyTestRead([
            'id' => 1,
            'name' => 'vk',
        ]);
        $this->assertTrue($testRead instanceof Read, 'Create Read');

        $this->assertTrue($testRead->getId() === 1, 'Check id');

        $this->assertTrue($testRead->getName() === 'vk', 'Check name');
    }

    /**
     * @covers \Core\Model\Read::getElementsList
     * @covers \Core\Model\Read::setElementsList
     */
    public function testElementsList(): void
    {

        $data = ['id' => 1, 'name' => 'vk',];
        $testRead = new \MyTestRead($data);

        $this->assertTrue($testRead->getElementsList() === $data, 'Check getElementsList');

        $data = ['id' => 2, 'name' => 'owl',];
        $testRead->setElementsList($data);
        $this->assertTrue($testRead->getElementsList() === $data, 'Check setElementsList');
    }

    /**
     * @covers \Core\Model\Read::jsonSerialize
     */
    public function testJsonSerialize(): void
    {
        $data = ['id' => 1, 'name' => 'vk',];
        $testRead = new MyTestRead($data);

        $this->assertTrue(json_encode($testRead) === '{"id":1,"name":"vk"}', 'json_encode');
    }
}
