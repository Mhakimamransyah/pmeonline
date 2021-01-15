@extends('instalasi.statistic.index')

@section('statistic-content')

    @includeIf('instalasi.statistic.components.'.$package->name)

@endsection