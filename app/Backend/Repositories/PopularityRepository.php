<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Popularity;
use App\Shared\Repositories\BaseRepository;

final class PopularityRepository extends BaseRepository
{
    public $tableName = 'Popularity';
    public $class = Popularity::class;

    function findAllPopularities($id)
    {

        $s = $this->db->prepare('SELECT ROUND(SUM(vote) / COUNT(*),1) AS points
        FROM ' . $this->tableName . ' 
        WHERE id_company = ' . $id );
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class);

        return $s->fetch();
    }
}
