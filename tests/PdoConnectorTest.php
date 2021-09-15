<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQuery\Pdo\PdoConnector;

final class PdoConnectorTest extends TestCase {

	public function testOk(): void {
		$connector = new PdoConnector('sqlite::memory:', '', '');

		$this->assertEquals(
			['1'],
			$connector->getConnection()->query("SELECT 1")->fetchAll(PDO::FETCH_COLUMN)
		);
	}

}