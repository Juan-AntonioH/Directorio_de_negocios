<?php

namespace App\Backend\Services;


use Slim\Flash\Messages as Flash;
use Psr\Container\ContainerInterface;
use App\Backend\Repositories\CompanyRepository;

final class CompanyService
{

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Flash
     */
    private $flash;
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository, ContainerInterface $container, Flash $flash)
    {
        $this->companyRepository = $companyRepository;
        $this->container = $container;
        $this->flash = $flash;
    }
    
    function delete($id){
        $company = $this->companyRepository->find($id);

        $company->deleted = 1;

        return $this->companyRepository->update($company);
        

    }

}
