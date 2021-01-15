@extends('instalasi.statistic.index')

@section('statistic-content')

    @includeIf('instalasi.rekap-isian.components.'.$package->name)

@endsection