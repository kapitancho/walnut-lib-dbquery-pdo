# PDO Adapter for the Query Executor

## A default implementation for the QueryExecutor interface

### Example
```php
$connector = new PdoConnector('sqlite::memory:', '', '');
$executor = new PdoQueryExecutor($connector);

$executor->execute("SELECT 1 AS val")->singleValue(); //1
$executor->execute("SELECT 1 AS val")->first(); //['val' => '1'],
$executor->execute("SELECT 1 AS val")->all(); //[['val' => '1']]
$executor->execute("SELECT 1")->collectAsList()->all(); //[['val' => '1']]
$executor->execute("SELECT 1 AS k, 1 AS val")->collectAsHash()->all(); //[1 => ['val' => '1']]
$executor->execute("SELECT 1 AS k, 1 AS val")->collectAsTreeData()->all(); //[1 => [['val' => '1']]],
```