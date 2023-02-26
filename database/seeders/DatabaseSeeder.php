<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Worker;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Permission;
use App\Models\Categories;
use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\UsersPermissions;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    //PERMISSIONS
    private function addPermissions()
    {
        $permissionsIdList = [];

        $p = Permission::create([
            'key' => 'p-expenses',
        ]);
        $p = Permission::create([
            'key' => 'p-receipts',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-suppliers',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-products',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-clients',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-services',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-branches',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-workers',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-users',
        ]);
        array_push($permissionsIdList, $p->id);

        $p = Permission::create([
            'key' => 'p-categories',
        ]);
        array_push($permissionsIdList, $p->id);


        $p = Permission::create([
            'key' => 'p-reports',
        ]);
        array_push($permissionsIdList, $p->id);

        return $permissionsIdList;
    }

    //ADD MAIN BRANCH
    private function addMainBranch()
    {

        return Branch::create([
            'name' => 'Main',
        ]);
    }

    //USERS
    private function addUsersWithPermissionsForMainBranch()
    {
        $mainBranch = $this->addMainBranch();

        $icon = User::create([
            'branch_id' => $mainBranch->id,
            'type' => '-1',
            'name' => 'iconDev',
            'username' => 'icon',
            'email' => 'icon.dev@icon-ts.com',
            // 'password' => '$2y$10$aFhDRthDjPC6KpTC93O5EeYpptZO/SJ2Um5gSxHSOKoGI5r0edFc2', //adminadminn
            'password' => Hash::make(124578963), //adminadminn
            'locale' => 'en',
            'visible' => '0',
        ]);

        $admin = User::create([
            'branch_id' => $mainBranch->id,
            'type' => '0',
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            // 'password' => '$2y$10$ojihJXwGpA9j7FlB/8BYH.PoqyYUPkzm/Fc1at.x43BUnVGh5ENUO', //admin12345
            'password' => Hash::make(124578963), //adminadminn
            'locale' => 'en',
            'visible' => '0',
        ]);

        $sadek = User::create([
            'branch_id' => $mainBranch->id,
            'type' => '0',
            'name' => 'sadek',
            'username' => 'sadek',
            'email' => 'sadek@sadek.com',
            // 'password' => '$2y$10$ojihJXwGpA9j7FlB/8BYH.PoqyYUPkzm/Fc1at.x43BUnVGh5ENUO', //admin12345
            'password' => Hash::make(124578963), //adminadminn
            'locale' => 'en',
            'visible' => '0',
        ]);

        $permissionsIdList = $this->addPermissions();


        $sadekPermissions = [
            "p-reports",
            "p-expenses",
            "p-products",
            "p-clients",
            "p-categories",
            "p-suppliers",
            "p-receipts",
        ];


        foreach ($sadekPermissions as $permission) {
            UsersPermissions::create([
                'user_id' => $sadek->id,
                'permission_id' => Permission::where("key" ,$permission)->first()->id,
            ]);
        }



        foreach ([$icon->id, $admin->id] as $userId) {

            foreach ($permissionsIdList as $pId) {
                UsersPermissions::create([
                    'user_id' => $userId,
                    'permission_id' => $pId,
                ]);
            }
        }
    }

    public function addWorkersWithBranches()
    {
        //MAIN BRANCH ID IS 1
        Worker::factory()->count(100)->create();
    }

    public function addSuppliers()
    {
        Supplier::factory()->count(100)->create();
    }

    public function addClients()
    {
        Client::factory()->count(100)->create();
    }

    public function addProducts()
    {

        Product::factory()->count(100)->create();
    }


    public function addExpenses()
    {

        Expense::factory()->count(60)->create();
    }

    public function addCategories()
    {

        Category::factory()->count(20)->create();
    }

    public function run()
    {
        $this->addUsersWithPermissionsForMainBranch();
        // $this->addWorkersWithBranches();
        // $this->addSuppliers();
        // $this->addClients();
        // $this->addCategories();
        // $this->addProducts();
        // $this->addExpenses();

    }
}
