<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQuery\Pdo\PdoConnector;
use Walnut\Lib\DbQuery\Pdo\PdoQueryExecutor;

final class PdoQueryExecutorTest extends TestCase {

	public function testOk(): void {
		$connector = new PdoConnector('sqlite::memory:', '', '');
		$executor = new PdoQueryExecutor($connector);

		$this->assertEquals(
			'0',
			$executor->lastIdentity()
		);

		$this->assertEquals(
			'1',
			$executor->execute("SELECT 1")->singleValue()
		);

		$this->assertEquals(
			[1 => '1'],
			$executor->execute("SELECT 1")->first()
		);

		$this->assertEquals(
			[[1 => '1']],
			$executor->execute("SELECT 1")->all()
		);

		$this->assertEquals(
			[[1 => '1']],
			$executor->execute("SELECT 1")->collectAsList()->all()
		);

		$this->assertEquals(
			[1 => [1 => '1']],
			$executor->execute("SELECT 1 AS `key`, 1")->collectAsHash()->all()
		);

		$this->assertEquals(
			[1 => [[1 => '1']]],
			$executor->execute("SELECT 1 AS `key`, 1")->collectAsTreeData()->all()
		);
	}

}