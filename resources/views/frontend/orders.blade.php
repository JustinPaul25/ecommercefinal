@extends('vue-layouts.app')

@section('content')
    <customer-orders :datas="{{ json_encode($data) }}"></customer-orders>
@endsection