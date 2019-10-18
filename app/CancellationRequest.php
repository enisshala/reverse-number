<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationRequest extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
}
