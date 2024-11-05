<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function calorieDays()
    {
        return $this->hasMany(CalorieDay::class);
    }
    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }

    public function carrots()
    {
        return $this->hasMany(Carrot::class);
    }

    public function weigh_ins()
    {
        return $this->hasMany(WeighIn::class);
    }

}
