<?php

/*
 * This file is part of the package ucph_ce_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * Sep 2022 Nanna Ellegaard, University of Copenhagen.
 */

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function () {
    ExtensionUtility::registerPlugin(
        'ucph_ce_phonebook',
        'Pi1',
        'LLL:EXT:ucph_ce_phonebook/Resources/Private/Language/locallang_be.xlf:title',
        'ucph-ce-phonebook-icon'
    );
});

// Remove default plugin fields
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['ucphcephonebook_pi1'] = 'recursive,pages';