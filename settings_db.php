<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 28.09.2017
 * Time: 18:30
 */

// при добавлении поста вставить это [spelling_test test=?] где вместо знака вопроса указать номер ранее созданого теста

//  Ввести свои данные
$user = 'root'; // имя пользователя юазой данныйх
$password = ''; //пароль пользователя базой данных  | -p{$password} вставить после -u{$user}
$name_database = 'wordpress';


$path = plugin_dir_path(__FILE__);
$name =  'dump_table_' .date('H_i_s'); //+3

exec("mysqldump -u{$user} {$name_database} wp_table_words wp_table_rules wp_table_test  --single-transaction --quick > {$path}/file_test/{$name}.sql");