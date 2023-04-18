<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserAccessToken
 *
 * @property int $id
 * @property int $site_id
 * @property string $access_token
 * @property string $mfa_secret
 * @property string $mfa_recovery_codes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereMfaRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereMfaSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccessToken withoutTrashed()
 * @mixin \Eloquent
 */
class UserAccessToken extends Model
{
    use HasFactory, SoftDeletes;

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
