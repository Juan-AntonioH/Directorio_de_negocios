<?php

namespace App\Backend\Validation\Rules;

use App\Backend\Repositories\RoleRepository;
use Respect\Validation\Rules\AbstractRule;

final class RoleAvailable extends AbstractRule
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function validate($input): bool
    {
        $role = $this->roleRepository->find($input);

        return $role ? true : false;
    }
}
