<?php

namespace App\Backend\Validation\Rules;

use App\Backend\Repositories\UserRepository;
use Respect\Validation\Rules\AbstractRule;

final class UserAvailable extends AbstractRule
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($input): bool
    {
        $user = $this->userRepository->find($input);

        return $user ? true : false;
    }
}
