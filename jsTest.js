document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");

  form.addEventListener("submit", function (event) {
      if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
      }
      form.classList.add("was-validated");
  });

  const decreaseBtn = document.getElementById("decreaseQuantity");
  const increaseBtn = document.getElementById("increaseQuantity");
  const quantityInput = document.getElementById("quantityInput");

  decreaseBtn.addEventListener("click", function () {
      let currentQuantity = parseInt(quantityInput.value);
      if (currentQuantity > 1) {
          quantityInput.value = currentQuantity - 1;
      }
  });

  increaseBtn.addEventListener("click", function () {
      let currentQuantity = parseInt(quantityInput.value);
      if (currentQuantity < 10) {
          quantityInput.value = currentQuantity + 1;
      }
  });

  const inputFields = form.querySelectorAll("input, textarea");
  inputFields.forEach(function (input) {
      input.setAttribute("required", "");
  });

  form.addEventListener('submit', (e) => {
      e.preventDefault();

      const nom = document.getElementById('nometprenom');
      const email = document.getElementById('email');
      const telephone = document.getElementById('telephone');
      const adresse = document.getElementById('adresse');
      const ville = document.getElementById('ville');
      const codepostal = document.getElementById('codepostal');

      let isValid = true;

      if (nom.value.trim() === '') {
          nom.classList.add('is-invalid');
          isValid = false;
      } else {
          nom.classList.remove('is-invalid');
          nom.classList.add('is-valid');
      }

      if (telephone.value.trim() === '' || !telephone.value.match(/^[0-9]{10}$/)) {
          telephone.classList.add('is-invalid');
          isValid = false;
      } else {
          telephone.classList.remove('is-invalid');
          telephone.classList.add('is-valid');
      }

      if (email.value.trim() === '' || !email.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
          email.classList.add('is-invalid');
          isValid = false;
      } else {
          email.classList.remove('is-invalid');
          email.classList.add('is-valid');
      }

      if (adresse.value.trim() === '') {
          adresse.classList.add('is-invalid');
          isValid = false;
      } else {
          adresse.classList.remove('is-invalid');
          adresse.classList.add('is-valid');
      }

      if (ville.value.trim() === '') {
          ville.classList.add('is-invalid');
          isValid = false;
      } else {
          ville.classList.remove('is-invalid');
          ville.classList.add('is-valid');
      }

      if (codepostal.value.trim() === '' || !codepostal.value.match(/^[0-9]{5}$/)) {
          codepostal.classList.add('is-invalid');
          isValid = false;
      } else {
          codepostal.classList.remove('is-invalid');
          codepostal.classList.add('is-valid');
      }

      if (isValid) {
          form.submit();
      }
  });
});
