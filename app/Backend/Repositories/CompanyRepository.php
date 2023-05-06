<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Company;
use App\Shared\Repositories\BaseRepository;

final class CompanyRepository extends BaseRepository
{
    public $tableName = 'company';
    public $class = Company::class;

    function findCompanies($limit = 0)
    {
        $limit = $limit > 0 ? " LIMIT " . $limit : "";

        $s = $this->db->prepare('SELECT c.*, p.name as provincia
        FROM ' . $this->tableName . ' as c 
        INNER JOIN provincias as p ON c.provincia = p.id 
        WHERE deleted = 0 ORDER BY created_at DESC' . $limit);

        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class);

        return $s->fetchAll();
    }

    function findCompaniesUser($id)
    {

        $s = $this->db->prepare('SELECT c.*, p.name as provincia
        FROM ' . $this->tableName . ' as c 
        INNER JOIN provincias as p ON c.provincia = p.id 
        WHERE deleted = 0 AND id_creator = ' . $id . ' ORDER BY created_at DESC');

        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class);

        return $s->fetchAll();
    }

    function findCompaniesPopularity($limit = 0)
    {
      $limit = $limit > 0 ? " LIMIT " . $limit : "";

      $s = $this->db->prepare('SELECT
      c.*,
      p.name as provincia,
      (
        SELECT ROUND(SUM(po.vote) / COUNT(*), 1)
        FROM popularity as po    WHERE po.id_company = c.id
      ) as points
    FROM
      company as c
      INNER JOIN provincias as p ON c.provincia = p.id
    WHERE
      deleted = 0
    ORDER BY
      points DESC' . $limit);

      $s->execute();
      $s->setFetchMode(\PDO::FETCH_CLASS, $this->class);

      return $s->fetchAll();
    }
}
