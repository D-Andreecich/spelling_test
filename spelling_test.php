<?php
/*
Plugin Name: Spelling
Description: Spelling Testing
Version: 1.0
Author: D_Andreevich
Author URI: local.host
Plugin URI: local.host/spelling_test
*/
?>
<?php
include ("includes/public.php");

require_once ABSPATH . 'wp-admin/includes/upgrade.php'; //для dbDelta

define('SPELLING_TEST_DIR', plugin_dir_path(__FILE__));
define('SPELLING_TEST_URL', plugin_dir_url(__FILE__));

register_activation_hook(__FILE__, 'spelling_activation');
register_deactivation_hook(__FILE__, 'spelling_deactivation');
//register_uninstall_hook(__FILE__, 'spelling_uninstall');

function spelling_activation()
{
    if(!file_exists(SPELLING_TEST_DIR."/file_test")){
        mkdir( SPELLING_TEST_DIR."/file_test", 0755);
    }

    global $wpdb;

    $table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';//Указать 0 в вызове get_blog_prefix(), чтобы использовать глобальный префикс базы данных WordPress.

    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    $sql[$table_name['test']] = "CREATE TABLE {$table_name['test']} (
        `id_test`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        PRIMARY KEY  (`id_test`)
    ) {$charset_collate};";

    $sql[$table_name['words']] = "CREATE TABLE {$table_name['words']} (
        `id_word`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `original_word` VARCHAR(50) NOT NULL,
        `modified_word` VARCHAR(55) NOT NULL,
        `options` VARCHAR(255) NOT NULL,
        `id_rule` INT(10) UNSIGNED NOT NULL,
        `id_test` INT(10) UNSIGNED NOT NULL,
        PRIMARY KEY  (`id_word`),
        KEY rule_ind (id_rule),
        KEY test_ind (id_test)
    ) {$charset_collate};";


    $sql[$table_name['rules']] = "CREATE TABLE {$table_name['rules']} (
        `id_rule` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `rules_for_word` TEXT NOT NULL,
        PRIMARY KEY  (`id_rule`)
    ) {$charset_collate};";

    // Проверка на существование таблицы
    foreach ($table_name as $table) {
        if ($wpdb->get_var("SHOW TABLES LIKE {$table} ") != $table) {
            dbDelta($sql[$table]);
        }
    }

    $test = "ALTER TABLE `wp_table_rules_words`
      ADD CONSTRAINT `wp_table_rules_words_ibfk_1` FOREIGN KEY (`id_word`) REFERENCES `wp_table_words` (`id_word`),
      ADD CONSTRAINT `wp_table_rules_words_ibfk_2` FOREIGN KEY (`id_rule`) REFERENCES `wp_table_rules` (`id_rule`);";

    //Создание внешних ключей
    $text = "ALTER TABLE {$sql[$table_name['rules_words']]}
        ADD FOREIGN KEY (`id_word`) REFERENCES {$sql[$table_name['words']]} (`id_word`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD FOREIGN KEY (`id_rule`) REFERENCES {$sql[$table_name['rules']]} (`id_rule`) ON DELETE CASCADE ON UPDATE CASCADE;";

    $wpdb->query($test);

//    $pdo = new PDO('mysql:host=127.0.0.1;dbname=wordpress', 'userwordpress', 'userwordpress');
//    $statement = $pdo->query("ALTER TABLE `wp_table_rules_words`
//      ADD CONSTRAINT `wp_table_rules_words_ibfk_1` FOREIGN KEY (`id_word`) REFERENCES `wp_table_words` (`id_word`),
//      ADD CONSTRAINT `wp_table_rules_words_ibfk_2` FOREIGN KEY (`id_rule`) REFERENCES `wp_table_rules` (`id_rule`);");
}

function spelling_deactivation()
{
    include_once ("settings_db.php");
    return true;
}

function spelling_uninstall()
{
    return true;

    /*if(file_exists(SPELLING_TEST_DIR."/file_test") && is_dir(SPELLING_TEST_DIR."/file_test")){
        if(!rmdir ( SPELLING_TEST_DIR."/file_test")){

        }
    }*/

    /*$table_name['test'] = $wpdb->get_blog_prefix() . 'table_test';
    $table_name['words'] = $wpdb->get_blog_prefix() . 'table_words';
    $table_name['rules'] = $wpdb->get_blog_prefix() . 'table_rules';
    $table_name['rule_word'] = $wpdb->get_blog_prefix() . 'table_rule_word';
    $table_name['test_word'] = $wpdb->get_blog_prefix() . 'table_test_word';

    foreach ($table_name as $table) {
            $wpdb->query("DROP TABLE IF EXISTS {$table}");
    }*/
}

//Меню редактирования и работы с тестами
function test_editing_menu(){
    add_menu_page('Редактор тестов', 'Редактор тестов', 8, 'test_editor', 'route_edit_test');
    add_submenu_page('test_editor', 'Добавить тест', 'Добавить тест', 8, 'add_test', 'route_edit_test');
    add_submenu_page('test_editor', 'Удалить тест', 'Удалить тест', 8, 'edit_test', 'route_edit_test');
}

add_action('admin_menu', 'test_editing_menu');

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
    }
    include("includes/$file.php");
}



function enqueue_plugin_scripts($plugin_array)
{
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["green_button_plugin"] =  plugin_dir_url(__FILE__) . "mce-button.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, "green");
    return $buttons;
}

add_filter("mce_buttons", "register_buttons_editor");

function enqueue_script() {
    $path = plugins_url( '/assets/js/main.js' , __FILE__ );
    echo("<script>console.log('PHP: ".$path."');</script>");
    wp_enqueue_script( 'add-script',$path, true , null);
}

add_action( 'admin_enqueue_scripts', 'enqueue_script' );

