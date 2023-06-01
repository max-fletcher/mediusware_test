<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
   protected $guarded = [];

   public function product(){
      return $this->belongsTo(Product::class);
   }

   public function product_variant_prices(){
      return $this->hasMany(ProductVariantPrice::class, 'product_id', 'product_id');
   }

   // public function product_variant_one(){
   //    return $this->hasMany(ProductVariantPrice::class, 'product_variant_one');
   // }

   // public function product_variant_two(){
   //    return $this->hasMany(ProductVariantPrice::class, 'product_variant_two');
   // }

   // public function product_variant_three(){
   //    return $this->hasMany(ProductVariantPrice::class, 'product_variant_three');
   // }
}
