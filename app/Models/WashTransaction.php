<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class WashTransaction extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'job_id', 'trx_number', 'item_detail', 'total', 'paid', 'change', 'status', 'created_by', 'edited_by'
    ];

    public function userCreate() {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    public function userEdit() {
        return $this->belongsTo(User::class, 'edited_by', 'uuid');
    }

    public function jobId() {
        return $this->belongsTo(WashJob::class, 'job_id', 'uuid');
    }
}
