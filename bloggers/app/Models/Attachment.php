<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function attachable()
    {
        return $this->morphTo();
    }
}
