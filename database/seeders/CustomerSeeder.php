<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'করিম সাহেব', 'phone' => '01712345678', 'email' => 'karim@example.com', 'address' => 'মতিঝিল, ঢাকা'],
            ['name' => 'রহিম মিয়া', 'phone' => '01812345679', 'email' => 'rahim@example.com', 'address' => 'আগ্রাবাদ, চট্টগ্রাম'],
            ['name' => 'জামাল উদ্দিন', 'phone' => '01912345680', 'email' => 'jamal@example.com', 'address' => 'জিন্দাবাজার, সিলেট'],
            ['name' => 'আবুল হোসেন', 'phone' => '01612345681', 'email' => 'abul@example.com', 'address' => 'সদর, রাজশাহী'],
            ['name' => 'মোঃ সালাম', 'phone' => '01512345682', 'email' => 'salam@example.com', 'address' => 'সোনাডাঙ্গা, খুলনা'],
            ['name' => 'নাসরিন আক্তার', 'phone' => '01312345683', 'email' => 'nasrin@example.com', 'address' => 'কাওরান বাজার, ঢাকা'],
            ['name' => 'ফারুক আহমেদ', 'phone' => '01412345684', 'email' => 'faruk@example.com', 'address' => 'নিউমার্কেট, ঢাকা'],
            ['name' => 'তানভীর হাসান', 'phone' => '01112345685', 'email' => 'tanvir@example.com', 'address' => 'বনানী, ঢাকা'],
            ['name' => 'সুমাইয়া খাতুন', 'phone' => '01712345686', 'email' => 'sumaiya@example.com', 'address' => 'দোহার, ঢাকা'],
            ['name' => 'রফিকুল ইসলাম', 'phone' => '01812345687', 'email' => 'rafiq@example.com', 'address' => 'বরিশাল সদর, বরিশাল'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
