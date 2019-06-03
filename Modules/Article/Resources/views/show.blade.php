@extends('layouts.master')

@section('title', $article->title)

@section('content')
  <div class="content-wrapper  text-xs-left">
    <v-content class="content">
      <v-layout row wrap>
        <v-flex xs12 class="text-xs-left">
          <v-card>
            <p class="article__header text-md-left">
              {{$article->title}}
            </p>
            <div class="article__content">
              {!! $article->content !!}
            </div>
          </v-card>
        </v-flex>
      </v-layout>
    </v-content>
  </div>
@stop