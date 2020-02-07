@extends('layouts.master')

@section('title', $article->meta_title?$article->meta_title:$article->title)
@section('meta-description',  $article->meta_description?$article->meta_description:$article->title)
@section('meta-keywords', $article->meta_keywords?$article->meta_keywords:config('info.keywords'))

@section('content')
  <div class="content-wrapper">
    <div class="content text-left">
        <v-row no-gutters class="justify-center align-center">
          <v-col cols="12">
            <v-card class="article-card" width="100%" style="margin-top: 20px;" elevation="0">
              <p class="article__header text-md-left mx-5 display-1">
                {{$article->title}}
              </p>
              <div class="article__content">
                {!! $article->content !!}
              </div>
            </v-card>
          </v-col>
        </v-row>
    </div>
  </div>
@stop

