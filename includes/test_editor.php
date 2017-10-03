<?php
/**
 * Created by PhpStorm.
 * User: D-Andreevich
 * Date: 26.09.2017
 * Time: 13:07
 */

include_once ("core.php");

    if($_GET['page'] == 'test_editor' && $_GET['test']){
        include ('test_edit.php');
    }

    $tests = test_editor();

?>
<?php if(empty($_GET['test'])): ?>
<h2>Тесты на орфографию</h2>
<ul>
    <?php foreach ($tests as $test):?>
    <li id="<?=$test['id_test']?>">
        <span>Teст №<?=$test['id_test'] ?></span>
        <br/>
        <a href="<?=$_SERVER['PHP_SELF'] ?>?page=test_editor&test=<?=$test['id_test']?>"> <?= $test['title']?> </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>