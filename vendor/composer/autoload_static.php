<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f0a357e88357c4512048dc57e74c22c
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Greenpeace\\Planet4GPCHBlocks\\Blocks\\' => 36,
            'Greenpeace\\Planet4GPCHBlocks\\' => 29,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/blocks',
        ),
        'Greenpeace\\Planet4GPCHBlocks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\Planet4_GPCH_Action_Divider' => __DIR__ . '/../..' . '/includes/blocks/Planet4_GPCH_Block_Action_Divider.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\Planet4_GPCH_Base_Block' => __DIR__ . '/../..' . '/includes/blocks/Planet4_GPCH_Base_Block.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\Planet4_GPCH_Block_Form_Progress_Bar' => __DIR__ . '/../..' . '/includes/blocks/Planet4_GPCH_Block_Form_Progress_Bar.php',
        'Greenpeace\\Planet4GPCHBlocks\\Planet4_GPCH_Plugin_Blocks' => __DIR__ . '/../..' . '/includes/Plugin.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1f0a357e88357c4512048dc57e74c22c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1f0a357e88357c4512048dc57e74c22c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1f0a357e88357c4512048dc57e74c22c::$classMap;

        }, null, ClassLoader::class);
    }
}
