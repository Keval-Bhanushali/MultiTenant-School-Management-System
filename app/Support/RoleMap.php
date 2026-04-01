<?php

namespace App\Support;

class RoleMap
{
    public const SUPERADMIN = 1;
    public const ADMIN = 2;
    public const STAFF = 3;
    public const TEACHER = 4;
    public const STUDENT = 5;
    public const PARENT = 6;
    public const ALUMNI = 7;

    private const NAME_TO_ID = [
        'superadmin' => self::SUPERADMIN,
        'admin' => self::ADMIN,
        'staff' => self::STAFF,
        'teacher' => self::TEACHER,
        'student' => self::STUDENT,
        'parent' => self::PARENT,
        'alumni' => self::ALUMNI,
    ];

    private const ID_TO_NAME = [
        self::SUPERADMIN => 'superadmin',
        self::ADMIN => 'admin',
        self::STAFF => 'staff',
        self::TEACHER => 'teacher',
        self::STUDENT => 'student',
        self::PARENT => 'parent',
        self::ALUMNI => 'alumni',
    ];

    public static function idFromName(string $name): int
    {
        return self::NAME_TO_ID[strtolower($name)] ?? self::STUDENT;
    }

    public static function nameFromId(int $id): string
    {
        return self::ID_TO_NAME[$id] ?? 'student';
    }
}
