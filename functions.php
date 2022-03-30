<?php

require 'FormCreate.php';

// типы расходных материалов
$types = array('cartridge' => 'Картридж',
    'tuba' => 'Туба');

// производители расходных материалов
$manufacturers = array('hp' => 'HP',
    'kyocera' => 'Kyocera');

// Основная логика функционирования страницы:
// - Если форма передана на обработку, проверить достоверность
// данных, обработать их и снова отобразить форму.
// - Если форма не передана на обработку, отобразить ее снова
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Если функция validate_form() возвратит ошибки,
    // передать их функции show_form()
    list($errors, $input) = validate_form();
    if ($errors) {
        show_form($errors);
    } else {
        // Переданные данные из формы достоверны, обработать их
        process_form($input);
    }
} else {
    // Данные из формы не переданы, отобразить ее снова
    show_form() ;
}

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
function show_form($errors = array())
{
    $defaults = array('types' => 'Выберите тип картриджа',
        'manufacturers' => 'Выберите производителя');
    // создать объект $form с надлежащими свойствами по умолчанию
    $form = new FormCreate($defaults);

    // Ради ясности весь код HTML-разметки и отображения
    // формы вынесен в отдельный файл
    include 'add_cartridge.php';
}

// проверить данные из формы
function validate_form()
{
// начать с пустого массива сообщений об ошибках
    $errors = array();
    $input = array();

    // обязательное имя
    $input['cartridge_name'] = trim($_POST['cartridge_name'] ?? '');
    if (! strlen($input['name'])) {
        $errors[] = 'Пожалуйста, введите наименование';
    }

    $input['types'] = '';
    // проверяет, присутствует ли в массиве указанный ключ или индекс
    if (!array_key_exists($input['types'], $GLOBALS['types']) ||
        array_key_exists($input['types'], ['Выберите тип картриджа'])) {
        $errors[] = 'Пожалуйста, выберите тип';
    }

    $input['manufacturers'] = '';
    if (!array_key_exists($input['manufacturers'], $GLOBALS['manufacturers']) ||
        array_key_exists($input['manufacturers'], ['Выберите производителя'])) {
        $errors[] = 'Пожалуйста, выберите производителя';
    }

    // возвратить (возможно, пустой) массив сообщений об ошибках
    return array($errors, $input);
}
