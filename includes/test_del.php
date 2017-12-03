<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 12.11.2017
 * Time: 23:37
 */

include_once("core.php");

if ($_POST['id_test']) {
    if (test_del($_POST['id_test'])) {
        echo "<h2>    Удалено тест id = {$_POST['id_test']}   </h2>";
    } else {
        echo "<h2>    Не удалено тест id = {$_POST['id_test']}   </h2>";
    }
}

$tests = test_editor();
?>
<?php if (empty($_GET['test'])): ?>
    <h2>Тесты на орфографию</h2>
    <ul>
        <?php foreach ($tests as $test): ?>
            <form method="post">
                <li id="<?= $test['id_test'] ?>">
                    <input type="hidden" name="id_test" value="<?= $test['id_test'] ?>">
                    <span>Teст №<?= $test['id_test'] ?></span>
                    <br/>
                    <span><?= $test['title']?></span>
                    <br/>
                    <button type="submit">Удалить</button>
                </li>
            </form>
            <br/>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>