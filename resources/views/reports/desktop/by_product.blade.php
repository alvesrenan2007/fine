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
Simulação de Preços
@endsection

@section('app-shell-subtitle')
Simule o preço de {{ $product->name }} em diversos lugares.
@endsection

@section('action-buttons')
    <a href="{{ route('reports.index') }}">
        <button class="action-button action-button--secondary">Voltar</button>
    </a>
@endsection

@section('app-shell-workspace')
<div class="card-row">
    <div class="card-column card-column--left">
        <h1 class="card-column__title">{{ $product->name }}</h1>
        <div class="form__input-field--horizontal">
            <label class="form__label">Custo do Produto</label>
            <input
                type="text"
                id="product-cost"
                class="form__text-input"
                placeholder="R$ 0,00"
                value="{{ $product->cost }}"
                data-mask-type="currency"
            / >
        </div>
        <div class="form__input-field--horizontal">
            <label class="form__label">Taxa de Imposto</label>
            <input
                type="text"
                id="tax-fee"
                class="form__text-input"
                placeholder="Entre 0 e 1, sendo 1 igual a 100%"
                value="{{ $company->imposto }}"
            / >
        </div>
    </div>
    @foreach($marketplaces as $marketplace)
        <div class="card-column card-column--right">
            <h1 class="card-column__title">{{ $marketplace->name }}</h1>
            <div class="form__input-field--horizontal">
                <label class="form__label">Taxa da Loja</label>
                <input
                    type="text"
                    id="marketplace-fee-{{ $marketplace->id }}"
                    data-marketplace-id="{{ $marketplace->id }}"
                    class="form__text-input marketplace-fee-input"
                    placeholder="Entre 0 e 1, sendo 1 igual a 100%"
                    value="{{ $marketplace->fee($product->category, 0.1650) }}"
                / >
            </div>
            <div class="form__input-field--horizontal">
                <label class="form__label">Preço de Venda</label>
                <input
                    type="text"
                    id="sell-price"
                    data-marketplace-id="{{ $marketplace->id }}"
                    class="form__text-input"
                    placeholder="R$ 0,00"
                    value=""
                    data-mask-type="currency"
                / >
            </div>
            <div class="form__input-field--horizontal">
                <label class="form__label">Margem de Lucro</label>
                <input
                    type="text"
                    id="profit-margin-{{ $marketplace->id }}"
                    data-marketplace-id="{{ $marketplace->id }}"
                    class="form__text-input"
                    placeholder="Entre 0 e 1, sendo 1 igual a 100%"
                    value="1.000"
                / >
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('floating-buttons')
@endsection

<style>
    .card-row{
        display: flex;
        flex-direction: row;
        gap: 3rem;
    }

    .card-column{
        display: flex;
        flex-direction: column;
        border-radius: 5px;
        padding: 1rem;
        width: 50%;
        gap: 1rem;
    }

    .card-column--left{
        background-color: var(--color-light-gray);
    }

    .card-column--right{
        background-color: var(--color-light-blue);
    }

    .card-column__title{
        font-size: 2rem;
        font-weight: 600;
    }

    .form__label{
        font-size: 2rem !important;
    }

    .form__text-input{
        background-color: white;
        font-size: 2rem !important;
    }
</style>

<script type="module">

    const costInput = document.getElementById('product-cost');
    const taxInput = document.getElementById('tax-fee');
    
    const feeInputs = document.querySelectorAll('.marketplace-fee-input');

    feeInputs.forEach(input => {
        // Get the raw value
        const feeValue = parseFloat(input.value) || 0;
        
        // Get the unique ID if you need to associate it back to a specific marketplace
        const marketplaceId = input.dataset.marketplaceId; 
        
        console.log(`Marketplace ID ${marketplaceId} has a fee of ${feeValue}`);
        
        // Run your calculation logic here per marketplace
    });

</script>