<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Grating Card</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    />

    <style>
      @font-face {
        font-family: "HelveticaNeue-Light";
        src: url(./assets/fonts/HelveticaNeue-Light.otf);
      }
      body {
        font-family: "HelveticaNeue-Light";
      }
      input,
      button,
      select {
        box-shadow: none !important;
        outline: none !important;
      }
      label {
        font-size: 20px;
      }
    </style>
  </head>
  <body>
    <div
      class="container d-flex justify-content-center align-items-center py-4 px-2"
      style="min-height: 100vh"
    >
      <div class="flex-column flex-lg-row d-flex">
        <div class="px-2 my-auto">
          <form id="cardForm" style="width: 400px; max-width: 100%">
            <div class="form-group">
              <label for="name">Please write your full name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                required
              />
            </div>
            <div class="form-group">
              <label for="email">Please write your email</label>
              <div class="d-flex">
                <input
                  type="text"
                  class="form-control mr-1"
                  id="email"
                  name="email"
                  required
                />
                <select class="custom-select ml-1" id="emailType">
                  <option value="@alfozan.com" selected>@alfozan.com</option>
                  <option value="@midadholding.com">@midadholding.com</option>
                  <option value="@ertiqa.org">@ertiqa.org</option>
                  <option value="@alfozanaward.org">@alfozanaward.org</option>
                </select>
              </div>
            </div>

            <div class="form-group mb-4">
              <label for="domain">Please write your company</label>
              <select class="custom-select" id="domain" name="domain">
                <option value="AFH" selected>AFH</option>
                <option value="A&M">A&M</option>
                <option value="FSF">FSF</option>
                <option value="FozanFamily">FozanFamily</option>
                <option value="Arnon">Arnon</option>
                <option value="Madar">Madar</option>
                <option value="MBM">MBM</option>
                <option value="MEM">MEM</option>
                <option value="MHW">MHW</option>
                <option value="UniSteel">UniSteel</option>
                <option value="Academy">Academy</option>
                <option value="AFAC">AFAC</option>
                <option value="Ertiqa">Ertiqa</option>
                <option value="MosqueAward">MosqueAward</option>
                <option value="Ascen">Ascen</option>
                <option value="Auva">Auva</option>
                <option value="Midad">Midad</option>
                <option value="Midad-ESP">Midad-ESP</option>
                <option value="MidadCC">MidadCC</option>
                <option value="Riyadah">Riyadah</option>
                <option value="Shomoul">Shomoul</option>
                <option value="UniGlass">UniGlass</option>
                <option value="Milad">Milad</option>
                <option value="Unesco">Unesco</option>
                <option value="SIMCO">SIMCO</option>
              </select>
            </div>
            <div class="form-group text-center mb-4">
              <button
                type="submit"
                class="btn rounded-pill text-white form-control"
                style="background-color: #5a5555"
              >
                SUBMIT
              </button>
            </div>
            <div class="d-flex justify-content-center">
              <div class="spinner-border text-muted d-none loading-icon"></div>
            </div>
          </form>
        </div>
        <div class="px-2">
          <canvas id="canvas" width="400px" height="592px"> </canvas>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#cardForm").submit(async function (e) {
          e.preventDefault();
          $("#cardForm button").prop("disabled", true);
          $(".loading-icon").addClass("d-block");
          var canvas = $("#canvas").get(0);
          var dataURL = canvas.toDataURL();
          var email = $("#email").val();
          var emailType = $("#emailType").val();
          var fullEmail = email + emailType;
          console.log(fullEmail);
          $.ajax({
            type: "POST",
            url: "mail.php",
            data: { imgBase64: dataURL, email: fullEmail },
            dataType: "json",
            success: function (response) {
              alert("The grating card was sent to your email successfully!");
              $("#cardForm button").prop("disabled", false);
              $("#cardForm input").val("");
              $(".loading-icon").removeClass("d-block");
            },
          });
        });
      });
      var text_title = "";
      var canvas = document.getElementById("canvas");
      var ctx = canvas.getContext("2d");
      var img = new Image();
      img.crossOrigin = "anonymous";
      window.addEventListener("load", DrawPlaceholder);
      document.getElementById("name").addEventListener("keyup", function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var domain = document.getElementById("domain").value;
        DrawOverlay(img);
        DynamicText(img, domain, (posy = 496));
        DynamicText(img, this.value, (posy = 470));
      });
      document.getElementById("domain").addEventListener("change", function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        DrawOverlay(img);
        var name = document.getElementById("name").value;
        DynamicText(img, name, (posy = 470));
        DynamicText(img, this.value, (posy = 496));
      });
      function DrawPlaceholder() {
        img.onload = function () {
          DrawOverlay(img);
        };
        img.src = "./a.jpg";
      }
      function DrawOverlay(img) {
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      }
      function DynamicText(img, val, posy) {
        text_title = val;
        ctx.textBaseline = "bottom";
        ctx.font = "20px 'Montserrat'";
        ctx.fillText(
          text_title,
          canvas.width / 2 - getTextWidth(text_title, ctx.font) / 2,
          posy
        );
      }
      function getTextWidth(text, font) {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");
        context.font = font || getComputedStyle(document.body).font;
        return context.measureText(text).width;
      }
    </script>
  </body>
</html>
