<?php
add_action( 'woocommerce_before_add_to_cart_button', 'vk7k_hi_wc_donation' );

/**
 * Function for `woocommerce_before_add_to_cart_button` action-hook.
 * Añade una botonera que rellena el campo generado por el plugin WPC Name Your Price for WooCommerce (https://es.wordpress.org/plugins/wpc-name-your-price)
 * @return void
 */

function vk7k_hi_wc_donation(){
//COSAS...
?>

	<style>
		/*Estilos de los radios en el producto de donación*/
		.vk7k-radio {
			display: inline-block;
			border: red thin dotted;
		}
		
		fieldset.vk7k, .vk7k > div {
			width:100%;
			text-align:center;
			padding:20px 0;
			margin: 20px 0;
		}
		.vk7k label{

		display:inline-block;
		width:45%;
		min-width:150px;
		padding: 5px 20px;
	    margin: 5px;
    	border: solid thin lightgray;
		
		}
		
		input[type="radio"]:checked + label {
    		font-weight: bold;
		}
		
		.woonp-overwrite{
			opacity:0;
		}
	</style>
   

<style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
  
        input[type=number] {
            -moz-appearance: textfield;
        }
</style>


		<fieldset class="vk7k field-radio-group-1659717234442" >
			<legend>Elige un monto de donación:</legend>
			<div>
				<label>
					<input type="radio" name="color" value="10000" id="primerRadio" onclick="syncToWoonp(this);"> $ 10.000
				</label>
				<label>
					<input type="radio" name="color" value="20000" onclick="syncToWoonp(this);"> $20.000
				</label>
				<label>
					<input type="radio" name="color" value="30000" onclick="syncToWoonp(this);"> $ 30.000
				</label>
				<label>
					<input type="radio" name="color" value="40000" onclick="syncToWoonp(this);"> 40.000
				</label>
			</div>
		</fieldset>



<?php
}

// AGREGAR JAVASCRIPT EN EL FOOTER

add_action('wp_footer', 'wpshout_action_example'); 
function wpshout_action_example() { 
?>


<script type="text/javascript">
	

	//WOONP CAMPO DE DONACIONES
	// syncToWoonp -------------
	//Envía un valor al campo de texto al hacer clic en los radio de opciones.
	//Si se selecciona "Otro" (1.000) se muestra. Si se selecciona alguno de los otros, se oculta en opacidad
	//Ojo, usamos "opacity" porque si se usa otro parámetro CSS como show o visibility, el plugin WOONP no es capaz de enviar el form.

	var syncToWoonp= function(origen){
		e = document.querySelector(".woonp-input");
			e.value = origen.value;
			
			console.log('origen.value = '+ origen.value);
			console.log('e.value = '+ e.value);
			
			//Oculta y muestra el cuadro de texto.
			f = document.querySelector(".woonp-overwrite");
			

			if(origen.value=="2000"){
				f.style.opacity=1;
				xfx = document.querySelector('.woonp-input');
				xfx.focus();
			}else{
				// f.style.display="none";
				f.style.opacity = 0;
			}
	}
	
	// Añadir botones y stepper customizado.
	
	woonp_input =  document.querySelector('.woonp-input');
	woonp_input.insertAdjacentHTML('beforebegin', '<p id="minus" class="boton">-</p>')
	woonp_input.insertAdjacentHTML('afterend', '<p id="plus" class="boton">+</p>')
	
	
	var NumberStepper = {
		  init: function () {
			this.domElems();
			this.events();
		  },
		  domElems: function () {
			this.plusBtn = document.getElementById('plus');
			this.minusBtn = document.getElementById('minus');
			this.input = document.querySelector('.woonp-input');
		  },
		  events: function () {
			this.minusBtn.addEventListener('click', this.decrement.bind(this));
			this.plusBtn.addEventListener('click', this.increment.bind(this));
		  },
		  decrement: function () {
			var value = this.input.value;
			if (this.input.value > 2000){
			
			value = (Math.floor(value/2000) * 2000)-2000;
		
			this.input.value = value;  
			} else{
				this.input.value = 2000; 
			}
		  },
		  increment: function () {
			var value = this.input.value;
			value = (Math.floor(value/2000) * 2000) + 2000;
			this.input.value = value;  
		  }
	};

	NumberStepper.init();
	

	
</script>




<?php
	
}


