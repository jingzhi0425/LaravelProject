<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        \DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            ['title' => 'user_management_access', 'type'  => 'management'],
            ['title' => 'permission_show', 'type'  => 'permission'],
            ['title' => 'permission_access', 'type'  => 'permission'],
            ['title' => 'role_create', 'type'  => 'role'],
            ['title' => 'role_edit', 'type'  => 'role'],
            ['title' => 'role_show', 'type'  => 'role'],
            ['title' => 'role_access', 'type'  => 'role'],
            ['title' => 'user_create', 'type'  => 'user'],
            ['title' => 'user_edit', 'type'  => 'user'],
            ['title' => 'user_show', 'type'  => 'user'],
            ['title' => 'user_delete', 'type'  => 'user'],
            ['title' => 'user_access', 'type'  => 'user'],
            ['title' => 'audit_log_show', 'type'  => 'audit_log'],
            ['title' => 'audit_log_access', 'type'  => 'audit_log'],
            ['title' => 'user_login_log_create', 'type'  => 'user_login_log'],
            ['title' => 'user_login_log_edit', 'type'  => 'user_login_log'],
            ['title' => 'user_login_log_show', 'type'  => 'user_login_log'],
            ['title' => 'user_login_log_delete', 'type'  => 'user_login_log'],
            ['title' => 'user_login_log_access', 'type'  => 'user_login_log'],
            ['title' => 'system_settings_menu_access', 'type'  => 'management'],
            ['title' => 'global_setting_create', 'type'  => 'global_setting'],
            ['title' => 'global_setting_edit', 'type'  => 'global_setting'],
            ['title' => 'global_setting_show', 'type'  => 'global_setting'],
            ['title' => 'global_setting_delete', 'type'  => 'global_setting'],
            ['title' => 'global_setting_access', 'type'  => 'global_setting'],
            ['title' => 'language_create', 'type'  => 'language'],
            ['title' => 'language_edit', 'type'  => 'language'],
            ['title' => 'language_show', 'type'  => 'language'],
            ['title' => 'language_delete', 'type'  => 'language'],
            ['title' => 'language_access', 'type'  => 'language'],
            ['title' => 'country_create', 'type'  => 'country'],
            ['title' => 'country_edit', 'type'  => 'country'],
            ['title' => 'country_show', 'type'  => 'country'],
            ['title' => 'country_delete', 'type'  => 'country'],
            ['title' => 'country_access', 'type'  => 'country'],
            ['title' => 'image_create', 'type'  => 'image'],
            ['title' => 'image_edit', 'type'  => 'image'],
            ['title' => 'image_show', 'type'  => 'image'],
            ['title' => 'image_delete', 'type'  => 'image'],
            ['title' => 'image_access', 'type'  => 'image'],
            ['title' => 'laravel_passport_create', 'type'  => 'laravel_passport'],
            ['title' => 'laravel_passport_edit', 'type'  => 'laravel_passport'],
            ['title' => 'laravel_passport_show', 'type'  => 'laravel_passport'],
            ['title' => 'laravel_passport_delete', 'type'  => 'laravel_passport'],
            ['title' => 'laravel_passport_access', 'type'  => 'laravel_passport'],
            ['title' => 'notice_board_create', 'type'  => 'notice_board'],
            ['title' => 'notice_board_edit', 'type'  => 'notice_board'],
            ['title' => 'notice_board_show', 'type'  => 'notice_board'],
            ['title' => 'notice_board_delete', 'type'  => 'notice_board'],
            ['title' => 'notice_board_access', 'type'  => 'notice_board'],
            ['title' => 'product_category_create', 'type'  => 'product_category'],
            ['title' => 'product_category_edit', 'type'  => 'product_category'],
            ['title' => 'product_category_show', 'type'  => 'product_category'],
            ['title' => 'product_category_delete', 'type'  => 'product_category'],
            ['title' => 'product_category_access', 'type'  => 'product_category'],
            ['title' => 'product_create', 'type'  => 'product'],
            ['title' => 'product_edit', 'type'  => 'product'],
            ['title' => 'product_show', 'type'  => 'product'],
            ['title' => 'product_delete', 'type'  => 'product'],
            ['title' => 'product_access', 'type'  => 'product'],
            ['title' => 'profile_password_edit', 'type'  => 'profile'],
        ];

        Permission::insert($permissions);
    }
}
