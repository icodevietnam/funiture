<?php

namespace App\Models;

use Nova\Auth\UserTrait;
use Nova\Auth\UserInterface;
use Nova\Auth\Reminders\RemindableTrait;
use Nova\Auth\Reminders\RemindableInterface;
use Nova\Database\ORM\Model as BaseModel;


class User extends BaseModel implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    //
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = array('role_id', 'username', 'password', 'realname', 'email', 'active', 'activation_code');

    protected $hidden = array('password', 'activation_code', 'remember_token');

    // Cache for associated Role instance.
    private $cachedRole;


    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function hasRole($roles)
    {
        if (! isset($this->cachedRole)) {
            $this->cachedRole = $this->role()->getResults();
        }

        // Check if the User is a Root account.
        if (! is_null($this->cachedRole) && ($this->cachedRole->slug == 'root')) {
            return true;
        }

        if (! is_array($roles)) {
            return $this->checkUserRole($roles);
        }

        foreach ($roles as $role) {
            if ($this->checkUserRole($role)) {
                return true;
            }
        }

        return false;
    }

    private function checkUserRole($wantedRole)
    {
        if(isset($this->cachedRole) && ($this->cachedRole instanceof Role)) {
            return (strtolower($wantedRole) == strtolower($this->cachedRole->slug));
        }

        return false;
    }

}
