<?php

/*
 * This file is part of the package ucph_ce_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * Sep 2022 Nanna Ellegaard, University of Copenhagen.
 */

defined('TYPO3') or die('Access denied.');

call_user_func(function () {
    $extensionKey = 'ucph_ce_phonebook';

    /**
     * Default TypoScript for UcphCePhonebook
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'UCPH TYPO3 content element "Employee directory"'
    );
});
