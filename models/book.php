<?php

class Book {

    public int $id = 0;
    public string $image;
    public string $name;
    public Author $author;
    public string $description;
    public int $price;

    public function __construct(int $id, string $image, string $name, Author $author, string $description, int $price)
    {
        $this->id = $id;
        $this->image = $image;
        $this->name = $name;
        $this->author = $author;
        $this->description = $description;
        $this->price = $price;
    }
}