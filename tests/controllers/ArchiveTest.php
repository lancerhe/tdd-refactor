<?php
/**
 * Request archive controller testcase.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace TestCase\Controller;

use \YafUnit\TestCase;

class ArchiveTest extends TestCase {

    protected $_setup_data = [
        "('1', '56500', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '1421035200')",
        "('2', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '1421467200')",
        "('3', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '1421488800')",
        "('4', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '1422756000')",
        "('5', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '{time}')",
        "('6', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '{time}')",
        "('7', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '{time}')",
        "('8', '15000', '1364', '13636', '15000', '100040', '1', '10.50.51.72', 'apps', '{time}')",
    ];

    public function setUp() {
        parent::setUp();
        $this->setUpDatabase();
    }

    /**
     * setup for database.
     */
    public function setUpDatabase() {
        $this->medoo()->setUp();
        $this->medoo()->exec("DROP TABLE IF EXISTS request_archives_201501");
        $this->medoo()->exec("DROP TABLE IF EXISTS request_archives_201502");
        foreach ($this->_setup_data as $value) 
            $this->medoo()->query("INSERT INTO request VALUES " . str_replace('{time}', time(), $value) );
    }

    /**
     * @test
     */
    public function archive() {
        $request = new \YafUnit\Request\Http('/archive/request');
        self::$_app->getDispatcher()->dispatch( $request );

        $this->assertEquals(1, $this->medoo()->query("SELECT count(*) FROM request_archives_201502")->fetchAll()[0][0]);
        $this->assertEquals(3, $this->medoo()->query("SELECT count(*) FROM request_archives_201501")->fetchAll()[0][0]);
        $this->assertEquals(4, $this->medoo()->query("SELECT count(*) FROM request")->fetchAll()[0][0]);
    }
}