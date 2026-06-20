<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FINE - Fine Is Not an ERP</title>
	<style>
		.slide{
			display: flex;
			flex-direction: row;
			margin-bottom: 100vh;
		}

		.sidebar{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			gap: 4rem;
			background-color: #d8d8d8;
			width: 20%;
			height: 40rem;
		}

		.sidebar a {
			display: flex;
			justify-content: center;
			align-items: center;
			border-radius: 5px;
			color: black;
			background-color: #c1c1c1;
			font-weight: bold;
			font-size: 1.5rem;
			padding: 0.5rem;
			width: 75%;
			text-decoration: none;

		}

		.active{
			background-color: lightgreen !important;
		}

		.main-area{
			display: flex;
		        flex-direction: row;
			justify-content: center;
			align-items: center;
			background-color: #c1c1c1;
			width: 80%;
			height: 40rem;
		}

		.canvas{
		      display: flex;
		      flex-direction: column;
		      border-radius: 5px;
		      background-color: #d8d8d8;
		      height: 30rem;
		      width: 80%;
		      padding: 1rem;

		      justify-content: space-between;
		      align-items: center;
		      gap: 1rem;
		      padding-bottom: 3rem;
		    }

		    .input-row{
		      display: flex;
		      flex-direction: row;
		      justify-content: flex-start;
		      align-items: center;
		    }

		    .input-row label{
		      font-size: 2rem;
		      margin-right: 1rem;
		    }

		    .input-row input,select{
		      border-radius: 5px;
		      height: 2.5rem;
		      width: 20rem;
		      padding: 0.5rem;
		    }

		    p,li {
		      font-size: 2rem;
		    }

		.address-section {
			display: flex;
			flex-direction: column;
			width: 100%;
			margin: 1rem;
			padding: 1rem;
		}

		.address-row{
		      display: flex;
		      flex-direction: row;
		      align-items: center;
		      gap: 1rem;
		      margin-bottom: 1rem;
		}

		.address-row label{
		      font-size: 1rem;
		      margin-right: 1rem;
		}

		.address-row input,select{
		      border-radius: 5px;
		      height: 2rem;
		      padding: 0.5rem;
		}

		.long-input{
			width: 100%;
		}

		.error-msg{
			font-size: 1rem;
			color: red;
		}

		.hidden{
			display: none;
		}

		.input-error-pair{
			display: flex;
			flex-direction: column;
		}

		.save-btn{
			background-color: blue;
			color: white;
			font-weight: 400;
			padding: 0.5rem;
			border-radius: 8px;
		}
	</style>
	<script type="module">
		// ---
		// Error demonstrations for Products
		// ---
		const nameInput = document.getElementById('name');
		const sellpriceInput = document.getElementById('sellprice');
		const costInput = document.getElementById('cost');
		const nameErrorSpan = document.getElementById('name-error');
		const sellpriceErrorSpan = document.getElementById('sellprice-error');
		const costErrorSpan = document.getElementById('cost-error');
		const productsSaveBtn = document.getElementById('products-save');

		productsSaveBtn.addEventListener('click', function(){
			nameErrorSpan.classList.add('hidden');
			sellpriceErrorSpan.classList.add('hidden');
			costErrorSpan.classList.add('hidden');

			if(nameInput.value == ""){
				nameErrorSpan.classList.remove('hidden');
				nameInput.focus();
			}
			if(isNaN(sellpriceInput.value)){
				sellpriceErrorSpan.classList.remove('hidden');
				sellpriceInput.focus();
			}
			if(costInput.value == "" || isNaN(costInput.value)){
				costErrorSpan.classList.remove('hidden');
				costInput.focus();
			}

		});
		// ---
		// Autofill demonstration for CNPJ
		// ---

		const cnpjInput = document.getElementById('cnpj');
		const razaoInput = document.getElementById('razao');
		const ieInput = document.getElementById('ie');
		const cepInput = document.getElementById('cep');
		const streetInput = document.getElementById('street');
		const streetNumberInput = document.getElementById('streetNumber');
		const complementInput = document.getElementById('complement');
		const neighborhoodInput = document.getElementById('neighborhood');
		const ufInput = document.getElementById('uf');
		const cityInput = document.getElementById('city');

		const cnpjErrorSpan = document.getElementById('cnpj-error');

		cnpjInput.addEventListener('change', function(){

		if(cnpjInput.value == "01.234.567/000-89"){
			cnpjErrorSpan.classList.add('hidden');

			razaoInput.value = "Lorem Ipsum Soluções Ltda";
			ieInput.value = "012.34567-89";
			cepInput.value = "01234-567";
			streetInput.value = "Rua Fulano de Tal";
			streetNumberInput.value = "123";
			neighborhoodInput.value = "Centro";
			ufInput.selectedIndex = 1;
			cityInput.selectedIndex = 1;
		} else {
			cnpjErrorSpan.classList.remove('hidden')
		}

		});

		/*
		* Checks if string is numeric
		* @param string
		* @return boolean
		*/
		function isNumeric(string){
		  if(!isNaN(string)){
			return true;
		  } else{
			return false;
		  }

		}
	</script>
