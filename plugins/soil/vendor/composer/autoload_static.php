<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4ac2b00e002f336e8293d288bb29d320
{
    public static $files = array (
        '521d5786a5c60a51bbc1bc6020724fec' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Roots\\Soil\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Roots\\Soil\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Roots\\Soil\\DOM' => __DIR__ . '/../..' . '/src/DOM.php',
        'Roots\\Soil\\Exceptions\\LifecycleException' => __DIR__ . '/../..' . '/src/Exceptions/LifecycleException.php',
        'Roots\\Soil\\Modules\\AbstractModule' => __DIR__ . '/../..' . '/src/Modules/AbstractModule.php',
        'Roots\\Soil\\Modules\\CleanUpModule' => __DIR__ . '/../..' . '/src/Modules/CleanUpModule.php',
        'Roots\\Soil\\Modules\\DisableAssetVersioningModule' => __DIR__ . '/../..' . '/src/Modules/DisableAssetVersioningModule.php',
        'Roots\\Soil\\Modules\\DisableRestApiModule' => __DIR__ . '/../..' . '/src/Modules/DisableRestApiModule.php',
        'Roots\\Soil\\Modules\\DisableTrackbacksModule' => __DIR__ . '/../..' . '/src/Modules/DisableTrackbacksModule.php',
        'Roots\\Soil\\Modules\\GoogleAnalyticsModule' => __DIR__ . '/../..' . '/src/Modules/GoogleAnalyticsModule.php',
        'Roots\\Soil\\Modules\\JsToFooterModule' => __DIR__ . '/../..' . '/src/Modules/JsToFooterModule.php',
        'Roots\\Soil\\Modules\\NavWalkerModule' => __DIR__ . '/../..' . '/src/Modules/NavWalkerModule.php',
        'Roots\\Soil\\Modules\\NiceSearchModule' => __DIR__ . '/../..' . '/src/Modules/NiceSearchModule.php',
        'Roots\\Soil\\Modules\\RelativeUrlsModule' => __DIR__ . '/../..' . '/src/Modules/RelativeUrlsModule.php',
        'Roots\\Soil\\NavWalker' => __DIR__ . '/../..' . '/src/NavWalker.php',
        'Roots\\Soil\\Options' => __DIR__ . '/../..' . '/src/Options.php',
        'Roots\\Soil\\Soil' => __DIR__ . '/../..' . '/src/Soil.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4ac2b00e002f336e8293d288bb29d320::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4ac2b00e002f336e8293d288bb29d320::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4ac2b00e002f336e8293d288bb29d320::$classMap;

        }, null, ClassLoader::class);
    }
}
