<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
	protected $primaryKey = 'users_id';
	protected $allowedFields = ['users_first_name', 'users_last_name', 'users_email', 'users_phone_number', 'users_business_name', 'users_business_address', 'users_website_url', 'users_logo', 'users_password'];
}

?>