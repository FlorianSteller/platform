<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Cart\Exception;

use Shopware\Core\Framework\ShopwareHttpException;
use Symfony\Component\HttpFoundation\Response;

class PayloadKeyNotFoundException extends ShopwareHttpException
{
    public function __construct(string $key, string $lineItemId)
    {
        parent::__construct(
            'Payload key "{{ payloadKey }}" in line item "{{ identifier }}" not found.',
            ['payloadKey' => $key, 'identifier' => $lineItemId]
        );
    }

    public function getErrorCode(): string
    {
        return 'CHECKOUT__CART_PAYLOAD_KEY_NOT_FOUND';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
