<?php
namespace Core;

/**
 * Db db access thru PDO
 *
 * PHP version 7.0.10
 *
 * @author    Genadijs Aleksejenko <agenadij@gmail.com>
 * @copyright 2017 Genadijs Aleksejenko
 */

class Db
{
    /**
     * @var PDOStatement last query statement
     */
    protected $statement = null;

    /**
     * @var PDO used link
     */
    protected $pdo = null;

    /**
     * Constructor
     *
     * @param string $dsn      data source name
     * @param array  $db_logn  db login
     * @param string $db_psw   database password
     *
     * @return void
     */
    public function __construct()
    {
        try
        {
            $this->pdo = new \PDO(DB_HOST, DB_LOGIN, DB_PSW);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $this->pdo->exec('SET NAMES utf8');
        }
        catch (\PDOException $e)
        {
            throw new ECore('PDO connection failed: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Statement preparing and execution
     *
     * @param string $sql     query string
     * @param array  $params  query parameters
     *
     * @return PDOStatement statement execution
     */
    protected function executeStatement($sql, $params = null)
    {
        $this->statement = null;
        try
        {
            $this->statement = $this->pdo->prepare($sql);
            $this->statement->execute($params);
            return $this->statement;
        }
        catch (\PDOException $e)
        {
            throw new ECore('PDO query failed: ' . $e->getMessage() . '<br />SQL: ' . $sql, $e->getCode());
        }
    }

    /**
     * Retrieves the first column of the first row.
     *
     * @param string $sql     query
     * @param array  $params  query parameters
     *
     * @return mixed result set
     */
    public function getOne($sql, $params = null)
    {
        $sql = $this->prepareSql($sql, $params);

        $this->statement = $this->executeStatement($sql, null);
        $data = $this->statement->fetchColumn(0);
        $this->statement->closeCursor();

        return $data;
    }

    /**
     * Retrieves the first row of the result set as a associative array
     *
     * @param string $sql     query
     * @param array  $params  query parameters
     * 
     * @return array result set
     */
    public function getRow($sql, $params = null)
    {
        $sql = $this->prepareSql($sql, $params);

        $this->statement = $this->executeStatement($sql, null);
        $data = $this->statement->fetch(\PDO::FETCH_ASSOC);
        $this->statement->closeCursor();

        return $data;
    }

    /**
     * Retrieves the first column of the result
     *
     * @param string $sql                  query
     * @param array  $params               query parameters
     *
     * @return array result set
     */
    public function getColumn($sql, $params = null)
    {
        $sql = $this->prepareSql($sql, $params);

        $this->statement = $this->executeStatement($sql, null);
        $data = $this->statement->fetchAll(\PDO::FETCH_COLUMN);
        $this->statement->closeCursor();

        return $data;
    }

    /**
     * Retrieves all the rows from resultset in assoc mode.
     * (!) Make sure the result set isn't that large. Use limit sql clause.
     *
     * @param string $sql                  query
     * @param array  $params               query parameters
     *
     * @return array result set
     */
    public function getAll($sql, $params = null)
    {
        $sql = $this->prepareSql($sql, $params);

        $this->statement = $this->executeStatement($sql, null);
        $data = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
        $this->statement->closeCursor();

        return $data;
    }

    /**
     * Executes the query.. update, insert, delete etc etc.. (excluding SELECT)
     *
     * @param string $sql     query
     * @param array  $params  parameters
     *
     * @return affected rows
     */
    public function query($sql, $params = null)
    {
        $sql = $this->prepareSql($sql, $params);
        $this->statement = $this->executeStatement($sql, null);
        $this->statement->closeCursor();

        return $this->statement->rowCount();
    }

    /**
     * Update a table using associative array
     *
     * @param string $table_name table name
     * @param array  $params     query parameters
     * @param string $where      WHERE body
     *
     * @return affected rows
     */
    public function update($table_name, $params, $where = null)
    {
        if (empty($params))
        {
            return false;
        }
        $field_list = array();

        if (!is_array($params))
        {
            throw new ECore('db->update() method require array passed as $params. You sent ' . gettype($params), 0);
        }
        foreach ($params as $key => $val)
        {
            $field_list[] = "`{$key}` = :{$key}";
            if (is_array($val))
            {
                $params[$key] = implode(',', $val);
            }
        }
        $sql = "UPDATE {$table_name} SET " . join(', ', $field_list) . (empty($where) ? '' : ' WHERE ' . $where);

        return $this->query($sql, $params);
    }

    /**
     * Insert record to the table using associative array
     *
     * @param string $table_name table name
     * @param array  $params     query parameters
     *
     * @return affected rows
     */
    public function insert($table_name, $params)
    {
        if (empty($params))
        {
            return false;
        }
        $field_list = array();
        $values_list = array();

        if (!is_array($params))
        {
            throw new ECore('db->insert() method require array passed as $params. You sent ' . gettype($params), 0);
        }
        foreach ($params as $key => $val)
        {
            $field_list[] = "`{$key}`";
            $values_list[] = ":{$key}";

            if (is_array($val))
            {
                $params[$key] = implode(',', $val);
            }
        }
        $sql = "INSERT INTO {$table_name} (" . implode(', ', $field_list) . ') VALUES (' . implode(', ', $values_list) . ')';

        return $this->query($sql, $params);
    }

    /**
     * Bulk insert records to the table
     *
     * @param string $table_name table name
     * @param array  $fields     query fields
     * @param array  $values     query values
     *
     * @return affected rows
     */
    public function bulkInsert($table_name, $fields, $values)
    {
        if (empty($fields) || empty($values))
        {
            return false;
        }
        $field_list = array();
        $values_list = array();
        $params = array();

        for ($i = 0; $i < sizeOf($fields); $i++)
        {
            $field_list[] = "`{$fields[$i]}`";
        }
        for ($i = 0; $i < sizeOf($values); $i++)
        {
            $data = array();
            for ($j = 0; $j < sizeOf($fields); $j++)
            {
                $value_key = "{$fields[$j]}_{$i}_{$j}";
                $data[] = ":{$value_key}";
                $params[$value_key] = $values[$i][$j];
            }
            $values_list[] = '(' . implode(', ', $data) . ')';
        }

        $sql = "INSERT INTO {$table_name} (" . implode(', ', $field_list) . ') VALUES ' . implode(', ', $values_list);

        return $this->query($sql, $params);
    }

    /**
     * Begin transaction
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    /**
     * Commit transaction
     *
     * @return void
     */
    public function commit()
    {
        $this->pdo->commit();
    }

    /**
     * Commit transaction
     *
     * @return void
     */
    public function rollback()
    {
        $this->pdo->rollback();
    }

    /**
     * Getter for last Statement
     *
     * @return PDOStatement last statement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Getter for last SQL query
     *
     * @return string last SQL query
     */
    public function getSql()
    {
        return $this->statement->queryString;
    }

    /**
     * Smart parameters binding
     *
     * @param string $sql    query
     * @param array  $params query params
     *
     * @return string prepared sql
     */
    public function prepareSql($sql, $params)
    {
        $is_assoc = false;
        foreach (array_keys((array) $params) as $k => $v)
        {
            if ($k !== $v)
            {
                $is_assoc = true;
            }
        }

        if (!$is_assoc && strpos($sql, '?') !== false)
        {
            $sql = explode('?', $sql);
            $new_params = array();
            for ($i = 0; $i < sizeOf($params); $i++)
            {
                $sql[$i] .= ":question_sigh_{$i}";
                $new_params["question_sigh_{$i}"] = $params[$i];
            }
            $sql = join('', $sql);
            $params = $new_params; 
        }

        if (!is_array($params))
        {
            $params = (array) $params;
        }

        if (!empty($params))
        {
            foreach ((array) $params as $key => $val)
            {
                if (is_array($val))
                {
                    $keys = array();
                    $values = array();
                    foreach ($val as $k => $v)
                    {
                        $new_key = "{$key}_{$k}";
                        $keys[] = ":{$new_key}";
                        $values[$new_key] = $v;
                    }
                    $sql = str_ireplace(":{$key}", join(',', $keys), $sql);
                    unset($params[$key]);
                    $params = array_merge($params, $values);
                }
            }

            // leading and ending spaces for parameters so that prevent ":id" ":ids" "idds" replacement issue
            $sql = preg_replace('/(:[a-zA-Z0-9_]*)/', ' $1 ', $sql);

            // type detection
            $replace = array();
            foreach ($params as $key => $val)
            {
                if (is_int($val) || is_float($val))
                {
                    $replace[" :{$key} "] = $val;
                }
                else if (is_bool($val))
                {
                    $replace[" :{$key} "] = (int) $val;
                }
                else if (is_null($val))
                {
                    $replace[" :{$key} "] = 'NULL';
                }
                else if (substr($val, 0, 6) == '[blob]')
                {
                    $val = substr($val, 6);
                    $replace[" :{$key} "] = $this->pdo->quote($val, \PDO::PARAM_LOB);
                }
                else
                {
                    $val = html_entity_decode($val, true);
                    $replace[" :{$key} "] = $this->pdo->quote($val, \PDO::PARAM_STR);
                }
            }
            if (!empty($replace))
            {
                $sql = str_replace(array_keys($replace), array_values($replace), $sql);
            }
        }
        return $sql;
    }

    /**
     * Smart parameters binding
     *
     *
     * @return int returns the ID of the last inserted row
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
