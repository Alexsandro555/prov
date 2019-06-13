@extends('layouts.master')

@section('title', $article->title)

@section('content')
  <div class="content-wrapper  text-xs-left">
   <!--<v-content>
      <v-layout row wrap>-->
        <div class="content text-xs-left">
          <v-card class="py-5 ma-2 article-card" width="95%">
            <p class="article__header text-md-left mx-5">
              {{$article->title}}
            </p>
            <div class="article__content">
              {!! $article->content !!}
            </div>
          </v-card>
        </div>
      <!--</v-layout>
    </v-content>-->
  </div>
@stop