<?php

/*
 * This file is part of the package ucph_ce_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * Sep 2022 Nanna Ellegaard, University of Copenhagen.
 */

 /**
  * Icon registry
  */

defined('TYPO3') || die();

return [
    // icon identifier
    'ucph-ce-phonebook-icon' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:ucph_ce_phonebook/Resources/Public/Icons/database-check.svg',
    ],
];
