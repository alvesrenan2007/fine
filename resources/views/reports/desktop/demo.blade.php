{{-- Written by Sonnet 4.6 via claude.ai web chat --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>PriceSimulator + LockStateManager Demo</title>
<style>
  body { font-family: system-ui, sans-serif; max-width: 950px; margin: 30px auto; }
  fieldset { margin-bottom: 20px; }
  table { border-collapse: collapse; width: 100%; }
  th, td { border: 1px solid #ccc; padding: 6px 10px; text-align: left; vertical-align: top; }
  th { background: #f5f5f5; }
  input[type="text"] { width: 100px; }
  .locked { background: #ffe9e9; }
  .unlocked { background: #e9ffe9; }
  label.lockbox { display: flex; align-items: center; gap: 4px; font-size: 12px; margin-top: 2px; }
  #error-banner { display: none; background: #fff3cd; border: 1px solid #ffe69c; color: #664d03; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
  #state-debug { font-family: monospace; font-size: 12px; background: #f8f8f8; padding: 10px; border-radius: 6px; white-space: pre-wrap; }
</style>
@vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>

<h1>PriceSimulator + LockStateManager Demo</h1>

<div id="error-banner"></div>

<fieldset>
  <legend>Global</legend>
  <label>Product cost: <input type="text" id="product-cost" data-mask-type="currency" value="{{ $product->cost}}"/></label>
  <label class="lockbox"><input type="checkbox" id="product-cost-lock" checked/> locked</label>
  <br/>
  <label>Tax fee: <input type="text" id="tax-fee" data-mask-type="percentage" value="{{$company->tax_fee}}"/></label>
  <label class="lockbox"><input type="checkbox" id="tax-fee-lock" checked/> locked</label>
</fieldset>

<table id="rows-table">
  <thead>
    <tr>
      <th>Marketplace</th>
      <th>Additional cost</th>
      <th>Marketplace fee</th>
      <th>Sell price</th>
      <th>Profit margin</th>
    </tr>
  </thead>
  <tbody id="rows-body">
    @foreach($marketplaces as $mp)
    <tr>
      <td><strong>{{$mp->name}}</strong></td>
      <td>
        <input type="text" data-type="additional-cost" data-marketplace-id="{{$mp->id}}" data-mask-type="currency" value="0"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="additional-cost" data-target-id="{{$mp->id}}" checked/> lock</label>
      </td>
      <td>
        <input type="text" data-type="marketplace-fee" data-marketplace-id="{{$mp->id}}" data-mask-type="percentage" value="{{$mp->fee}}"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="marketplace-fee" data-target-id="{{$mp->id}}" checked/> lock</label>
      </td>
      <td>
        <input type="text" data-type="sell-price" data-marketplace-id="{{$mp->id}}" data-mask-type="currency" value="0"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="sell-price" data-target-id="{{$mp->id}}"/> lock</label>
      </td>
      <td>
        <input type="text" data-type="profit-margin" data-marketplace-id="{{$mp->id}}" data-mask-type="percentage" value="{{$company->profit_margin}}"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="profit-margin" data-target-id="{{$mp->id}}" checked/> lock</label>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<h3>Internal state (debug)</h3>
<div id="state-debug"></div>

<script type="module">

  const marketplaces = [
    { id: "1", name: "Amazon" },
    { id: "2", name: "eBay" },
    { id: "3", name: "Shopify" },
  ];

  const seed = {
    1: { "additional-cost": "$2.00", "marketplace-fee": "15.00%", "sell-price": "$20.00", "profit-margin": "10.00%" },
    2: { "additional-cost": "$1.50", "marketplace-fee": "12.00%", "sell-price": "$19.00", "profit-margin": "12.00%" },
    3: { "additional-cost": "$0.50", "marketplace-fee": "8.00%",  "sell-price": "$18.00", "profit-margin": "15.00%" },
  };
/**
  const tbody = document.getElementById("rows-body");
  for (const mp of marketplaces) {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td><strong>${mp.name}</strong></td>
      <td>
        <input type="text" data-type="additional-cost" data-marketplace-id="${mp.id}" data-mask-type="currency" value="${seed[mp.id]["additional-cost"]}"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="additional-cost" data-target-id="${mp.id}" checked/> lock</label>
      </td>
      <td>
        <input type="text" data-type="marketplace-fee" data-marketplace-id="${mp.id}" data-mask-type="percentage" value="${seed[mp.id]["marketplace-fee"]}"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="marketplace-fee" data-target-id="${mp.id}" checked/> lock</label>
      </td>
      <td>
        <input type="text" data-type="sell-price" data-marketplace-id="${mp.id}" data-mask-type="currency" value="${seed[mp.id]["sell-price"]}"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="sell-price" data-target-id="${mp.id}"/> lock</label>
      </td>
      <td>
        <input type="text" data-type="profit-margin" data-marketplace-id="${mp.id}" data-mask-type="percentage" value="${seed[mp.id]["profit-margin"]}"/>
        <label class="lockbox"><input type="checkbox" data-type="input-lock" data-target-type="profit-margin" data-target-id="${mp.id}" checked/> lock</label>
      </td>
    `;
    tbody.appendChild(tr);
  }
*/
  // Starting posture: every row's "sell-price" is the sole unlocked (dependent)
  // field; both global fields start locked (globalDependent = null).

  const marketplaceIds = marketplaces.map((m) => m.id);

  function renderDebug(state) {
    document.getElementById("state-debug").textContent = JSON.stringify(state, null, 2);
  }

  const errorBanner = document.getElementById("error-banner");

  const lockState = new LockStateManager({
    marketplaceIds,
    onChange: (state) => {
      renderDebug(state);
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
  renderDebug(lockState.getState());
</script>

</body>
</html>
