@extends('layouts.main_desktop')


@section('page-title')
HTTP 400 - Problema com a requisição
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
            <li><button class="header-navigation__btn">Relatórios</button></li>
        </a>
    </ul>
@endsection

@section('app-shell-title')
Erro
@endsection

@section('app-shell-subtitle')
HTTP 400
@endsection

@section('action-buttons')
<a href="{{ route('products.index')}}">
    <button class="action-button action-button--secondary">Voltar</button>
</a>
@endsection

@section('app-shell-workspace')
<div class="status-error__msg-container">
    <h1>Parece que encontramos um erro com sua requisição.</h1>
    <p>Não se preocupe, pois nosso suporte técnico já foi acionado. Para acompanhar o caso, basta escrever para suporte@fine.com se identificando.</p>
</div>
@endsection

<style>
    .status-error__msg-container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

    .status-error__msg-container h1 {
            font-size: 2rem;
            font-weight: 600;
        }

    .status-error__msg-container p{
            font-size: 1.5rem;
            font-weight: 400;
        }
</style>
