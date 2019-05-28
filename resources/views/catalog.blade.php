@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="true"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content">
    <div class="wrapper content__product-margin">
      <div class="breadcrumbs">
        <div class="wrapper">
          <v-flex xs12 text-xs-left>
            {{ Breadcrumbs::render() }}
          </v-flex>
        </div>
      </div>
      <v-flex xs12 text-xs-left class="top-20 bottom-20">
        <p class="headsite">
          <span>{{$model->title}}</span><br>
        </p>
        <v-layout row wrap>
          @if($model->lineProducts)
            @foreach($model->lineProducts as $lineProduct)
              <div class="product-wrapper">
                <div class="product">
                  <div class="product-image-wrapper">
                    <div class="product-image">
                    </div>
                  </div>
                  <div class="product__title">
                  <a class="line-product-elements" href="/catalog/{{$model->product_category->url_key}}/{{$model->url_key}}/{{$lineProduct->url_key}}">{{str_limit($lineProduct->title, $limit = 27, $end="...")}}</a>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
            @if($model->typeProducts)
              @foreach($model->typeProducts as $typeProduct)
                <div class="product-wrapper">
                  <div class="product">
                    <div class="product-image-wrapper">
                      <div class="product-image">
                      </div>
                    </div>
                    <div class="product__title">
                      <a class="line-product-elements" href="/catalog/{{$model->url_key}}/{{$typeProduct->url_key}}">{{str_limit($typeProduct->title, $limit = 27, $end="...")}}</a>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
        </v-layout>
      </v-flex>
    </div>
  </div>
  <div class="best-sale">
    <div class="wrapper">
    </div>
  </div>
@endsection