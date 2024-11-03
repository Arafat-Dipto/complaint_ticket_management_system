<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePrivilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'privilege_id',
    ];

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return BelongsTo
     */
    public function privilege(): BelongsTo
    {
        return $this->belongsTo(Privilege::class);
    }
}
