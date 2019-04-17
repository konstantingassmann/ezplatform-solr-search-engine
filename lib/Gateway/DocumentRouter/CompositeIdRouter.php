<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\EzPlatformSolrSearchEngine\Gateway\DocumentRouter;

use eZ\Publish\SPI\Search\Document;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\DocumentRouter;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointResolver;

final class CompositeIdRouter implements DocumentRouter
{
        /**
     * Endpoint registry service.
     *
     * @var \EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointResolver
     */
    protected $endpointResolver;

    /**
     * @param \EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointResolver $endpointResolver
     */
    public function __construct(EndpointResolver $endpointResolver)
    {
        $this->endpointResolver = $endpointResolver;
    }


    public function processDocument(Document $document): Document
    {
        // TODO: Implement createRoutedDocument() method.
    }

    public function processMainTranslationDocument(Document $document): Document
    {
        // TODO: Implement processMainTranslationDocument() method.
    }
}
