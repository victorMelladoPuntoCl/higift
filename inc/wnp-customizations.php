<?php
/*
Customizaciones para WNP Name Your Price 
*/

/**
 * Function for `woocommerce_before_add_to_cart_button` action-hook.
 * Añade una botonera que rellena el campo generado por el plugin WPC Name Your Price for WooCommerce (https://es.wordpress.org/plugins/wpc-name-your-price)
 * @return void
 */

function vk7k_hi_wc_donation()
{
    //COSAS...
?>

    <style>
        /*Estilos de los radios en el producto de donación*/

        .woocommerce h2 {
            padding: 20px;
            text-align: center;
            margin: 20px;
            border: gray thin solid;
        }

        .woocommerce h3 {
            padding: 20px;
            text-align: center;
            border: gray solid 1px;
            margin: 30px 0 5px 0;
            color: #555;
        }

        #higift_wnp_fieldset>div {
            width: 100%;
            text-align: center;
            padding: 20px 0;
            margin: 20px 0;
        }

        #higift_wnp_fieldset label {

            display: inline-block;
            width: 45%;
            min-width: 150px;
            padding: 5px 20px;
            margin: 5px;
            border: solid thin lightgray;

        }

        #higift_wnp_fieldset label:hover,
        input[type="text"]:hover,
        textarea:hover {
            -webkit-box-shadow: inset 0px 0px 27px -18px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: inset 0px 0px 27px -18px rgba(0, 0, 0, 0.75);
            box-shadow: inset 0px 0px 27px -18px rgba(0, 0, 0, 0.75);
        }



        /*Ni idea*/
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /*woonp*/

        .woonp {
            border: green 2px solid;
            display: none;
            text-align:center;
            padding:20px;
        }

        .woonp p {
            display: inline-block;
        }

        .woonp input[type="radio"]:checked+label {
            font-weight: bold;
        }

        .woonp-bot {
            border: red solid dotted;
            width:30px;
            font-size:30px;
            height:40px;
            background-color: red;
            color:white;
            margin:5px;
        }

        .woonp-bot:hover{
            background-color:green;
        }

        .woonp-overwrite {
            opacity: 0;
        }
    </style>


    <fieldset id="higift_wnp_fieldset">
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
                <input id="cuartoRadio" type="radio" name="color" value="40000" onclick="syncToWoonp(this);"> Otro
            </label>
        </div>
    </fieldset>



<?php
}

// AGREGAR JAVASCRIPT EN EL FOOTER

add_action('wp_footer', 'wpshout_action_example');
function wpshout_action_example()
{
?>


    <script type="text/javascript">
        //WOONP CAMPO DE DONACIONES
        // syncToWoonp -------------
        //Envía un valor al campo de texto al hacer clic en los radio de opciones.
        //Si se selecciona "Otro" (1.000) se muestra. Si se selecciona alguno de los otros, se oculta en opacidad
        //Ojo, usamos "opacity" porque si se usa otro parámetro CSS como show o visibility, el plugin WOONP no es capaz de enviar el form.

        var syncToWoonp = function(origen) {
            e = document.querySelector(".woonp-input");
            e.value = origen.value;

            console.log('origen.value = ' + origen.value);
            console.log('e.value = ' + e.value);

            //Oculta y muestra el cuadro de texto.
            f = document.querySelector(".woonp-overwrite");

            var woonpField = document.querySelector('.woonp');
    
            if (origen.id === 'cuartoRadio' && origen.checked) {
                woonpField.style.display = 'block'; // Muestra el campo woonp cuando el cuarto radio esté seleccionado
            } else {
                woonpField.style.display = 'none'; // Oculta el campo woonp en otros casos
            }
            
                }

        // Añadir botones y stepper customizado.

        woonp_input = document.querySelector('.woonp-input');
        woonp_input.insertAdjacentHTML('beforebegin', '<p id="minus" class="woonp-bot">-</p>')
        woonp_input.insertAdjacentHTML('afterend', '<p id="plus" class="woonp-bot">+</p>')


        var NumberStepper = {
            init: function() {
                this.domElems();
                this.events();
            },
            domElems: function() {
                this.plusBtn = document.getElementById('plus');
                this.minusBtn = document.getElementById('minus');
                this.input = document.querySelector('.woonp-input');
            },
            events: function() {
                this.minusBtn.addEventListener('click', this.decrement.bind(this));
                this.plusBtn.addEventListener('click', this.increment.bind(this));
            },
            decrement: function() {
                var value = this.input.value;
                if (this.input.value > 2000) {

                    value = (Math.floor(value / 2000) * 2000) - 2000;

                    this.input.value = value;
                } else {
                    this.input.value = 2000;
                }
            },
            increment: function() {
                var value = this.input.value;
                value = (Math.floor(value / 2000) * 2000) + 2000;
                this.input.value = value;
            }
        };

        NumberStepper.init();

    </script>

<?php

}
