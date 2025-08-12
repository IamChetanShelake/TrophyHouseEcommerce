<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{

    protected $product_cat_id;
    protected $subcategory_id;
    public function __construct($product_cat_id, $subcategory_id)
    {
        $this->product_cat_id = $product_cat_id;
        $this->subcategory_id = $subcategory_id;
    }

    public function model(array $row)
    {

        // 1. Create Product
        $product = new Product();
        $product->title = trim($row['title']);
        $product->description = trim($row['description'] ?? '') ?: null;
        $product->category_id = $this->product_cat_id;
        $product->sub_category_id = $this->subcategory_id;
        $product->rating = $row['rating'] ?? null;
        $product->image = trim($row['image']);
        $product->is_top_pick = !empty($row['is_top_pick']) ? 1 : 0;
        $product->is_best_seller = !empty($row['is_best_seller']) ? 1 : 0;
        $product->is_new_arrival = !empty($row['is_new_arrival']) ? 1 : 0;
        $product->save();

        // 2. Handle Multiple Images (optional)
        if (!empty($row['images'])) {
            $images = explode(',', $row['images']);
            foreach ($images as $imageName) {
                $imageName = trim($imageName);
                if ($imageName) {
                    $product->images()->create([
                        'image' => $imageName,
                    ]);
                }
            }
        }
        // 3. Handle Product Variants (size, color, price, etc.)
        if (!empty($row['sizes']) && !empty($row['price'])) {
            // dd($row['price']);
            $sizes = array_map('floatval', array_map('trim', explode(',', $row['sizes'])));
            // $sizes = array_map('floatval', explode(',', $row['sizes']));
            $colors = !empty($row['colors']) ? array_map('trim', explode(',', $row['colors'])) : [];
            // $prices = array_map('trim', explode(',', $row['price']));
            $prices = array_map('floatval', array_map('trim', explode(',', $row['price'])));
            $discounts = !empty($row['discounts']) ? array_map('trim', explode(',', $row['discounts'])) : [];

            foreach ($sizes as $index => $size) {
                $price = isset($prices[$index]) ? floatval($prices[$index]) : 0;
                $discount = isset($discounts[$index]) ? floatval($discounts[$index]) : 0;
                $discounted = $price - ($price * $discount / 100);

                if ($size !== '') {
                    $product->variants()->create([
                        'size' => $size,
                        'color' => json_encode($colors),
                        'price' => $price,
                        'discount_percentage' => $discount,
                        'discounted_price' => $discounted,
                    ]);
                }
            }
        }

        return $product;
    }
}