</head>

<body>

	<div class="slide" id="main-slide">
		<div class="sidebar">
			<a href="#main-slide" class="active">Página Inicial</a>
			<a href="#products-slide">Produtos</a>
			<a href="#company-slide">Empresa</a>
			<a>Lojas Virtuais</a>
			<a href="#reports-slide">Relatórios</a>
		</div>
		<div class="main-area">
			<div class="canvas">
				<h1>Bem vindo ao FINE (Fine Is Not an Erp), um sistema de precificação inteligente.</h1>
        <p>Sobre o nome:</p>
          <ul>
            <li>Acrônimo Recursivo</li>
            <li>Foneticamente proximo de "Finance"</li>
            <li>Significado positivo</li>
          </ul>
			</div>
		</div>
	</div>
	<div class="slide" id="products-slide">
		<div class="sidebar">
			<a href="#main-slide">Página Inicial</a>
			<a href="#products-slide" class="active">Produtos</a>
			<a href="#company-slide">Empresa</a>
			<a>Lojas Virtuais</a>
			<a href="#reports-slide">Relatórios</a>
		</div>
		<div class="main-area">
			<div class="canvas">

				<h1>(Caso de Uso 1) Cadastro de Produtos</h1>

		<div class="input-row">
		    <label>Nome do Produto</label>
		    <div class="input-error-pair">
			    <input type="text" id="name" placeholder="nome do produto..."/>
			    <span id="name-error" class="error-msg hidden">O nome do produto é obrigatório.</span>
		    </div>
		</div>

		<div class="input-row">
		    <label>Preço de Venda</label>
		    <div class="input-error-pair">
			    <input type="text" id="sellprice" placeholder="R$ 0,00"/>
			    <span id="sellprice-error" class="error-msg hidden">O preço de venda pode ter apenas números.</span>
		    </div>
		</div>

		<div class="input-row">
		    <label>Preço de Custo</label>
		    <div class="input-error-pair">
			    <input type="text" id="cost" placeholder="R$0,00"/>
			    <span id="cost-error" class="error-msg hidden">O preço de custo é obrigatório e pode ter apenas números.</span>
		    </div>
		</div>

		<div class="input-row">
		    <label>Categoria</label>
		    <select>
			<option>Bicicletas</option>
			<option>Bolsas</option>
			<option>Capacetes</option>
		    </select>
		</div>

	        <button type="button" id="products-save" class="save-btn">Salvar</button>
	      </div>
	    </div>
        </div>
	<div class="slide" id="company-slide">
		<div class="sidebar">
			<a href="#main-slide">Página Inicial</a>
			<a href="#products-slide">Produtos</a>
			<a href="#company-slide" class="active">Empresa</a>
			<a>Lojas Virtuais</a>
			<a href="#reports-slide">Relatórios</a>
		</div>
		<div class="main-area">
			<div class="canvas">
				<h1>(Caso de Uso 3) Cadastro de Empresa</h1>

        <div class="input-row">
            <label>CNPJ</label>
	    <div>
            <input type="text" id="cnpj" placeholder="00.000.000/000-00"/>
	    <p id="cnpj-error" class="error-msg hidden">O CNPJ não foi encontrado na SEFAZ</p>
	    </div>
        </div>

        <div class="input-row">
            <label>Razão Social</label>
            <input disabled type="text" id="razao" placeholder="Razão Social da empresa.."/>
        </div>

        <div class="input-row">
            <label>Inscrição Estadual</label>
            <input disabled type="text" id="ie" placeholder="000.00000-00"/>
        </div>

	<div class="address-section">
		<div class="address-row">
		    <label>CEP</label>
		    <input disabled type="text" id="cep" placeholder="00.000-000"/>
		</div>
		<div class="address-row">
		    <label>Rua</label>
		    <input disabled type="text" id="street" placeholder="Rua da sede fiscal da empresa..."/>
		    <label>Número</label>
		    <input disabled type="text" id="streetNumber" placeholder="000"/>
		</div>
		<div class="address-row">
		    <label>Complemento</label>
		    <input disabled type="text" id="compliment" class="long-input" placeholder="Complementos, pontos de referência e outras informações..."/>
		</div>
		<div class="address-row">
		    <label>Bairro</label>
		    <input disabled type="text" id="neighborhood" placeholder="Bairro"/>
		    <label>UF</label>
		    <select id="uf" disabled>
			    <option>AM</option>
			    <option>PR</option>
		    </select>
		    <label>Cidade</label>
		    <select id="city" disabled>
			    <option>Manaus</option>
			    <option>Londrina</option>
		    </select>
		</div>
	</div>
	</div>
	</div>
	</div>

			</div>
		</div>
	</div>
	<div class="slide" id="reports-slide">
		<div class="sidebar">
			<a href="#main-slide">Página Inicial</a>
			<a href="#products-slide">Produtos</a>
			<a href="#company-slide">Empresa</a>
			<a>Lojas Virtuais</a>
			<a href="#reports-slide" class="active">Relatórios</a>
		</div>
		<div class="main-area">
			<div class="canvas">
				<h1>(Caso de Uso 2) Simulação de Preços</h1>
				<h2>Bicicleta Infantil Lorem Ipson ACB12</h2>

				<div class="input-row">
				    <label>Preço de Venda</label>
				    <input type="text" placeholder="R$ 0,00" value="399,00"/>
				    <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="00A3C4"><path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/></svg>
				</div>

				<div class="input-row">
				    <label>Preço de Custo</label>
				    <input type="text" placeholder="R$ 0,00"/ value="200,00">
				    <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="00A3C4"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>
				</div>

				<div class="input-row">
				    <label>Custos Operacionais</label>
				    <input type="text" placeholder="R$ 0,00" value="60,00"/>
				    <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="00A3C4"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>
				</div>

				<div class="input-row">
				    <label>Custos da Loja</label>
				    <input type="text" placeholder="R$ 0,00" value="39,00"/>
				    <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="00A3C4"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>
				</div>

				<div class="input-row">
				    <label>Custos Tributários</label>
				    <input type="text" placeholder="R$ 0,00" value="28,00"/>
				    <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="00A3C4"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>
				</div>

				<div class="input-row">
				    <label>Margem de Lucro</label>
				    <input type="text" placeholder="0,00%" value="18,00%"/>
				    <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="00A3C4"><path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm296.5-143.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM240-160v-400 400Z"/></svg>
				</div>
			</div>
			</div>
			</div>
		</div>
	</div>
</body>

</html>
