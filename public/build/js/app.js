function darkMode(){const e=window.matchMedia("(prefers-color-scheme: dark)");e.matches?document.body.classList.add("dark-mode"):document.body.classList.remove("dark-mode"),e.addEventListener("change",(function(){e.matches?document.body.classList.add("dark-mode"):document.body.classList.remove("dark-mode")}));document.querySelector(".dark-mode-boton").addEventListener("click",(function(){document.body.classList.toggle("dark-mode")}))}function eventListeners(){document.querySelector(".mobile-menu").addEventListener("click",navegacionResponsive);document.querySelectorAll('input[name="contacto[contacto]"]').forEach(e=>e.addEventListener("click",mostrarMetodoContacto))}function navegacionResponsive(){document.querySelector(".navegacion").classList.toggle("mostrar")}function mostrarMetodoContacto(e){const o=document.querySelector("#contacto");"telefono"===e.target.value?o.innerHTML='\n        <label for="telefono">Teléfono</label>\n        <input type="tel" placeholder="Tu Teléfono" id="telefono"  name="contacto[telefono]" required>\n\n        <label for="fecha">Fecha Llamada:</label>\n        <input type="date" id="fecha"  name="contacto[fecha]" required>\n\n        <label for="hora">Hora Llamada:</label>\n        <input type="time" id="hora" min="09:00" max="18:00"  name="contacto[hora]" required>\n        ':o.innerHTML='\n        <label for="email">E-mail</label>\n        <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>\n        '}document.addEventListener("DOMContentLoaded",(function(){eventListeners(),darkMode()}));