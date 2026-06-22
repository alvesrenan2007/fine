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
    <div class="table-container">
        <div class="table-container__header">
            <h2 class="table-container__title">Produtos Cadastrados</h2>
            <span class="table-container__count">{{ $companies->count() }} {{ $companies->count() === 1 ? 'produto encontrado' : 'produtos encontrados' }}</span>
        </div>

        @if($companies->count() > 0)
            <table class="index-table">
                <thead>
                    <tr>
                        <th>Nome da Empresa</th>
                        <th class="text-right">Taxa de Imposto</th>
                        <th class="text-right">Margem de Lucro</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td>
                                <span class="product-name">{{ $company->name }}</span>
                            </td>
                            <td class="text-right font-mono">
                                <span class="text-right font-mono">{{ number_format($company->tax_fee * 100, 2, ',', '.') . ' %' ?? '10.00 %' }}</span>
                            </td>
                            <td class="text-right font-mono">
                                <span class="text-right font-mono">{{ number_format($company->profit_margin * 100, 2, ',', '.') . ' %' ?? '10.00 %' }}</span>
                            </td>
                            <td class="text-right">
                                    Editar
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state__icon">📦</div>
                <h3 class="empty-state__title">Nenhuma empresa cadastrada</h3>
                <p class="empty-state__subtitle">Comece adicionando sua primeira empresa no sistema.</p>
            </div>
        @endif
    </div>
@endsection

@section('floating-buttons')
@endsection
