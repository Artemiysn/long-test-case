<?php

//******
// КАК БЫЛО
//******

function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    // слишком много запросов, надо сделать один
    foreach ($user_ids as $user_id) {
        // слишком простой пароль и логин, хакер может подобрать его
        $db = mysqli_connect("localhost", "root", "123123", "database");
        // данные никак не отфильтрованы, уязвимость для sql-инъекции!
        // злой хакер может добавить, например, строку вида '1 UNION SELECT email FROM users'
        // и украсть email'ы (если они есть в базе)
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
       // дальше ошибки синтаксиса еще
        while($obj = $sql->fetch_object()){
            $data[$user_id] = $obj->name;
        }
    mysqli_close($db);
    }
    return $data;
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);

foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}

//******
// ИСПРАВЛЕННЫЙ ВАРИАНТ
//******

//****************************
// ACTUAL PROGRAM START
//****************************

$data = $_GET['user_ids'];
// для проверки
//$data = '1,b,3,235ggs,asr1,3f,f,4,20';

$filteredData = filterData($data);

$mysqli = getConnection();

// Note! Неподготовленный запрос
$users = getUsers($mysqli, $filteredData);

$mysqli->close();

foreach($users as $user)
{
    echo "<a href='/show_user.php?id=" . $user['id'] . "/'>" . $user['name'] . "</a>";
    echo "<br>";
}


//****************************
// ACTUAL PROGRAM END
//****************************

//****************************
// FUNCTION DECLARATION START
//****************************


/**
 * попытаемся установить соединение с базой данной, если не
 * получится - выходим из программы
 * @return mysqli - mysqli object
 */
function getConnection()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $mysqli = new mysqli("127.0.0.1:3306", "homestead", "secret", "apiex");
        $mysqli->set_charset("utf8mb4");
        return $mysqli;
    } catch(Exception $e) {
        exit($e->getMessage()); //Should be a message a typical user could understand
    }
}

/**
 * либо вернет готовую строку для запроса такого
 * вида: (2,4), либо выйдет из программы
 * @param $data - ожидаем строку с GET параметром такого вида: '1,2,5'
 * @return string - ожидаем строку вида (2,4)
 */
function filterData($data)
{
    $dataArr = explode(',', $data);
    foreach ($dataArr as $key => $value) {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            unset($dataArr[$key]);
        }
    }
    if (empty($dataArr)) {
        // можно залогировать хакерскую активность
        exit('возможна попытка взлома сервера базы данных!');
    }
    $fixedDataString = '(' . implode(",", $dataArr) . ')';
    return $fixedDataString;
}

/**
 * Пытаемся получить пользователей из базы данных
 * @param $mysqli - объект mysqli
 * @param $filteredData - УЖЕ ГОТОВАЯ строка для НЕПОДГОТОВЛЕННОГО запроса
 * вида (1,4,7)
 * @return array - массив со списком пользователей или
 * пустой массив (если пользователи не найдены)
 */
function getUsers($mysqli, $filteredData) {
    $rows = [];
    $sql = "SELECT name, id FROM users WHERE id IN " . $filteredData;
    $result = $mysqli->query($sql);
    while($row = $result->fetch_array())
    {
        $rows[] = $row;
    }
    $result->close();
    return $rows;
}

//****************************
// FUNCTION DECLARATION END
//****************************