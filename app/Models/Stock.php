<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use App\Models\Item;
use App\Models\Unit;

class Stock extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'item_type_id', 'item_name', 'amount', 'unit_name', 'unit_price', 'created_by', 'edited_by' 
    ];

    public function userCreate() {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    public function userEdit() {
        return $this->belongsTo(User::class, 'edited_by', 'uuid');
    }

    public function itemType() {
        return $this->belongsTo(Item::class, 'item_type_id', 'uuid');
    }

    public function unitName() {
        return $this->belongsTo(Unit::class, 'unit_name', 'uuid');
    }
}
