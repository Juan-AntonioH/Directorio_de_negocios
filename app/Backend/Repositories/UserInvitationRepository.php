<?php

namespace App\Backend\Repositories;

use App\Backend\Models\UserInvitation;
use App\Shared\Repositories\BaseRepository;

final class UserInvitationRepository extends BaseRepository
{
    public $tableName = 'user_invitation';
    public $class = UserInvitation::class;
}
