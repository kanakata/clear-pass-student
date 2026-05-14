const images = document.querySelectorAll('img');
const inputs = document.querySelectorAll('input');
const alertBox = document.querySelector('.alert'); // Renamed to avoid confusion with window.alert

images.forEach((img) => {

  img.fetchPriority = 'high';
});

// inputs.forEach((input) => {
//   input.required = input.name !== 'surname';
//   if (input.name == "phone") {
//     input.addEventListener("keyup", () => {
//       alert("hello")
//       let value = input.value;
//       if (input.value[0] == 0 || input.value == '+') {
//         alert("please use the 254 format without the + sign i.e 254712345678.");
//       }
//     })
//   }
// });

inputs.forEach((input) => {
  // Set required status for all except surname
  input.required = input.name !== 'surname';

  if (input.name === 'phone') {
    input.addEventListener('keyup', () => {
      const value = input.value;

      // 1. Check for illegal starting characters (+ or 0)
      if (value.startsWith('0') || value.startsWith('+')) {
        input.style.borderColor = 'red';
        // Consider showing a small <span> error message instead of an alert
        console.warn('Invalid format: Use 254...');
      } else {
        input.style.borderColor = '';
      }

      // 2. Comprehensive Kenyan MSISDN Regex:
      // Starts with 254, followed by 1 or 7, then 8 digits.
      const msisdnPattern = /^254[17]\d{8}$/;

      if (value.length >= 12 && !msisdnPattern.test(value)) {
        console.error(
          'Number does not match 2547XXXXXXXX or 2541XXXXXXXX format.'
        );
      }
    });
  }
});

if (alertBox) {
  const isVisible = window.getComputedStyle(alertBox).display === 'block';
  if (isVisible) {
    document.body.style.overflow = 'hidden';
  }
}

