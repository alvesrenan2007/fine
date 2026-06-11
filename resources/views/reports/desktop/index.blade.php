@extends('layouts.main_desktop')

@section('page-title')
Relatórios
@endsection

@section('header')
    <ul class="header-navigation__list">
        <a href="{{ route('products.index')}}">
            <li><button class="header-navigation__btn">Produtos</button></li>
        </a>
        <a href="{{ route('companies.index')}}">
            <li><button class="header-navigation__btn">Empresas</button></li>
        </a>
        <a href="{{ route('marketplaces.index')}}">
            <li><button class="header-navigation__btn">Lojas</button></li>
        </a>
        <a href="{{ route('reports.index')}}">
            <li><button class="header-navigation__btn header-navigation__btn--active">Relatórios</button></li>
        </a>
    </ul>
@endsection

@section('app-shell-title')
Relatórios
@endsection

@section('app-shell-subtitle')
Gere seus relatórios e realize suas simulações de preços
@endsection

@section('action-buttons')
    <button class="action-button action-button--secondary">Cadastrar Relatório</button>
@endsection

@section('app-shell-workspace')
<form action="{{ route('reports.byProduct') }}" method="GET">
    @csrf
    @method('GET')

    <div class="card__item">
        <span class="card__title">Simulação por Produto de </span>
        <select name="query-product" class="form__text-input">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
        <span class="card__title"> na empresa </span>
        <select name="query-company" class="form__text-input">
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
        <span class="card__title"> na loja </span>
        <select name="query-marketplace" class="form__text-input">
                <option value="0">Todas as lojas</option>
        </select>
        <button type="submit" class="action-button action-button--primary">Simular</button>
    </div>
</form>
@endsection

@section('floating-buttons')
@endsection

<style>
    .card__item{
        display: flex;
        flex-direction: row;
        gap: 3rem !important;
        height: 4rem;
    }

    .card__title{
        font-size: 2.5rem;
        cursor: pointer;
    }

    /* overriding style from fine.css */
    .form__text-input{
        width: 20rem !important;
    }
</style>