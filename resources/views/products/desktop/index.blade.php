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
    <div class="table-container">
        <div class="table-container__header">
            <h2 class="table-container__title">Produtos Cadastrados</h2>
            <span class="table-container__count">{{ $products->count() }} {{ $products->count() === 1 ? 'produto encontrado' : 'produtos encontrados' }}</span>
        </div>

        @if($products->count() > 0)
            <table class="index-table">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Categoria</th>
                        <th class="text-right">Custo</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <span class="product-name">{{ $product->name }}</span>
                            </td>
                            <td>
                                <span class="badge badge--neutral">{{ $product->category->name ?? 'Sem Categoria' }}</span>
                            </td>
                            <td class="text-right font-mono">
                                R$ {{ number_format($product->cost, 2, ',', '.') }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('products.edit', $product->id) }}" class="table-action-link">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state__icon">📦</div>
                <h3 class="empty-state__title">Nenhum produto cadastrado</h3>
                <p class="empty-state__subtitle">Comece adicionando o seu primeiro produto ao sistema.</p>
            </div>
        @endif
    </div>
@endsection

@section('floating-buttons')
@endsection
