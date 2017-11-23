<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 28.09.2017
 * Time: 9:59
 */
function print_test($atts)
{
    extract($atts);
    $error = true;

    $path = plugin_dir_path(__FILE__) . "../file_test/test_" . $test . ".txt";
    global $wpdb;

    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';

    $table_test_query = "SELECT `id_test` FROM {$table_name['test']} WHERE {$table_name['test']}.`id_test` = {$test}  AND {$table_name['test']}.`is_del` = 0";
    $array_table_test_is = $wpdb->get_results($table_test_query, ARRAY_A);
    $temp = $array_table_test_is ? $array_table_test_is['0']['id_test'] :  false;

    if(!$temp){
        echo '<h2>' . 'Указаного теста не найдено' . '</h2>' . '<div id="p' . $test . '">' . '<p>' . 'Нет указаного текста' . '</p>' . '</div>';
        die();
    }

    $table_test_query = "SELECT `id_test`, `title` FROM {$table_name['test']}";
    $array_table_test_result = $wpdb->get_results($table_test_query, ARRAY_A);

    foreach ($array_table_test_result as $result) {
        if ($result['id_test'] == $test) {
            $article_title = $result['title'];//присваиваем заголовок
            $error = file_exists($path); // проверяем есть ли файл с текстом
            break;
        }
    }

    if ($error) {
        $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
        $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';

        $table_word_query = "SELECT * FROM {$table_name['words']} WHERE `id_test` = {$test}";
        $array_table_word_result = $wpdb->get_results($table_word_query, ARRAY_A);

//        $article_text = file_get_contents($path);
            $tmp = file($path);
            $str ='';
            foreach ($tmp as $val){
                $str .= $val . '<br>';
            }
        $article_text =$str;

        $id_rules = '(';

        foreach ($array_table_word_result as $word) {
            $id_rules = $id_rules . $word['id_rule'] . ', ';

            $repl = '<span class="word" id="w' . $word['id_word'] . '" >' . $word['modified_word'] . '</span>';
            $article_text = str_replace($word['original_words'], $repl, $article_text);

            $variant = '<select id="v' . $word['id_word'] . '"></select>';

            $opth = '<span class="options" id="o' . $word['id_word'] . '">' . '<select id="v' . $word['id_word'] . '" ></select>' . '</span>';
            $article_text = str_replace('_', $opth, $article_text);
        }

        $id_rules = rtrim($id_rules, ', ') . ')';
        $table_rules_query = "SELECT * FROM {$table_name['rules']} WHERE `id_rule` in {$id_rules}";
        $array_table_rules_result = $wpdb->get_results($table_rules_query, OBJECT_K );

    } else {
//        echo '<h2>' . 'Указаного теста не найдено' . '</h2>' . '<div id="p' . $test . '">' . '<p>' . 'Нет указаного текста' . '</p>' . '</div>';
//        wiev('', '');
    }

    $wrd = json_encode($array_table_word_result);

    $opt = json_encode($array_table_rules_result);



    echo '<h2>' . $article_title . '</h2>' . '<div id="p' . $test . '">' . '<p>' . $article_text . '</p>' . '</div>' . '<button id="t' . $test . '" type="button" onclick="check_test(this.id)">Проверить</button>';
    wiev($opt, $wrd);
}

add_shortcode('spelling_test', 'print_test');

