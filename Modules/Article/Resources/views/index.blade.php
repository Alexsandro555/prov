@extends('layouts.master')

@section('title', 'статьи')

@section('content')
    <div class="content-wrapper articles">
        <v-content>
            <v-layout row wrap>
                <div class="content text-xs-center">
                    @foreach($articles as $article)
                        <v-card class="article--card" min-width="1200">
                            <v-container>
                                <v-layout row wrap>
                                    <v-flex xs8 text-xs-left>
                                        <div class="articles__content">
                                            <a href="/article/{{$article->url_key}}"><h2>{{$article->title}}</h2></a><br>
                                            <p>
                                                {{str_limit(strip_tags($article->content), $limit = 402, $end="...")}}
                                            </p>
                                        </div>
                                        <a class="article--button" href="/article/{{$article->url_key}}">Подробнее</a>
                                    </v-flex>
                                    <v-flex>
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
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>
                        <p>
                            <br>
                        </p>
                    @endforeach
                </div>
            </v-layout>
        </v-content>
    </div>
@endsection

