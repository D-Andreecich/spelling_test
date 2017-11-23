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

    $parse = postParse($_POST);

    if (!test_add($parse['article_title'], $parse['article_text'], $parse['words_and_rules'])) {
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

$allRuleWord = getRuleWord();
$allText = getAllText();
?>

<h1>Добавить новый тест</h1>

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
    <select id="text" data-id="text" class="selectpicker" onchange="setText(this.id)">
        <option>Выбрать готовый текст</option>
    </select>
    <br/>
    <textarea id="inputTest" rows="10" cols="45" name="text" onchange="addWords()" required><?= $article_text ?></textarea>
    <br/>
    <br/>
    <div>
        <span>Слово:</span>
        <select id="original_word" data-id="original_word_" class="selectpicker" onchange="setValue(this.id)">
            <!--  original_word(s)  -->
            <option>Выбрать слово</option>
        </select>
        <span>Замена:</span>
        <select id="modified_word" data-id="modified_word_" class="selectpicker" onchange="setValue(this.id)">
            <option>Выбрать замену</option>
        </select>
        <span>Варианты ответа:</span>
        <select id="options" data-id="options_for_word_" class="selectpicker" onchange="setValue(this.id)">
            <option>Выбрать варианты ответа</option>
        </select>
        <br/>

        <span>Правило:</span>
        <select id="rules_for_word" data-id="rules_for_word_" class="selectpicker" onchange="setValue(this.id)">
            <option>Выбрать правило</option>
        </select>
        <br/>
    </div>

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
        <input id="id_word" type="hidden" value="<?= $i ?>">
        <button type="button" value="" onclick=" add_word()">Добавить слово</button>
        <button type="button" value="" onclick=" del_word()">Удалить слово</button>
    </div>
    <br/>
    <input type="submit" value="Сохранить тест">
</form>

<script type="text/javascript">
    var arrRulesWords = <?php echo json_encode($allRuleWord) ?>;
    var arrText = <?php echo json_encode($allText) ?>;

    addOptionsText('text', arrText);

    goAddOptoins();

</script>