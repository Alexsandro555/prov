@extends('layouts.master')

@section('title', $model->meta_title?$model->meta_title:'Купить '.$model->title.' по доступным ценам')
@section('meta-description', $model->meta_description?$model->meta_description:'Купить '.$model->title.' '.str_limit(strip_tags($model->description), $limit = 160, $end="..."))
@section('meta-keywords', $model->meta_keywords?$model->meta_keywords:config('info.keywords'))

@section('breadcrumbs')
  <div class="abs-breadcrumbs">
    {{ Breadcrumbs::render() }}
  </div>
@endsection

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu/>
    </div>
  </div>
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="content" style="position: relative">
      <v-layout row wrap>
        <v-flex xs11 offset-xs1 md9 offset-md3 text-xs-left>
          <v-layout column wrap>
            <p class="content__header text-md-left">
              {{$model->title}}
            </p>
            <p class="content-discription">
              {!! $model->description !!}
            </p>
          </v-layout>
          <v-flex xs12 class="text-xs-left">
            <v-container grid-list-md>
              <v-layout align-center justify-left row wrap>
                @if($model->lineProducts)
                  @foreach($model->lineProducts as $lineProduct)
                    <div class="special-product-wrapper">
                      <div class="special-product text-xs-center" align="center">
                        <div class="special-product__header text-xs-center">
                          <a href="/catalog/{{$model->product_category->url_key}}/{{$model->url_key}}/{{$lineProduct->url_key}}">{{str_limit($lineProduct->title, $limit = 27, $end="...")}}</a>
                        </div>
                        <div class="special-product__img">
                          <v-layout fill-height text-xs-center>
                            @if($lineProduct->files->count() > 0)
                              @foreach($lineProduct->files->random()->config as $filesItem)
                                @foreach($filesItem as $key => $fileItem)
                                  @if($key == 'medium')
                                    <a href="/catalog/{{$model->product_category->url_key}}/{{$model->url_key}}/{{$lineProduct->url_key}}" style="display: inline-block; text-align: center;  margin:0 auto;">
                                      <img src="/storage/{{$fileItem['filename']}}" style="margin: 0px auto;"/>
                                    </a>
                                  @endif
                                @endforeach
                              @endforeach
                            @else
                              <img src="{{asset('images/no-image-medium.png')}}" style="margin: 0px auto;"/>
                            @endif
                          </v-layout>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
                @if($model->typeProducts)
                  @foreach($model->typeProducts as $typeProduct)
                    <div class="special-product-wrapper">
                      <div class="special-product text-xs-center" align="center">
                        <div class="special-product__header text-xs-center">
                          <a href="/catalog/{{$model->url_key}}/{{$typeProduct->url_key}}">{{str_limit($typeProduct->title, $limit = 27, $end="...")}}</a>
                        </div>
                        <div class="special-product__img">
                          <v-layout fill-height text-xs-center>
                            @if($typeProduct->files->count() > 0)
                              @foreach($typeProduct->files->random()->config as $filesItem)
                                @foreach($filesItem as $key => $fileItem)
                                  @if($key == 'medium')
                                    <a href="/catalog/{{$model->url_key}}/{{$typeProduct->url_key}}" style="display: inline-block; text-align: center;  margin:0 auto;">
                                      <img src="/storage/{{$fileItem['filename']}}" style="margin: 0px auto;"/>
                                    </a>
                                  @endif
                                @endforeach
                              @endforeach
                            @else
                              <img src="{{asset('images/no-image-medium.png')}}" style="margin: 0px auto;"/>
                            @endif
                          </v-layout>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </v-layout>
            </v-container>
          </v-flex>
        </v-flex>
      </v-layout>
    </div>
  </div>
  <div class="best-sale">
    <div class="wrapper">
    </div>
  </div>
@endsection