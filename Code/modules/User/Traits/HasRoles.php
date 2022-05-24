<?php


namespace Modules\User\Traits;


use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;

trait HasRoles
{
    /**
     * Check User has Permission
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission = ''){
        if(!PermissionHelper::find($permission)){
            throw new \Exception(__("Permission: :name not found",['name'=>$permission]));
        }
        if(!$this->role or !$this->role->hasPermission($permission)) return false;

        return true;
    }

    /**
     * Assign Role for User
     *
     * @param String|Role $role_id
     */
    public function assignRole($role_id){
        if($role_id instanceof Role){
            $this->role_id = $role_id->id;
            $this->save();
        }

        if(is_string($role_id)){
            $role = Role::query()->where('code',$role_id)->first();
        }else{
            $role = Role::find($role_id);
        }

        if($role){
            $this->role_id = $role->id;
            $this->save();
        }
    }


    public function getRoleNameAttribute(){
        return $this->role->name ?? '';
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function scopeRole($query,$role_id){
        if(is_string($role_id)){
            $role = Role::find($role_id);
            if($role){
                return $query->where('role_id',$role->id);
            }
        }
        return $query->where('role_id',$role_id);
    }

    public function hasRole($role_id){
        if($role_id instanceof Role){
           return $this->role_id == $role_id->id;
        }
        if(is_integer($role_id)){
            return $this->role_id == $role_id;
        }
        $role = Role::query()->where('code',$role_id)->first();

        return $this->role_id == $role->id;
    }
}
