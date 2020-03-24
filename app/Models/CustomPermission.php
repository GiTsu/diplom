<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CustomPermission
 *
 * @property int $id
 * @property string $name name доступа
 * @property string $slug
 * @property string|null $description описание доступа
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomPermission newModelQuery()
 */
class CustomPermission extends Model
{
    public function getSlugAttribute($value){
      return json_decode($value);
    }
}
