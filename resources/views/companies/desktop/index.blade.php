@extends('layouts.main_desktop')

@section('page-title')
Empresas
@endsection

@section('header')
    <ul class="header-navigation__list">
        <a href="{{ route('products.index')}}">
            <li><button class="header-navigation__btn">Produtos</button></li>
        </a>
        <a href="{{ route('companies.index')}}">
            <li><button class="header-navigation__btn header-navigation__btn--active">Empresas</button></li>
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
Empresas
@endsection

@section('app-shell-subtitle')
Gerencie suas empresas
@endsection

@section('action-buttons')
    <button class="action-button action-button--secondary">Cadastrar Empresa</button>
@endsection

@section('app-shell-workspace')
     @if($companies->count() > 0)
        <ul class="app-shell__list">
        @foreach($companies as $company)
            <a href="#"><li class="app-shell__list-item">
                <span>{{ $company->name }}</span>
            </li></a>
        @endforeach
        </ul>
    @else
        <span>Nenhuma empresa cadastrada.</span>
    @endif
@endsection

@section('floating-buttons')
@endsection
