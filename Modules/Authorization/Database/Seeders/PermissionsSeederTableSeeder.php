<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Authorization\Entities\Permission;

class PermissionsSeederTableSeeder extends Seeder
{

    private $extraPermissions =
    ["packages", "categories", "countries", "cities", "states", "pages", "admins", "users", "roles", "sliders", "subscriptions", "suspensions"];

    private $permissions = [
        'dashboard_access' => [
            'routes' => 'dashboard.home',
            'category' => 'access',
            'title_en' => 'Dashboard access',
            'title_ar' => 'عرض لوحة التحكم',
        ],
        'show_statistics' => [
            'routes' => '',
            'category' => 'access-statistics',
            'title_en' => 'show statistics',
            'title_ar' => 'عرض  حصائيات لوحه التحكم',
        ],
        'edit_settings' => [
            'routes' => '',
            'category' => 'settings',
            'title_en' => 'Edit',
            'title_ar' => 'تعديل',
        ],
        'show_settings' => [
            'routes' => '',
            'category' => 'settings',
            'title_en' => 'Show',
            'title_ar' => 'عرض',
        ],
        'send_notifications' => [
            'routes' => '',
            'category' => 'notifications',
            'title_en' => 'Send',
            'title_ar' => 'إرسال',
        ],
        'show_notifications' => [
            'routes' => '',
            'category' => 'notifications',
            'title_en' => 'Show',
            'title_ar' => 'عرض',
        ],
        'delete_logs' => [
            'routes' => 'dashboard.logs.deletes,dashboard.logs.destroy',
            'category' => 'logs',
            'title_en' => 'Delete',
            'title_ar' => 'حذف',
        ],
        'show_logs' => [
            'routes' => 'dashboard.logs.index,dashboard.logs.datatable,dashboard.logs.show',
            'category' => 'logs',
            'title_en' => 'Show',
            'title_ar' => 'عرض',
        ],
        'delete_devices' => [
            'routes' => 'dashboard.devices.deletes,dashboard.devices.destroy',
            'category' => 'devices',
            'title_en' => 'Delete',
            'title_ar' => 'حذف',
        ],
        'show_devices' => [
            'routes' => 'dashboard.devices.index,dashboard.devices.datatable,dashboard.devices.show',
            'category' => 'devices',
            'title_en' => 'Show',
            'title_ar' => 'عرض',
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->handelExtraPermissions(collect($this->permissions));
        foreach ($data as $name => $per_data) {
            $perm = Permission::updateOrCreate([
                "name" => $name,
            ], [
                "name" => $name,
                "category" => $per_data["category"],
                "guard_name" => "web",
                "routes" => $per_data["routes"],
                "display_name" => ["en" => $per_data["title_en"], "ar" => $per_data["title_ar"]]
            ]);
            $perm->save();
        }
    }



//



    public function handelExtraPermissions($permissions)
    {

        $data = $permissions;
        foreach ($this->extraPermissions  as  $model) {
            $data["add_$model"]   = [
                "routes" => "dashboard.$model.create,dashboard.$model.store",
                "category" => "$model",
                "title_en" => "Add",
                "title_ar" => "إضافة",
            ];
            $data["edit_$model"] = [
                "routes" => "dashboard.$model.edit,dashboard.$model.update",
                "category" => "$model",
                "title_en" => "Edit",
                "title_ar" => "تعديل",
            ];
            $data["delete_$model"] = [
                "routes" => "dashboard.$model.deletes,dashboard.$model.destroy",
                "category" => "$model",
                "title_en" => "Delete",
                "title_ar" => "حذف",
            ];
            $data["show_$model"] = [
                "routes" => "dashboard.$model.index,dashboard.$model.datatable,dashboard.$model.show",
                "category" => "$model",
                "title_en" => "Show",
                "title_ar" => "عرض",
            ];
        }
        return $data;
    }
}
