<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit873d8c5c0edadc34b9fd36d2b892d445
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit873d8c5c0edadc34b9fd36d2b892d445::$classMap;

        }, null, ClassLoader::class);
    }
}