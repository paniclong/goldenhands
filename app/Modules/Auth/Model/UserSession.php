<?php

declare(strict_types=1);

namespace App\Modules\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSession extends Model
{
    protected $table = 'users_sessions';

    protected $casts = [
        'expires_in' => 'date',
        'user_id' => 'int',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('users');
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->getAttributeValue('user_id');
    }
}
