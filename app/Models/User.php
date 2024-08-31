<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'nip',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];
    
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
    
    public function field(): HasMany
    {
        return $this->hasMany(Field::class);
    }
    
    public function pegawai(): HasOne
    {
        return $this->hasOne(Pegawai::class);
    }
}