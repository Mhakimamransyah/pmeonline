<?php

namespace App\Http\Controllers\v3;

use App\v3\Package;
use Illuminate\Http\Request;

class PackageController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->makeIndex(Package::query(), $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\v3\Package  $v3Package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $v3Package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\v3\Package  $v3Package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $v3Package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\v3\Package  $v3Package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $v3Package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\v3\Package  $v3Package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $v3Package)
    {
        //
    }
}
