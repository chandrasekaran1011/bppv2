<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $dates=['created_at'];

    public function getLink(){
        return Search::get_domain($this->links);
    }

    private static function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
}
