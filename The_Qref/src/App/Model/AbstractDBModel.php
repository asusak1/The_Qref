<?php

namespace App\Model;


use DB\DBPool;

abstract class AbstractDBModel implements DBModel {

    /**
     * Primarni ključ.
     * @var mixed
     */
    private $pk;

    /**
     * Redak tablice. Podaci modela.
     * @var mixed
     */
    private $data;

    public function __construct() {
        $this->data = new \stdClass();
    }

    /**
     * Spremanje novog podatka ili osvježavanje postojećeg.
     */
    public function save() {
        $columns = $this->getColumns();

        if (null === $this->pk) {

            $values = array();
            $placeHolders = array();
            foreach ($columns as $column) {
                $values[] = $this->data->$column;
                $placeHolders[] = "?";
            }

            $sql = "INSERT INTO " . $this->getTable() . " (" . implode(", ", $columns)
                . ") VALUES (" . implode(", ", $placeHolders) . ")";

            DBPool::getInstance()->prepare($sql)->execute($values);

            $this->pk = DBPool::getInstance()->lastInsertId();
        } else {

            $values = array();
            $placeHolders = array();
            foreach ($columns as $column) {
                $values[] = $this->data->$column;
                $placeHolders[] = $column . " = ?";
            }

            $values[] = $this->pk;

            $sql = "UPDATE " . $this->getTable() . " SET " . implode(", ", $placeHolders)
                . " WHERE " . $this->getPrimaryKeyColumn() . " = ?";



            DBPool::getInstance()->prepare($sql)->execute($values);
        }
    }

    /**
     * Dohvat podatka.
     * @param type $pk primarni ključ
     */
    public function load($pk) {

        $sql = "SELECT * FROM " . $this->getTable() . " WHERE " .
            $this->getPrimaryKeyColumn() . " = ?";

        $statement = DBPool::getInstance()->prepare($sql);
        $statement->execute(array($pk));

        if (1 !== $statement->rowCount()) {
            throw new NotFoundException();
        }

        $this->data = $statement->fetch();
        $pkCol = $this->getPrimaryKeyColumn();
        $this->pk = $this->data->$pkCol;
    }

    /**
     * Brisanje modela.
     * @return void
     */
    public function delete() {
        if (null === $this->pk) {
            return;
        }
        DBPool::getInstance()->prepare("DELETE FROM " . $this->getTable() . " WHERE " .
            $this->getPrimaryKeyColumn() . " = ?"
        )->execute(array($this->pk));
        $this->pk = null;
    }

    /**
     * Ispitivanje jednakosti modela.
     * @param \oipa\model\Model $model model
     * @return boolean true ako su modeli jednaki, false inače
     */
    public function equals(Model $model) {

        if (get_class($this) !== get_class($model)) {
            return false;
        }

        return $this->pk === $model->getPrimaryKey();
    }

    /**
     * Serijaliziran objekt.
     * @return type
     */
    public function serialize() {
        return serialize($this->data);
    }

    /**
     * Deserijaliziran objekt.
     * @param type $string
     */
    public function unserialize($string) {
        $this->data = unserialize($string);
    }

    /**
     * Dohvaćanje primarnog ključa.
     * @return mixed
     */
    public function getPrimaryKey() {
        return $this->pk;
    }

    /**
     * Dohvat kolone retka.
     * @param type $name ime kolone
     * @return mixed
     */
    public function __get($name) {
        return $this->data->$name;
    }

    /**
     * Postavljanje vrijednosti kolone retka
     * @param type $name ime kolone
     * @param type $value vrijednost
     * @return mixed
     */
    public function __set($name, $value) {
        return $this->data->$name = $value;
    }

    /**
     * Dohvat primarnog ključa.
     */
    public abstract function getPrimaryKeyColumn();

    /**
     * Dohvat tablice.
     */
    public abstract function getTable();

    /**
     * Vraća sve kolone osim primarnog ključa.
     * @return array
     */
    public abstract function getColumns();

    public function loadAll($where = null) {

        $sql = "SELECT * FROM " . $this->getTable() . " " .$where;

        $statement = DBPool::getInstance()->prepare($sql);
        $statement->execute();

        if (1 > $statement->rowCount()) {
            return null;
        }

        $resources = $statement->fetchAll();

        $collection = array();

        $className = get_class($this);
        //$attributes = $this->getColumns();
        foreach ($resources as $singleRow) {
            $model = new $className();
            $model->pk = $singleRow->{$this->getPrimaryKeyColumn()};
            $model->data = $singleRow;

            /*foreach ($attributes as $prop) {
                $model->$prop = $singleRow->{$prop};
            }*/

            $collection[] = $model;
        }

        return $collection;
    }

}