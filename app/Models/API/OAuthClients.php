<?php

namespace CodeDelivery\Models\API;

use Illuminate\Database\Eloquent\Model;

class OAuthClients extends Model
{
    protected $table = 'oauth_clients';

    protected $fillable = [
        'id',
        'secret',
        'name',
    ];
}
