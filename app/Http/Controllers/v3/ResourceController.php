<?php

namespace App\Http\Controllers\v3;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    public function makeIndex(Builder $query, Request $request)
    {
        if ($request->has('filter')) {
            foreach ($request->get('filter') as $key => $value) {
                $query = $query->where($key, '=', $value);
            }
        }
        if ($request->has('with')) {
            $query = $query->with($request->get('with'));
        }
        $result = $query->get();
        if ($request->has('first')) {
            $result = $result->first();
        }
        if ($request->has('last')) {
            $result = $result->last();
        }
        return response($result, 200);
    }
}
