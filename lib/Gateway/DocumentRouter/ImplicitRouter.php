<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\EzPlatformSolrSearchEngine\Gateway\DocumentRouter;

use eZ\Publish\SPI\Search\Document;
use eZ\Publish\SPI\Search\Field;
use eZ\Publish\SPI\Search\FieldType;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\DocumentRouter;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointReference;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointResolver;

class ImplicitRouter implements DocumentRouter
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
    public function __construct(EndpointResolver $endpointResolver = null)
    {
        $this->endpointResolver = $endpointResolver;
    }

    public function processDocument(Document $document): Document
    {
        $endpoint = EndpointReference::fromString(
            $this->endpointResolver->getIndexingTarget($document->languageCode)
        );

        return $this->doProcessDocument($document, $endpoint);
    }

    public function processMainTranslationDocument(Document $document): Document
    {
        $endpoint = EndpointReference::fromString(
            $this->endpointResolver->getMainLanguagesEndpoint()
        );

        return $this->doProcessDocument($document, $endpoint);
    }

    private function doProcessDocument(Document $document, EndpointReference $endpoint): Document
    {
        if ($endpoint->shard !== null) {
            $document = clone $document;
            $document->fields[] = new Field(
                'router_field',
                $endpoint->shard,
                new FieldType\IdentifierField()
            );
        }

        return $document;
    }
}
