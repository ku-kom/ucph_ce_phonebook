<?php

/*
 * This file is part of the package ucph_content_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * Sep 2022 Nanna Ellegaard, University of Copenhagen.
 */

defined('TYPO3') or die('Access denied.');

call_user_func(function () {
    $extensionKey = 'ucph_content_phonebook';

    /**
     * Default TypoScript for UcphContentPhonebook
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'UCPH TYPO3 content element "Employee directory"'
    );
});
