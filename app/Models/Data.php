<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Data extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function dataPegawais(): HasMany
    {
        return $this->hasMany(DataPegawai::class);
    }
}