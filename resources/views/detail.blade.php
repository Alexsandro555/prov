@extends('layouts.master')

@section('breadcrumbs')
  <div class="abs-breadcrumbs">
    {{ Breadcrumbs::render() }}
  </div>
@endsection

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="content">
      <v-flex xs11 offset-xs1 md9 offset-md3>
        <v-card class="detail-info" style="min-height: 700px; font-size: 1.2em;">
          <v-layout row wrap>
            <v-flex pa-3 xs6>
              <detail-image :stock="{{$product->special?$product->special:'false'}}" :url="'/files/product-image/{{$product->id}}'" :id="{{$product->id}}"/>
              <!--<detail-image :url="'/files/product-image/{{$product->id}}'"/>-->
            </v-flex>
            <v-flex class="detail__title text-xs-left" px-2 xs6 md6>
              <h1>{{$product->title}}</h1>
              <calculate-price :product="{{$product}}"/>
            </v-flex>
            <v-flex class="detail__tabs" pa-3 xs12>
              <br>
              <v-tabs class="detail-characteristics" color="green darken-4" dark slider-color="yellow">
                @foreach($groups as $group)
                  <v-tab key="#tabs-group-{{$group->id}}">{{$group->title}}</v-tab>
                @endforeach
                <v-tab key="description">Описание</v-tab>
                @foreach($groups as $group)
                  <v-tab-item class="tabs-content" key="tabs-group-{{$group->id}}">
                    <!--<v-card height="300px">
                      <v-card-text class="text-xs-left">-->
                        @foreach($product->attributes->filter(function($attribute, $key) use (&$group){
                            return $attribute->attribute_group_id == $group->id;
                          })->sortBy('sort')->chunk(10) as $chunkAttributes)
                          <div class="tabs__characteristics">
                            <dl class="tabs__characteristics-attributes">
                              @foreach($chunkAttributes as $attribute)
                                @if($attribute->attribute_type_id == 3)
                                  <dt>{{$attribute->title}}</dt><dd class="tabs__characteristics--value">{{$attribute->pivot->integer_value}} {{$attribute->attribute_unit?$attribute->attribute_unit->title:""}}</dd>
                                @endif
                                @if($attribute->attribute_type_id == 4)
                                  <dt>{{$attribute->title}}</dt><dd class="tabs__characteristics--value">{{$attribute->pivot->double_value}} {{$attribute->attribute_unit?$attribute->attribute_unit->title:""}}</dd>
                                @endif
                                @if($attribute->attribute_type_id == 5)
                                  <dt>{{$attribute->title}}</dt><dd class="tabs__characteristics--value">{{$attribute->pivot->date_value}} {{$attribute->attribute_unit?$attribute->attribute_unit->title:""}}</dd>
                                @endif
                                @if($attribute->attribute_type_id == 7)
                                  <dt>{{$attribute->title}}</dt><dd class="tabs__characteristics--value">{{$attribute->pivot->decimal_value}} {{$attribute->attribute_unit?$attribute->attribute_unit->title:""}}</dd>
                                @endif
                                @if($attribute->attribute_type_id == 8)
                                  <dt>{{$attribute->title}}</dt><dd class="tabs__characteristics--value">{{Modules\Product\Entities\AttributeListValues::find($attribute->pivot->list_value)->title}} {{$attribute->attribute_unit?$attribute->attribute_unit->title:""}}</dd>
                                @endif
                              @endforeach
                            </dl>
                          </div>
                        @endforeach
                      <!--</v-card-text>
                    </v-card>-->
                  </v-tab-item>
                @endforeach
                <v-tab-item key="description">
                  <div class="text-xs-left" style="color: black; padding: 10px;">
                     {!! $product->description !!}
                  </div>
                </v-tab-item>
              </v-tabs>
            </v-flex>
          </v-layout>
        </v-card>
      </v-flex>
    </div>
  </div>
@endsection