<?php

namespace App\Domain\Infrastructure\Model;

use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\User\UserPassword;
use App\Domain\Entity\User\User as UserEntity;
use App\Domain\Infrastructure\Model\Domainable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Domainable
{
    use HasFactory;

    public $timestamps = false; //ここでこのtableではtimestampを使わないことを明示、さもなければ生成時にupdated_atがないみたいなエラーが出る(migarteで削除していても)
    protected $keytype = "string";
    public  $incrementing = false;
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


    public function toDomain()
    {
        return UserEntity::New(
            new UserId($this->id),
            new UserName($this->name),
            new UserEmail($this->email),
            UserPassword::FromRepository($this->password)
        );
    }
}
