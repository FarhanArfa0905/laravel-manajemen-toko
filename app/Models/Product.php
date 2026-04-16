<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const TYPE_FISIK = 'fisik';
    public const TYPE_DIGITAL = 'digital';

    public const TYPE_LABELS = [
        self::TYPE_FISIK => 'Barang Fisik',
        self::TYPE_DIGITAL => 'Produk Digital',
    ];

    public const CATEGORY_OPTIONS = [
        self::TYPE_FISIK => [
            'voucher_fisik' => 'Voucher Fisik',
            'kartu_perdana' => 'Kartu Perdana',
            'kabel_data' => 'Kabel Data',
            'charger' => 'Charger',
            'headset' => 'Headset',
            'aksesoris_lain' => 'Aksesoris Lain',
        ],
        self::TYPE_DIGITAL => [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'token_listrik' => 'Token Listrik',
            'topup_emoney' => 'Top Up E-Money',
            'transfer_bank' => 'Transfer Bank',
            'tarik_tunai' => 'Tarik Tunai',
            'pembayaran_tagihan' => 'Pembayaran Tagihan',
            'voucher_game' => 'Voucher Game',
            'layanan_digital_lain' => 'Layanan Digital Lain',
        ],
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'category',
        'price',
        'cost_price',
        'stock',
        'image',
        'provider',
    ];

    public static function availableCategories(): array
    {
        return array_merge(
            array_keys(self::CATEGORY_OPTIONS[self::TYPE_FISIK]),
            array_keys(self::CATEGORY_OPTIONS[self::TYPE_DIGITAL]),
        );
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? ucfirst((string) $this->type);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_OPTIONS[$this->type][$this->category]
            ?? str($this->category)->replace('_', ' ')->title()->toString();
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
}
