<?php
namespace App\Enums;

enum RolesEnum: string
{
    // case NAMEINAPP = 'name-in-database';

    case ADMIN = 'admin';
    case USER = 'user';

    /**
     * Array of available roles.
     *
     * @var array
     */
    const SET = [
        self::ADMIN,
        self::USER,
    ];

}