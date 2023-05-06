<?php
namespace App\Backend\Services;

use Slim\Flash\Messages as Flash;
use App\Backend\Models\popularity;
use Psr\Container\ContainerInterface;
use App\Backend\Repositories\PopularityRepository;


final class PopularityService
{

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Flash
     */
    private $flash;
    private PopularityRepository $popularityRepository;

    public function __construct(PopularityRepository $popularityRepository, ContainerInterface $container, Flash $flash)
    {
        $this->popularityRepository = $popularityRepository;
        $this->container = $container;
        $this->flash = $flash;
    }
    public function save(array $fields)
    {
        $popularity = $this->popularityRepository->findWhere('WHERE id_company = ' . $fields['id_company']) ?: new Popularity();

        foreach ($fields as $field => $value) {
            $popularity->$field = $value;
        }
        return $this->popularityRepository->save($popularity);
    }
}
