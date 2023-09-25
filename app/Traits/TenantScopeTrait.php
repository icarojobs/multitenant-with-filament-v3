<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Scopes\TenantScope;

trait TenantScopeTrait
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope());

        self::getCreating();
    }

    private static function getCreating(): void
    {
        static::creating(function ($model) {
            self::defineTenant($model);
        });
    }

    private static function defineTenant($model): void
    {
        if (auth()->check()) {
            $model->tenant_id = auth()->user()->tenant_id;
        } else {
            if (session()->get('tenant') !== null) {
                $model->tenant_id = session()->get('tenant')->id;
            }
        }
    }
}
