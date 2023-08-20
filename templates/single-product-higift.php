<?php
global $product;
$product = wc_get_product(get_the_ID());
$higift_type = get_post_meta($post->ID, 'hi_gift_type', true);
get_header(); // Incluir el archivo header.php de tu tema
?>
<div id="higift-wrapper">
    <!-- Columna Izquierda -->

<div id="higift-left">
    <div id="higift-left-container">
        <form action="" method="post" id="higift-form">

            <!-- Paso 1: Tus Datos -->
            <h2>Paso 1: tus datos</h2>
            <p>Indícanos la información sobre tí</p>
            <label>Tu nombre:</label>
            <input type="text" name="customer_name" maxlength="20" required>
            <label>Tu dirección de correo electrónico:</label>
            <input type="email" name="billing_email" required>

            <!-- Paso 2: Contenido de la Tarjeta/Corona -->
            <h2>Paso 2: Contenido de la <?php echo $higift_type == 'corona_de_caridad' ? 'corona de caridad' : 'tarjeta solidaria'; ?></h2>
            <?php if ($higift_type == 'corona_de_caridad'): ?>
                <label>Nombre del difunto:</label>
                <input type="text" name="higift_other_name">
            <?php endif; ?>
            <label>Mensaje:</label>
            <input type="text" name="higift_message" maxlength="200" required>
            <!-- Aquí puedes agregar el combobox para mensajes predefinidos -->
            <label>Nombre de quien envía la corona/tarjeta:</label>
            <input type="text" name="higift_sender_name" maxlength="20" required>
            <label>Nombre de la persona o familia a quien se envía:</label>
            <input type="text" name="higift_to_name" required>
            <label>Email al que se enviará la tarjeta:</label>
            <input type="email" name="higift_to_email" required>
            <!-- Aquí puedes agregar la dirección a la que se enviará la tarjeta física si es una corona de caridad -->

            <!-- Paso 3: Escoge un diseño (solo para productos variables) -->
            <?php if ($product->is_type('variable')): ?>
    <h2>Paso 3: Escoge un diseño</h2>
    <div class="higift-designs">
        <?php foreach ($product->get_available_variations() as $variation): ?>
            <div class="higift-design variant-box">
                <img src="<?php echo $variation['image']['url']; ?>" alt="<?php echo $variation['image']['alt']; ?>">
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>



            <!-- Botón Añadir al Carrito -->
            <button type="submit" class="single_add_to_cart_button button alt">Revisar Donación</button>
        </form>
    </div>
</div>

 <!-- Columna Derecha: higift-view -->
 <div id="higift-view" style="width: 496px; height: 708px; box-sizing: border-box;">
        <div id="higift_view_top" style="height: 496px;"></div>
        <div id="higift_view_bottom" style="height: 496px; padding: 92px;">
            <?php if ($higift_type == 'corona_de_caridad'): ?>
                <div style="text-align: center;">
                    <p>Hogar Italiano ha recibido una Corona de Caridad:</p>
                    <p>En memoria de <span id="higift_other_name_preview"></span></p>
                    <p id="higift_message_preview"></p>
                    <p>Enviada por: <span id="higift_sender_name_preview"></span></p>
                    <p>Dirección <span id="shipping_address_preview"></span></p>
                </div>
            <?php else: ?>
                <div style="text-align: center;">
                    <p id="higift_to_name_preview"></p>
                    <p id="higift_message_preview"></p>
                    <p id="higift_sender_name_preview"></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php if ($higift_type == 'corona_de_caridad'): ?>
    <!-- Código específico para la corona de caridad -->
<?php else: ?>
    <!-- Código específico para la tarjeta solidaria -->
<?php endif; ?>

</div>


<?php
get_footer(); // Incluir el archivo footer.php de tu tema
?>
