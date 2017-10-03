<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 26.09.2017
 * Time: 13:07
 */
include_once("core.php");

//echo "Вы перешли на " . $_GET['test'];
$result = test_edit_view($_GET['test']);
//var_dump($result);

if ($result) {
    $test_id = $result['test']['0']['id_test'];
    $path = plugin_dir_path(__FILE__) . "../file_test/test_" . $test_id . ".txt";
    $article_title = $result['test']['0']['title']; //заголовок
    if (file_exists($path)) {
        $article_text = file_get_contents($path); //сам текст
    }

    $i = 1;
    foreach ($result['words'] as $word_temp) {
        $original_word[$i] = $word_temp['original_words'];
        $modified_word[$i] = $word_temp['modified_word'];
        $options_for_word[$i] = $word_temp['options'];
        $rules_for_word[$i] = $result['rules'][$word_temp['id_rule']]->rules_for_word;
        $i++;
    }
} else {
    $article_title = '';
    $article_text = '';
    $original_word = '';
    $modified_word = '';
    $rules_for_word = '';
    $options_for_word = '';
    $error = false;
}

?>

<form method="post">
    <h2>Teст № <?=$test_id ?></h2>
    <br/>
    <span>Заголовок:</span>
    <br/>
    <input type="text" name="title" value="<?=$article_title ?>" required/>
    <br/>
    <span>Текст:</span>
    <br/>
    <textarea rows="10" cols="45" name="text" required><?=$article_text ?></textarea>
    <br/>
    <?php for ($i = 1; $i <= count($result['words']); $i++):  ?>
        <div id="input_word_<?= $i ?>">
            <span><?=$i ?>) </span>
            <span>Слово:</span><input type="text" name="original_word_<?=$i ?>" value="<?=$original_word[$i] ?>"
                                      placeholder="слово" required/>
            <span>Замена:</span><input type="text" name="modified_word_<?=$i ?>" value="<?=$modified_word[$i] ?>"
                                       placeholder="сл_во" required/>
            <span>Варианты ответа:</span><input type="text" name="options_for_word_<?=$i ?>"
                                                value="<?=$options_for_word[$i] ?>" placeholder="о, а, е" required/>
            <span>Правило:</span><input type="text" name="rules_for_word_<?=$i ?>" value="<?=$rules_for_word[$i] ?>"
                                        placeholder="Потому что" required/>
            <br/>
        </div>
    <?php endfor; ?>
    <br/>

    <div id="add_input">
        <input id="id_word" type="hidden" value="<?=$i ?>">
        <button type="button" value="" onclick=" add_word()">Добавить слово</button>
        <button type="button" value="" onclick=" del_word()">Удалить слово</button>
    </div>
    <br/>
    <input type="submit" value="Сохранить тест">
</form>