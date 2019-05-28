@extends('layouts.master')

@section('content')
  <div class="content">
    <div class="wrapper content-wrapper">
      <v-layout row wrap>
        <filter-products :products="{{$products}}" :attributes="{{$attributes}}"/>
      </v-layout>
    </div>
  </div>
@endsection