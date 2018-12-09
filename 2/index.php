<?php

$url = 'https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3';

/**
 * @param $url - валидная урла
 * @return string - исправленная урла
 */
function brakeMyUrl($url)
{
    // в реальном приложении эти 3-и функции ниже возможно
    // стоило бы сделать приватными методами класса
    $fixedUrl = removeParameter($url);
    $fixedUrl = sortParameters($fixedUrl);
    $fixedUrl = urlPathToGet($fixedUrl);
    return $fixedUrl;
}

$finalUrl = brakeMyUrl($url);

var_dump($finaldUrl); // https://www.somehost.com/?param4=1&param3=2&param1=4&url=%2Ftest%2Findex.html

//****************************
// FUNCTION DECLARATION START
//****************************

/**
 * @param $url - урла
 * @return string|string[]|null - та же урла, но без GET параметров со значениями
 * равными 3-ем
 */
function removeParameter($url)
{
    // для предложенной урлы достаточно этого
    $fixedUrl = preg_replace('/&[\w]+=3/', '', $url);
    // для более универсального решения следует добавить еще и это
    // $fixedUrl = preg_replace('/\?[\w]+=3/', '?', $fixedUrl);
    return $fixedUrl;
}

/**
 * @param $url - урла с несортированными по значению GET параметрами
 * @return string - та же урла с сортированными по значению GET параметрами
 */
function sortParameters($url)
{
    $queryParams = parse_url($url, PHP_URL_QUERY);
    $arr = [];
    parse_str($queryParams, $arr);
    asort($arr);
    $sortedQueryString = http_build_query($arr);
    $sortedUrl = strtok($url, '?') . '?' . $sortedQueryString;
    return $sortedUrl;
}

/**
 * @param $url - обычная урла
 * @return string - та же урла, но параметр path (такой как /test/index.php)
 * из неё убран и добавлен как параметр GET запроса
 */
function urlPathToGet($url)
{
    $urlArr = parse_url($url);
    $fullUrlHost = $urlArr['scheme'] . '://' . $urlArr['host'] . '/';
    $newQueryParam = http_build_query(['url' => $urlArr['path']]);
    $fixedUrlQuery = '?' .  $urlArr['query'] . '&' . $newQueryParam;
    $fixedUrl = $fullUrlHost . $fixedUrlQuery;
    return $fixedUrl;
}

//****************************
// FUNCTION DECLARATION END
//****************************
