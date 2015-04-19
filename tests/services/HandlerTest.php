<?php
/**
 * Request archive service testcase.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace TestCase\Service;

use \YafUnit\TestCase;

class HandlerTest extends TestCase {

    public $data_provider = [
        "id"            => '1',
        "amount"        => '56500', 
        "coupons"       => '1364', 
        "cash"          => '13636',
        "request"       => '15000',
        "type"          => '100040',
        "production_id" => '1',
        "source_ip"     => '10.50.51.72',
        "source_name"   => 'apps', 
        "ctime"         => '1421035200',
    ];

    public $data_output_file = "/tmp/phpunit.log";

    /**
     * @test
     */
    public function createFailure() {
        $Handler = $this->getMock('Service\Archive\Request\Handler', ['create']);

        $Handler->method('create')
            ->will($this->throwException(new \Exception("Mock Message Create Failure.")));

        $Handler->setLoggerFile('/tmp/phpunit.log');
        $Handler->archive($this->data_provider);

        $this->assertContains(date('Y-m-d') . ":Mock Message Create Failure.", file_get_contents($this->data_output_file));
    }

    /**
     * @test
     */
    public function removeFailure() {
        $Handler = $this->getMock('Service\Archive\Request\Handler', ['create', 'remove']);

        $Handler->method('create')
            ->will($this->returnValue(true));
        $Handler->method('remove')
            ->will($this->throwException(new \Exception("Mock Message Remove Failure.")));

        $Handler->setLoggerFile('/tmp/phpunit.log');
        $Handler->archive($this->data_provider);

        $this->assertContains(date('Y-m-d') . ":Mock Message Remove Failure.", file_get_contents($this->data_output_file));
    }

    public function tearDown() {
        parent::tearDown();
        unlink($this->data_output_file);
    }
}