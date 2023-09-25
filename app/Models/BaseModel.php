<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\TenantScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaseModel extends Model
{
    use HasFactory;
    use TenantScopeTrait;

    protected $with = ['tenant'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
