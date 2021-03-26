<?php

abstract class Model
{
    protected static $tableName = null;
    protected static $primaryKey = null;

    public static function getAll()
    {
        $delimiter = Database::getDelimiter();
        $tableName = $delimiter . static::$tableName . $delimiter;

        $sql = 'SELECT * FROM ' . $tableName;
        $pst = Database::getInstance()->prepare($sql);
        $pst->execute();

        return $pst->fetchAll();
    }

    public static function getById($id)
    {
        $delimiter = Database::getDelimiter();
		$tableName = $delimiter . static::$tableName . $delimiter;
        $primaryKey = $delimiter . static::$primaryKey . $delimiter;

        $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $primaryKey . ' = :id;';
        $pst = Database::getInstance()->prepare($sql);
        $pst->bindValue(':id', $id);
        $pst->execute();

        return $pst->fetch();
    }

    public static function create($data)
    {
        $delimiter = Database::getDelimiter();
        $tableName = $delimiter . static::$tableName . $delimiter;
        $fields = $placeholders = $values = [];

        // TODO Mieux gerer le cas ou il n y a pas de parametres
        if (!is_array($data) || count($data) === 0) {
            echo 'SQL: Bad input for create.';
            exit();
        }

        foreach ($data as $field => $value) {
            $fields[] = $delimiter . $field . $delimiter;
            $values[] = $value;
            $placeholders[] = '?';
        }

        $fields = '(' . implode(', ', $fields) . ')';
        $placeholders = '(' . implode(', ', $placeholders) . ')';

        $sql = 'INSERT INTO ' . $tableName . $fields . ' VALUES ' . $placeholders . ';';
        $pst = Database::getInstance()->prepare($sql);

        /* Impossible de retouner last id avec une primary key composite
        if ($pst->execute($values)) {
            return Database::getInstance()->lastInsertId();
        }
        */

        if ($pst->execute($values)) {
            return true;
        }

        return false;
    }

    public static function update($id, $data)
    {
        $delimiter = Database::getDelimiter();
        $tableName = $delimiter . static::$tableName . $delimiter;
        $primaryKey = $delimiter . static::$primaryKey . $delimiter;
        $fields = $values = [];

        // TODO Mieux gerer le cas ou il n y a pas de parametres
        if (!is_array($data) || count($data) === 0) {
            die('MODEL: Bad input for update.');
        }

        foreach ($data as $field => $value) {
            $fields[] = $delimiter . $field . $delimiter . ' = ?';
            $values[] = $value;
        }

        $fields = implode(', ', $fields);
        $values[] = $id;

        $sql = 'UPDATE ' . $tableName . ' SET ' . $fields . ' WHERE ' . $primaryKey . ' = ?;';
        $pst = Database::getInstance()->prepare($sql);

        if($pst->execute($values)) {
            return $pst->rowCount();
        }

        return false;
    }

    public static function delete($id)
    {
        $delimiter = Database::getDelimiter();
        $tableName = $delimiter . static::$tableName . $delimiter;
        $primaryKey = $delimiter . static::$primaryKey . $delimiter;

        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $primaryKey . ' = :id;';
        $pst = Database::getInstance()->prepare($sql);
        $pst->bindValue(':id', $id);

        return $pst->execute();
    }

    private function __construct()
    {
    }
}
