<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 26.09.2017
 * Time: 20:41
 */

function validatorValue($title, $text, $words_and_rules)
{
    if ($title === '' || $text === '') {
        echo 'no $title or $text';
        return false;
    } elseif (isset($words_and_rules)) {
        foreach ($words_and_rules as $wrrl) {
            if (in_array('', $wrrl)) {
                echo 'no $words_and_rules';
                return false;
            }
        }
    } else {
        echo 'no  isset $words_and_rules';
        return false;
    }
    return true;
}

function test_editor()
{
    global $wpdb;
    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $select = "SELECT `id_test`, `title` FROM {$table_name['test']} WHERE {$table_name['test']}.`is_del` = 0 ORDER BY `id_test` DESC ";
    return $wpdb->get_results($select, ARRAY_A);
}

function test_del($id_test)
{
    global $wpdb;
    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $del_test = "UPDATE {$table_name['test']} SET `is_del` = 1 WHERE {$table_name['test']}.`id_test` = {$id_test}";
    dbDelta($del_test);
    $select = "SELECT `is_del` FROM {$table_name['test']} WHERE {$table_name['test']}.`id_test` = {$id_test}";
    return $wpdb->get_results($select)['0']->is_del;
}

function test_add($title, $text, $words_and_rules)
{
    if (!validatorValue($title, $text, $words_and_rules)) {
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
        $query_add_rule = $wpdb->prepare($add_rule, $wr['rules_for_word']);
        $result['rules'] = $wpdb->query($query_add_rule);
        $id_rule = $wpdb->insert_id;

        $add_word = "INSERT INTO {$table_name['words']} (original_word, modified_word, options, id_rule, id_test) VALUES ('%s','%s','%s',%d,%d)";
        $query_add_word = $wpdb->prepare($add_word, $wr['original_word'], $wr['modified_word'], $wr['options'], $id_rule, $id_post);
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

    return true;
}

function test_edit_view($id_test)
{
    global $wpdb;
    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';

    $select_test = "SELECT * FROM {$table_name['test']} WHERE `id_test` = {$id_test}";
    $result['test'] = $wpdb->get_results($select_test, ARRAY_A);
    $select_words = "SELECT * FROM {$table_name['words']} WHERE `id_test` = {$id_test}";
    $result['words'] = $wpdb->get_results($select_words, ARRAY_A);
    $id_rules = '(';
    foreach ($result['words'] as $word_temp) {
        $id_rules .= $word_temp['id_rule'] . ',';
    }
    $id_rules = rtrim($id_rules, ',') . ')';
    $select_rules = "SELECT * FROM {$table_name['rules']} WHERE `id_rule` in {$id_rules}";
    $result['rules'] = $wpdb->get_results($select_rules, OBJECT_K);
    return $result;
}

function update_words($origin, $change, array $fields)
{
    foreach ($fields as $field) {
        if ($change[$field] !== $origin[$field]) {
            $update_word = "UPDATE `wp_table_words` SET {$field} = {$change[$field]} WHERE `wp_table_words`.`id_word` = {$change['id_word']}";
            dbDelta($update_word);
        }
    }
//    return false;
}

function test_edit($id_test, $origin_title, $title, $origin_text, $text, $origin_w_r, $words_and_rules)
{
    if (!validatorValue($title, $text, $words_and_rules)) {
        return false;
    }

    global $wpdb;

    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';

    if ($origin_title !== $title) {
        $update_title = "UPDATE {$table_name['test']} SET `title` = '{$title}' WHERE `wp_table_test`.`id_test` = {$id_test}";
    }
    if ($origin_text !== $text) {
        $update_text = strip_tags($text);
        file_put_contents(plugin_dir_path(__FILE__) . "../file_test/test_" . $id_test . ".txt", $update_text);
    }

    foreach ($words_and_rules as $word_rule) {
//    UPDATE `wp_table_rules` SET `rules_for_word` = 'Вот так вот ' WHERE `wp_table_rules`.`id_rule` = 9
//    UPDATE `wp_table_words` SET `original_words` = 'текст ', `modified_word` = 'те_ст ', `options` = 'к, с, л ' WHERE `wp_table_words`.`id_word` = 3
    }
    $i = 1;
    while ($i <= count($words_and_rules)) {
        if (!empty($words_and_rules[$i]['id_word']) && $words_and_rules[$i]['id_word'] === $origin_w_r['words'][$i - 1]['id_word']) {
            $fields = [
                '0' => 'original_word',
                '1' => 'modified_word',
                '2' => 'options',
            ];
            update_words($origin_w_r['words'][$i - 1], $words_and_rules[$i], $fields);

            if ($words_and_rules[$i]['rules_for_word'] !== $origin_w_r['rules'][$words_and_rules[$i]['id_rule']]->rules_for_word) {
                $update_rule = "UPDATE {$table_name['rules']} SET `rules_for_word` = {$words_and_rules[$i]['rules_for_word']} WHERE {$table_name['rules']}.`id_rule` = {$words_and_rules[$i]['id_rule']}";
                dbDelta($update_rule);
            }
        } else {
            $add_rule = "INSERT INTO {$table_name['rules']} (rules_for_word) VALUES ('%s')";
            $query_add_rule = $wpdb->prepare($add_rule, $words_and_rules[$i]['rules_for_word']);
            $wpdb->query($query_add_rule);
            $id_rule = $wpdb->insert_id;

            $add_word = "INSERT INTO {$table_name['words']} (original_word, modified_word, options, id_rule, id_test) VALUES ('%s','%s','%s',%d,%d)";
            $query_add_word = $wpdb->prepare($add_word, $words_and_rules[$i]['original_word'], $words_and_rules[$i]['modified_word'], $words_and_rules[$i]['options'], $id_rule, $id_test);
            $wpdb->query($query_add_word);
        }
        $i++;
    }
    return true;
}

function postParse($post)
{
    $article_title = trim($post['title']);
    $article_text = trim($post['text']);
    $i = 1;

    while (!empty($post['original_word_' . $i])) {
        $original_word[$i] = trim($post['original_word_' . $i]);
        $modified_word[$i] = trim($post['modified_word_' . $i]);
        $options_for_word[$i] = trim($post['options_for_word_' . $i]);
        $rules_for_word[$i] = trim($post['rules_for_word_' . $i]);

        $words_and_rules[$i]['original_word'] = $original_word[$i];
        $words_and_rules[$i]['modified_word'] = $modified_word[$i];
        $words_and_rules[$i]['options'] = $options_for_word[$i];
        $words_and_rules[$i]['rules_for_word'] = $rules_for_word[$i];
        if ($post['id_rule_' . $i] && $post['id_word_' . $i]) {
            $words_and_rules[$i]['id_rule'] = $post['id_rule_' . $i];
            $words_and_rules[$i]['id_word'] = $post['id_word_' . $i];
        }
        $i++;
    }

    $arr_parse['article_title'] = $article_title;
    $arr_parse['article_text'] = $article_text;
    $arr_parse['words_and_rules'] = $words_and_rules;

    return $arr_parse;
}

function getRuleWord()
{
    global $wpdb;
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';

    $result['rules'] = $wpdb->get_results("SELECT DISTINCT `rules_for_word` FROM {$table_name['rules']}", ARRAY_A);
    $result['words'] = $wpdb->get_results("SELECT DISTINCT * FROM {$table_name['words']}", ARRAY_A);

    return $result;
}

function getTexts()
{
    $i = 1;
    $result = array();
    while (file_exists(plugin_dir_path(__FILE__) . "../file_test/test_" . $i . ".txt")) {
        $fp = fopen(plugin_dir_path(__FILE__) . "../file_test/test_" . $i . ".txt", 'r');
        $result["test_" . $i] = fgets($fp);
        fclose($fp);
        $i++;
    }
    return $result;
}

function getAllText()
{
    $id = 1;
    $result = array();
    while ($id < 10) {
        $path = plugin_dir_path(__FILE__) . "../file_test/test_" . $id . ".txt";
        if (file_exists($path)) {
            $result["test_" . $id] = file_get_contents($path);
        }
        $id++;
    }
    return $result;
}

function route_edit_test(){
    switch ($_GET['page']){
        case 'test_editor':
            $file = 'test_editor';
            break;
        case 'add_test':
            $file = 'test_add';
            break;
        case 'edit_test':
            $file = 'test_edit';
            break;
        case 'del_test':
            $file = 'test_del';
            break;
    }
    include("$file.php");
}