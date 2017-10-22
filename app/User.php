<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /** Possible states of the user's verified field. */
    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    /** Possible states of the user's admin field. */
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    /** The table associated with the model. */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /******************************************************************************************************************/

    /**
     * Checks if the user is verified.
     * @return bool True when the user is verified, false otherwise.
     */
    public function isVerified() : bool
    {
        return $this->verified == User::VERIFIED_USER;
    }

    /******************************************************************************************************************/

    /**
     * Checks if the user is admin.
     * @return bool True when the user has admin privileges, false otherwise.
     */
    public function isAdmin() : bool
    {
        return $this->admin == User::ADMIN_USER;
    }

    /******************************************************************************************************************/

    /**
     * Generates random string for the verification code.
     * @return string
     */
    public static function generateVerificationCode() : string
    {
        return str_random(40);
    }
}
