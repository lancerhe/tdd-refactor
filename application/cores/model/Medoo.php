<?php
/**
 * Medoo Model
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-22
 */
namespace Core\Model;

class Medoo extends \Core\Model {

    public static $Medoo = null;

    public function medoo() {
        if ( ! is_null( self::$Medoo ) ) {
            return self::$Medoo;
        }

        $config = (new \Yaf\Config\Ini( APPLICATION_CONFIG_PATH . '/database.ini', \Yaf\ENVIRON))->database;

        self::$Medoo = new \Medoo([
            'database_type' => $config->type,
            'database_file' => ROOT_PATH . $config->file,
        ]);
        return self::$Medoo;
    }
}