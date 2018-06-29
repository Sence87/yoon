<?php
/**
 * User: jg
 * Date: 13/02/17
 * Time: 15:48
 */

namespace ByJG\AnyDataset;

use ByJG\AnyDataset\Store\PdoLiteral;
use ByJG\Util\Uri;

class Factory
{
    /**
     * @param $connectionString
     * @param $schemesAlternative
     * @return \ByJG\AnyDataset\DbDriverInterface
     */
    public static function getDbRelationalInstance($connectionString, $schemesAlternative = null)
    {
        $prefix = '\\ByJG\\AnyDataset\\Store\\';

        $instance = self::getInstance(
            $connectionString,
            array_merge(
                [
                    "oci8" => $prefix . "DbOci8Driver",
                    "dblib" => $prefix . "PdoDblib",
                    "mysql" => $prefix . "PdoMysql",
                    "pgsql" => $prefix . "PdoPgsql",
                    "oci" => $prefix . "PdoOci",
                    "odbc" => $prefix . "PdoOdbc",
                    "sqlite" => $prefix . "PdoSqlite",
                ],
                (array)$schemesAlternative
            ),
            DbDriverInterface::class
        );

        return $instance;
    }

    /**
     * @param $connectionString
     * @param $schemesAlternative
     * @return NoSqlInterface
     */
    public static function getNoSqlInstance($connectionString, $schemesAlternative = null)
    {
        $prefix = '\\ByJG\\AnyDataset\\Store\\';

        $instance = self::getInstance(
            $connectionString,
            array_merge(
                [
                    "mongodb" => $prefix . "MongoDbDriver",
                ],
                (array)$schemesAlternative
            ),
            NoSqlInterface::class
        );

        return $instance;
    }

    /**
     * @param string $connectionString
     * @param array $schemesAlternative
     * @return KeyValueInterface
     */
    public static function getKeyValueInstance($connectionString, $schemesAlternative = null)
    {
        $prefix = '\\ByJG\\AnyDataset\\Store\\';

        $instance = self::getInstance(
            $connectionString,
            array_merge(
                [
                    "s3" => $prefix . "AwsS3Driver",
                ],
                (array)$schemesAlternative
            ),
            KeyValueInterface::class
        );

        return $instance;
    }

    protected static function getInstance($connectionString, $validSchemes, $typeOf)
    {
        $connectionUri = new Uri($connectionString);

        $scheme = $connectionUri->getScheme();

        $class = isset($validSchemes[$scheme]) ? $validSchemes[$scheme] : PdoLiteral::class;

        $instance = new $class($connectionUri);

        if (!is_a($instance, $typeOf)) {
            throw new \InvalidArgumentException(
                "The class '$typeOf' is not a instance of DbDriverInterface"
            );
        }

        return $instance;
    }

    /**
     * Get a IDbFunctions class to execute Database specific operations.
     *
     * @param \ByJG\Util\Uri $connectionUri
     * @return \ByJG\AnyDataset\DbFunctionsInterface
     */
    public static function getDbFunctions(Uri $connectionUri)
    {
        $dbFunc = "\\ByJG\\AnyDataset\\Store\\Helpers\\Db"
            . ucfirst($connectionUri->getScheme())
            . "Functions";
        return new $dbFunc();
    }
}
