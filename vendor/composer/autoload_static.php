<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f0a357e88357c4512048dc57e74c22c
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Greenpeace\\Planet4GPCHBlocks\\' => 29,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Greenpeace\\Planet4GPCHBlocks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Greenpeace\\Planet4GPCHBlocks\\AssetEnqueuer' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/AssetEnqueuer.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\AccordionBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/AccordionBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\ActionDividerBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/ActionDividerBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\BSBingoBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/BSBingoBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\BaseBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/BaseBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\BaseFormBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/BaseFormBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\DonationProgressBarBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/DonationProgressBarBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\DreampeaceCoverBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/DreampeaceCoverBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\DreampeaceSlideBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/DreampeaceSlideBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\EventsBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/EventsBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\FormCounterTextBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/FormCounterTextBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\FormEntriesBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/FormEntriesBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\FormProgressBarBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/FormProgressBarBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\MagazineArticlesBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/MagazineArticlesBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\NewsletterBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/NewsletterBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\P2PShareBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/P2PShareBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\SpacerBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/SpacerBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\TaskforceBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/TaskforceBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\Blocks\\WordCloudBlock' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/Blocks/WordCloudBlock.php',
        'Greenpeace\\Planet4GPCHBlocks\\DictionaryTable' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/DictionaryTable.php',
        'Greenpeace\\Planet4GPCHBlocks\\RaiseNowAPI' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/RaiseNowAPI.php',
        'Greenpeace\\Planet4GPCHBlocks\\SmsClient' => __DIR__ . '/../..' . '/includes/Greenpeace/Planet4GPCHBlocks/SmsClient.php',
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
