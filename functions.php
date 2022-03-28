<?php

require 'FormCreate.php';

// типы расходных материалов
$types = array('cartridge' => 'Картридж', 'tuba' => 'Туба');

// производители расходных материалов
$manufacturers = array('hp' => 'HP', 'kyocera' => 'Kyocera');

// отображение списка, размечаемого дескриптором
function generate_options_types($options_types)
{
    $html = "<option disabled>Выберите тип</option>\n";
    foreach ($options_types as $value => $option_type) {
        $html .= "<option value=$value>$option_type</option>\n";
    }
    return $html;
}

// сделать что-нибудь, когда форма передана на обработку
function process_form()
{
    print "Модель картриджа " . $_POST['cartridge_name'] . " добавлена";
}

// отобразить форму
function show_form_cartridge($errors = false)
{
    $types = generate_options_types($GLOBALS['types']);

// Если переданы ошибки, вывести их на экран
    if ($errors) {
        print 'Пожалуйста, исправьте эти ошибки: <ul ><li > ';
        print implode('</li ><li > ', $errors);
        print ' </li ></ul > ';
    }
    print <<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Наименование: <input type="text" name="cartridge_name">
<br/>
Тип: <select name="types">
$types;
</select>
<br/>
<input type="submit" value="Отправить">
</form>
_HTML_;
}

// проверить данные из формы
function validate_form()
{
// начать с пустого массива сообщений об ошибках
    $errors = array();
    $input = array();
    $input['cartridge_name'] = $_POST['cartridge_name'] ?? '';
// добавить сообщение об ошибке, если введено слишком
// короткое имя картриджа
    if (strlen(trim($input['cartridge_name'])) < 3) {
        $errors[] = 'Наименование должно состоять не менее чем из 3 букв . ';
    }
    $input['types'] = $_POST['types'];
// проверяет, присутствует ли в массиве указанный ключ или индекс
    if (! array_key_exists($input['types'], $GLOBALS['types'])) {
        $errors[] = 'Пожалуйста, выберите тип';
    }
// возвратить (возможно, пустой) массив сообщений об ошибках
    return array($errors, $input);
}
