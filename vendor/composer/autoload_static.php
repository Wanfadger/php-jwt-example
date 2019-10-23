<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1fec92b7c3ce8790da82d356e43e4cdb
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1fec92b7c3ce8790da82d356e43e4cdb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1fec92b7c3ce8790da82d356e43e4cdb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
