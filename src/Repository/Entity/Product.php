<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Repository\Entity;

/**
 * @var $uuid           string  uuid
 * @var $isActive       bool    Активен
 * @var $category       string  Категория товара
 * @var $name           string  Наименование товара
 * @var $description    string  Описание товара
 * @var $price          float   Цена
 */
readonly class Product
{
    private function __construct(
        private int $id,
        private string $uuid,
        private bool $isActive,
        private string $category,
        private string $name,
        private string $description,
        private string $thumbnail,
        private float $price,
    ) {
    }

    /** Создать экземпляр класса */
    public static function create(
        int $id,
        string $uuid,
        bool $isActive,
        string $category,
        string $name,
        string $description,
        string $thumbnail,
        float $price,
    ): Product
    {
        return new Product($id, $uuid, $isActive, $category, $name, $description, $thumbnail, $price);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
