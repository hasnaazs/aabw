<?php

namespace Config;

use Myth\Auth\Config\Auth as MythAuth;

class Auth extends MythAuth
{
    public $defaultUserGroup = '';

    public $views = [
        'login'           => 'Myth\Auth\Views\login',
        'register'        => 'Myth\Auth\Views\register',
        'forgot'          => 'Myth\Auth\Views\forgot',
        'reset'           => 'Myth\Auth\Views\reset',
        'emailForgot'     => 'Myth\Auth\Views\emails\forgot',
        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];

    public $validFields = ['email', 'username'];
    public $personalFields = [];
    public $maxPasswordLength = 255;
    public $minimumPasswordLength = 8;

    public $passwordValidators = [
        'Myth\Auth\Authentication\Passwords\CompositionValidator',
        'Myth\Auth\Authentication\Passwords\NothingPersonalValidator',
        'Myth\Auth\Authentication\Passwords\DictionaryValidator',
    ];

    public $allowRegistration = true;
    public $requireActivation = 'Myth\Auth\Authentication\Activators\EmailActivator';
    public $activeResetter = 'Myth\Auth\Authentication\Resetters\EmailResetter';

    public $userActivators = [
        'Myth\Auth\Authentication\Activators\EmailActivator' => [
            'fromEmail' => null,
            'fromName'  => null,
        ],
    ];

    public $hashAlgorithm = PASSWORD_BCRYPT;
    public $hashCost = 10;
}
