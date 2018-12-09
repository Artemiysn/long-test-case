<?php

// паттерн ActiveRecord
// преимущества:
// * наиболее очевидный подход - хранение логики доступа к данным в объекте сущности.
// * распространенность подхода
// * хорошо расширяется
// недостатки:
// * иногда нарушает принципе единственной ответственности

// в реальном приложении я бы добавил DI container, например pimple или что-то подобное

// создали автора

$authorJohn = new \App\Author();
$authorJohn->name = "John";
$authorJohn->save();

// создали статью автора Джона

$newJohnArticle = new \App\Article();

$authorJohnId = $authorJohn->getAuthorId();
$newJohnArticle->authorId = $authorJohnId;
$newJohnArticle->title = 'title';
$newJohnArticle->content = 'content';
$newJohnArticle->save();

// ищем автора некой статьи

$someArticle = new \App\Article();

if ($someArticle->findOrFail('Заголовок')) {
    $someAuthor = $someArticle->getAuthor();
    // сменим автора некой статьи на автора Джона
    $someArticle->authorId = $authorJohnId;
    $someArticle->save();
}


// получим статьи автора Джона

$johnArticles = $author->getArticles();

foreach ($johnArticles as $article) {
    echo $article->title;
}
