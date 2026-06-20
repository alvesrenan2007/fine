@extends('layouts.main_desktop')

@section('page-title')
Cadastro de Loja
@endsection

@section('header')
    <ul class="header-navigation__list">
        <a href="{{ route('marketplaces.index')}}">
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
Cadastro de Loja
@endsection

@section('app-shell-subtitle')
Edite as informações da Loja {{ $marketplace->name }}
@endsection

@section('app-shell-workspace')
<div class="form__input-field">
    <label class="form__label" for="marketplace_name">Nome da Loja</label>
    <input
        type="text"
        id="marketplace-name"
        name="marketplace_name"
        class="form__text-input"
        placeholder="Nome da loja"
        value="{{ $marketplace->name }}"
    / >
    <span id="marketplace-name-error-msg" class="form__error-span"></span>
</div>

{{-- Form with vlidated and converted data --}}
<div class="form__hidden">
    <form action="{{ route('marketplaces.update', $marketplace->id) }}" method="POST" id="sub-form">
        @csrf
        @method('POST')
        <input id="sub-input-marketplace-name" type="text" name="marketplace-name"/>
        <input id="sub-input-marketplace-cost" type="text" name="marketplace-cost"/>
        <input id="sub-input-marketplace-category" type="text" name="marketplace-category"/>
    </form>

    <form action="{{ route('marketplaces.delete', $marketplace->id)}}" method="POST" id="delete-form">
        @crsft
        @method('DELETE')

    </form>
</div>

<dialog id="deletion-dialog" class="dialog__dialog">
    <form id="form-delete" action="{{ route('marketplaces.delete', $marketplace->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <h2 class="modal__warning-header">Tem certeza que deseja deletar o produto?</h2>
        <p class="modal__warning-body">Não será possível recuperá-lo depois de deletado.</p>

        <div class="modal__actions-container">
            <button type="button" id="deletion-dialog-cancel-btn" class="action-button action-button--cancel">
                Cancelar
            </button>
            <button type="submit" class="action-button action-button--delete">
                Deletar
            </button>
        </div>
    </form>
</dialog>
@endsection


@section('app-shell-lower-actions')
    <button id="form-marketplaces-create__edit-btn" class="action-button action-button--primary">Salvar Alterações</button>
    <button id="form-marketplaces-create__delete-btn" class="action-button action-button--delete">Deletar Produto</button>
    <button id="form-marketplaces-create__cancel-btn" class="action-button action-button--cancel">Cancelar</button>
@endsection

<script type="module">

const registerBtn = document.getElementById('form-marketplaces-create__edit-btn');
const cancelBtn = document.getElementById('form-marketplaces-create__cancel-btn');
const subForm = document.getElementById('sub-form');

// Validation, conversions and submission
registerBtn.addEventListener('click', function(){
    let isDataValid = true;

    // Validation Stage
    const nameInput = document.getElementById('marketplace-name');
    const nameErrorSpan = document.getElementById('marketplace-name-error-msg');
    nameErrorSpan.innerText = '';

    const costInput = document.getElementById('marketplace-cost');
    const costErrorSpan = document.getElementById('marketplace-cost-error-msg');
    costErrorSpan.innerText = '';

    const categorySelect = document.getElementById('marketplace-category');
    const categoryErrorSpan = document.getElementById('marketplace-category-error-msg');
    categoryErrorSpan.innerText = '';

    if(nameInput.value == ''){
        nameErrorSpan.innerText = "Por favor, insira um nome para o produto."
        isDataValid = false;
    }

    // Conversion and Submission Stages
    if(isDataValid){
        const subInputName = document.getElementById('sub-input-marketplace-name');
        const subInputCost = document.getElementById('sub-input-marketplace-cost');
        const subInputCategory = document.getElementById('sub-input-marketplace-category');

        subInputName.value = nameInput.value;
        subInputCost.value = window.AppUtils.currency.formatFloat(costInput.value);
        subInputCategory.value = window.AppUtils.currency.formatInt(categorySelect.value);

        subForm.submit();
    }


});

cancelBtn.addEventListener('click', function(){
        window.location.href = "/marketplaces";
    });

    // Handling the delete button
    const deleteBtn = document.getElementById('form-marketplaces-create__delete-btn');
    const deletionDialog = document.getElementById('deletion-dialog');
    const deletionDialogCancelBtn = document.getElementById('deletion-dialog-cancel-btn');

    if(deleteBtn){
        deleteBtn.addEventListener('click', function(){
            console.log('showing the modal');
            deletionDialog.showModal();
        });
    }

    if(deletionDialogCancelBtn){
        deletionDialogCancelBtn.addEventListener('click', function(){
            deletionDialog.close();
        });
    }

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
