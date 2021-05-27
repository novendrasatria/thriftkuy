<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use softDeletes;
    protected $fillable = [
        'name', 'users_id', 'categories_id', 'price', 'description', 'slug', 'status'
    ];
    protected $hidden = [

    ];
    public function galleries(){ //relasi ke galeri produk
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    public function user(){ //relasi ke user
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function category(){ //relasi ke kategori
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

}
