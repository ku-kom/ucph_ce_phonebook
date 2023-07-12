<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_prototype.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * Sep 2022 Nanna Ellegaard, University of Copenhagen.
 */

namespace UniversityOfCopenhagen\UcphCePhonebook\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class PhoneNumberViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('phoneNumber', 'string', 'The actual phone number', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        return self::getPhoneNumber($arguments['phoneNumber']);
    }

    /**
     * Returns the phone number in an easy-to-read format
     *
     * @param string $phoneNumber
     * @return string
     */
    protected static function getPhoneNumber(string $phoneNumber): string
    {
        $data = filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT);

        // Remove dashes, if any
        $data = Str_Replace('-', '', $data);

        $regex_format = '/^\+45(\d{2})(\d{2})(\d{2})(\d{2})$/i';
        // assuming that the +45 is constant and then use the \d shortcut to match decimal characters.
        // The value in {} is the number of characters to match.
        if (preg_match($regex_format, $data, $matches)) {
            $result = '+45 ' . $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
            return $result;
        } else {
            return $phoneNumber;
        }
    }
}
