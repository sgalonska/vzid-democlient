<?php

/**
 * Class Db
 *
 * Tiny database layer for handling connections and statments
 *
 * @author sgalonska
 *
 */
class Db {

    const DB = '';
    const HOST = '';
    const USER = '';
    const PW = '';

    /**
     * get a database handler
     *
     * @staticvar PDO $con
     * @return PDO
     */
    public static function getConnection() {
        static $con;
        if (!isset($con)) {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DB;
            try {
            $con = new PDO(
                $dsn,
                self::USER,
                self::PW,
                array(PDO::FETCH_ASSOC)
            );
            } catch (Exception $e) {
                throw new Exception('cannot connect to db');
            }
        }
        return $con;
    }

    public static function prepare($sql) {
        $con = self::getConnection();
        return $con->prepare($sql);
    }

    /**
    * queries the db
     *
     * @param string $sql the query with placeholders
     * @param array $params given query parameters as associative array
     * @return array
     */
    public static function execute($sql, array $params = array()) {
        $statement = self::prepare($sql);
        foreach ($params as $key => $currentValue) {
            if (is_array($currentValue)) {
                list($value, $type) = $currentValue;
                $statement->bindValue($key, $value, $type);
            } else {
                $statement->bindValue($key, $currentValue);
            }
        }
        $statement->execute();
        return $statement;
    }

    public static function fetch($sql, array $params = array()) {
        return self::execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchAll($sql, array $params = array()) {
        return self::execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}