@extends('layouts.semantic-ui.app')

@section('content-header')
    <h1>
        &nbsp;
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('homepage') }}">Home</a></li>
        <li><a href="{{ route('homepage') }}">Panduan</a></li>
    </ol>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Jadwal PME</h3>
        </div>
        <div class="box-body">
		<br>
		<table class="ui striped table data-tables">
			<thead>
			<tr>
				<th width="5%">
					{{ __('#') }}
				</th>
				<th>
					{{ __('Kegiatan') }}
				</th>
				<th>
					{{ __('Siklus 1') }}
				</th>
				<th>
					{{ __('Siklus 2') }}
				</th>
			</tr>
			</thead>
			<tbody>
			<?php $no = 1; ?>
			@foreach($schedule as $schedule)
				<tr>
					<td class="ui center aligned">{{ $no++ }}</td>
					<td class="ui">{{ $schedule->kegiatan }}</td>
					<td class="ui">{{ $schedule->siklus_1 }}</td>
					<td class="ui">{{ $schedule->siklus_2 }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
        </div>
    </div>
@endsection
