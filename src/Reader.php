<?php

declare(strict_types=1);

namespace Kstptm\FeedReader;

use DOMDocument;
use Kstptm\FeedReader\Assembler\Factory;
use Kstptm\FeedReader\Exception\ReadException;
use Kstptm\FeedReader\Exception\UnknownFeedTypeException;
use Kstptm\FeedReader\Feed\Feed;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use RuntimeException;

class Reader
{
    /** @var ClientInterface */
    private $client;

    /** @var RequestFactoryInterface */
    private $requestFactory;

    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @param string $uri
     *
     * @throws ClientExceptionInterface
     * @throws ReadException
     * @throws RuntimeException
     * @throws UnknownFeedTypeException
     *
     * @return Feed
     */
    public function read(string $uri): Feed
    {
        $request = $this->requestFactory->createRequest('GET', $uri);

        $response = $this->client->sendRequest($request);

        if (200 !== $response->getStatusCode()) {
            throw new ReadException('Response status code was not 200 OK');
        }

        $document = new DOMDocument();

        $document->loadXML($response->getBody()->getContents());

        $feedAssembler = Factory::build($document);

        return $feedAssembler->assemble($document);
    }
}
