<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $name
 * @property int $price
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];
}
