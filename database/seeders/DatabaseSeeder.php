<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name' => 'অ্যাডমিন',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'রহিম উদ্দিন',
            'email' => 'rahim@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'করিম হোসেন',
            'email' => 'karim@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Categories
        $electronics = Category::create(['name' => 'ইলেকট্রনিক্স', 'description' => 'ইলেকট্রনিক ডিভাইস ও আনুষাঙ্গিক']);
        $clothing = Category::create(['name' => 'পোশাক', 'description' => 'গার্মেন্টস ও পোশাক সামগ্রী']);
        $grocery = Category::create(['name' => 'মুদি পণ্য', 'description' => 'দৈনন্দিন মুদি সামগ্রী']);
        $stationery = Category::create(['name' => 'স্টেশনারি', 'description' => 'অফিস ও স্কুল সামগ্রী']);
        $cosmetics = Category::create(['name' => 'প্রসাধনী', 'description' => 'সৌন্দর্য ও ব্যক্তিগত যত্ন']);

        // Suppliers
        $sup1 = Supplier::create(['name' => 'এবিসি ইলেকট্রনিক্স লিমিটেড', 'email' => 'abc@electronics.com', 'phone' => '01711111111', 'address' => 'ঢাকা, বাংলাদেশ']);
        $sup2 = Supplier::create(['name' => 'ফ্যাশন ওয়ার্ল্ড', 'email' => 'fashion@world.com', 'phone' => '01722222222', 'address' => 'চট্টগ্রাম, বাংলাদেশ']);
        $sup3 = Supplier::create(['name' => 'ডেইলি নিডস সাপ্লাই', 'email' => 'daily@needs.com', 'phone' => '01733333333', 'address' => 'রাজশাহী, বাংলাদেশ']);
        $sup4 = Supplier::create(['name' => 'স্টার স্টেশনারি', 'email' => 'star@stationery.com', 'phone' => '01744444444', 'address' => 'সিলেট, বাংলাদেশ']);
        $sup5 = Supplier::create(['name' => 'বিউটি কেয়ার বিডি', 'email' => 'beauty@care.com', 'phone' => '01755555555', 'address' => 'খুলনা, বাংলাদেশ']);

        // Products
        $p1 = Product::create(['category_id' => $electronics->id, 'name' => 'স্যামসাং গ্যালাক্সি A15', 'sku' => 'ELEC-001', 'description' => 'স্যামসাং স্মার্টফোন', 'buy_price' => 12000, 'sell_price' => 14500, 'quantity' => 25, 'unit' => 'পিস']);
        $p2 = Product::create(['category_id' => $electronics->id, 'name' => 'ওয়্যারলেস ইয়ারবাড', 'sku' => 'ELEC-002', 'description' => 'ব্লুটুথ ইয়ারবাড', 'buy_price' => 800, 'sell_price' => 1200, 'quantity' => 50, 'unit' => 'পিস']);
        $p3 = Product::create(['category_id' => $electronics->id, 'name' => 'ইউএসবি ক্যাবল টাইপ-সি', 'sku' => 'ELEC-003', 'description' => '১ মিটার টাইপ-সি ক্যাবল', 'buy_price' => 100, 'sell_price' => 180, 'quantity' => 100, 'unit' => 'পিস']);
        $p4 = Product::create(['category_id' => $clothing->id, 'name' => 'টি-শার্ট (পুরুষ)', 'sku' => 'CLT-001', 'description' => 'কটন টি-শার্ট', 'buy_price' => 250, 'sell_price' => 450, 'quantity' => 60, 'unit' => 'পিস']);
        $p5 = Product::create(['category_id' => $clothing->id, 'name' => 'জিন্স প্যান্ট', 'sku' => 'CLT-002', 'description' => 'ডেনিম জিন্স', 'buy_price' => 600, 'sell_price' => 950, 'quantity' => 40, 'unit' => 'পিস']);
        $p6 = Product::create(['category_id' => $grocery->id, 'name' => 'বাসমতি চাল (৫কেজি)', 'sku' => 'GRC-001', 'description' => 'প্রিমিয়াম বাসমতি চাল', 'buy_price' => 450, 'sell_price' => 550, 'quantity' => 80, 'unit' => 'ব্যাগ']);
        $p7 = Product::create(['category_id' => $grocery->id, 'name' => 'সয়াবিন তেল (৫লি)', 'sku' => 'GRC-002', 'description' => 'সয়াবিন তেল', 'buy_price' => 700, 'sell_price' => 850, 'quantity' => 45, 'unit' => 'বোতল']);
        $p8 = Product::create(['category_id' => $grocery->id, 'name' => 'চিনি (১কেজি)', 'sku' => 'GRC-003', 'description' => 'সাদা চিনি', 'buy_price' => 80, 'sell_price' => 110, 'quantity' => 3, 'unit' => 'কেজি']);
        $p9 = Product::create(['category_id' => $stationery->id, 'name' => 'নোটবুক (২০০ পৃষ্ঠা)', 'sku' => 'STN-001', 'description' => 'রুলড নোটবুক', 'buy_price' => 40, 'sell_price' => 70, 'quantity' => 150, 'unit' => 'পিস']);
        $p10 = Product::create(['category_id' => $stationery->id, 'name' => 'বল পেন (বক্স)', 'sku' => 'STN-002', 'description' => '১০টি পেনের বক্স', 'buy_price' => 80, 'sell_price' => 130, 'quantity' => 2, 'unit' => 'বক্স']);
        $p11 = Product::create(['category_id' => $cosmetics->id, 'name' => 'ফেস ওয়াশ', 'sku' => 'COS-001', 'description' => 'জেন্টল ফেস ওয়াশ ১০০মিলি', 'buy_price' => 150, 'sell_price' => 250, 'quantity' => 35, 'unit' => 'পিস']);
        $p12 = Product::create(['category_id' => $cosmetics->id, 'name' => 'বডি লোশন', 'sku' => 'COS-002', 'description' => 'ময়েশ্চারাইজিং লোশন ২০০মিলি', 'buy_price' => 200, 'sell_price' => 350, 'quantity' => 0, 'unit' => 'পিস']);

        // Purchases
        Purchase::create(['product_id' => $p1->id, 'supplier_id' => $sup1->id, 'quantity' => 30, 'buy_price' => 12000, 'total_price' => 360000, 'purchase_date' => '2026-02-01', 'note' => 'প্রথম ব্যাচ']);
        Purchase::create(['product_id' => $p2->id, 'supplier_id' => $sup1->id, 'quantity' => 50, 'buy_price' => 800, 'total_price' => 40000, 'purchase_date' => '2026-02-03']);
        Purchase::create(['product_id' => $p3->id, 'supplier_id' => $sup1->id, 'quantity' => 100, 'buy_price' => 100, 'total_price' => 10000, 'purchase_date' => '2026-02-05']);
        Purchase::create(['product_id' => $p4->id, 'supplier_id' => $sup2->id, 'quantity' => 80, 'buy_price' => 250, 'total_price' => 20000, 'purchase_date' => '2026-02-07']);
        Purchase::create(['product_id' => $p5->id, 'supplier_id' => $sup2->id, 'quantity' => 50, 'buy_price' => 600, 'total_price' => 30000, 'purchase_date' => '2026-02-10']);
        Purchase::create(['product_id' => $p6->id, 'supplier_id' => $sup3->id, 'quantity' => 100, 'buy_price' => 450, 'total_price' => 45000, 'purchase_date' => '2026-02-12']);
        Purchase::create(['product_id' => $p7->id, 'supplier_id' => $sup3->id, 'quantity' => 50, 'buy_price' => 700, 'total_price' => 35000, 'purchase_date' => '2026-02-15']);
        Purchase::create(['product_id' => $p8->id, 'supplier_id' => $sup3->id, 'quantity' => 30, 'buy_price' => 80, 'total_price' => 2400, 'purchase_date' => '2026-02-18']);
        Purchase::create(['product_id' => $p9->id, 'supplier_id' => $sup4->id, 'quantity' => 200, 'buy_price' => 40, 'total_price' => 8000, 'purchase_date' => '2026-02-20']);
        Purchase::create(['product_id' => $p10->id, 'supplier_id' => $sup4->id, 'quantity' => 30, 'buy_price' => 80, 'total_price' => 2400, 'purchase_date' => '2026-02-22']);
        Purchase::create(['product_id' => $p11->id, 'supplier_id' => $sup5->id, 'quantity' => 40, 'buy_price' => 150, 'total_price' => 6000, 'purchase_date' => '2026-02-25']);
        Purchase::create(['product_id' => $p12->id, 'supplier_id' => $sup5->id, 'quantity' => 25, 'buy_price' => 200, 'total_price' => 5000, 'purchase_date' => '2026-02-28']);
        Purchase::create(['product_id' => $p1->id, 'supplier_id' => $sup1->id, 'quantity' => 10, 'buy_price' => 11800, 'total_price' => 118000, 'purchase_date' => '2026-03-01', 'note' => 'দ্বিতীয় ব্যাচ']);
        Purchase::create(['product_id' => $p6->id, 'supplier_id' => $sup3->id, 'quantity' => 50, 'buy_price' => 440, 'total_price' => 22000, 'purchase_date' => '2026-03-02']);

        // Sales
        Sale::create(['product_id' => $p1->id, 'customer_name' => 'জামাল হোসেন', 'quantity' => 5, 'sell_price' => 14500, 'total_price' => 72500, 'sale_date' => '2026-02-05']);
        Sale::create(['product_id' => $p1->id, 'customer_name' => 'রফিক আহমেদ', 'quantity' => 3, 'sell_price' => 14500, 'total_price' => 43500, 'sale_date' => '2026-02-10']);
        Sale::create(['product_id' => $p2->id, 'customer_name' => 'সুমন দাস', 'quantity' => 10, 'sell_price' => 1200, 'total_price' => 12000, 'sale_date' => '2026-02-08']);
        Sale::create(['product_id' => $p3->id, 'customer_name' => null, 'quantity' => 20, 'sell_price' => 180, 'total_price' => 3600, 'sale_date' => '2026-02-12']);
        Sale::create(['product_id' => $p4->id, 'customer_name' => 'হাবিব মিয়া', 'quantity' => 15, 'sell_price' => 450, 'total_price' => 6750, 'sale_date' => '2026-02-14']);
        Sale::create(['product_id' => $p5->id, 'customer_name' => 'নাঈম খান', 'quantity' => 8, 'sell_price' => 950, 'total_price' => 7600, 'sale_date' => '2026-02-16']);
        Sale::create(['product_id' => $p6->id, 'customer_name' => 'আক্তার বানু', 'quantity' => 20, 'sell_price' => 550, 'total_price' => 11000, 'sale_date' => '2026-02-18']);
        Sale::create(['product_id' => $p7->id, 'customer_name' => 'রুবেল শেখ', 'quantity' => 5, 'sell_price' => 850, 'total_price' => 4250, 'sale_date' => '2026-02-20']);
        Sale::create(['product_id' => $p8->id, 'customer_name' => 'মিনা বেগম', 'quantity' => 10, 'sell_price' => 110, 'total_price' => 1100, 'sale_date' => '2026-02-22']);
        Sale::create(['product_id' => $p9->id, 'customer_name' => 'স্কুল সাপ্লায়ার', 'quantity' => 50, 'sell_price' => 70, 'total_price' => 3500, 'sale_date' => '2026-02-24']);
        Sale::create(['product_id' => $p10->id, 'customer_name' => 'অফিস মার্ট', 'quantity' => 10, 'sell_price' => 130, 'total_price' => 1300, 'sale_date' => '2026-02-25']);
        Sale::create(['product_id' => $p11->id, 'customer_name' => 'তাসনিম আক্তার', 'quantity' => 5, 'sell_price' => 250, 'total_price' => 1250, 'sale_date' => '2026-02-27']);
        Sale::create(['product_id' => $p12->id, 'customer_name' => 'ফাতেমা খাতুন', 'quantity' => 8, 'sell_price' => 350, 'total_price' => 2800, 'sale_date' => '2026-02-28']);
        Sale::create(['product_id' => $p1->id, 'customer_name' => 'সোহাগ ইসলাম', 'quantity' => 7, 'sell_price' => 14500, 'total_price' => 101500, 'sale_date' => '2026-03-01']);
        Sale::create(['product_id' => $p4->id, 'customer_name' => 'মাসুদ রানা', 'quantity' => 5, 'sell_price' => 450, 'total_price' => 2250, 'sale_date' => '2026-03-03']);
    }
}
