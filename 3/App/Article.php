<?php

namespace App;

// каждый экземпляр данного класса соответствует одной записи таблицы
class Article
{
    // свойства соответствуют полям в таблице
    private $id = false;

    public $title;
    public $content;
    public $authorId; // foreign key

    /**
     * Заполняет объект данными о статье
     * @param $id - ай ди статьи в базе данных
     * @return bool - возвращает true если статья найдена
     */
    public function getOrFail($id)
    {
        // ..
        return true ;
    }

    /**
     * Сохраняет или изменяет данные о статье в базе данных
     * Если поле id заполнено - делает update запрос
     * Если нет  - делает insert запрос
     * @return bool - возвращает true если все получилось
     */
    public function save()
    {
        // ..
        return true;
    }

    /**
     * Заполняет объект данными о статье
     * @param $title - заголовок статьи в базе данных
     * @return bool - возвращает true если статья найдена
     */
    public function findOrFail($title)
    {
        return true;
    }

    /**
     * @return Author возвращает объект с автором этой статьи или null
     */
    public function getAuthor()
    {
        $authorId = $this->id;
        $author = new Author();
        $author->get($authorId);
        return $author;
    }

}