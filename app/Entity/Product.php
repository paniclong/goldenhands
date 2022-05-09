<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Entity
{
    use HasFactory;

    protected $table = 'products';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return BelongsTo
     */
    public function config(): BelongsTo
    {
        return $this->belongsTo(ProductConfig::class);
    }
}
