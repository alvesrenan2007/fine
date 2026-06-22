@extends('layouts.main_desktop')

@section('page-title')
Lojas
@endsection

@section('header')
    <ul class="header-navigation__list">
        <a href="{{ route('products.index')}}">
            <li><button class="header-navigation__btn">Produtos</button></li>
        </a>
        <a href="{{ route('marketplaces.index')}}">
            <li><button class="header-navigation__btn">Empresas</button></li>
        </a>
        <a href="{{ route('marketplaces.index')}}">
            <li><button class="header-navigation__btn header-navigation__btn--active">Lojas</button></li>
        </a>
        <a href="{{ route('reports.index')}}">
            <li><button class="header-navigation__btn">Relatórios</button></li>
        </a>
    </ul>
@endsection

@section('app-shell-title')
Lojas
@endsection

@section('app-shell-subtitle')
Realize a vinculação com as lojas virtuais onde vende seus produtos
@endsection

@section('action-buttons')
<a href="{{ route('marketplaces.create')}}">
    <button class="action-button action-button--secondary">Vincular Loja</button>
</a>
@endsection

@section('app-shell-workspace')
    <div class="table-container">
        <div class="table-container__header">
            <h2 class="table-container__title">Lojas e Marketplaces Integrados</h2>
            <span class="table-container__count">{{ $marketplaces->count() }} {{ $marketplaces->count() === 1 ? 'loja configurada' : 'lojas configuradas' }}</span>
        </div>

        @if($marketplaces->count() > 0)
            <table class="index-table nested-table-layout">
                <thead>
                    <tr>
                        <th style="width: 40%;">Marketplace</th>
                        <th style="width: 30%;">Categorias Sincronizadas</th>
                        <th style="width: 30%;" class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marketplaces as $marketplace)
                        <tr class="master-row">
                            <td>
                                <div class="marketplace-identity">
                                    <span class="marketplace-icon">🏪</span>
                                    <div>
                                        <span class="marketplace-name">{{ $marketplace->name }}</span>
                                        <span class="marketplace-meta">ID: #{{ $marketplace->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge--green">
                                    {{ $marketplace->fees->count() }} {{ $marketplace->fees->count() === 1 ? 'categoria' : 'categorias' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="#" class="table-action-link">Configurar Loja</a>
                            </td>
                        </tr>

                        <tr class="detail-row">
                            <td colspan="3">
                                <div class="nested-wrapper">
                                    <div class="nested-header">Taxas por Categoria de Produto</div>

                                    @if($marketplace->fees && $marketplace->fees->count() > 0)
                                        <div class="category-grid">
                                            @foreach($marketplace->fees as $fee)
                                                <div class="category-card">
                                                    <div class="category-card__info">
                                                        <span class="category-card__name">{{ $fee->category_name }}</span>
                                                    </div>
                                                    <div class="category-card__fee font-mono">
                                                        {{ number_format($fee->value, 2, ',', '.') }}%
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="nested-empty-text">Nenhuma categoria configurada para esta loja. Todas as vendas usarão a taxa padrão.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state__icon">🔌</div>
                <h3 class="empty-state__title">Nenhuma loja cadastrada</h3>
                <p class="empty-state__subtitle">Conecte seus marketplaces para começar a gerenciar e simular taxas integradas.</p>
            </div>
        @endif
    </div>
@endsection
