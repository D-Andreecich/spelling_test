<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 26.09.2017
 * Time: 13:07
 */

//wp_enqueue_script('newscript', plugin_dir_path(__FILE__)."../assets/js/main.js");

include("core.php");

if (!empty($_POST)) {
    $article_title = trim($_POST['title']);
    $article_text = trim($_POST['text']);
    $i = 1;

    while (!empty($_POST['original_word_' . $i])) {
        $original_word[$i] = trim($_POST['original_word_' . $i]);
        $modified_word[$i] = trim($_POST['modified_word_' . $i]);
        $options_for_word[$i] = trim($_POST['options_for_word_' . $i]);
        $rules_for_word[$i] = trim($_POST['rules_for_word_' . $i]);

        $words_and_rules[$i][] = $original_word[$i];
        $words_and_rules[$i][] = $modified_word[$i];
        $words_and_rules[$i][] = $options_for_word[$i];
        $words_and_rules[$i][] = $rules_for_word[$i];

        $i++;
    }
    if (!test_add($article_title, $article_text, $words_and_rules)) {
        $error = true;
    }
} else {
    $i = 1;
    $article_title = '';
    $article_text = '';
    $original_word = '';
    $modified_word = '';
    $rules_for_word = '';
    $options_for_word = '';
    $error = false;
}

$i = 1;//test

?>

<h1>Добавть новый тест</h1>

<?php if ($error): ?>
    <p class="error">Пожалуйста заполните все поля</p>
<?php endif; ?>

<form method="post">
    <br/>
    <span>Заголовок:</span>
    <br/>
    <input type="text" name="title" value="<?= $article_title ?>" required/>
    <br/>
    <span>Текст:</span>
    <br/>
    <textarea rows="10" cols="45" name="text" required><?= $article_text ?></textarea>
    <br/>
    <!--    for     -->
    <div id="input_word_<?= $i ?>">
        <span><?= $i ?>) </span>
        <span>Слово:</span><input type="text" name="original_word_<?= $i ?>" value="<?= $original_word[$i] ?>"
                                  placeholder="слово" required/>
        <span>Замена:</span><input type="text" name="modified_word_<?= $i ?>" value="<?= $modified_word[$i] ?>"
                                   placeholder="сл_во" required/>
        <span>Варианты ответа:</span><input type="text" name="options_for_word_<?= $i ?>"
                                            value="<?= $options_for_word[$i] ?>" placeholder="о, а, е" required/>
        <span>Правило:</span><input type="text" name="rules_for_word_<?= $i ?>" value="<?= $rules_for_word[$i] ?>"
                                    placeholder="Потому что" required/>
        <br/>
    </div>
    <!--    end for   -->
    <br/>

    <div id="add_input">
        <input id="id_word" type="hidden" value="<?=$i ?>">
        <button type="button" value="" onclick=" add_word()">Добавить слово</button>
        <button type="button" value="" onclick=" del_word()">Удалить слово</button>
    </div>
    <br/>
    <input type="submit" value="Сохранить тест">
</form>
