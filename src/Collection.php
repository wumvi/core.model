<?php
declare(strict_types=1);

namespace Core\Model;

/**
 * Управление моделями
 */
class Collection implements \Iterator, \JsonSerializable
{
    /**
     * @var bool
     */
    protected $isValid;

    /**
     * @var Read Модель объекта
     */
    protected $model;

    /**
     * @var array
     * Массив сырых данных
     */
    private $list;

    /**
     * Constructor
     *
     * @param array $list Массив сырых данных
     * @param Read  $model Модель
     */
    public function __construct(array $list, Read $model)
    {
        $this->list = $list;
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rewind(): void
    {
        reset($this->list);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        $this->model->setElementsList(current($this->list) ?: []);

        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->list);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        next($this->list);
        return $this->current();
    }

    /**
     * @inheritdoc
     */
    public function valid(): bool
    {
        return false !== current($this->list);
    }

    /**
     * @inheritdoc
     */
    public function length(): int
    {
        return count($this->list);
    }

    /**
     * @inheritdoc
     */
    public function shift($key): Read
    {
        $value = $this->list[$key];
        unset($this->list[$key]);

        $this->model->setElementsList($value ?: []);

        return $this->model;
    }

    /**
     * Фильтрует модели
     *
     * @param \callback $cb Callback function
     *
     * @return Collection Коллекция с фильтрованными данными
     */
    public function filter($cb): Collection
    {
        return new Collection(array_filter($this->list, $cb), $this->model);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return $this->list;
    }
}
