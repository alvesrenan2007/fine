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
<div class="form-card">
    <div class="form-card__header">
        <h2 class="form-card__title">Configuração da Simulação</h2>
        <p class="form-card__subtitle">Selecione os parâmetros abaixo para gerar o relatório de preços.</p>
    </div>

    <form action="{{ route('reports.byProduct') }}" method="GET" class="form-card__body">
        @csrf
        {{-- Note: @method('GET') is redundant on a GET form, but kept safe if needed --}}

        <div class="form-grid">
            <div class="form-group">
                <label for="query-product" class="form-group__label">Produto</label>
                <div class="form-group__input-wrapper">
                    <select name="query-product" id="query-product" class="form__select-input">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="query-company" class="form-group__label">Empresa</label>
                <div class="form-group__input-wrapper">
                    <select name="query-company" id="query-company" class="form__select-input">
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="query-marketplace" class="form-group__label">Loja / Marketplace</label>
                <div class="form-group__input-wrapper">
                    <select name="query-marketplace" id="query-marketplace" class="form__select-input">
                        <option value="0">Todas as lojas</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card__footer">
            <button type="submit" class="action-button action-button--primary form-card__submit-btn">
                <span>Simular Preços</span>
            </button>
        </div>
    </form>
</div>
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
