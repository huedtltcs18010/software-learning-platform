<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const AVATAR_FILE_SIZE_LIMITATION = 2048;
    const MIN_PASSWORD_LENGTH = 6;
    const MAX_PASSWORD_LENGTH = 16;

    const ROLE_ADMIN = 1;
    const ROLE_MENTOR = 2;
    const ROLE_LEARNER = 3;

    const DEFAULT_AVATAR_URL = '/images/avatar-person.svg';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
