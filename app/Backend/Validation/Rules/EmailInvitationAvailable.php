<?php

namespace App\Backend\Validation\Rules;

use App\Backend\Repositories\UserInvitationRepository;
use Respect\Validation\Rules\AbstractRule;

final class EmailInvitationAvailable extends AbstractRule
{
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;

    public function __construct(UserInvitationRepository $userInvitationRepository)
    {
        $this->userInvitationRepository = $userInvitationRepository;
    }

    public function validate($input): bool
    {
        $user = $this->userInvitationRepository->findWhere('WHERE email = :email', [
            ':email' => [
                'value' => $input,
                'type' => \PDO::PARAM_STR,
            ],
        ]);

        return $user ? false : true;
    }
}
