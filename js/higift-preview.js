document.addEventListener('DOMContentLoaded', function() {
  
  // Actualizaciones automáticas de los campos
  var higiftOtherNameInput = document.querySelector('input[name="higift_other_name"]');
  var higiftMessageInput = document.querySelector('textarea[name="higift_message"]');
  var higiftSenderNameInput = document.querySelector('input[name="higift_sender_name"]');
  var higiftToNameInput = document.querySelector('input[name="higift_to_name"]');

  if (higiftOtherNameInput) {
    higiftOtherNameInput.addEventListener('input', function() {
      document.getElementById('higift_other_name_preview').textContent = this.value;
    });
  }

  if (higiftMessageInput) {
    higiftMessageInput.addEventListener('input', function() {
      document.getElementById('higift_message_preview').textContent = this.value;
    });
  }

  if (higiftSenderNameInput) {
    higiftSenderNameInput.addEventListener('input', function() {
      document.getElementById('higift_sender_name_preview').textContent = this.value;
    });
  }

  if (higiftToNameInput) {
    higiftToNameInput.addEventListener('input', function() {
      document.getElementById('higift_to_name_preview').textContent = this.value;
    });
  }

  // Selector de diseños
  var designImages = document.querySelectorAll('.higift-design img');
  var higiftView = document.getElementById('higift-view');
  var variantSelect = document.querySelector('select[name="attribute_diseno"]');

  // Establecer la primera imagen como seleccionada por defecto
  var firstImage = designImages[0];
  var firstImageURL = firstImage.getAttribute('src');
  higiftView.style.backgroundImage = 'url("' + firstImageURL + '")';
  firstImage.closest('.higift-design').classList.add('selected-design');
  variantSelect.selectedIndex = 1; // +1 para saltar la primera opción "Elige una opción"


  // Bucle para cada imagen
    designImages.forEach(function(image, index) {
      image.addEventListener('click', function(event) {
      
      // Eliminar la clase .selected-design de todas las imágenes de diseño
      designImages.forEach(function(design) {
        design.closest('.higift-design').classList.remove('selected-design');
      });

      // Agregar la clase .selected-design a la imagen clickeada
      event.target.closest('.higift-design').classList.add('selected-design');

      // Actualizar el fondo de higift-view con la imagen seleccionada
      var imageURL = event.target.getAttribute('src');
      higiftView.style.backgroundImage = 'url("' + imageURL + '")';
      
      // Actualizar la opción seleccionada en el combobox según la posición de la imagen
      variantSelect.selectedIndex = index + 1; // +1 para saltar la primera opción "Elige una opción"
      
      // Disparar un evento de cambio para actualizar el UI de WooCommerce
      var changeEvent = new Event('change', {'bubbles': true, 'cancelable': true});
      variantSelect.dispatchEvent(changeEvent);
    });
  });

  // Mensajes predefinidos
  var predefinedMessagesSelect = document.getElementById('higift_predefined_messages');
  
  if (predefinedMessagesSelect) {
    predefinedMessagesSelect.addEventListener('change', function() {
      var selectedMessage = this.value;
      higiftMessageInput.value = selectedMessage;
      var messagePreview = document.getElementById('higift_message_preview');
      messagePreview.textContent = selectedMessage;
    });
  }

});
