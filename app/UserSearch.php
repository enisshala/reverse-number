<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSearch extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function number()
    {
        return $this->belongsTo('App\Number');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }

}
