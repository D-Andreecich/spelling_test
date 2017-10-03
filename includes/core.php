<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 26.09.2017
 * Time: 20:41
 */

function test_editor()
{
    global $wpdb;
    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $select = "SELECT `id_test`, `title` FROM {$table_name['test']} ORDER BY `id_test` DESC ";
    return $wpdb->get_results($select, ARRAY_A);
}

function test_add($title, $text, $words_and_rules)
{
    if ($title === '' || $text === '') {
        echo 'no $title or $text';
        return false;
    } elseif (isset($words_and_rules)) {
            foreach ($words_and_rules as $wrrl) {
                if (in_array('', $wrrl)){
                    echo 'no $words_and_rules';
                    return false;
                }
            }
    }else {
        echo 'no  isset $words_and_rules';
        return false;
    }

    global $wpdb;

    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';

    $add_test = "INSERT INTO {$table_name['test']} (title) VALUES ('%s')";
    $query_add_test = $wpdb->prepare($add_test, $title);
    $result['test'] = $wpdb->query($query_add_test);

    $id_post = $wpdb->insert_id;

    foreach ($words_and_rules as $wr) {
        $add_rule = "INSERT INTO {$table_name['rules']} (rules_for_word) VALUES ('%s')";
        $query_add_rule = $wpdb->prepare($add_rule, $wr['3']);
        $result['rules'] = $wpdb->query($query_add_rule);
        $id_rule = $wpdb->insert_id;

        $add_word = "INSERT INTO {$table_name['words']} (original_words, modified_word, options, id_rule, id_test) VALUES ('%s','%s','%s',%d,%d)";
        $query_add_word = $wpdb->prepare($add_word, $wr['0'], $wr['1'], $wr['2'], $id_rule, $id_post);
        $result['words'] = $wpdb->query($query_add_word);
    }

    $file_test = strip_tags($text); // Текст, который будем записывать
    // открываем файл, если файл не существует,
    //делается попытка создать его
    $fp = fopen(plugin_dir_path(__FILE__) . "../file_test/test_" . $id_post . ".txt", 'w');
    // записываем в файл текст
    fwrite($fp, $file_test);
    // закрываем
    fclose($fp);


/*    print '<br/>';
    print '$title= ';
    var_dump($title);
    print '$text= ';
    var_dump($text);
    print '$words_and_rules= ';
    var_dump($words_and_rules);*/

    echo '----------------Good-----------------';

    return true;
}

function test_edit_view ($id_test){
    global $wpdb;
    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';

    $select_test = "SELECT * FROM {$table_name['test']} WHERE `id_test` = {$id_test}";
    $result['test'] = $wpdb->get_results($select_test, ARRAY_A);
    $select_words = "SELECT * FROM {$table_name['words']} WHERE `id_test` = {$id_test}";
    $result['words'] = $wpdb->get_results($select_words, ARRAY_A);
    $id_rules = '(';
    foreach ($result['words'] as $word_temp){
        $id_rules .= $word_temp['id_rule'].',';
    }
    $id_rules = rtrim($id_rules,',').')';
    $select_rules = "SELECT * FROM {$table_name['rules']} WHERE `id_rule` in {$id_rules}";
    $result['rules'] = $wpdb->get_results($select_rules, OBJECT_K);
    return $result;
}

function test_edit($id_test, $title, $text, $words_and_rules)
{

}

function test_del($id_test)
{

}