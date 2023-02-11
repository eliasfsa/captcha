<?php
// Desenvoldido por Elias Sant'Anna em fevereiro de 2023
// https://github.com/eliasfsa/captcha


session_start();

// Um arquivo de log é criado no mesmo diretório da aplicação para fins de debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'erro.log');

if (isset($_POST['captcha'])) {
    $inputdados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	if (!isset($inputdados) || $inputdados === '') {
		// código a ser executado se a variável estiver vazia
		} else {
		  // código a ser executado se a variável não estiver vazia
		  // Verifica se a imagem existe
		if (file_exists($_SESSION['temp_file'])) {
			// Apaga a imagem
			unlink($_SESSION['temp_file']);
		}
		  
		}
}


// Tamanho da imagem
$width = 240;
$height = 60;

// Criando a imagem
$image = imagecreatetruecolor($width, $height);

// Criando as cores
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$border_color = imagecolorallocate($image, 150, 150, 150);

// Preenchendo a imagem com a cor de fundo
imagefill($image, 0, 0, $bg_color);

// Carregando a fonte
$font_path = realpath('arial.ttf');

// Gerando o texto do CAPTCHA
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters_length = strlen($characters);
$random_string = '';
// Quantidade de caracteres gerados pelo sistema
$length = 5;
for ($i = 0; $i < $length; $i++) {
  $random_string .= $characters[rand(0, $characters_length - 1)];
}
$_SESSION['captcha'] = $random_string;


// Definindo o tamanho da fonte
$size = 24;

// Definindo o espaçamento entre as letras
$spacing = 40;

// Definindo o ângulo da fonte
$angle = 0;

// Definindo a posição inicial do primeiro caractere
$x = 20;
$y = 40;

// Gerando o texto do CAPTCHA na imagem
for ($i = 0; $i < $length; $i++) {
  // Gerando sombras aleatórias nas letras e números
  $shadow_color = imagecolorallocatealpha($image, 0, 0, 0, 50);
  $shadow_x = $x + 2;
  $shadow_y = $y + 2;
  imagettftext($image, $size, $angle, $shadow_x, $shadow_y, $shadow_color, $font_path, $random_string[$i]);

  // Gerando as letras e números
  imagettftext($image, $size, $angle, $x, $y, $text_color, $font_path, $random_string[$i]);
  
    // Incrementando a posição x para o próximo caractere
  $bbox = imagettfbbox($size, $angle, $font_path, $random_string[$i]);
  $width_char = $bbox[2] - $bbox[0];
  $x += $spacing;
}

// Gerando bordas aleatórias nas letras e números
for ($i = 0; $i < 4; $i++) {
    $rand_x = mt_rand(-$width/10, $width/10);
    $rand_y = mt_rand(-$height/10, $height/10);
    $rand_w = mt_rand($width*1.1, $width*1.5);
    $rand_h = mt_rand($height*1.1, $height*1.5);

    $rand_color = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    imagefilledrectangle($image, $x + $rand_x, $y + $rand_y, $x + $rand_x + $rand_w, $y + $rand_y + $rand_h, $rand_color);
}

// Gerando pontos aleatórios na imagem
for ($i = 0; $i < 1000; $i++) {
  $color = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));
  imagesetpixel($image, rand(0, $width), rand(0, $height), $color);
}

// Gerando linhas aleatórias na imagem
for ($i = 0; $i < 10; $i++) {
  $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
  imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $color);
}

// Gerando curvas aleatórias na imagem
for ($i = 0; $i < 5; $i++) {
  $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
  $c1x = rand(0, $width / 2);
  $c1y = rand(0, $height / 2);
  $c2x = rand($width / 2, $width);
  $c2y = rand($height / 2, $height);
  imagearc($image, $c1x, $c1y, $c2x, $c2y, 0, 360, $color);
}
// Exibindo imagem gerada
//header("Content-type: image/png");
//imagepng($image);

// Limpando memória
//imagedestroy($image);

$temp_folder = 'temp/';

// Criando pasta temporária, se ela não existir
if (!file_exists($temp_folder)) {
    mkdir($temp_folder, 0777, true);
}

// Gerando nome do arquivo temporário
$temp_file = $temp_folder . 'captcha_' . time() . '.png';
// Gravando o arquivo em uma Sessão

$_SESSION['temp_file'] = $temp_file;

// Salvando imagem
imagepng($image, $temp_file);

// Limpando memória
imagedestroy($image);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Captcha</title>
     <meta charset="UTF-8">
  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1" />
     <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Adicionando o JavaScript do Bootstrap e JQuery-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
 </head>
<body> 
<div class="container">
<h1>Captcha</h1>
<form id="form" action="captcha.php" method="POST">
  <!-- outros campos de formulário aqui -->
 <div class="form-group">
            <label for="imagem">Imagem</label>
  <img src="<?php echo $temp_file; ?>" alt="Imagem">
  </div>
  <div class="form-group">
            <label for="captcha">Escreva o texto da imagem acima, para verificar se você é humano.</label>
<input type="text" class="form-control" id="captcha" name="captcha" required>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<script>
  document.getElementById("form").addEventListener("submit", function(event) {
    event.preventDefault();

    // Verifica se o valor digitado no campo é igual ao valor da imagem captcha
    if (document.getElementById("captcha").value !== "<?php echo $_SESSION["captcha"]; ?>") {
      alert("O valor digitado não corresponde a imagem captcha. Por favor, tente novamente.");
    } else {
      // Se a validação do captcha for bem-sucedida, envie o formulário
      this.submit();
    }
  });
</script>

</body>
</html>
