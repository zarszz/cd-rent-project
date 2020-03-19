<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompactDisc extends Model
{
    protected $table = 'compact_discs';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'rate', 'category', 'quantity'];
}
