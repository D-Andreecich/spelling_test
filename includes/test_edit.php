<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 26.09.2017
 * Time: 13:07
 */
include_once("core.php");

$result = test_edit_view($_GET['test']);

if ($result) {
    $test_id = $result['test']['0']['id_test'];
    $path = plugin_dir_path(__FILE__) . "../file_test/test_" . $test_id . ".txt";
    $article_title = $result['test']['0']['title']; //заголовок
    if (file_exists($path)) {
        $article_text = file_get_contents($path); //сам текст
    }

    $i = 1;
    foreach ($result['words'] as $word_temp) {
        $original_word[$i] = $word_temp['original_word'];
        $modified_word[$i] = $word_temp['modified_word'];
        $options_for_word[$i] = $word_temp['options'];
        $rules_for_word[$i] = $result['rules'][$word_temp['id_rule']]->rules_for_word;
        $id_word_rule[$i]['id_word'] = $word_temp['id_word'];
        $id_word_rule[$i]['id_rule'] = $word_temp['id_rule'];
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

$allRuleWord = getRuleWord();

if (!empty($_POST)) {

    $parse = postParse($_POST);

    if (!test_edit($test_id, $article_title, $parse['article_title'], $article_text, $parse['article_text'], $result, $parse['words_and_rules'])) {
        $error = true;
    }else {
//        wp_redirect('http://wordpress/wp-admin/admin.php', 301);
    }
}
?>

<form method="post">
    <h2>Teст № <?= $test_id ?></h2>
    <br/>
    <span>Заголовок:</span>
    <br/>
    <input type="text" name="title" value="<?= $article_title ?>" required/>
    <br/>
    <span>Текст:</span>
    <br/>
    <textarea id="inputTest" rows="10" cols="45" name="text" required><?= $article_text ?></textarea>
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
    <?php for ($i = count($result['words']); $i >= 1; $i--): ?>
        <div id="input_word_<?= $i ?>">
            <span><?= $i ?>) </span>
            <span>Слово:</span>
            <input type="text" name="original_word_<?= $i ?>" value="<?= $original_word[$i] ?>"
            placeholder="слово" required/>
            <span>Замена:</span>
            <input type="text" name="modified_word_<?= $i ?>" value="<?= $modified_word[$i] ?>"
            placeholder="сл_во" required/>
            <span>Варианты ответа:</span>
            <input type="text" name="options_for_word_<?= $i ?>"
            value="<?= $options_for_word[$i] ?>" placeholder="о, а, е" required/>
            <span>Правило:</span>
            <input type="text" name="rules_for_word_<?= $i ?>" value="<?= $rules_for_word[$i] ?>"
            placeholder="Потому что" required/>
            <br/>
            <input type="hidden" name="id_word_<?= $i ?>" value="<?= $id_word_rule[$i]['id_word']?>">
            <input type="hidden" name="id_rule_<?= $i ?>" value="<?= $id_word_rule[$i]['id_rule']?>">
        </div>
    <?php endfor; ?>
    <br/>

    <div id="add_input">
        <input id="id_word" type="hidden" value="<?= count($result['words']) ?>">
        <button type="button" value="" onclick=" add_word()">Добавить слово</button>
        <button type="button" value="" onclick=" del_word()">Удалить слово</button>
    </div>
    <br/>
    <input type="submit" value="Сохранить тест">
</form>
<script type="text/javascript">
    var arrRulesWords = <?php echo json_encode($allRuleWord) ?>;

    goAddOptoins();
</script>