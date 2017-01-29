<?php

namespace App;
use DB;


use Illuminate\Database\Eloquent\Model;


class CategoryTop extends Model
{
	protected $table = 'categoryTop';
	protected $fillable = ['category_id', 'product_id'];
	public $timestamps = false;
}