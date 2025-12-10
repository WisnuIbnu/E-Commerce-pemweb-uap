<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }

   public function store()
{
    return $this->hasOne(Store::class, 'buyer_id', 'id');
}

}