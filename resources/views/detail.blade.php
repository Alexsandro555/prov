@extends('layouts.master')

@section('title', $product->meta_title?$product->meta_title:'Купить '.$product->title.' по доступным ценам')
@section('meta-description', $product->meta_description?$product->meta_description:'Купить '.$product->title.' '.str_limit(strip_tags($product->description), $limit = 160, $end="..."))
@section('meta-keywords', $product->meta_keywords?$product->meta_keywords:config('info.keywords'))


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
  <div id="detail" class="content-wrapper">
    <v-container class="content hidden-md-and-down">
      <v-row class="no-gutters">
        <v-col cols="12" lg="9" offset-lg="3">
          <v-card class="detail-info" elevation="0">
            <v-list-item>
              <v-list-item-content>
                <h1>{{$product->title}}</h1>
                <span class="subheader">{{$product->productCategory->title}}</span>
              </v-list-item-content>
            </v-list-item>
            <v-container class="px-3 ma-0 no-gutters">
              <v-row>
                <v-col cols="12" lg="8" class="no-gutters pa-0 ma-0">
                  <detail-image style="max-width: 390px;" class="text-center"
                                :stock="{{$product->special?$product->special:'false'}}"
                                :url="'/files/product-image/{{$product->id}}'" :id="{{$product->id}}"/>
                </v-col>
                <v-col cols="12" lg="4" class="no-gutters pa-0 ma-0">
                  <div class="detail-info__price">
                    <v-container no-gutter class="ma-0 pa-0">
                      <v-row class="justify-start align-start">
                        <v-col cols="12">
                          @if($product->need_order)
                            <callback-price :product="{{$product}}"/>
                          @endif
                        </v-col>
                      </v-row>
                    </v-container>
                  </div>
                </v-col>
                <v-col cols="12">
                  <div class="detail-info__description">
                    <v-container no-gutter class="ma-0 pa-3">
                      <v-row>
                        <v-col cols="12">
                          <h2 class="subtitle">Описание</h2><br>
                          {!! $product->description !!}
                        </v-col>
                        <v-col cols="12">
                          <div class="characteristics__cell">
                            <h2 class="subtitle">Технические характеристики</h2>
                            <div class="table">
                              <table class="table__box">
                                <tbody>
                                @foreach($product->attributes as $attribute)
                                  <tr class="table__tr">
                                    <th class="table__th">{{$attribute->title}}:</th>
                                    <td class="table__td">
                                      @if($attribute->attribute_type_id == 3)
                                        {{$attribute->pivot->integer_value}}
                                      @endif
                                      @if($attribute->attribute_type_id == 2)
                                        {{$attribute->pivot->string_value}}
                                      @endif
                                      @if($attribute->attribute_type_id == 4)
                                       {{$attribute->pivot->double_value}}
                                      @endif
                                      @if($attribute->attribute_type_id == 5)
                                       {{$attribute->pivot->date_value}}
                                      @endif
                                      @if($attribute->attribute_type_id == 7)
                                        {{$attribute->pivot->decimal_value}}
                                      @endif
                                      @if($attribute->attribute_type_id == 8)
                                        {{Modules\Product\Entities\AttributeListValues::find($attribute->pivot->list_value)->title}}
                                      @endif
                                      {{$attribute->attributeUnit?$attribute->attributeUnit->title:""}}
                                    </td>
                                  </tr>
                                @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </v-col>
                      </v-row>
                    </v-container>
                  </div>
                </v-col>
              </v-row>
            </v-container>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <div class="hidden-lg-and-up">
      <v-container no-gutter class="ma-0 pa-3">
        <v-row>
          <v-col cols="12">
            <h1>{{$product->title}}</h1>
            <span class="subtitle">{{$product->productCategory->title}}</span>
          </v-col>
          <v-col cols="12">
            <detail-image :stock="{{$product->special?$product->special:'false'}}" :url="'/files/product-image/{{$product->id}}'" :id="{{$product->id}}"/>
          </v-col>
          <v-col cols="12">
            @if($product->need_order)
              <callback-price :product="{{$product}}"/>
            @endif
          </v-col>
          <v-col cols="12">
            <v-container no-gutter class="ma-0 pa-3">
              <v-row>
                <v-col cols="12">
                  <h2 class="subtitle">Описание</h2><br>
                  {!! $product->description !!}
                </v-col>
              </v-row>
            </v-container>
          </v-col>
        </v-row>
      </v-container>

    </div>
  </div>
@endsection