<?php

namespace BezhanSalleh\FilamentExceptions\Models;

use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class Exception extends model
{
    use MassPrunable;

    protected $table = 'filament_exceptions_table';

    /**
     * @var array
     */
    protected $guarded = [];

    public function prunable(): Builder
    {
        return static::whereDate('created_at', '<=', FilamentExceptionsPlugin::get()->getModelPruneInterval());
    }
}
