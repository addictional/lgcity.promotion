<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit057bed07613affe5b1806066a82f0fad
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '65fec9ebcfbb3cbb4fd0d519687aea01' => __DIR__ . '/..' . '/danielstjules/stringy/src/Create.php',
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/..' . '/illuminate/support/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Translation\\' => 30,
            'Stringy\\' => 8,
        ),
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Database\\' => 20,
            'Illuminate\\Contracts\\' => 21,
            'Illuminate\\Container\\' => 21,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Inflector\\' => 26,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Stringy\\' => 
        array (
            0 => __DIR__ . '/..' . '/danielstjules/stringy/src',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/support',
        ),
        'Illuminate\\Database\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/database',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
        'Illuminate\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/container',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/nesbot/carbon/src',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit057bed07613affe5b1806066a82f0fad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit057bed07613affe5b1806066a82f0fad::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit057bed07613affe5b1806066a82f0fad::$fallbackDirsPsr4;

        }, null, ClassLoader::class);
    }
}
