@extends('layouts.master')

@section('title', 'статьи')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <section class="content-wrapper text-xs-center">
    <div class="content">
      <v-container style="margin-left: 400px;">
        <v-row class="justify-center align-center">
          <v-col cols="12" style="color: yellow;">
            <h1>Страница не найдена</h1>
            К сожалению, такой страницы не существует.
          </v-col>
        </v-row>
      </v-container>
    </div>
  </section>
@endsection