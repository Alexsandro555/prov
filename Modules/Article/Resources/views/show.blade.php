@extends('layouts.master')

@section('title', $article->meta_title?$article->meta_title:$article->title)
@section('meta-description',  $article->meta_description?$article->meta_description:$article->title)
@section('meta-keywords', $article->meta_keywords?$article->meta_keywords:config('info.keywords'))

@section('content')
  <div class="content-wrapper text-xs-left">
    <div class="content text-xs-left">
      <v-card class="py-5 ma-2 article-card" width="95%">
        <p class="article__header text-md-left mx-5 display-1">
          {{$article->title}}
        </p>
        <div class="article__content">
          {!! $article->content !!}
        </div>
      </v-card>
    </div>
  </div>
@stop

