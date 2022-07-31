<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit91cc5e4c539a83d27b1d4800a450f2ab
{
    public static $files = array (
        'ea3b51f863c0128058f832792efbf208' => __DIR__ . '/../..' . '/Helpers/utility.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\BackEnd\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\BackEnd\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Modules\\BackEnd\\Entities\\AbstractModel' => __DIR__ . '/../..' . '/Entities/AbstractModel.php',
        'Modules\\BackEnd\\Entities\\Admin\\AdminAuth' => __DIR__ . '/../..' . '/Entities/Admin/AdminAuth.php',
        'Modules\\BackEnd\\Entities\\Admin\\AdminModel' => __DIR__ . '/../..' . '/Entities/Admin/AdminModel.php',
        'Modules\\BackEnd\\Entities\\Auth\\AuthModel' => __DIR__ . '/../..' . '/Entities/Auth/AuthModel.php',
        'Modules\\BackEnd\\Entities\\Role\\RoleModel' => __DIR__ . '/../..' . '/Entities/Role/RoleModel.php',
        'Modules\\BackEnd\\Exceptions\\AppException' => __DIR__ . '/../..' . '/Exceptions/AppException.php',
        'Modules\\BackEnd\\Exceptions\\Handler' => __DIR__ . '/../..' . '/Exceptions/Handler.php',
        'Modules\\BackEnd\\Http\\Controllers\\AbstractController' => __DIR__ . '/../..' . '/Http/Controllers/AbstractController.php',
        'Modules\\BackEnd\\Http\\Controllers\\Admin\\AdminController' => __DIR__ . '/../..' . '/Http/Controllers/Admin/AdminController.php',
        'Modules\\BackEnd\\Http\\Controllers\\Admin\\IndexController' => __DIR__ . '/../..' . '/Http/Controllers/Admin/IndexController.php',
        'Modules\\BackEnd\\Http\\Controllers\\Admin\\LoginController' => __DIR__ . '/../..' . '/Http/Controllers/Admin/LoginController.php',
        'Modules\\BackEnd\\Http\\Controllers\\Admin\\TestController' => __DIR__ . '/../..' . '/Http/Controllers/Admin/TestController.php',
        'Modules\\BackEnd\\Http\\Middleware\\Authendicate' => __DIR__ . '/../..' . '/Http/Middleware/Authendicate.php',
        'Modules\\BackEnd\\Logic\\AbstractLogic' => __DIR__ . '/../..' . '/Logic/AbstractLogic.php',
        'Modules\\BackEnd\\Logic\\Admin\\AdminLogic' => __DIR__ . '/../..' . '/Logic/Admin/AdminLogic.php',
        'Modules\\BackEnd\\Logic\\Admin\\AuthLogic' => __DIR__ . '/../..' . '/Logic/Admin/AuthLogic.php',
        'Modules\\BackEnd\\Providers\\BackEndServiceProvider' => __DIR__ . '/../..' . '/Providers/BackEndServiceProvider.php',
        'Modules\\BackEnd\\Providers\\RouteServiceProvider' => __DIR__ . '/../..' . '/Providers/RouteServiceProvider.php',
        'Modules\\BackEnd\\Rules\\BackEnd' => __DIR__ . '/../..' . '/Rules/BackEnd.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit91cc5e4c539a83d27b1d4800a450f2ab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit91cc5e4c539a83d27b1d4800a450f2ab::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit91cc5e4c539a83d27b1d4800a450f2ab::$classMap;

        }, null, ClassLoader::class);
    }
}