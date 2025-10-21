@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="page-content">
    <h1>Добро пожаловать</h1>
    <p>Это главная страницасайта. Здесь вы можете найти основную информацию</p>
    <p></p>
    <a href="{{ route('about') }}" class="btn">Узнать больше</a>
</div>
@endsection