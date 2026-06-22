@extends('layouts.main_desktop')

@section('page-title')
Relatórios
@endsection

@section('header')
    <ul class="header-navigation__list">
        <a href="{{ route('products.index')}}" style="text-decoration: none;">
            <li><button class="header-navigation__btn">Produtos</button></li>
        </a>
        <a href="{{ route('companies.index')}}" style="text-decoration: none;">
            <li><button class="header-navigation__btn">Empresas</button></li>
        </a>
        <a href="{{ route('marketplaces.index')}}" style="text-decoration: none;">
            <li><button class="header-navigation__btn">Lojas</button></li>
        </a>
        <a href="{{ route('reports.index')}}" style="text-decoration: none;">
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
    <a href="{{ route('reports.index') }}" style="text-decoration: none;">
        <button class="action-button action-button--secondary">Voltar</button>
    </a>
@endsection

@section('app-shell-workspace')
<div id="error-banner"></div>

<div class="control-panel">
    <div class="control-panel__group">
        <h2>{{ $product->name }}</h2>

        <div class="control-panel__row">
            <span class="form__label">Preço de Custo:</span>
            <input class="form__text-input" type="text" id="product-cost" data-mask-type="currency" value="{{ $product->cost}}"/>
            <label class="lockbox">
                <input type="checkbox" id="product-cost-lock" checked/>
                <svg class="icon-unlocked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/>
                </svg>

                <svg class="icon-locked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                </svg>
            </label>
        </div>

        <div class="control-panel__row">
            <span class="form__label">Taxa de Imposto:</span>
            <input class="form__text-input" type="text" id="tax-fee" data-mask-type="percentage" value="{{$company->tax_fee}}"/>
            <label class="lockbox">
                <input type="checkbox" id="tax-fee-lock" checked/>
                <svg class="icon-unlocked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/>
                </svg>

                <svg class="icon-locked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                </svg>
            </label>
        </div>
    </div>
</div>

<table id="rows-table" class="data-table">
    <thead>
        <tr>
            <th>Loja</th>
            <th>Custos Adiconais</th>
            <th>Taxa da Loja</th>
            <th>Preço de Venda</th>
            <th>Margem de Lucro</th>
        </tr>
    </thead>
    <tbody id="rows-body">
        @foreach($marketplaces as $mp)
        <tr>
            <td><strong>{{$mp->name}}</strong></td>

            <td>
                <div class="table-cell-actions">
                    <input class="form__text-input" type="text" data-type="additional-cost" data-marketplace-id="{{$mp->id}}" data-mask-type="currency" value="0"/>
                    <label class="lockbox">
                        <input type="checkbox" data-type="input-lock" data-target-type="additional-cost" data-target-id="{{$mp->id}}" checked/>
                        <svg class="icon-unlocked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/>
                        </svg>

                        <svg class="icon-locked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                        </svg>
                    </label>
                </div>
            </td>

            <td>
                <div class="table-cell-actions">
                    <input class="form__text-input" type="text" data-type="marketplace-fee" data-marketplace-id="{{$mp->id}}" data-mask-type="percentage" value="{{$mp->fee}}"/>
                    <label class="lockbox">
                        <input type="checkbox" data-type="input-lock" data-target-type="marketplace-fee" data-target-id="{{$mp->id}}" checked/>
                        <svg class="icon-unlocked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/>
                        </svg>

                        <svg class="icon-locked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                        </svg>
                    </label>
                </div>
            </td>

            <td>
                <div class="table-cell-actions">
                    <input class="form__text-input" type="text" data-type="sell-price" data-marketplace-id="{{$mp->id}}" data-mask-type="currency" value="0"/>
                    <label class="lockbox">
                        <input type="checkbox" data-type="input-lock" data-target-type="sell-price" data-target-id="{{$mp->id}}"/>
                        <svg class="icon-unlocked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/>
                        </svg>

                        <svg class="icon-locked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                        </svg>
                    </label>
                </div>
            </td>

            <td>
                <div class="table-cell-actions">
                    <input class="form__text-input" type="text" data-type="profit-margin" data-marketplace-id="{{$mp->id}}" data-mask-type="percentage" value="{{$company->profit_margin}}"/>
                    <label class="lockbox">
                        <input type="checkbox" data-type="input-lock" data-target-type="profit-margin" data-target-id="{{$mp->id}}" checked/>
                        <svg class="icon-unlocked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/>
                        </svg>

                        <svg class="icon-locked" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                        </svg>
                    </label>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('floating-buttons')
@endsection

<style>
    /* 1. Hide the checkbox visually */
    .lockbox input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .lockbox svg {
        cursor: pointer;
    }

    /* 2. DEFAULT STATE: Checkbox is UNCHECKED */
    /* Show the unlocked icon, hide the locked icon */
    .lockbox .icon-locked {
        display: none;
    }
    .lockbox .icon-unlocked {
        display: block;
    }

    /* 3. CHECKED STATE: Checkbox is CHECKED */
    /* We use the '~' (general sibling combinator) to find the SVGs after the input */
    .lockbox input[type="checkbox"]:checked ~ .icon-unlocked {
        display: none;
    }
    .lockbox input[type="checkbox"]:checked ~ .icon-locked {
        display: block;
    }
</style>

<script type="module">
window.addEventListener('app:ready', () => {
  const marketplaces = @json($marketplaces);
  const marketplaceIds = marketplaces.map((m) => m.id);

  const errorBanner = document.getElementById("error-banner");
let _original = window.LockStateManager;
Object.defineProperty(window, 'LockStateManager', {
  get() { return _original; },
  set(val) {
    console.trace('LockStateManager overwritten with:', val);
    _original = val;
  }
});
  const lockState = new window.LockStateManager({
    marketplaceIds,
    onChange: (state) => {
      refreshLockColors();
    },
  });

  const simulator = new PriceSimulator({
    lockState,
    onError: (err) => {
      errorBanner.style.display = "block";
      errorBanner.textContent = `⚠ ${err.message} ${err.details ? JSON.stringify(err.details) : ""}`;
    },
  });

  simulator.initialize();

  // Clear the error banner whenever a value input is edited again (best-effort UX).
  document.querySelectorAll('input[type="text"]').forEach((input) => {
    input.addEventListener("focus", () => {
      errorBanner.style.display = "none";
    });
  });

  window.simulator = simulator;
  window.lockState = lockState;

  function refreshLockColors() {
    document.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
      let input = cb.closest("td")?.querySelector('input[type="text"]');
      if (!input) {
        if (cb.id === "product-cost-lock") input = document.querySelector("#product-cost");
        if (cb.id === "tax-fee-lock") input = document.querySelector("#tax-fee");
      }
      if (input) {
        input.classList.toggle("locked", cb.checked);
        input.classList.toggle("unlocked", !cb.checked);
      }
    });
  }
  refreshLockColors();


    const maskInit = new window.MaskInitializer;
    maskInit.formatInputsOnLoad();
}); // end of app ready
</script>
