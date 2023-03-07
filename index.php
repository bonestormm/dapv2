<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/nixon2/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/nixon2/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/nixon2/mail/SMTP.php';

$nombre_cotice = $_POST['nombre_cotice'] ?? '';
$numero_cotice = $_POST['numero_cotice'] ?? '';

$response_captcha = $_POST['g-recaptcha-response'] ?? '';

if (isset($response_captcha) && $response_captcha) {
  $key = "6LdxpjkaAAAAAPJqQqswJVqcMElobDaK95bkrltZ";
  $ip = $_SERVER['REMOTE_ADDR'];
  $validation_server = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$key&response=$response_captcha&remoteip=$ip");
  //var_dump($validation_server);
  $array = json_decode($validation_server, true);
  //var_dump($array);
  if ($array["success"] == false) {
    echo "<script>alert('Falló el envío de correo intente nuevamente, no olvide llenar el captcha.')</script>";
  } else if ($array["success"] == true) {
    $prueba = ";)";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = "smtp.gmail.com"; // Define el servidor de correos de smtp.
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;
    $mail->Username = 'safarothh@gmail.com'; // email emisor
    $mail->Password = 'jlziecieacelhhog'; // password del email emisor
    $mail->setFrom('safarothh@gmail.com', 'DAP Fumigaciones'); // Correo que se muestra en la vista previa y el nombre de quién lo envía
    $mail->addAddress('k.o.fumigaciones@gmail.com'); // Correo receptor.
    $mail->Subject = $_POST['nombre_cotice']." ha solicitado una llamada!"; //Asunto
    $mail->msgHTML("<table style='min-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
    <br>        
    <tr>
        <td style='background-color: #ecf0f1'>
            <div class='titulo' style='display: flex; margin-top: 1em; '>
                <h1 style='text-align:center; margin: 0 auto;'> <b>Nueva solicitud de llamada</b></h1>
            </div>
            
            <div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
                <h2 style='color: #e67e22; margin: 0 0 7px'>La persona <b style='text-decoration: none; color: black;'>{$nombre_cotice}</b></h2> 
                <p style='margin: 2px; font-size: 15px'>
                    Ha solicitado una llamada.
                </p>
                <br>
                <div style='width: 100%; text-align: center'>
                    <a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #25D366' href='tel:+57{$numero_cotice}'>Llamar ahora</a>	
                </div>
                <p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Fumigaciones K.O</p>
            </div>
        </td>
    </tr>
    </table>");
    //Cuerpo del mensaje                //Cuerpo del mensaje                        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
    $mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
    // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
    $mail->CharSet = 'UTF-8';
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );
    if (!$mail->send()) {
      //echo "Mailer Error: " . $mail->ErrorInfo; //Si pasa algo malo en el metodo Error info sale qué pasó.
    } else {
      echo "<script>alert('¡Hemos recibido su número, tan pronto podamos lo llamaremos!')</script>"; //Si sale bien
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald:wght@700&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/eab3c4b8ca.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/style.css" />

    <title>Fumigaciones DAP</title>
  </head>

  <body>
    <header>
      <div class="container row">
        <button class="nav-toggle" aria-label="open navigation">
          <span class="hamburger"></span>
        </button>
        <a class="logo" href="#">
          <img
            src="img/logo.svg"
            alt="conquering responsive layouts"
            class="img_logo"
          />
        </a>
        <nav class="nav" id="navbar">
          <ul class="nav__list nav__list--primary">
            <li class="nav__item">
              <a href="index.html" class="nav__link activo">Inicio</a>
            </li>
            <li class="nav__item">
              <a href="servicios.html" class="nav__link">servicios</a>
            </li>
            <li class="nav__item">
              <a href="#" class="nav__link">Contacto</a>
            </li>
          </ul>
          <ul class="nav__list nav__list--secondary">
            <li class="nav__item">
              <a href="#" class="nav__link">(+57) 301 531 6248</a>
            </li>
            <li class="nav__item">
              <a href="#" class="nav__link nav__link--button">Whatsapp</a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="whatsapp">
      <div class="whats-float">
        <a href="https://api.whatsapp.com/send?phone=573243466362&text=¡Hola! Me gustaría conocer mas sobre sus servicios, ¿podrían darme más información? por favor. Gracias."
           target="_blank">
            <i class="fa fa-whatsapp"></i><span>WhatsApp<br><small>301 531 6248</small></span>
        </a>
      </div>
    </div>

    <div class="banner">
      <div class="container row">
        <h1 class="banner__title1">
          Control integrado de
          <span class="banner__title2">todo tipo de plagas.</span>
        </h1>
        <div class="banner__paragraph">
          <p class="justify">
            En <b>Fumigaciones DAP </b>brindamos un servicio especializado y de
            calidad para cualquier tipo de erradicación de plagas. 
            <span class="banner__title2"><b>Contamos con concepto sanitario favorable ante Secretaria de Salud.</b>
            </span>
          </p>
          <a href="#services_list" class="banner__button">saber más de Nuestros servicios</a>
        </div>
      </div>
    </div>
    <section class="features">
      <h1 class="center features__title">Nuestro trabajo</h1>
      <div class="container row">
        <div class="features__feat">
          <h1>Garantizado</h1>
          <p><i class="fa-solid fa-handshake-angle fa-2xl"></i></p>
          <p>
            Nuestro servicio ofrece seguridad y confianza al ser brindando.
            Siéntase tranquilo de <b>deshacerse por completo</b> de la plaga que
            quiera erradicar.
          </p>
        </div>
        <div class="features__feat">
          <h1>Eficiente</h1>
          <p><i class="fa-solid fa-bolt fa-2xl"></i></p>
          <p>
            Enfocado a ser un servicio ágil, empleando la cantidad de tiempo
            <b>justa y necesaria</b> para que retome sus actividades tan pronto sea posible.
          </p>
        </div>
        <div class="features__feat">
          <h1>A la medida</h1>
          <p><i class="fa-solid fa-ruler fa-2xl"></i></p>
          <p>
            Tenemos muy en cuenta las medidas de los espacios y lugares a
            fumigar, <b>¡para que no se nos escape ni una esquina!</b>
          </p>
        </div>
      </div>
    </section>

    <section class="services">
      <h1 class="center services__title">Servicios</h1>
      <div class="container">
        <div class="wrapper">
          <div class="services__explanation--primary">
            <p>
              Contamos con diferentes tipos de servicios relacionados con las
              fumigaciones y la salubridad e higiene en su negocio,
            </p>
            <div class="home_container">
              <main>
                <div class="slideshow-container">
                  <div class="mySlides fade" style="display: block">
                    <!-- <div class="numbertext">1 / 3</div> -->
                    <img
                      src="img/1.jpg"
                      style="width: 100%"
                      id="img_carousel"
                      class="img_carousel"
                    />
                    <div class="text">Caption Text</div>
                  </div>
                  <div class="mySlides fade" style="display: none">
                    <!-- <div class="numbertext">2 / 3</div> -->
                    <img
                      src="img/1.jpg"
                      style="width: 100%"
                      id="img_carousel"
                      class="img_carousel"
                    />
                    <div class="text">Caption Two</div>
                  </div>
                  <div class="mySlides fade" style="display: none">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img
                      src="img/1.jpg"
                      style="width: 100%"
                      id="img_carousel"
                      class="img_carousel"
                    />
                    <div class="text">Caption Three</div>
                  </div>
                  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                  <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br />
                <div style="text-align: center">
                  <span class="dot" onclick="currentSlide(1)"></span>
                  <span class="dot" onclick="currentSlide(2)"></span>
                  <span class="dot" onclick="currentSlide(3)"></span>
                </div>
              </main>
            </div>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                        enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam.
                    </p> -->
          </div>
          <div class="services_list" id="services_list">
          <h1 class="center services__title">Lista de servicios</h1>
          <div class="services__explanation--secondary row col">
            <div class="services__explanation--service">
              <h1>Fumigación de plagas</h1>
              <p>
                Nos deshacemos o mantenemos el control de cualquier tipo de
                plaga invasora en su sitio.
              </p>
              <ul class="services__explanation--list">
                <li class="services__explanation--item">Pececillo de plata</li>
                <li class="services__explanation--item">Cucarachas</li>
                <li class="services__explanation--item">Mosquitos</li>
                <li class="services__explanation--item">Hormigas</li>
                <li class="services__explanation--item">Todo tipo de insectos</li>
              </ul>

              <div class="fila">
                <span class="button__service"
                  ><a href="#" class="service__button"
                    >Estoy interesado/a <i class="fab fa-whatsapp"></i>
                  </a>
                </span>
              </div>
            </div>
            <div class="services__explanation--service">
              <h1>Limpieza de tanques</h1>
              <p>
                Lavamos y desinfectamos sus tanques de agua potable, para que
                cumplan con la
                <b
                  ><a
                    href="https://www.alcaldiabogota.gov.co/sisjur/normas/Norma1.jsp?i=662"
                    class="lavado_norma"
                    target="_blank"
                    >norma sanitaria (Resolución 2190 de 1991)</a
                  ></b
                >.
              </p>
              <div class="cita_norma">
                <p class="justify">
                  <i class="cita_norma-paragraph"
                    >"Deberán ser sometidos a lavado y desinfección mínimo 2
                    veces al año"</i
                  >
                </p>
              </div>
              <div class="fila">
                <span class="button__service"
                  ><a href="#" class="service__button"
                    >Estoy interesado/a <i class="fab fa-whatsapp"></i>
                  </a>
                </span>
              </div>
            </div>
            <div class="services__explanation--service">
              <h1>Roedores</h1>
              <p>
                Controlamos animales que merodean sus zonas comunes,
                deshaciendonos por completo de éstos. Permitiendo un ambiente
                seguro e higiénico.
              </p>
              <div class="cita_norma">
                <p class="justify">
                  <i class="cita_norma-paragraph"
                    >"No se generan animales en descomposición"</i
                  >
                </p>
              </div>
              <div class="fila">
                <span class="button__service"
                  ><a href="#" class="service__button"
                    >Estoy interesado/a <i class="fab fa-whatsapp"></i>
                  </a>
                </span>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </section>
    <section class="call_you">
      <div class="call">
        <h1>
          ¡Nosotros lo llamamos!
        </h1>
      </div>
        <div class="form_div">
          <form action="" method="post" class="formulario">
              <input id="nombre_cotice" class="input_call_name" type="text" name="nombre_cotice" placeholder="Su nombre" size="30">
              <input id="numero_cotice" class="input_call_cel_number" type="tel" name="numero_cotice" placeholder="Su teléfono fijo o celular" pattern="^(\d{7}|\d{10})$">
            <div class="g-recaptcha form-group " data-sitekey="6LdxpjkaAAAAAI_diDPP60VAvWiBw9Spp-7LXNZv"><div style="width: 304px; height: 78px;"><div><iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LdxpjkaAAAAAI_diDPP60VAvWiBw9Spp-7LXNZv&amp;co=aHR0cHM6Ly9mdW1pZ2FjaW9uZXNrby5jb206NDQz&amp;hl=es&amp;v=8G7OPK94bhCRbT0VqyEVpQNj&amp;size=normal&amp;cb=ovestubjfb88" width="304" height="78" role="presentation" name="a-p64877r12wo9" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div>
              <br>
              <div class="input_submit">
                <input type="submit" value="Enviar" class="service__button">
            </div>
          </form>
        </div>
    </section>
    <footer class="footer">
      <h1 class="footer__title">
        Llámenos o escríbanos por <a href="#" class="whatsapp">WhatsApp</a>
        <br /><a href="tel:+573015316248" class="telefono">3015316248</a>
      </h1>

      <div class="container row footer__lists">
        <div class="about_us">
          <h2 class="footer__subtitle">Nuestra compañía</h2>
          <p class="footer__paragraph justify">
            Fumigaciones DAP es una empresa dedicada a las fumigaciones y
            servicios relacionados con la salud e higiene de su negocio, espacio
            de trabajo, casa, apartamento, lote, edificio, conjunto residencial,
            etc. Brindamos el servicio en todo Bogotá y Cundinamarca. A todo
            tipo de persona y/o empresa.
          </p>
        </div>
        <hr class="hr__footer" />
        <div class="footer__nav row">
          <div class="footer__nav--getting">
            <h2 class="footer__subtitle center">Nosotros</h2>
            <ul class="footer__nav--list">
              <li class="footer__nav--item">
                <a href="#" class="footer__nav--link">Inicio</a>
              </li>
              <li class="footer__nav--item">
                <a href="#" class="footer__nav--link">Acerca</a>
              </li>
              <li class="footer__nav--item">
                <a href="#" class="footer__nav--link">Servicios</a>
              </li>
              <li class="footer__nav--item">
                <a href="#" class="footer__nav--link">Contacto</a>
              </li>
            </ul>
          </div>
          <div class="footer__nav--other">
            <h2 class="footer__subtitle center">Redes sociales</h2>
            <ul class="footer__nav--list">
              <li class="footer__nav--item">
                <a href="#" class="footer__nav--link"
                  ><i class="fab fa-facebook-square fa-2x"></i
                ></a>
              </li>
              <li class="footer__nav--item">
                <a href="#" class="footer__nav--link"
                  ><i class="fab fa-whatsapp-square fa-2x"></i
                ></a>
              </li>
            </ul>
          </div>
          <!--<div class="footer__nav--more">
                    <h2 class="footer__subtitle center">And more</h2>
                    <ul class="footer__nav--list">
                        <li class="footer__nav--item"><a href="#" class="footer__nav--link">Lorem ipsum</a></li>
                        <li class="footer__nav--item"><a href="#" class="footer__nav--link">dolor</a></li>
                        <li class="footer__nav--item"><a href="#" class="footer__nav--link">sit amet</a></li>
                        <li class="footer__nav--item"><a href="#" class="footer__nav--link">consecteur</a></li>
                    </ul>
                </div>  -->
        </div>
      </div>
      <hr />

      <div class="footer__final row">
        <p class="footer__company_name">Fumigaciones DAP, Bogotá Colombia</p>
      </div>
    </footer>

    <script src="main.js"></script>
  </body>
</html>