function wiev($opt, $wrd)
{
    ?>
    <script type="text/javascript">
        var array_rules = JSON.parse('<?= $opt; ?>');
        var array_words = JSON.parse('<?= $wrd; ?>');

        console.log(array_rules);
        console.log(array_words);

        var p = array_words['0']['id_test'];
        var post =[];

//        setTimeout(optVariant, 10);
            optVariant();

//        addEventListener("click", optVariant);

        function optVariant() {
            console.log('in');
//            removeEventListener("click", optVariant);
            for (var i = 0; i < array_words.length; i++) {
                var objSel = document.getElementById('v' + array_words[i]['id_word']);

                var array_opt = array_words[0]['options'].split(', ');

                objSel.options[0] = new Option('_', "_", true);
                for (var j = 0; j < array_opt.length; j++) {
                    objSel.options[j + 1] = new Option(array_opt[j], array_opt[j]);
                }
            }
        }

        function check_test(id) {
            console.log('Проверка test №' + id);
            var array_test_word = [];
            for (var i = 0; i < array_words.length; i++) {
                document.getElementById('o' + array_words[i]['id_word']).innerText = document.getElementById('v' + array_words[i]['id_word']).value;

                var rules = '<span class="cl_new info"><img src="http://www.bzfar.net/Erudit/Sova.png" alt="Правило" height="50" width="50" /><em>Правило</em>' + array_rules[array_words[i]['id_rule']].rules_for_word + '</span>';

                array_test_word[array_words[i]['id_word']] = document.getElementById('w' + array_words[i]['id_word']).innerText;
                if(array_words[i]['original_words'] === array_test_word[array_words[i]['id_word']]){
                    document.getElementById('w' + array_words[i]['id_word']).style.backgroundColor = '#00b901';
                }else {
                    document.getElementById('w' + array_words[i]['id_word']).style.backgroundColor = '#de0f17';
                }
                document.getElementById('w' + array_words[i]['id_word']).dataset.tooltip = rules ;
            }

            console.log(array_test_word);

            document.styleSheets[0].insertRule(".word { cursor: help; }",1);
        }

//        Всплывающие подсказки
            var showingTooltip;

            document.onmouseover = function (e) {
                var target = e.target;

                var tooltip = target.getAttribute('data-tooltip');
                if (!tooltip) return;
                //console.log(tooltip);

                var tooltipElem = document.createElement('div');
                tooltipElem.className = 'helptext';
                tooltipElem.innerHTML = tooltip;
                document.body.appendChild(tooltipElem);

                var coords = target.getBoundingClientRect();

                var left = coords.left + (target.offsetWidth - tooltipElem.offsetWidth) / 2;
                if (left < 0) left = 0; // не вылезать за левую границу окна

                var top = coords.top - tooltipElem.offsetHeight - 5;
                if (top < 0) { // не вылезать за верхнюю границу окна
                    top = coords.top + target.offsetHeight + 5;
                }

                tooltipElem.style.left = left + 'px';
                tooltipElem.style.top = top + 'px';

                showingTooltip = tooltipElem;
                //console.log(tooltipElem);

            };

            document.onmouseout = function (e) {

                if (showingTooltip) {
                    document.body.removeChild(showingTooltip);
                    showingTooltip = null;
                }

            };
    </script>
    <style type="text/css">
        .word{
            background: #ffca54;
        }
        /*-----------*/
        .helptext {
            position: fixed;
        }

        .helptext span {
            background: #333;
            background: rgba(0,0,0,.8);
            color: #fff;
            border-radius: 5px 5px;

            font-family: Calibri, Tahoma, Geneva, sans-serif;
            position: absolute;
            left: 1em;
            top: 2em;
            z-index: 99;
            margin-left: 0;
               display: inline-block ;
            width: 300px;
        }
        .helptext img {
            border: 0;
            margin: 0px 0 0 -205px;
            float: left;
            position: absolute;
        }
        .helptext em {
            font-family: Candara, Tahoma, Geneva, sans-serif;
            color:red;
            font-size: 1.2em;
            font-weight: bold;
            display: block;
            padding: 0.2em 0 0.6em 0;
            margin: 0 0 0 -175px;
        }
        .cl_old { padding: 0.8em 1em; }
        .cl_new { padding: 0.5em 0.8em 0.8em 2em; }
        <strong>* html</strong> span:hover { background: transparent;  }
    </style>
    <?php
    echo '<script>console.log("end")</script>';
}
?>