<?php

namespace App\Domain\Infrastructure\Model;

use App\Domain\Entity\User\User as UserEntity;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use Illuminate\Notifications\Notifiable;
use App\Domain\Repository\Model\Domainable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Domainable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toDomain()
    {
        return new UserEntity(
            new UserId($this->id),
            new UserName($this->name),
        );
    }
}
