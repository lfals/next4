<?php

namespace YOOtheme;

interface Database
{
    /**
     * Fetches all rows of the result as an associative array.
     *
     * @param string $statement
     * @param array  $params
     *
     * @return array
     */
    public function fetchAll($statement, array $params = []);

    /**
     * Fetches the first row of the result as an associative array.
     *
     * @param string $statement
     * @param array  $params
     *
     * @return array
     */
    public function fetchAssoc($statement, array $params = []);

    /**
     * Fetches the first row of the result as a numerically indexed array.
     *
     * @param string $statement
     * @param array  $params
     *
     * @return array
     */
    public function fetchArray($statement, array $params = []);

    /**
     * Prepares and executes an SQL query and returns the first row of the result as an object.
     *
     * @param string $statement
     * @param array  $params
     * @param string $class
     * @param array  $args
     *
     * @return object|null
     */
    public function fetchObject($statement, array $params = [], $class = 'stdClass', $args = []);

    /**
     * Prepares and executes an SQL query and returns the result as an array of objects.
     *
     * @param string $statement
     * @param array  $params
     * @param string $class
     * @param array  $args
     *
     * @return array
     */
    public function fetchAllObjects($statement, array $params = [], $class = 'stdClass', $args = []);

    /**
     * Executes an, optionally parametrized, SQL query.
     *
     * @param string $query
     * @param array  $params
     *
     * @return int|false
     */
    public function executeQuery($query, array $params = []);

    /**
     * Inserts a table row with specified data.
     *
     * @param string $table
     * @param mixed  $data
     *
     * @return int
     */
    public function insert($table, $data);

    /**
     * Updates a table row with specified data.
     *
     * @param string $table
     * @param mixed  $data
     * @param array  $identifier
     *
     * @return int
     */
    public function update($table, $data, $identifier);

    /**
     * Deletes a table row.
     *
     * @param string $table
     * @param array  $identifier
     *
     * @return int
     */
    public function delete($table, $identifier);

    /**
     * Escapes a string for usage in an SQL statement.
     *
     * @param string $text
     *
     * @return string
     */
    public function escape($text);

    /**
     * Retrieves the last inserted id.
     *
     * @return int
     */
    public function lastInsertId();
}
