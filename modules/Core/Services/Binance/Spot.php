<?php

declare(strict_types=1);

namespace BotAcademy\Core\Services\Binance;

class Spot extends \Binance\Spot
{
    public function getQuote(string $from, string $to, int|float $amount, array $options = []): array
    {
        return $this->signRequest('POST', '/sapi/v1/convert/getQuote', array_merge(
            $options,
            [
                'fromAsset' => $from,
                'toAsset' => $to,
                'fromAmount' => $amount
            ]
        ));
    }

    public function acceptQuote(string $quoteId, array $options = []): array
    {
        return $this->signRequest('POST', '/sapi/v1/convert/acceptQuote', array_merge(
            $options,
            [
                'quoteId' => $quoteId,
            ]
        ));
    }

}
