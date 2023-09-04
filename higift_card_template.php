<div id="higift-card-wrapper">

    <div id="higift-view">
        <!--parte superior de la tarjeta-->
        <div id="higift_view_top" >
        </div>

        <!--parte inferior de la tarjeta -->
        <div id="higift_view_bottom">
            <?php if ($higift_type == 'corona_de_caridad'): ?>
                <div style="text-align: center;">
                    <p class="texto-sm">Hogar Italiano ha recibido una Corona de Caridad:</p>
                    <p>En memoria de: </p>
                    <p id="higift_other_name_preview" class="cursiva">Nombre del difunto</p>
                    <p id="higift_message_preview" >Mensaje personalizado</p>
                    <p>Enviada por: <p> 
                    <span id="higift_sender_name_preview" class="cursiva">Nombre del remitente</p>
                    
            </span></p>
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
        
        
        
        