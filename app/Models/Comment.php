<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Subordinate relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator_user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCreatedAtDate()
    {
        return $this->created_at->format('y/m/d');
    }
    public function getCreatedAtFull()
    {
        return $this->created_at->format('Y/m/d H:i:s');
    }
    public function getUpdatedAtFull()
    {
        return $this->updated_at->format('Y/m/d H:i:s');
    }
}
