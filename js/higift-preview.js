document.addEventListener('DOMContentLoaded', function() {
    // Actualizar el nombre del difunto para la corona de caridad
    var higiftOtherNameInput = document.querySelector('input[name="higift_other_name"]');
    if (higiftOtherNameInput) {
      higiftOtherNameInput.addEventListener('input', function() {
        document.getElementById('higift_other_name_preview').textContent = this.value;
      });
    }
  
    // Actualizar el mensaje
    document.querySelector('input[name="higift_message"]').addEventListener('input', function() {
      document.getElementById('higift_message_preview').textContent = this.value;
    });
  
    // Actualizar el nombre del remitente
    document.querySelector('input[name="higift_sender_name"]').addEventListener('input', function() {
      document.getElementById('higift_sender_name_preview').textContent = this.value;
    });
  
    // Actualizar el nombre del destinatario (para tarjetas)
    var higiftToNameInput = document.querySelector('input[name="higift_to_name"]');
    if (higiftToNameInput) {
      higiftToNameInput.addEventListener('input', function() {
        document.getElementById('higift_to_name_preview').textContent = this.value;
      });
    }
  
    // Aquí puedes agregar más eventos para actualizar otros campos
  });


/*Actualizar fondo */
  document.addEventListener('DOMContentLoaded', function() {
    // Obtener todas las imágenes de diseño
    var designImages = document.querySelectorAll('.higift-design img');
  
    // Obtener la caja higift-view
    var higiftView = document.getElementById('higift-view');
  
    // Agregar un evento de clic a cada imagen
    designImages.forEach(function(image) {
      image.addEventListener('click', function() {
        // Obtener la URL de la imagen clickeada
        var imageURL = this.getAttribute('src');
  
        // Actualizar el fondo de higift-view con la imagen seleccionada
        higiftView.style.backgroundImage = 'url("' + imageURL + '")';
      });
    });
  });
  