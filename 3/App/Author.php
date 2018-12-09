<?php

namespace App;

// один экземпляр класса соответствует одной записи в таблице
class Author
{
    // свойства соответствуют полям в таблице
    private $id = false;

    public $name;

    /**
     * Заполняет объект данными об авторе
     * @param $id - ай ди пользователя в базе данных
     * @return bool - возвращает true если пользователь найден
     */
    public function getOrFail($id)
    {
        return true;
    }

    /**
     * Заполняет объект данными об авторе
     * @param $name - имя автора в базе данных
     * @return bool - возвращает true если автор найден
     */
    public function findOrFail($name)
    {
        return true;
    }

    /**
     * Сохраняет или изменяет данные о пользователе в базе данных
     * Если поле id заполнено - делает update запрос
     * Если нет  - делает insert запрос
     * @return bool - возвращает true если все получилось
     */
    public function save()
    {
        // ..
    }

    /**
     * @return bool - возвращает id автора статьи или false
     */
    public function getAuthorId()
    {
        // ..
        return $this->id;
    }

    /**
     * @return array - возвращает массив с экземплярами класса article
     *  ищем по id автора (который является foreign key в таблице articles)
     */
    public function getArticles()
    {
        // ..
        return [];
    }

}