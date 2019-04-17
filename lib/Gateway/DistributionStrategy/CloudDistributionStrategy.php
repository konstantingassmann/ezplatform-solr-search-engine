<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\EzPlatformSolrSearchEngine\Gateway\DistributionStrategy;

use eZ\Publish\SPI\Search\Document;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\DistributionStrategy;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointReference;
use EzSystems\EzPlatformSolrSearchEngine\Gateway\EndpointResolver;

/**
 * Solr Cloud distributed search
 *
 * @see https://lucene.apache.org/solr/guide/7_7/distributed-requests.html
 */
class CloudDistributionStrategy implements DistributionStrategy
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

    public function getSearchTargets(array $endpoints): array
    {
        $entryEndpoint = $this->endpointResolver->getEntryEndpoint();

        return array_map(function($name) use ($entryEndpoint) {
            $reference = EndpointReference::fromString($name);

            if ($reference->endpoint !== $entryEndpoint) {
                throw new \RuntimeException("Multiple entry endpoint are not supported by Solr Cloud");
            }

            return $reference->shard;
        }, $endpoints);
    }
}
