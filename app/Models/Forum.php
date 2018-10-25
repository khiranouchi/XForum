<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Forum extends Model
{
    public $incrementing = false;

    /**
     * Subordinate relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator_user()
    {
        return $this->belongsTo('App\User');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
}
