<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" 
     type="image/png" 
     href="../../public/assest/img/icon.png">
  <title>Error Page</title>
  <style>
    /* Scope for error.ejs */
    .scope-id-GkJ4JBheL2iiyVOw9Pqf {
      box-sizing: border-box;
      height: 100vh;
      background-color: #000000;
      background-image: radial-gradient(#112658, #040816), url("https://media.giphy.com/media/oEI9uBYSzLpBK/giphy.gif");
      background-repeat: no-repeat;
      background-size: cover;
      font-family: "Inconsolata", Helvetica, sans-serif;
      font-size: 1.5rem;
      color: rgba(128, 255, 237, 0.8);
      text-shadow: 0 0 1ex #33fcff, 0 0 2px rgba(255, 255, 255, 0.8);
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .noise {
      pointer-events: none;
      position: absolute;
      width: 100%;
      height: 100%;
      background-image: url("https://media.giphy.com/media/oEI9uBYSzLpBK/giphy.gif");
      background-repeat: no-repeat;
      background-size: cover;
      z-index: -1;
      opacity: 0.02;
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .overlay {
      pointer-events: none;
      position: absolute;
      width: 100%;
      height: 100%;
      background: repeating-linear-gradient(180deg, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0) 100%);
      background-size: auto 4px;
      z-index: 1;
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .overlay::before {
      content: "";
      pointer-events: none;
      position: absolute;
      display: block;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      background-image: linear-gradient(0deg,
          transparent 0%,
          rgba(32, 93, 128, 0.2) 2%,
          rgba(32, 105, 128, 0.8) 3%,
          rgba(32, 110, 128, 0.2) 3%,
          transparent 100%);
      background-repeat: no-repeat;
      animation: scan 7.5s linear 0s infinite;
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .terminal {
      box-sizing: inherit;
      position: absolute;
      height: 100%;
      width: 1000px;
      max-width: 100%;
      padding: 4rem;
      text-transform: uppercase;
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .output {
      color: rgba(128, 214, 255, 0.8);
      text-shadow: 0 0 1px rgba(51, 255, 51, 0.4), 0 0 2px rgba(255, 255, 255, 0.8);
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .output::before {
      content: "> ";
    }

    .scope-id-GkJ4JBheL2iiyVOw9Pqf .error-code {
      color: white;
    }
  </style>
</head>

<body class="scope-id-GkJ4JBheL2iiyVOw9Pqf">
  <!-- Start of Template scope -->
  <section>
    <div class="noise"></div>
    <div class="overlay"></div>
    <div class="terminal">
      <h1>
        Error
        <span class="error-code"> <?= $data['error_code'] ? $data['error_code']  : null  ?> </span>
      </h1>
      <p class="output"><?= $data['error_Content'] ? $data['error_Content']  : null ?></p>
      <p class="output">Please contact administrator.</p>
      <a href="<?= getenv('BASE_URL')?>"class="output" style="text-decoration: none;">GO BACK TO HOME PAGE</a>
    </div>
  </section>
  <!-- End of Template scope -->
</body>

</html> 