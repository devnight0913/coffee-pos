<?php

namespace App\Models;

class Role
{
    const SUPER_ADMIN = "super_admin";
    const ADMIN = "admin";
    const CASHIER = "cashier";


    public static $roles = [
        self::ADMIN => "admin",
        self::CASHIER => "cashier",
    ];
}
