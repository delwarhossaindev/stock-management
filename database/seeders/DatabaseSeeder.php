<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles & Permissions first
        $this->call(RolePermissionSeeder::class);

        // Users
        $admin = User::create([
            'name' => 'অ্যাডমিন',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $user1 = User::create([
            'name' => 'রহিম উদ্দিন',
            'email' => 'rahim@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole('user');

        $user2 = User::create([
            'name' => 'করিম হোসেন',
            'email' => 'karim@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole('user');

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

        // Units
        $unitPcs = Unit::create(['name' => 'পিস']);
        $unitBag = Unit::create(['name' => 'ব্যাগ']);
        $unitBottle = Unit::create(['name' => 'বোতল']);
        $unitKg = Unit::create(['name' => 'কেজি']);
        $unitBox = Unit::create(['name' => 'বক্স']);

        // Products
        $p1 = Product::create(['category_id' => $electronics->id, 'unit_id' => $unitPcs->id, 'name' => 'স্যামসাং গ্যালাক্সি A15', 'sku' => 'ELEC-001', 'description' => 'স্যামসাং স্মার্টফোন', 'buy_price' => 12000, 'sell_price' => 14500, 'quantity' => 25]);
        $p2 = Product::create(['category_id' => $electronics->id, 'unit_id' => $unitPcs->id, 'name' => 'ওয়্যারলেস ইয়ারবাড', 'sku' => 'ELEC-002', 'description' => 'ব্লুটুথ ইয়ারবাড', 'buy_price' => 800, 'sell_price' => 1200, 'quantity' => 50]);
        $p3 = Product::create(['category_id' => $electronics->id, 'unit_id' => $unitPcs->id, 'name' => 'ইউএসবি ক্যাবল টাইপ-সি', 'sku' => 'ELEC-003', 'description' => '১ মিটার টাইপ-সি ক্যাবল', 'buy_price' => 100, 'sell_price' => 180, 'quantity' => 100]);
        $p4 = Product::create(['category_id' => $clothing->id, 'unit_id' => $unitPcs->id, 'name' => 'টি-শার্ট (পুরুষ)', 'sku' => 'CLT-001', 'description' => 'কটন টি-শার্ট', 'buy_price' => 250, 'sell_price' => 450, 'quantity' => 60]);
        $p5 = Product::create(['category_id' => $clothing->id, 'unit_id' => $unitPcs->id, 'name' => 'জিন্স প্যান্ট', 'sku' => 'CLT-002', 'description' => 'ডেনিম জিন্স', 'buy_price' => 600, 'sell_price' => 950, 'quantity' => 40]);
        $p6 = Product::create(['category_id' => $grocery->id, 'unit_id' => $unitBag->id, 'name' => 'বাসমতি চাল (৫কেজি)', 'sku' => 'GRC-001', 'description' => 'প্রিমিয়াম বাসমতি চাল', 'buy_price' => 450, 'sell_price' => 550, 'quantity' => 80]);
        $p7 = Product::create(['category_id' => $grocery->id, 'unit_id' => $unitBottle->id, 'name' => 'সয়াবিন তেল (৫লি)', 'sku' => 'GRC-002', 'description' => 'সয়াবিন তেল', 'buy_price' => 700, 'sell_price' => 850, 'quantity' => 45]);
        $p8 = Product::create(['category_id' => $grocery->id, 'unit_id' => $unitKg->id, 'name' => 'চিনি (১কেজি)', 'sku' => 'GRC-003', 'description' => 'সাদা চিনি', 'buy_price' => 80, 'sell_price' => 110, 'quantity' => 3]);
        $p9 = Product::create(['category_id' => $stationery->id, 'unit_id' => $unitPcs->id, 'name' => 'নোটবুক (২০০ পৃষ্ঠা)', 'sku' => 'STN-001', 'description' => 'রুলড নোটবুক', 'buy_price' => 40, 'sell_price' => 70, 'quantity' => 150]);
        $p10 = Product::create(['category_id' => $stationery->id, 'unit_id' => $unitBox->id, 'name' => 'বল পেন (বক্স)', 'sku' => 'STN-002', 'description' => '১০টি পেনের বক্স', 'buy_price' => 80, 'sell_price' => 130, 'quantity' => 2]);
        $p11 = Product::create(['category_id' => $cosmetics->id, 'unit_id' => $unitPcs->id, 'name' => 'ফেস ওয়াশ', 'sku' => 'COS-001', 'description' => 'জেন্টল ফেস ওয়াশ ১০০মিলি', 'buy_price' => 150, 'sell_price' => 250, 'quantity' => 35]);
        $p12 = Product::create(['category_id' => $cosmetics->id, 'unit_id' => $unitPcs->id, 'name' => 'বডি লোশন', 'sku' => 'COS-002', 'description' => 'ময়েশ্চারাইজিং লোশন ২০০মিলি', 'buy_price' => 200, 'sell_price' => 350, 'quantity' => 0]);

        // Purchases (invoice style with items)
        $pur1 = Purchase::create(['purchase_no' => 'PUR-000001', 'supplier_id' => $sup1->id, 'subtotal' => 410000, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 410000, 'paid_amount' => 410000, 'due_amount' => 0, 'purchase_date' => '2026-02-01', 'note' => 'প্রথম ব্যাচ - ইলেকট্রনিক্স']);
        PurchaseItem::create(['purchase_id' => $pur1->id, 'product_id' => $p1->id, 'quantity' => 30, 'buy_price' => 12000, 'total' => 360000]);
        PurchaseItem::create(['purchase_id' => $pur1->id, 'product_id' => $p2->id, 'quantity' => 50, 'buy_price' => 800, 'total' => 40000]);
        PurchaseItem::create(['purchase_id' => $pur1->id, 'product_id' => $p3->id, 'quantity' => 100, 'buy_price' => 100, 'total' => 10000]);

        $pur2 = Purchase::create(['purchase_no' => 'PUR-000002', 'supplier_id' => $sup2->id, 'subtotal' => 50000, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 50000, 'paid_amount' => 50000, 'due_amount' => 0, 'purchase_date' => '2026-02-07', 'note' => 'পোশাক ক্রয়']);
        PurchaseItem::create(['purchase_id' => $pur2->id, 'product_id' => $p4->id, 'quantity' => 80, 'buy_price' => 250, 'total' => 20000]);
        PurchaseItem::create(['purchase_id' => $pur2->id, 'product_id' => $p5->id, 'quantity' => 50, 'buy_price' => 600, 'total' => 30000]);

        $pur3 = Purchase::create(['purchase_no' => 'PUR-000003', 'supplier_id' => $sup3->id, 'subtotal' => 82400, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 82400, 'paid_amount' => 82400, 'due_amount' => 0, 'purchase_date' => '2026-02-12', 'note' => 'মুদি পণ্য ক্রয়']);
        PurchaseItem::create(['purchase_id' => $pur3->id, 'product_id' => $p6->id, 'quantity' => 100, 'buy_price' => 450, 'total' => 45000]);
        PurchaseItem::create(['purchase_id' => $pur3->id, 'product_id' => $p7->id, 'quantity' => 50, 'buy_price' => 700, 'total' => 35000]);
        PurchaseItem::create(['purchase_id' => $pur3->id, 'product_id' => $p8->id, 'quantity' => 30, 'buy_price' => 80, 'total' => 2400]);

        $pur4 = Purchase::create(['purchase_no' => 'PUR-000004', 'supplier_id' => $sup4->id, 'subtotal' => 10400, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 10400, 'paid_amount' => 10400, 'due_amount' => 0, 'purchase_date' => '2026-02-20', 'note' => 'স্টেশনারি ক্রয়']);
        PurchaseItem::create(['purchase_id' => $pur4->id, 'product_id' => $p9->id, 'quantity' => 200, 'buy_price' => 40, 'total' => 8000]);
        PurchaseItem::create(['purchase_id' => $pur4->id, 'product_id' => $p10->id, 'quantity' => 30, 'buy_price' => 80, 'total' => 2400]);

        $pur5 = Purchase::create(['purchase_no' => 'PUR-000005', 'supplier_id' => $sup5->id, 'subtotal' => 11000, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 11000, 'paid_amount' => 11000, 'due_amount' => 0, 'purchase_date' => '2026-02-25', 'note' => 'প্রসাধনী ক্রয়']);
        PurchaseItem::create(['purchase_id' => $pur5->id, 'product_id' => $p11->id, 'quantity' => 40, 'buy_price' => 150, 'total' => 6000]);
        PurchaseItem::create(['purchase_id' => $pur5->id, 'product_id' => $p12->id, 'quantity' => 25, 'buy_price' => 200, 'total' => 5000]);

        $pur6 = Purchase::create(['purchase_no' => 'PUR-000006', 'supplier_id' => $sup1->id, 'subtotal' => 118000, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 118000, 'paid_amount' => 100000, 'due_amount' => 18000, 'purchase_date' => '2026-03-01', 'note' => 'দ্বিতীয় ব্যাচ']);
        PurchaseItem::create(['purchase_id' => $pur6->id, 'product_id' => $p1->id, 'quantity' => 10, 'buy_price' => 11800, 'total' => 118000]);

        $pur7 = Purchase::create(['purchase_no' => 'PUR-000007', 'supplier_id' => $sup3->id, 'subtotal' => 22000, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 22000, 'paid_amount' => 22000, 'due_amount' => 0, 'purchase_date' => '2026-03-02']);
        PurchaseItem::create(['purchase_id' => $pur7->id, 'product_id' => $p6->id, 'quantity' => 50, 'buy_price' => 440, 'total' => 22000]);

        // Sales (invoice style with items)
        $s1 = Sale::create(['invoice_no' => 'INV-000001', 'customer_name' => 'জামাল হোসেন', 'subtotal' => 72500, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 72500, 'paid_amount' => 72500, 'due_amount' => 0, 'sale_date' => '2026-02-05']);
        SaleItem::create(['sale_id' => $s1->id, 'product_id' => $p1->id, 'quantity' => 5, 'sell_price' => 14500, 'total' => 72500]);

        $s2 = Sale::create(['invoice_no' => 'INV-000002', 'customer_name' => 'রফিক আহমেদ', 'subtotal' => 43500, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 43500, 'paid_amount' => 43500, 'due_amount' => 0, 'sale_date' => '2026-02-10']);
        SaleItem::create(['sale_id' => $s2->id, 'product_id' => $p1->id, 'quantity' => 3, 'sell_price' => 14500, 'total' => 43500]);

        $s3 = Sale::create(['invoice_no' => 'INV-000003', 'customer_name' => 'সুমন দাস', 'subtotal' => 12000, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 12000, 'paid_amount' => 12000, 'due_amount' => 0, 'sale_date' => '2026-02-08']);
        SaleItem::create(['sale_id' => $s3->id, 'product_id' => $p2->id, 'quantity' => 10, 'sell_price' => 1200, 'total' => 12000]);

        $s4 = Sale::create(['invoice_no' => 'INV-000004', 'customer_name' => null, 'subtotal' => 3600, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 3600, 'paid_amount' => 3600, 'due_amount' => 0, 'sale_date' => '2026-02-12']);
        SaleItem::create(['sale_id' => $s4->id, 'product_id' => $p3->id, 'quantity' => 20, 'sell_price' => 180, 'total' => 3600]);

        $s5 = Sale::create(['invoice_no' => 'INV-000005', 'customer_name' => 'হাবিব মিয়া', 'subtotal' => 14350, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 14350, 'paid_amount' => 14350, 'due_amount' => 0, 'sale_date' => '2026-02-14']);
        SaleItem::create(['sale_id' => $s5->id, 'product_id' => $p4->id, 'quantity' => 15, 'sell_price' => 450, 'total' => 6750]);
        SaleItem::create(['sale_id' => $s5->id, 'product_id' => $p5->id, 'quantity' => 8, 'sell_price' => 950, 'total' => 7600]);

        $s6 = Sale::create(['invoice_no' => 'INV-000006', 'customer_name' => 'আক্তার বানু', 'subtotal' => 15250, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 15250, 'paid_amount' => 15250, 'due_amount' => 0, 'sale_date' => '2026-02-18']);
        SaleItem::create(['sale_id' => $s6->id, 'product_id' => $p6->id, 'quantity' => 20, 'sell_price' => 550, 'total' => 11000]);
        SaleItem::create(['sale_id' => $s6->id, 'product_id' => $p7->id, 'quantity' => 5, 'sell_price' => 850, 'total' => 4250]);

        $s7 = Sale::create(['invoice_no' => 'INV-000007', 'customer_name' => 'মিনা বেগম', 'subtotal' => 1100, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 1100, 'paid_amount' => 1100, 'due_amount' => 0, 'sale_date' => '2026-02-22']);
        SaleItem::create(['sale_id' => $s7->id, 'product_id' => $p8->id, 'quantity' => 10, 'sell_price' => 110, 'total' => 1100]);

        $s8 = Sale::create(['invoice_no' => 'INV-000008', 'customer_name' => 'স্কুল সাপ্লায়ার', 'subtotal' => 4800, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 4800, 'paid_amount' => 4800, 'due_amount' => 0, 'sale_date' => '2026-02-24']);
        SaleItem::create(['sale_id' => $s8->id, 'product_id' => $p9->id, 'quantity' => 50, 'sell_price' => 70, 'total' => 3500]);
        SaleItem::create(['sale_id' => $s8->id, 'product_id' => $p10->id, 'quantity' => 10, 'sell_price' => 130, 'total' => 1300]);

        $s9 = Sale::create(['invoice_no' => 'INV-000009', 'customer_name' => 'তাসনিম আক্তার', 'subtotal' => 4050, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 4050, 'paid_amount' => 4050, 'due_amount' => 0, 'sale_date' => '2026-02-27']);
        SaleItem::create(['sale_id' => $s9->id, 'product_id' => $p11->id, 'quantity' => 5, 'sell_price' => 250, 'total' => 1250]);
        SaleItem::create(['sale_id' => $s9->id, 'product_id' => $p12->id, 'quantity' => 8, 'sell_price' => 350, 'total' => 2800]);

        $s10 = Sale::create(['invoice_no' => 'INV-000010', 'customer_name' => 'সোহাগ ইসলাম', 'subtotal' => 101500, 'discount' => 1500, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 100000, 'paid_amount' => 80000, 'due_amount' => 20000, 'sale_date' => '2026-03-01']);
        SaleItem::create(['sale_id' => $s10->id, 'product_id' => $p1->id, 'quantity' => 7, 'sell_price' => 14500, 'total' => 101500]);

        $s11 = Sale::create(['invoice_no' => 'INV-000011', 'customer_name' => 'মাসুদ রানা', 'subtotal' => 2250, 'discount' => 0, 'tax_type' => 'percentage', 'tax_value' => 0, 'tax_amount' => 0, 'total_price' => 2250, 'paid_amount' => 2250, 'due_amount' => 0, 'sale_date' => '2026-03-03']);
        SaleItem::create(['sale_id' => $s11->id, 'product_id' => $p4->id, 'quantity' => 5, 'sell_price' => 450, 'total' => 2250]);

        // Quotations (depends on customers & products)
        $this->call([
            CustomerSeeder::class,
            QuotationSeeder::class,
        ]);
    }
}
