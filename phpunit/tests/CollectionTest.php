<?php
declare(strict_types=1);

use Core\Model\Collection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Core\Model\Collection
 */
class CollectionTest extends TestCase
{
    private const OWN_KEY_NUM = 1;

    private const ASSERT_DATA = [
        ['id' => 1, 'name' => 'vk'],
        ['id' => 2, 'name' => 'owl'],
    ];

    /**
     * @covers \Core\Model\Collection::__construct
     * @covers \Core\Model\Collection::current
     * @covers \Core\Model\Collection::key
     * @covers \Core\Model\Collection::length
     * @covers \Core\Model\Collection::valid
     * @covers \Core\Model\Collection::jsonSerialize
     * @covers \Core\Model\Collection::filter
     * @covers \Core\Model\Collection::next
     * @covers \Core\Model\Collection::rewind
     * @covers \Core\Model\Collection::shift
     */
    public function testConstructor(): void
    {
        $collection = new Collection(self::ASSERT_DATA, new MyTestRead());

        /** @var MyTestRead $testRead */
        $testRead = $collection->current();
        $this->checkItemCollection($testRead, $collection, 0);

        $this->assertTrue(
            json_encode($collection) === json_encode(self::ASSERT_DATA),
            'Check json_encode'
        );

        $dataFilter = $collection->filter(function ($item) {
            return $item['id'] == self::ASSERT_DATA[self::OWN_KEY_NUM]['id'];
        });

        $this->assertTrue(
            $dataFilter instanceof Collection && $dataFilter->current() instanceof MyTestRead,
            'Check json_encode'
        );

        $testRead = $dataFilter->current();
        $this->assertTrue(
            $dataFilter->length() === 1 && $testRead->getName() === self::ASSERT_DATA[self::OWN_KEY_NUM]['name'],
            'Check json_encode'
        );

        $collection->next();
        $this->checkItemCollection($testRead, $collection, 1);

        $collection->next();
        $this->assertTrue($collection->valid() === false, 'Check name');

        $collection->rewind();
        $testRead = $collection->current();
        $this->checkItemCollection($testRead, $collection, 0);

        /** @var MyTestRead $owlReadTest */
        $owlReadTest = $collection->shift(self::OWN_KEY_NUM);
        $this->assertTrue(
            $owlReadTest->getName() === self::ASSERT_DATA[self::OWN_KEY_NUM]['name'],
            'Check name'
        );

        $this->assertTrue(
            json_encode($collection) === json_encode([self::ASSERT_DATA[0]]),
            'Check json_encode'
        );
    }

    private function checkItemCollection(MyTestRead $testRead, Collection $collection, int $key): void
    {
        $elem = self::ASSERT_DATA[$key];
        $this->assertTrue($testRead instanceof MyTestRead, 'Create Read');
        $this->assertTrue($testRead->getId() === $elem['id'], 'Check id');
        $this->assertTrue($testRead->getName() === $elem['name'], 'Check name');

        $this->assertTrue($collection->key() === $key, 'Check name');
        $this->assertTrue($collection->valid() === true, 'Check name');
        $this->assertTrue($collection->length() === count(self::ASSERT_DATA), 'Check name');

    }
}
