@extends('layouts.main_desktop')

@section('page-title')
Produtos
@endsection

@section('header')
    <ul class="header-navigation__list">
        <a href="{{ route('products.index')}}">
            <li><button class="header-navigation__btn header-navigation__btn--active">Produtos</button></li>
        </a>
        <a href="{{ route('companies.index')}}">
            <li><button class="header-navigation__btn">Empresas</button></li>
        </a>
        <a href="{{ route('marketplaces.index')}}">
            <li><button class="header-navigation__btn">Lojas</button></li>
        </a>
        <a href="{{ route('reports.index')}}">
            <li><button class="header-navigation__btn">Relatórios</button></li>
        </a>
    </ul>
@endsection

@section('app-shell-title')
Produtos
@endsection

@section('app-shell-subtitle')
Gerencie os produtos de seu inventário
@endsection

@section('action-buttons')
<a href="{{ route('products.create')}}">
    <button class="action-button action-button--secondary">Cadastrar Produto</button>
</a>
@endsection

@section('app-shell-workspace')
    @if($products->count() > 0)
        <ul class="app-shell__list">
        @foreach($products as $product)
            <a href="{{ route('products.edit', $product->id)}}"><li class="app-shell__list-item">
                <span>{{ $product->name }}</span>
            </li></a>
        @endforeach
        </ul>
    @else
        <span>Nenhum produto cadastrado.</span>
    @endif
@endsection

@section('floating-buttons')
@endsection
