<?php

namespace App\Imports;

use App\Models\productImage;
use App\Models\OccasionProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class occProductImport implements ToModel, WithHeadingRow
{
    protected $occasion_id;
    protected $product_cat_id;
    protected $subcategory_id;
    public function __construct($occasion_id, $product_cat_id, $subcategory_id)
    {
        $this->occasion_id = $occasion_id;
        $this->product_cat_id = $product_cat_id;
        $this->subcategory_id = $subcategory_id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // 1. Create Product
        $occproduct = new OccasionProduct();
        $occproduct->title = trim($row['title']);
        $occproduct->description = trim($row['description'] ?? '') ?: null;
        $occproduct->category_id = $this->product_cat_id;
        $occproduct->sub_category_id = $this->subcategory_id;
        $occproduct->occasion_id = $this->occasion_id;
        $occproduct->rating = $row['rating'] ?? null;
        $occproduct->image = trim($row['image']);
        $occproduct->save();
        
    
        
        // 2. Handle Multiple Images (optional)
         // 2. Handle Multiple Images (optional)
        if (!empty($row['images'])) {
            $images = explode(',', $row['images']);
            foreach ($images as $imageName) {
                $imageName = trim($imageName);
                if ($imageName) {
                    $occproduct->images()->create([
                        'image' => $imageName,
                    ]);
                }
            }
        }
        // if (!empty($row['images'])) {
        //     $images = explode(',', $row['images']);
        //     foreach ($images as $imageName) {
        //         $imageName = trim($imageName);
        //         if ($imageName) {
                    
        //      $occproduct->images()->createOrUpdate([
        //                 'image' => $imageName,
        //                 'occasion_product_id' => $occproduct->id,
        //             ]);
        //         }
        //     }
        // }
      
        // 3. Handle Product Variants (size, color, price, etc.)
        if (!empty($row['sizes']) && !empty($row['price'])) {
      
            $sizes = array_map('floatval', array_map('trim', explode(',', $row['sizes'])));
            $colors = !empty($row['colors']) ? array_map('trim', explode(',', $row['colors'])) : [];
            $prices = array_map('floatval', array_map('trim', explode(',', $row['price'])));
            $discounts = !empty($row['discounts']) ? array_map('trim', explode(',', $row['discounts'])) : [];

            foreach ($sizes as $index => $size) {
                $price = isset($prices[$index]) ? floatval($prices[$index]) : 0;
                $discount = isset($discounts[$index]) ? floatval($discounts[$index]) : 0;
                $discounted = $price - ($price * $discount / 100);

                if ($size !== '') {
                    $occproduct->variants()->create([
                        'size' => $size,
                        'color' => json_encode($colors),
                        'price' => $price,
                        'discount_percentage' => $discount,
                        'discounted_price' => $discounted,
                    ]);
                }
            }
        }

        return $occproduct;
    }
}