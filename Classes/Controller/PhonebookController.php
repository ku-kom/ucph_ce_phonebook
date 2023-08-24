<?php

declare(strict_types=1);

namespace UniversityOfCopenhagen\UcphContentPhonebook\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class PhonebookController extends ActionController
{
    /**
     * @var RequestFactory
     */

    protected RequestFactory $requestFactory;
    /**
     * Initiate the RequestFactory.
     */
    public function __construct(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * Request url and return response to fluid template.
     * @return ResponseInterface
     */
    public function phonebookSearchAction(int $currentPage = 1): ResponseInterface
    {
        // Webservive endpoint url is set in TYPO3 > Admin Tools > Settings > Extension Configuration
        $url = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ucph_content_phonebook', 'uri');

        // Check settings for items per page set in TYPO3 > Admin Tools > Settings > Extension Configuration
        $itemsPerPage = (int)GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ucph_content_phonebook', 'itemsPerPage') ?? 10;

        // Get arguments from request
        $query = $this->request->hasArgument('query') ? (string)$this->request->getArgument('query') : '';
        $currentPage = $this->request->hasArgument('currentPage') ? (int)$this->request->getArgument('currentPage') : 1;

        // Parameters
        $additionalOptions = [
          //'debug' => true,
          'form_params' => [
            'format' => 'json',
            'startrecord' => 0,
            'recordsperpage' => 100,
            'searchstring' => $query
          ]
        ];

        // Return response object
        if (!empty($url) && !empty($query)) {
            try {
                $response = $this->requestFactory->request($url, 'POST', $additionalOptions);
                // Get the content on a successful request
                if ($response->getStatusCode() === 200) {
                    if (false !== strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
                        $string = $response->getBody()->getContents();
                        // getContents() returns a string
                        // Convert string back to json
                        $string = iconv('ISO-8859-1', 'UTF-8', $string);
                        $data = json_decode((string) $string, true);

                        $items = $data['root']['employees'];
                        if ($items) {
                            $this->view->assign('employee', $items);
                            $this->view->assign('currentEmployees', array_slice($items, (($currentPage - 1) * $itemsPerPage), $itemsPerPage));
                        }

                        // Paging
                        $arrayPaginator = new ArrayPaginator($items, $currentPage, $itemsPerPage);
                        $paging = new SimplePagination($arrayPaginator);
                        $this->view->assignMultiple(
                            [
                                'paginator' => $arrayPaginator,
                                'query'=> $query,
                                'paging' => $paging,
                                'pages' => range(1, $paging->getLastPageNumber()),
                                'items' => count($items),
                                'offset_start' =>  ($arrayPaginator->getKeyOfLastPaginatedItem() - $itemsPerPage) > 1 ? (($arrayPaginator->getKeyOfLastPaginatedItem() - $itemsPerPage) + 2) : 1,
                                'offset_end' =>  ($arrayPaginator->getKeyOfLastPaginatedItem() + 1)
                            ]
                        );
                    }
                } else {
                    // Sisplay error message
                    $this->addFlashMessage(
                        $this->getLanguageService()->sL('LLL:EXT:ucph_content_phonebook/Resources/Private/Language/locallang.xlf:phonebook_warningmsg'),
                        '',
                        FlashMessage::ERROR,
                        false
                    );
                }
            } catch (\Exception $e) {
                // Display error message
                $this->addFlashMessage(
                    'Error: ' . $e->getMessage(),
                    '',
                    FlashMessage::ERROR,
                    false
                );
            }
        }
        
        return $this->htmlResponse();
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
