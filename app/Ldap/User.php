<?php

namespace App\Ldap;

use LdapRecord\Models\Model;

class User extends Model
{
    protected $guidKey = 'uid';
    /**
     * The object classes of the LDAP model.
     *
     * @var array
     */
    public static $objectClasses = [
        'top',
        'person',
        'organizationalperson',
        'inetorgperson',
        'inetuser',
        'posixaccount'
    ];
}
