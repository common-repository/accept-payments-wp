var form = document.querySelector('#payment-form');
var nonceInput = document.querySelector('#nonce');
var amount = document.querySelector('#price');

let successPage = scriptParams.successPage;
let failurePage = scriptParams.failurePage;
let tokenizationKey = scriptParams.tokenizationKey;
let recurring = false;

braintree.dropin.create({
  authorization: tokenizationKey,
  container: '#dropin-container'
}, function (err, dropinInstance) {
  if (err) {
    // Handle any errors that might've occurred when creating Drop-in
    console.error(err);
    return;
  }
  form.addEventListener('submit', function (event) {
    event.preventDefault();

    dropinInstance.requestPaymentMethod(function (err, payload) {
      if (err) {
        // Handle errors in requesting payment method
        return;
      }

      // Send payload.nonce to your server
      let url = form.dataset.url;
      nonceInput.value = payload.nonce;
      let params = new URLSearchParams(new FormData(form));

      fetch(url, {
        method: "POST",
        body: params
      }).then(res => res.json()).catch(error => {
        console.log(error);
      }).then(response => {
        if (response['success'] = true)
        {
          window.location.href = successPage;
        } else if (response['success'] = false) {
          window.location.href = failurePage;
        }

      });

    });
  });
});
