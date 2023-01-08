<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Business;
use App\Models\UserRole;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultUserRole();

        $this->createDefaultUser();

        $this->createDefaultUserAddress();

        $this->createDefaultCategory();

        $this->createDefaultBusiness();

        $this->createDefaultProduct();
    }

    public function createDefaultUserRole()
    {
        $userRoles = [
            ['name' => 'Admin','login_allowed' => true],
            ['name' => 'Client','login_allowed' => true],
            ['name' => 'Customer','login_allowed' => false]
        ];
        UserRole::insert($userRoles);
    }

    public function createDefaultUser()
    {
        /* Creating Entry For Master User */
        User::factory(1)->create([
            'name' => 'Rajeev Gupta',
            'user_role' => UserRole::ADMIN.','.UserRole::CLIENT.','.UserRole::CUSTOMER,
            'email' => 'rrpit9@gmail.com',
            'mobile' => '8804809613',
            'referred_by' => 1,
            'date_of_birth' => '1995-06-09',
            'aniversary' => '2020-12-11'
        ]);
        
        /* Creating Faker Entry For all Type of User */
        User::factory(10)->create();
    }

    public function createDefaultUserAddress()
    {
        
    }

    public function createDefaultCategory()
    {
        $categories = [
            ['name' => 'Medical'],
            ['name' => 'Doctor'],
            ['name' => 'Automobile'],
            ['name' => 'Grocery'],
            ['name' => 'Furniture'],
            ['name' => 'Electronics'],
            ['name' => 'Jwellary'],
            ['name' => 'Online Shopping']
        ];
        Category::insert($categories);
    }

    public function createDefaultBusiness()
    {
        $faker = Faker::create();
        $clients = User::whereRaw('FIND_IN_SET('.UserRole::CLIENT.', user_role)')->get();
        foreach($clients as $key => $client){
            $business = Business::firstOrCreate(['client_id' => $client->id],
                [
                    'category_id' => rand(1,7),
                    'name' => $faker->name,
                    'logo' => $faker->imageUrl(400, 300),
                    'address' => $faker->address,
                    'pincode' => \Faker\Provider\Address::postcode(),
                    'business_email' => $client->email,
                    'business_mobile' => $client->mobile
                ]
            );
        }
    }

    public function createDefaultProduct()
    {
        $faker = Faker::create();
        $businessess = Business::get();

        foreach($businessess as $key => $business)
        {
            $productData = [];
            for ($i=0; $i < 10; $i++) { 
                $productData[] = [
                    'client_id' => $business->client_id,
                    'business_id' => $business->id,
                    'image' => $faker->imageUrl(400, 300),
                    'name' => $faker->name(),
                    'price' => $faker->numberBetween($min = 10, $max = 40),
                    'discount' => $faker->numberBetween($min = 2, $max = 10),
                    'description' => $faker->text(),
                    'expiry' => date('Y-m-d',strtotime('+ '.rand(200,500).' days'))
                ];
            }
            Product::insert($productData);
        }
    }
}
