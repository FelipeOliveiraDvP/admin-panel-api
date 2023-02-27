<?php

namespace App\Helpers;

use App\Models\Role;

class HasClaim
{
    /**
     * Verify if the given claim exists on the user role.
     * 
     * @param $claim string
     * 
     * @return bool
     */
    public static function verify(string $claim)
    {
        $user = auth('sanctum')->user();

        if ($user == null) return false;

        $role = Role::with('claims:identifier')->find($user->role_id);

        $claims = $role->claims->map(function ($claim) {
            return $claim->identifier;
        })->toArray();

        return in_array($claim, $claims);
    }
}
