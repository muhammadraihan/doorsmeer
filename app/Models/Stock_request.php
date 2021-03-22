<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use App\Models\Item;

class Stock_request extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'item_id', 'amount', 'created_by', 'edited_by'
    ];

    public function namaItem() {
        return $this->belongsTo(Item::class, 'item_id', 'uuid');
    }

    public function userCreate() {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    public function userEdit() {
        return $this->belongsTo(User::class, 'edited_by', 'uuid');
    }
}
