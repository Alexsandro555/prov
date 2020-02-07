@extends('layouts.master')

@section('title', 'Статьи. '.config('info.site_name'))
@section('meta-description', 'Статьи. Купить '.config('info.site_name'))
@section('meta-keywords', config('info.keywords'))

@section('content')
  <v-row>
    <v-col cols="12" class="content-wrapper articles">
      <div id="articles__content" class="content">
        <v-content>
          <v-row no-gutter>
            <v-col cols="12" class="text-center">
              @foreach($articles as $article)
                <v-card class="article--card" elevation="0">
                  <v-container>
                    <v-row no-gutter>
                      <v-col cols="10" md="8" class="text-left">
                      <div class="articles__content">
                        <a href="/article/{{$article->url_key}}"><h2>{{$article->title}}</h2></a><br>
                        <p>
                          {{str_limit(strip_tags($article->content), $limit = 402, $end="...")}}
                        </p>
                      </div>
                      <a class="article--button" href="/article/{{$article->url_key}}">Подробнее</a>
                    </v-col>
                      <v-col class="hidden-md-and-down">
                      @if($article->files->count()>0)
                        @foreach($article->files as $fileRecord)
                          @foreach($fileRecord->config as $files)
                            @foreach($files as $key => $file)
                              @if($key == 'medium')
                                <img src="/storage/{{$file['filename']}}"/>
                              @endif
                            @endforeach
                          @endforeach
                          @break
                        @endforeach
                      @else
                        <img src="{{asset('images/no-image-medium.png')}}"/>
                      @endif
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
              <p><br></p>
            @endforeach
          </v-col>
        </v-row>
        </v-content>
      </div>
    </v-col>
  </v-row>
@endsection

