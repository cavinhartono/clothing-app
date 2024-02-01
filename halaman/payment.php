<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form method="post">
    <input type="text" name="code" id="code">
    <button type="button" onclick="getPayment()">Cari</button>
  </form>
  <div id="display"></div>
  <script>
    function getPayment() {
      fetch("PaymentApi.php", {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "code=" + encodeURIComponent(document.querySelector("#code").value)
        })
        .then(response => response.text())
        .then(result => {
          document.querySelector("#display").innerHTML = result;
        })
        .catch(error => console.error(error));
    }
  </script>
</body>

</html>