<?php
declare(strict_types=1);

namespace Core\Model;

/**
 * Базовый класс моделей
 */
abstract class Read implements \JsonSerializable
{
     /**
      * @var array Массив значений модели
      */
    protected $list = [];

    /**
     * Constructor
     *
     * @param array $list Массив значений
     */
    public function __construct($list = [])
    {
        $this->setElementsList($list);
    }

    /**
     * Задаёт данные ддля модели
     *
     * @param array $list Список значений для модели
     */
    public function setElementsList(array $list): void
    {
        $this->list = $list;
    }

    /**
     * Возвращает данные модели
     *
     * @return array Данные модели
     */
    public function getElementsList(): array
    {
        return $this->list;
    }

    /**
     * Возвращает методв
     *
     * @param string $name Название метода
     *
     * @return mixed|null Значение
     *
     * @codeCoverageIgnore
     */
    public function __get(string $name)
    {
        return $this->get($name);
    }

    /**
     * Возвращает значение по ключу
     *
     * @param string $name Ключ
     *
     * @return mixed|null Значение
     *
     * @codeCoverageIgnore
     */
    protected function get(string $name)
    {
        $name[0] = strtolower($name[0]);

        return $this->list[$name] ?? null;
    }

    /**
     * Вызовает магический метод
     *
     * @param string $methodName Название метода
     * @param array $arguments аргументы
     *
     * @return mixed|null Значение
     *
     * @codeCoverageIgnore
     */
    public function __call(string $methodName, array $arguments)
    {
        if (substr($methodName, 0, 3) === 'get') {
            return $this->get(substr($methodName, 3));
        } elseif (substr($methodName, 0, 2) === 'is') {
            return $this->get(substr($methodName, 2));
        }

        return $this->get($methodName);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return $this->list;
    }
}
