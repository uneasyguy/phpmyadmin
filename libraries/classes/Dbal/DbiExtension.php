<?php
/**
 * Contract for every database extension supported by phpMyAdmin
 */

declare(strict_types=1);

namespace PhpMyAdmin\Dbal;

use PhpMyAdmin\FieldMetadata;

/**
 * Contract for every database extension supported by phpMyAdmin
 */
interface DbiExtension
{
    /**
     * connects to the database server
     *
     * @param string $user     user name
     * @param string $password user password
     * @param array  $server   host/port/socket/persistent
     *
     * @return mixed false on error or a connection object on success
     */
    public function connect(
        $user,
        $password,
        array $server
    );

    /**
     * selects given database
     *
     * @param string|DatabaseName $databaseName database name to select
     * @param object              $link         connection object
     */
    public function selectDb($databaseName, $link): bool;

    /**
     * runs a query and returns the result
     *
     * @param string $query   query to execute
     * @param object $link    connection object
     * @param int    $options query options
     *
     * @return mixed result
     */
    public function realQuery($query, $link, $options);

    /**
     * Run the multi query and output the results
     *
     * @param object $link  connection object
     * @param string $query multi query statement to execute
     *
     * @return bool
     */
    public function realMultiQuery($link, $query);

    /**
     * returns array of rows with associative and numeric keys from $result
     *
     * @param object $result result set identifier
     */
    public function fetchArray($result): ?array;

    /**
     * returns array of rows with associative keys from $result
     *
     * @param object $result result set identifier
     */
    public function fetchAssoc($result): ?array;

    /**
     * returns array of rows with numeric keys from $result
     *
     * @param object $result result set identifier
     */
    public function fetchRow($result): ?array;

    /**
     * Adjusts the result pointer to an arbitrary row in the result
     *
     * @param object $result database result
     * @param int    $offset offset to seek
     */
    public function dataSeek($result, $offset): bool;

    /**
     * Frees memory associated with the result
     *
     * @param object $result database result
     */
    public function freeResult($result): void;

    /**
     * Check if there are any more query results from a multi query
     *
     * @param object $link the connection object
     */
    public function moreResults($link): bool;

    /**
     * Prepare next result from multi_query
     *
     * @param object $link the connection object
     */
    public function nextResult($link): bool;

    /**
     * Store the result returned from multi query
     *
     * @param object $link mysql link
     *
     * @return mixed false when empty results / result set when not empty
     */
    public function storeResult($link);

    /**
     * Returns a string representing the type of connection used
     *
     * @param object $link mysql link
     *
     * @return string type of connection used
     */
    public function getHostInfo($link);

    /**
     * Returns the version of the MySQL protocol used
     *
     * @param object $link mysql link
     *
     * @return int|string version of the MySQL protocol used
     */
    public function getProtoInfo($link);

    /**
     * returns a string that represents the client library version
     *
     * @return string MySQL client library version
     */
    public function getClientInfo();

    /**
     * returns last error message or false if no errors occurred
     *
     * @param object $link connection link
     *
     * @return string|bool error or false
     */
    public function getError($link);

    /**
     * returns the number of rows returned by last query
     *
     * @param object|bool $result result set identifier
     *
     * @return string|int
     * @psalm-return int|numeric-string
     */
    public function numRows($result);

    /**
     * returns the number of rows affected by last query
     *
     * @param object $link the connection object
     *
     * @return int|string
     * @psalm-return int|numeric-string
     */
    public function affectedRows($link);

    /**
     * returns metainfo for fields in $result
     *
     * @param object $result result set identifier
     *
     * @return FieldMetadata[]|null meta info for fields in $result
     */
    public function getFieldsMeta($result): ?array;

    /**
     * return number of fields in given $result
     *
     * @param object $result result set identifier
     *
     * @return int field count
     */
    public function numFields($result);

    /**
     * returns the length of the given field $i in $result
     *
     * @param object $result result set identifier
     * @param int    $i      field
     *
     * @return int|bool length of field
     */
    public function fieldLen($result, $i);

    /**
     * returns name of $i. field in $result
     *
     * @param object $result result set identifier
     * @param int    $i      field
     *
     * @return string name of $i. field in $result
     */
    public function fieldName($result, $i);

    /**
     * returns properly escaped string for use in MySQL queries
     *
     * @param mixed  $link   database link
     * @param string $string string to be escaped
     *
     * @return string a MySQL escaped string
     */
    public function escapeString($link, $string);

    /**
     * Prepare an SQL statement for execution.
     *
     * @param mixed  $link  database link
     * @param string $query The query, as a string.
     *
     * @return object|false A statement object or false.
     */
    public function prepare($link, string $query);
}
