@extends('layouts.main_desktop')

@section('page-title')
Cadastro de Produto
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
Cadastro de Produto
@endsection

@section('app-shell-subtitle')
Gerencie os produtos de seu inventário
@endsection

@section('action-buttons')
<a href="{{ route('categories.create')}}">
    <button class="action-button action-button--secondary">Cadastrar Categoria de Produto</button>
</a>
@endsection

@section('app-shell-workspace')
<div class="form__input-field">
    <label class="form__label" for="product_name">Nome do Produto</label>
    <input
        type="text"
        id="product-name"
        name="product_name"
        class="form__text-input"
        placeholder="Nome do produto"
    / >
    <span id="product-name-error-msg" class="form__error-span"></span>
</div>

<div class="form__input-field">
    <label class="form__label" for="product_cost">Custo do Produto</label>
    <input
        type="text"
        id="product-cost"
        name="product_cost"
        class="form__text-input"
        placeholder="R$ 0,00"
        data-mask-type="currency"
    / >
    <span id="product-cost-error-msg" class="form__error-span"></span>
</div>

<div class="form__input-field">
    <label class="form__label" for="product_category">Categoria do Produto</label>
    <select
        type="text"
        id="product-category"
        name="product_category"
        class="form__text-input"
    >
     @foreach($categories as $category)
        <option value="{{ $category->id}}">{{ $category->name}}</option>
     @endforeach
    </select>
    <span id="product-category-error-msg" class="form__error-span"></span>
</div>

{{-- Form with vlidated and converted data --}}
<div class="form__hidden">
    <form action="{{ route('products.store') }}" method="POST" id="sub-form">
        @csrf
        @method('POST')
        <input id="sub-input-product-name" type="text" name="product-name"/>
        <input id="sub-input-product-cost" type="text" name="product-cost"/>
        <input id="sub-input-product-category" type="text" name="product-category"/>
    </form>
</div>
@endsection


@section('app-shell-lower-actions')
    <button id="form-products-create__register-btn" class="action-button action-button--primary">Cadastrar</button>
    <button id="form-products-create__cancel-btn" class="action-button action-button--cancel">Cancelar</button>
@endsection

<script type="module">

const registerBtn = document.getElementById('form-products-create__register-btn');
const cancelBtn = document.getElementById('form-products-create__cancel-btn');
const subForm = document.getElementById('sub-form');

// Validation, conversions and submission
registerBtn.addEventListener('click', function(){
    let isDataValid = true;

    // Validation Stage
    const nameInput = document.getElementById('product-name');
    const nameErrorSpan = document.getElementById('product-name-error-msg');
    nameErrorSpan.innerText = '';

    const costInput = document.getElementById('product-cost');
    const costErrorSpan = document.getElementById('product-cost-error-msg');
    costErrorSpan.innerText = '';

    const categorySelect = document.getElementById('product-category');
    const categoryErrorSpan = document.getElementById('product-category-error-msg');
    categoryErrorSpan.innerText = '';

    if(nameInput.value == ''){
        nameErrorSpan.innerText = "Por favor, insira um nome para o produto."
        isDataValid = false;
    }

    // Conversion and Submission Stages
    if(isDataValid){
        const subInputName = document.getElementById('sub-input-product-name');
        const subInputCost = document.getElementById('sub-input-product-cost');
        const subInputCategory = document.getElementById('sub-input-product-category');

        subInputName.value = nameInput.value;
        subInputCost.value = window.AppUtils.currency.formatFloat(costInput.value);
        subInputCategory.value = window.AppUtils.currency.formatInt(categorySelect.value);

        subForm.submit();
    }


});

cancelBtn.addEventListener('click', function(){
        window.location.href = "/products";
    });

</script>

<style>

.app-shell__list{
    display: flex;
    flex-direction: column;
    padding: 1rem;
    gap: 1rem;
}

.app-shell__list-item{
    color: var(--color-text-main)
    padding: 0.2rem;
    border-bottom: 1px solid rgb(0 0 100 / 0.2);
}

.app-shell__list-item span{
    font-size: 1.5rem;
    font-weight: 400;
}

.app-shell__list-item:hover{
    color: var(--color-text-muted);
}
</style>
