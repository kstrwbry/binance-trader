<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\EntityBase;

use Kstrwbry\BinanceTrader\Interface\KlineRawInterface;
use Kstrwbry\BinanceTrader\Trait\IdTrait;
use Doctrine\ORM\Mapping as ORM;

use DateTime;

abstract class KlineRaw implements KlineRawInterface
{
    use IdTrait;

    #[ORM\Column(name:'start_time', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $startTime;

    #[ORM\Column(name:'start_time_date', type:'datetime', nullable:false, options:['unsigned' => true])]
    protected readonly DateTime $startTimeDate;

    #[ORM\Column(name:'close_time', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $closeTime;

    #[ORM\Column(name:'close_time_date', type:'datetime', nullable:false, options:['unsigned' => true])]
    protected readonly DateTime $closeTimeDate;

    #[ORM\Column(name:'symbol', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $symbol;

    #[ORM\Column(name:'interval', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $interval;

    #[ORM\Column(name:'first_trade_id', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $firstTradeID;

    #[ORM\Column(name:'last_trade_id', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $lastTradeID;

    #[ORM\Column(name:'open', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $open;

    #[ORM\Column(name:'open_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $openFloat;

    #[ORM\Column(name:'close', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $close;

    #[ORM\Column(name:'close_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $closeFloat;

    #[ORM\Column(name:'high', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $high;

    #[ORM\Column(name:'high_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $highFloat;

    #[ORM\Column(name:'low', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $low;

    #[ORM\Column(name:'low_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $lowFloat;

    #[ORM\Column(name:'base_asset_volume', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $baseAssetVolume;

    #[ORM\Column(name:'base_asset_volume_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $baseAssetVolumeFloat;

    #[ORM\Column(name:'trades_count', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $tradesCount;

    #[ORM\Column(name:'trades_count_int', type:'integer', nullable:false, options:['unsigned' => true])]
    protected readonly int $tradesCountInt;

    #[ORM\Column(name:'is_closed', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $isClosed;

    #[ORM\Column(name:'is_closed_bool', type:'boolean', nullable:false, options:['unsigned' => true])]
    protected readonly bool $isClosedBool;

    #[ORM\Column(name:'quote_asset_volume', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $quoteAssetVolume;

    #[ORM\Column(name:'quote_asset_volume_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $quoteAssetVolumeFloat;

    #[ORM\Column(name:'taker_buy_base_asset_volume', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $takerBuyBaseAssetVolume;

    #[ORM\Column(name:'taker_buy_base_asset_volume_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $takerBuyBaseAssetVolumeFloat;

    #[ORM\Column(name:'taker_buy_quote_asset_volume', type:'string', nullable:false, options:['unsigned' => true])]
    protected readonly string $takerBuyQuoteAssetVolume;

    #[ORM\Column(name:'taker_buy_quote_asset_volume_float', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $takerBuyQuoteAssetVolumeFloat;

    public function __construct(
        string $startTime,
        string $closeTime,
        string $symbol,
        string $interval,
        string $firstTradeID,
        string $lastTradeID,
        string $open,
        string $close,
        string $high,
        string $low,
        string $baseAssetVolume,
        string $tradesCount,
        string $isClosed,
        string $quoteAssetVolume,
        string $takerBuyBaseAssetVolume,
        string $takerBuyQuoteAssetVolume,
    ) {
        $this->startTime = $startTime;
        $this->startTimeDate = $this->timestampToDate($startTime);
        $this->closeTime = $closeTime;
        $this->closeTimeDate = $this->timestampToDate($closeTime);
        $this->symbol = $symbol;
        $this->interval = $interval;
        $this->firstTradeID = $firstTradeID;
        $this->lastTradeID = $lastTradeID;
        $this->open = $open;
        $this->openFloat = (float)$open;
        $this->close = $close;
        $this->closeFloat = (float)$close;
        $this->high = $high;
        $this->highFloat = (float)$high;
        $this->low = $low;
        $this->lowFloat = (float)$low;
        $this->baseAssetVolume = $baseAssetVolume;
        $this->baseAssetVolumeFloat = (float)$baseAssetVolume;
        $this->tradesCount = $tradesCount;
        $this->tradesCountInt = (int)$tradesCount;
        $this->isClosed = $isClosed;
        $this->isClosedBool = '1' === $isClosed;
        $this->quoteAssetVolume = $quoteAssetVolume;
        $this->quoteAssetVolumeFloat = (float)$quoteAssetVolume;
        $this->takerBuyBaseAssetVolume = $takerBuyBaseAssetVolume;
        $this->takerBuyBaseAssetVolumeFloat = (float)$takerBuyBaseAssetVolume;
        $this->takerBuyQuoteAssetVolume = $takerBuyQuoteAssetVolume;
        $this->takerBuyQuoteAssetVolumeFloat = (float)$takerBuyQuoteAssetVolume;
    }

    public function getClose(): float
    {
        return $this->closeFloat;
    }

    public function isClosed(): bool
    {
        return $this->isClosedBool;
    }

    private function timestampToDate(int|string $timestamp): DateTime
    {
        $seconds = substr((string)$timestamp, 0, 10);

        return (new DateTime())->setTimestamp((int)$seconds);
    }
}
