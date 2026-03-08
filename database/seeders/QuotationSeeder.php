<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        // কোটেশন ১ - করিম সাহেব
        $q1 = Quotation::create([
            'quotation_no' => 'QUO-000001',
            'customer_id' => $customers[0]->id,
            'customer_name' => $customers[0]->name,
            'subtotal' => 87000,
            'discount' => 2000,
            'tax_type' => 'percentage',
            'tax_value' => 5,
            'tax_amount' => 4250,
            'total_price' => 89250,
            'quotation_date' => '2026-02-10',
            'note' => 'ইলেকট্রনিক্স পণ্যের কোটেশন',
        ]);

        QuotationItem::create(['quotation_id' => $q1->id, 'product_id' => $products[0]->id, 'quantity' => 5, 'unit_price' => 14500, 'total' => 72500]);
        QuotationItem::create(['quotation_id' => $q1->id, 'product_id' => $products[1]->id, 'quantity' => 10, 'unit_price' => 1200, 'total' => 12000]);
        QuotationItem::create(['quotation_id' => $q1->id, 'product_id' => $products[2]->id, 'quantity' => 5, 'unit_price' => 500, 'total' => 2500]);

        // কোটেশন ২ - রহিম মিয়া
        $q2 = Quotation::create([
            'quotation_no' => 'QUO-000002',
            'customer_id' => $customers[1]->id,
            'customer_name' => $customers[1]->name,
            'subtotal' => 15350,
            'discount' => 500,
            'tax_type' => 'percentage',
            'tax_value' => 0,
            'tax_amount' => 0,
            'total_price' => 14850,
            'quotation_date' => '2026-02-12',
            'note' => 'পোশাক ও মুদি পণ্য',
        ]);

        QuotationItem::create(['quotation_id' => $q2->id, 'product_id' => $products[3]->id, 'quantity' => 10, 'unit_price' => 450, 'total' => 4500]);
        QuotationItem::create(['quotation_id' => $q2->id, 'product_id' => $products[4]->id, 'quantity' => 5, 'unit_price' => 950, 'total' => 4750]);
        QuotationItem::create(['quotation_id' => $q2->id, 'product_id' => $products[5]->id, 'quantity' => 8, 'unit_price' => 550, 'total' => 4400]);
        QuotationItem::create(['quotation_id' => $q2->id, 'product_id' => $products[6]->id, 'quantity' => 2, 'unit_price' => 850, 'total' => 1700]);

        // কোটেশন ৩ - জামাল উদ্দিন
        $q3 = Quotation::create([
            'quotation_no' => 'QUO-000003',
            'customer_id' => $customers[2]->id,
            'customer_name' => $customers[2]->name,
            'subtotal' => 7600,
            'discount' => 0,
            'tax_type' => 'fixed',
            'tax_value' => 500,
            'tax_amount' => 500,
            'total_price' => 8100,
            'quotation_date' => '2026-02-15',
            'note' => 'স্টেশনারি অর্ডার',
        ]);

        QuotationItem::create(['quotation_id' => $q3->id, 'product_id' => $products[8]->id, 'quantity' => 50, 'unit_price' => 70, 'total' => 3500]);
        QuotationItem::create(['quotation_id' => $q3->id, 'product_id' => $products[9]->id, 'quantity' => 20, 'unit_price' => 130, 'total' => 2600]);
        QuotationItem::create(['quotation_id' => $q3->id, 'product_id' => $products[10]->id, 'quantity' => 6, 'unit_price' => 250, 'total' => 1500]);

        // কোটেশন ৪ - আবুল হোসেন
        $q4 = Quotation::create([
            'quotation_no' => 'QUO-000004',
            'customer_id' => $customers[3]->id,
            'customer_name' => $customers[3]->name,
            'subtotal' => 43500,
            'discount' => 1500,
            'tax_type' => 'percentage',
            'tax_value' => 7.5,
            'tax_amount' => 3150,
            'total_price' => 45150,
            'quotation_date' => '2026-02-18',
            'note' => 'বাল্ক অর্ডার - স্মার্টফোন',
        ]);

        QuotationItem::create(['quotation_id' => $q4->id, 'product_id' => $products[0]->id, 'quantity' => 3, 'unit_price' => 14500, 'total' => 43500]);

        // কোটেশন ৫ - মোঃ সালাম
        $q5 = Quotation::create([
            'quotation_no' => 'QUO-000005',
            'customer_id' => $customers[4]->id,
            'customer_name' => $customers[4]->name,
            'subtotal' => 11900,
            'discount' => 400,
            'tax_type' => 'percentage',
            'tax_value' => 5,
            'tax_amount' => 575,
            'total_price' => 12075,
            'quotation_date' => '2026-02-20',
            'note' => 'মুদি পণ্য ও প্রসাধনী',
        ]);

        QuotationItem::create(['quotation_id' => $q5->id, 'product_id' => $products[5]->id, 'quantity' => 10, 'unit_price' => 550, 'total' => 5500]);
        QuotationItem::create(['quotation_id' => $q5->id, 'product_id' => $products[7]->id, 'quantity' => 15, 'unit_price' => 110, 'total' => 1650]);
        QuotationItem::create(['quotation_id' => $q5->id, 'product_id' => $products[10]->id, 'quantity' => 10, 'unit_price' => 250, 'total' => 2500]);
        QuotationItem::create(['quotation_id' => $q5->id, 'product_id' => $products[11]->id, 'quantity' => 5, 'unit_price' => 350, 'total' => 1750]);
        QuotationItem::create(['quotation_id' => $q5->id, 'product_id' => $products[2]->id, 'quantity' => 5, 'unit_price' => 100, 'total' => 500]);

        // কোটেশন ৬ - নাসরিন আক্তার
        $q6 = Quotation::create([
            'quotation_no' => 'QUO-000006',
            'customer_id' => $customers[5]->id,
            'customer_name' => $customers[5]->name,
            'subtotal' => 5200,
            'discount' => 200,
            'tax_type' => 'percentage',
            'tax_value' => 0,
            'tax_amount' => 0,
            'total_price' => 5000,
            'quotation_date' => '2026-02-22',
            'note' => 'প্রসাধনী পণ্যের কোটেশন',
        ]);

        QuotationItem::create(['quotation_id' => $q6->id, 'product_id' => $products[10]->id, 'quantity' => 8, 'unit_price' => 250, 'total' => 2000]);
        QuotationItem::create(['quotation_id' => $q6->id, 'product_id' => $products[11]->id, 'quantity' => 8, 'unit_price' => 350, 'total' => 2800]);
        QuotationItem::create(['quotation_id' => $q6->id, 'product_id' => $products[7]->id, 'quantity' => 4, 'unit_price' => 100, 'total' => 400]);

        // কোটেশন ৭ - ফারুক আহমেদ
        $q7 = Quotation::create([
            'quotation_no' => 'QUO-000007',
            'customer_id' => $customers[6]->id,
            'customer_name' => $customers[6]->name,
            'subtotal' => 29500,
            'discount' => 1000,
            'tax_type' => 'fixed',
            'tax_value' => 1000,
            'tax_amount' => 1000,
            'total_price' => 29500,
            'quotation_date' => '2026-02-25',
            'note' => 'ইলেকট্রনিক্স ও পোশাক',
        ]);

        QuotationItem::create(['quotation_id' => $q7->id, 'product_id' => $products[0]->id, 'quantity' => 1, 'unit_price' => 14500, 'total' => 14500]);
        QuotationItem::create(['quotation_id' => $q7->id, 'product_id' => $products[1]->id, 'quantity' => 5, 'unit_price' => 1200, 'total' => 6000]);
        QuotationItem::create(['quotation_id' => $q7->id, 'product_id' => $products[3]->id, 'quantity' => 10, 'unit_price' => 450, 'total' => 4500]);
        QuotationItem::create(['quotation_id' => $q7->id, 'product_id' => $products[4]->id, 'quantity' => 4, 'unit_price' => 950, 'total' => 3800]);
        QuotationItem::create(['quotation_id' => $q7->id, 'product_id' => $products[2]->id, 'quantity' => 4, 'unit_price' => 175, 'total' => 700]);

        // কোটেশন ৮ - তানভীর হাসান
        $q8 = Quotation::create([
            'quotation_no' => 'QUO-000008',
            'customer_id' => $customers[7]->id,
            'customer_name' => $customers[7]->name,
            'subtotal' => 9350,
            'discount' => 350,
            'tax_type' => 'percentage',
            'tax_value' => 10,
            'tax_amount' => 900,
            'total_price' => 9900,
            'quotation_date' => '2026-02-28',
            'note' => 'মিক্স অর্ডার',
        ]);

        QuotationItem::create(['quotation_id' => $q8->id, 'product_id' => $products[6]->id, 'quantity' => 3, 'unit_price' => 850, 'total' => 2550]);
        QuotationItem::create(['quotation_id' => $q8->id, 'product_id' => $products[8]->id, 'quantity' => 30, 'unit_price' => 70, 'total' => 2100]);
        QuotationItem::create(['quotation_id' => $q8->id, 'product_id' => $products[3]->id, 'quantity' => 8, 'unit_price' => 450, 'total' => 3600]);
        QuotationItem::create(['quotation_id' => $q8->id, 'product_id' => $products[7]->id, 'quantity' => 10, 'unit_price' => 110, 'total' => 1100]);

        // কোটেশন ৯ - সুমাইয়া খাতুন (ওয়াক-ইন, কাস্টমার ছাড়া)
        $q9 = Quotation::create([
            'quotation_no' => 'QUO-000009',
            'customer_id' => null,
            'customer_name' => 'ওয়াক-ইন কাস্টমার',
            'subtotal' => 2150,
            'discount' => 0,
            'tax_type' => 'percentage',
            'tax_value' => 0,
            'tax_amount' => 0,
            'total_price' => 2150,
            'quotation_date' => '2026-03-01',
            'note' => null,
        ]);

        QuotationItem::create(['quotation_id' => $q9->id, 'product_id' => $products[3]->id, 'quantity' => 3, 'unit_price' => 450, 'total' => 1350]);
        QuotationItem::create(['quotation_id' => $q9->id, 'product_id' => $products[9]->id, 'quantity' => 5, 'unit_price' => 130, 'total' => 650]);
        QuotationItem::create(['quotation_id' => $q9->id, 'product_id' => $products[2]->id, 'quantity' => 1, 'unit_price' => 150, 'total' => 150]);

        // কোটেশন ১০ - রফিকুল ইসলাম
        $q10 = Quotation::create([
            'quotation_no' => 'QUO-000010',
            'customer_id' => $customers[9]->id,
            'customer_name' => $customers[9]->name,
            'subtotal' => 63500,
            'discount' => 3000,
            'tax_type' => 'percentage',
            'tax_value' => 5,
            'tax_amount' => 3025,
            'total_price' => 63525,
            'quotation_date' => '2026-03-05',
            'note' => 'বড় বাল্ক অর্ডার - বিভিন্ন পণ্য',
        ]);

        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[0]->id, 'quantity' => 2, 'unit_price' => 14500, 'total' => 29000]);
        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[1]->id, 'quantity' => 8, 'unit_price' => 1200, 'total' => 9600]);
        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[5]->id, 'quantity' => 15, 'unit_price' => 550, 'total' => 8250]);
        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[6]->id, 'quantity' => 10, 'unit_price' => 850, 'total' => 8500]);
        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[8]->id, 'quantity' => 100, 'unit_price' => 70, 'total' => 7000]);
        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[9]->id, 'quantity' => 5, 'unit_price' => 130, 'total' => 650]);
        QuotationItem::create(['quotation_id' => $q10->id, 'product_id' => $products[2]->id, 'quantity' => 5, 'unit_price' => 100, 'total' => 500]);
    }
}
