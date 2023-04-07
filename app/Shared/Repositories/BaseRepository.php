<?php

namespace App\Shared\Repositories;

use App\Shared\Helpers\DB;
use App\Shared\Interfaces\ModelInterface;
use LogicException;
use PDO;
use Psr\Container\ContainerInterface;
use stdClass;

class BaseRepository
{
    /**
     * @var DB
     */
    protected $db;
    /**
     * @var ContainerInterface
     */
    protected $container;

    public $tableName = '';

    public $class = stdClass::class;

    public $dependencies = [];

    public function __construct(DB $db, ContainerInterface $container)
    {
        $this->db = $db;
        $this->container = $container;
    }

    public function findAll()
    {
        $s = $this->db->prepare('SELECT * FROM ' . $this->tableName);
        $s->execute();
        $s->setFetchMode(PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetchAll();
    }

    public function find($id)
    {
        $s = $this->db->prepare('SELECT * FROM ' . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER);
        $s->bindParam(':' . $this->class::DB_IDENTIFIER, $id, PDO::PARAM_INT);
        $s->execute();
        $s->setFetchMode(PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }

    public function findWhere(string $where = '', array $params = [])
    {
        $s = $this->db->prepare('SELECT * FROM ' . $this->tableName . ' ' . $where);

        foreach ($params as $keyParam => $param) {
            $s->bindParam($keyParam, $param['value'], $param['type']);
        }

        $s->execute();
        $s->setFetchMode(PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }

    public function findAllWhere(string $where = '', array $params = [])
    {
        $s = $this->db->prepare('SELECT * FROM ' . $this->tableName . ' ' . $where);

        foreach ($params as $keyParam => $param) {
            $s->bindParam($keyParam, $param['value'], $param['type']);
        }

        $s->execute();
        $s->setFetchMode(PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetchAll();
    }

    public function update(ModelInterface $model, array $attributes = [], string $where = '', array $whereParams = [])
    {
        if (!isset($model->{$this->class::DB_IDENTIFIER})) {
            throw new LogicException(
                'Cannot update user that does not yet exist in the database.'
            );
        }
        $attributes = empty($attributes) ? $model->getUpdateValues() : $attributes;
        [$whereParams, $where] = $this->prepareWhere($whereParams, $where);

        $set = $this->prepareSet($attributes);

        $s = $this->db->prepare('
            UPDATE ' . $this->tableName . '
            SET ' . $set . ' ' . $where);

        foreach ($attributes as $attribute) {
            $s->bindParam(':' . $attribute, $model->{$attribute});
        }

        foreach ($whereParams as $whereParam) {
            $s->bindParam(':' . $whereParam, $model->{$whereParam});
        }

        return $s->execute();
    }

    private function prepareSet(array $attributes)
    {
        $set = '';

        foreach ($attributes as $attribute) {
            $set .= $attribute . ' = :' . $attribute . ',';
        }

        return rtrim($set, ',');
    }

    public function save(ModelInterface $model, array $attributes = [])
    {
        if (isset($model->{$this->class::DB_IDENTIFIER})) {
            return $this->update($model);
        }
        $attributes = empty($attributes) ? $model->getCreateValues() : $attributes;

        $insertValues = $this->prepareInsertValues($attributes);

        $s = $this->db->prepare('
            INSERT INTO ' . $this->tableName . ' 
                ' . $insertValues['columns'] . ' 
            VALUES 
                ' . $insertValues['values'] . '
        ');

        foreach ($attributes as $attribute) {
            $s->bindParam(':' . $attribute, $model->{$attribute});
        }

        return $s->execute();
    }

    private function prepareInsertValues(array $attributes)
    {
        $insertValues = [
            'columns' => '(',
            'values' => '(',
        ];

        foreach ($attributes as $attribute) {
            $insertValues['columns'] .= $attribute . ',';
        }

        $insertValues['columns'] = rtrim($insertValues['columns'], ',');
        $insertValues['columns'] .= ')';

        foreach ($attributes as $attribute) {
            $insertValues['values'] .= ':' . $attribute . ',';
        }

        $insertValues['values'] = rtrim($insertValues['values'], ',');
        $insertValues['values'] .= ')';

        return $insertValues;
    }

    public function delete(ModelInterface $model, string $where = '', array $whereParams = [])
    {
        if (!isset($model->{$this->class::DB_IDENTIFIER})) {
            throw new LogicException(
                'Cannot delete user invitation that does not yet exist in the database.'
            );
        }

        [$whereParams, $where] = $this->prepareWhere($whereParams, $where);

        $s = $this->db->prepare('
            DELETE FROM ' . $this->tableName . '
             ' . $where);

        foreach ($whereParams as $whereParam) {
            $s->bindParam(':' . $whereParam, $model->{$whereParam});
        }

        return $s->execute();
    }

    private function prepareWhere(array $whereParams, string $where): array
    {
        $whereParams = empty($whereParams) ? [strval($this->class::DB_IDENTIFIER)] : $whereParams;
        $where = empty($where) ? 'WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER : $where;

        return [$whereParams, $where];
    }
}
