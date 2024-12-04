<?php

declare(strict_types=1);

namespace BotAcademy\Core\Services\Binance;

use BotAcademy\Users\Models\Attempt;
use BotAcademy\Users\Models\BinanceToken;
use BotAcademy\Users\Models\Strategy;
use BotAcademy\Users\Models\Trade;
use Illuminate\Support\Facades\DB;

class Trader
{
    private Spot $spot;

    public function trade(Strategy $strategy, BinanceToken $token): void
    {
        $this->spot = new Spot(['key' => $token->api_key, 'secret' => $token->api_secret]);
        $last = $this->getLastTrade($strategy);
        /** @var Attempt|null $attempt */
        $attempt = Attempt::query()
            ->where('user_id', $strategy->user_id)
            ->where('strategy_id', $strategy->id)
            ->first();
        if (!$attempt) {
            $attempt = new Attempt();
            $attempt->user_id = $strategy->user_id;
            $attempt->strategy_id = $strategy->id;
            $attempt->amount = 1;
            $attempt->save();
        } else {
            $attempt->amount++;
            $attempt->save();
        }
        if (!$last) {
            $this->sell($strategy);
            return;
        }

        $this->deal($strategy, $last);
    }

    private function deal(Strategy $strategy, Trade $last): void
    {
        if ($last->isSell()) {
            $symbol = $strategy->coin . $strategy->getDefaultConvert();
            $ticker = $this->spot->tickerPrice(['symbol' => $symbol]);
            $price = (float)$ticker['price'];
            $total = $price * $last->amount;
            $diff = $total - $last->total;
            if ($diff < $strategy->target) {
                // deal ends
                return;
            }
            $quote = $this->spot->getQuote($strategy->getDefaultConvert(), $strategy->coin, $last->total);
            dump($quote);
            $quoteId = (string)$quote['quoteId'];
            $toAmount = (int)floor((float)$quote['toAmount']);
            if (!$quoteId || !$toAmount) {
                throw new \Exception('Error on get quote');
            }
            $result = $this->spot->acceptQuote($quoteId);
            dump($result);
            $trade = new Trade();
            $trade->user_id = $strategy->user_id;
            $trade->coin = $strategy->coin;
            $trade->type = Trade::BUY;
            $trade->amount = $toAmount;
            $trade->total = $last->total;
            $trade->save();
        } else {
            dump('BUY');
            $symbol = $strategy->coin . $strategy->getDefaultConvert();
            $ticker = $this->spot->tickerPrice(['symbol' => $symbol]);
            $price = (float)$ticker['price'];
            $total = $price * $last->amount;
            $diff = $total - $last->total;
            dump($diff);
            if ($diff > (-$strategy->target)) {
                // end of deal
                return;
            }
            $this->sell($strategy);
        }
    }

    private function sell(Strategy $strategy): void
    {
        $response = $this->spot->account();
        $balances = $response['balances'];
        $free = null;
        foreach ($balances as $balance) {
            if ($balance['asset'] === $strategy->coin) {
                $free = (int)floor((float)$balance['free']);
                break;
            }
        }
        if (!$free) {
            throw new \Exception('Target coin was not found in balance');
        }
        dump($free);
        $quote = $this->spot->getQuote($strategy->coin, $strategy->getDefaultConvert(), $free);
        $quoteId = (string)$quote['quoteId'];
        $toAmount = (float)$quote['toAmount'];
        if (!$quoteId || !$toAmount) {
            throw new \Exception('Error on get quote');
        }
        $result = $this->spot->acceptQuote($quoteId);
        dump($result);
        $trade = new Trade();
        $trade->user_id = $strategy->user_id;
        $trade->coin = $strategy->coin;
        $trade->type = Trade::SELL;
        $trade->amount = $free;
        $trade->total = $toAmount;
        $trade->save();
    }

    private function getLastTrade(Strategy $strategy): ?Trade
    {
        /** @var Trade|null $trade */
        $trade = Trade::query()
            ->where('user_id', $strategy->user_id)
            ->where('coin', $strategy->coin)
            ->latest('id')
            ->first();

        return $trade;
    }
}
