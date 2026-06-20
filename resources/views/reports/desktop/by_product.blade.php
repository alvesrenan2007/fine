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
            <input type="hidden" class="marketplace-id-input" data-marketplace-id="{{ $marketplace->id }}"/>
            <div class="form__input-field--horizontal">
                <label class="form__label">Custos Adicionais</label>
                <input
                    type="text"
                    id="additional-costs-{{ $marketplace->id}}"
                    class="form__text-input"
                    placeholder="R$ 0,00"
                    data-mask-type="currency"
                / >
            </div>
            <div class="form__input-field--horizontal">
                <label class="form__label">Taxa da Loja</label>
                <input
                    type="text"
                    id="marketplace-fee-{{ $marketplace->id }}"
                    class="form__text-input marketplace-fee-input"
                    placeholder="Entre 0 e 1, sendo 1 igual a 100%"
                    value="{{ $marketplace->fee($product->category, 0.1650) }}"
                / >
            </div>
            <div class="form__input-field--horizontal">
                <label class="form__label">Preço de Venda</label>
                <input
                    type="text"
                    id="sell-price-{{ $marketplace->id}}"
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

    // ------------
    // | Class Declarations and Function Definitions (needs refactoring)
    // ------------

    class PricingService {

        constructor(){}

        /**
         * Returns the sell price given tha all other values are locked
         * and using the formula 'sellPrice = absoluteValues/(1-relativeValues)'
         * @param {float} productCost (absolute value)
         * @param {float} additionalCosts (absolute value)
         * @param {float} taxFee (relative value)
         * @param {float} marketplaceFee (relative value)
         * @param {float} profitMargin (relative value)
         */
        calculateSellPrice(prouctCost, additionalCosts, taxFee, marketplaceFee, profitMargin){
            let numerator = productCost + additionalCosts;
            let denominator = 1 - taxFee - marketplaceFee - profitMargin;

            if(denominator == 0){
                    return 0.0;
            }

            return numerator/denominator;
        }
    }

    // ------------
    // | Main script flow
    // -----------;-

    const costInput = document.getElementById('product-cost');
    const taxInput = document.getElementById('tax-fee');

    const marketplaceIdInputs = document.querySelectorAll('.marketplace-id-input');

    // Initializing sellPrice for each marketplace block
    marketplaceIdInputs .forEach(input => {
        let marketplaceId = input.dataset.marketplace-id;
        const additionalCostsInput = document.getElementById('additionalCosts' + marketplaceId);
        const marketplaceFeeInput = document.getEleentById('marketplace-fee' + marketplaceId);
        const proftitMarginInput = document.getEleentById('');
        const sellPriceInput = document.getEleentById('');
    });

</script>
