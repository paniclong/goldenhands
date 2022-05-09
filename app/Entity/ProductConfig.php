<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductConfig extends Entity
{
    use HasFactory;

    protected $table = 'products_config';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttributeValue('id');
    }

    /**
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'config_id', 'id');
    }
}
