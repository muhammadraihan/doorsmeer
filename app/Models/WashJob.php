<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use App\Models\Package;
use App\Models\Vehicle;

class WashJob extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'package_id', 'vehicle_type', 'vehicle_name','vehicle_register', 'status', 'created_by', 'edited_by'
    ];

    public function userCreate() {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    public function userEdit() {
        return $this->belongsTo(User::class, 'edited_by', 'uuid');
    }

    public function packageId() {
        return $this->belongsTo(Package::class, 'package_id', 'uuid');
    }

    public function vehicleName() {
        return $this->belongsTo(Vehicle::class, 'vehicle_name', 'uuid');
    }
}
