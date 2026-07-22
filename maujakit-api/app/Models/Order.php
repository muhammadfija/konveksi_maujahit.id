<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property string $tracking_code
 * @property string $customer_name
 * @property string $whatsapp
 * @property string|null $company_name
 * @property string $product_type
 * @property int $quantity
 * @property string $color
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $estimated_finish
 * @property string $current_status
 * @property string|null $resi_number
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property bool $is_priority
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'customer_name',
        'whatsapp',
        'company_name',
        'product_type',
        'quantity',
        'total_price',
        'color',
        'notes',
        'estimated_finish',
        'current_status',
        'resi_number',
        'is_priority',
    ];

    protected $casts = [
        'estimated_finish' => 'date',
        'is_priority' => 'boolean',
    ];

    /**
     * All production stages in order.
     */
    public static array $stages = [
        'ORDER_MASUK',
        'DP_PELUNASAN',
        'DESAIN',
        'BELI_BAHAN',
        'POTONG',
        'JAHIT',
        'QC',
        'PACKING',
        'KIRIM',
    ];

    /**
     * Stage labels in Indonesian.
     */
    public static array $stageLabels = [
        'ORDER_MASUK'       => 'Order Masuk',
        'DP_PELUNASAN'      => 'DP/Pelunasan',
        'DESAIN'            => 'Desain',
        'BELI_BAHAN'        => 'Beli Bahan',
        'POTONG'            => 'Potong',
        'JAHIT'             => 'Jahit',
        'QC'                => 'QC',
        'PACKING'           => 'Packing',
        'KIRIM'             => 'Kirim',
    ];

    public function progresses(): HasMany
    {
        return $this->hasMany(ProductionProgress::class)->orderBy('created_at', 'asc');
    }

    /**
     * Calculate progress percentage.
     */
    public function getProgressPercentageAttribute(): int
    {
        $percentages = [
            'ORDER_MASUK'       => 10,
            'DP_PELUNASAN'      => 20,
            'DESAIN'            => 30,
            'BELI_BAHAN'        => 45,
            'POTONG'            => 60,
            'JAHIT'             => 75,
            'QC'                => 85,
            'PACKING'           => 95,
            'KIRIM'             => 100,
        ];

        return $percentages[$this->current_status] ?? 0;
    }

    /**
     * Generate a unique tracking code like MJK-XXXXXX.
     */
    public static function generateTrackingCode(): string
    {
        do {
            $code = 'MJK-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }
}
