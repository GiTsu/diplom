<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\Models\Permission
 *
 * @property int                    $id
 * @property int|null               $inherit_id
 * @property string                 $name
 * @property array                  $slug
 * @property string|null            $description
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property-read Collection|Role[] $roles
 * @property-read Collection|User[] $users
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission query()
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereDescription($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereInheritId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereSlug($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null            $deleted_at
 * @method static Builder|Permission whereDeletedAt($value)
 */
class Permission extends \Kodeine\Acl\Models\Eloquent\Permission
{
    protected $guarded = ['slug'];
    protected $casts = [
        'slug' => 'array',
    ];
    protected $attributes = [
        'slug' => '',
    ];
}
