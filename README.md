# captcha

Esse script em PHP, você pode usar tanto em aplicações comerciais, quanto para uso pessoal.
Por favor, mantenha no script a fonte github: https://github.com/eliasfsa/captcha

Este script gera uma imagem de CAPTCHA com uma string aleatória de 5 caracteres, composta por letras e números. As letras e números são desenhados com tamanhos variados, enquanto o fundo é preenchido com linhas aleatórias, curvas, pontos, etc. A string aleatória é armazenada na sessão e usada para verificar a entrada do usuário ao enviar o formulário.

Para alterar o tamanho da string defina na variável $length = 5;

Você pode ajustar o tamanho da imagem, a quantidade de caracteres na string, o tamanho das letras e outros parâmetros de acordo com suas necessidades.

Além disso, você pode modificar a função rand_string() para gerar caracteres aleatórios, em vez de apenas números e letras. 

A fonte Arial.ttf está anexada, porém você pode definir qualquer tipo de fonte, bem como o diretório onde ficará armazenada. 
O servidor precisará de permissão para leitura da fonte. Nessa variável é definida o caminho da fonte:
$font_path = realpath('arial.ttf');

Nessa variável $temp_folder, fica o diretório onde será armazenada a imagem gerada pelo CAPTCHA. Você é livre para definir o local dessa variável.
Caso não tenha o diretório, ele será criada no mesmo diretório do script. Lembre-se de que esse diretório tem que ter permissão de escrita.
$temp_folder = 'temp';

O captcha é case sensitive. Letras maiúsculas e mínusculas são diferenciadas.

Assim que for submetido o formulário a imagem irá desaparecer do diretório onde foi armazenada para não ficar enchendo a pasta com arquivos desnecessários.

A biblioteca GD deve estar instalada no servidor para o script funcionar, você pode instalá-la seguindo as instruções específicas na sua plataforma de hospedagem.

