<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPegawai extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function data(): BelongsTo
    {
        return $this->belongsTo(Data::class, 'data_id');
    }
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
