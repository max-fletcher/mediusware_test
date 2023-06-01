<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
   protected $guarded = [];

   public function product(){
      return $this->belongsTo(Product::class);
   }

   public function product_variant(){
      return $this->belongsTo(ProductVariant::class, 'product_id', 'product_id');
   }

   public function product_variant_one_belongs_to(){
      return $this->belongsTo(ProductVariant::class,'product_variant_one', 'id');
   }

   public function product_variant_two_belongs_to(){
      return $this->belongsTo(ProductVariant::class, 'product_variant_two', 'id');
   }

   public function product_variant_three_belongs_to(){
      return $this->belongsTo(ProductVariant::class, 'product_variant_three', 'id');
   }
}

