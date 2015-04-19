<?php
/**
 * Request archive service testcase.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace TestCase\Service;

use \YafUnit\TestCase;

class RequestTest extends TestCase {

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
        if ( is_file("/tmp/archiveresult.log") ) unlink("/tmp/archiveresult.log");
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
        $Archive = new \Service\Archive\Request();
        $Archive->setLimit(3);
        $Archive->setPassDays(40);
        $Archive->archive();

        $this->assertContains("success:3; failure: 0", file_get_contents("/tmp/archiveresult.log"));
    }
}