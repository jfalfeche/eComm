<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitead8f0cbecdc1bc71ef851c59267ca8d
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitead8f0cbecdc1bc71ef851c59267ca8d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitead8f0cbecdc1bc71ef851c59267ca8d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitead8f0cbecdc1bc71ef851c59267ca8d::$classMap;

        }, null, ClassLoader::class);
    }
}
