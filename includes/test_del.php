<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 12.11.2017
 * Time: 23:37
 */

include_once("core.php");

if ($_GET['page'] == 'del_test' && $_GET['test']) {
    if(test_del($_GET['test'])){
        echo "Удалено тест id = {$_GET['test']}";
    }else{
        echo "НЕ удалено тест id = {$_GET['test']}";
    }
}

$tests = test_editor();

?>
<?php if (empty($_GET['test'])): ?>
    <h2>Тесты на орфографию</h2>
    <ul>
        <?php foreach ($tests as $test): ?>
            <li id="<?= $test['id_test'] ?>">
                <span>Teст №<?= $test['id_test'] ?></span>
                <br/>
                <a href="<?= $_SERVER['PHP_SELF'] ?>?page=del_test&test=<?= $test['id_test'] ?>">
                    Удалить <?= $test['title'] ?> </a>
                <br/>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>