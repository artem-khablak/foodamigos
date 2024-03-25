<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    /**
     * Define a many-to-many relationship between the User model and the Order model.
     * This relationship includes the 'quantity' pivot column.
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

}
