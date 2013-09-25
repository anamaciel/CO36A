<?php
date_default_timezone_set('America/Sao_Paulo');

function calculaFrete($cod_servico, $cep_origem, $cep_destino, $peso, $altura, $largura, $comprimento, $valor_declarado) {
    #OFICINADANET###############################
    # C�digo dos Servi�os dos Correios
    # 41106 PAC sem contrato
    # 40010 SEDEX sem contrato
    # 40045 SEDEX a Cobrar, sem contrato
    # 40215 SEDEX 10, sem contrato
    ############################################

    if ($altura < 2) {
        $altura = 0;
        $formato = 3;
    } else {
        $formato = 1;
    }
    $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=" . $cep_origem . "&sCepDestino=" . $cep_destino . "&nVlPeso=" . $peso . "&nCdFormato=" . $formato . "&nVlComprimento=" . $comprimento . "&nVlAltura=" . $altura . "&nVlLargura=" . $largura . "&sCdMaoPropria=n&nVlValorDeclarado=" . $valor_declarado . "&sCdAvisoRecebimento=n&nCdServico=" . $cod_servico . "&nVlDiametro=0&StrRetorno=xml";
    $xml = simplexml_load_file($correios);
    return trataRetornoCep($xml->cServico->Erro, $xml->cServico->Valor);
}

function calculaPrazoEntrega($cod_servico, $cep_origem, $cep_destino, $peso, $altura, $largura, $comprimento, $valor_declarado) {
    if ($altura < 2) {
        $altura = 0;
        $formato = 3;
    } else {
        $formato = 1;
    }

    $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=" . $cep_origem . "&sCepDestino=" . $cep_destino . "&nVlPeso=" . $peso . "&nCdFormato=" . $formato . "&nVlComprimento=" . $comprimento . "&nVlAltura=" . $altura . "&nVlLargura=" . $largura . "&sCdMaoPropria=n&nVlValorDeclarado=" . $valor_declarado . "&sCdAvisoRecebimento=n&nCdServico=" . $cod_servico . "&nVlDiametro=0&StrRetorno=xml";
    $xml = simplexml_load_file($correios);
    return trataRetornoCep($xml->cServico->Erro, $xml->cServico->PrazoEntrega);
}

function trataRetornoCep($retorno, $valor) {
    switch ($retorno) {
        case 0:
            return floatval($valor);
            break;
        case -3:
            $msg = "CEP de destino inv&aacute;lido!";
            return $msg;
            break;
        case -2:
            $msg = "Escolha um endere&ccedil;o para entrega!";
            return $msg;
            break;
        case -6:
            $msg = "Servi�o indispon&iacute;vel para o trecho informado";
            return $msg;
            break;
        default:
            return "ERRO " . $retorno;
            break;
    }
}

function geraTotalFrete($frete, $total, $desconto, $retorno, $entrega) {
    $preco_total = ($frete + $total) - $desconto;
    if (ceil($entrega) > 1) {
        $dias = " dias &uacute;teis";
    } else {
        $dias = " dia &uacute;til";
    }
    if ($retorno >= 0) {
        $erro = "
            <li class=\"precoTotal\"><span id=\"precoCalc\">R$ " . number_format($frete, 2, ',', ' ') . "</span></li>
        ";
    }
    echo "
    <ul class=\"frete\">  
    <div class=\"entrega\">Prazo de entrega em at&eacute; " . ceil($entrega) . $dias . "</div>
        <li class=\"totalFrete\">Total Frete</li>" .
    $erro . "
    </ul>
    <ul class=\"desconto\">
        <li class=\"total\">Desconto</li>
        <li class=\"precoTotal\"><span>R$ " . number_format($desconto, 2, ',', ' ') . "</span></li>
    </ul> 
    <ul class=\"subtotal\">
        <li class=\"precoTotal\"><span id=\"totalGeral\">R$ " . number_format($preco_total, 2, ',', ' ') . "</span></li>
        <li class=\"total\">Total</li>
    </ul>
    ";
}

function erroFrete($retorno) {
    ?>
    <div class="noAdress">
        <?php echo $retorno; ?>
    </div>;
    <?php
}

function textoTamanho($texto, $casas) {
    $texto = substr($texto, 0, $casas);
    return $texto;
}

function convAsp($vp) {
    $vp = str_replace("'", " ", $vp);
    return $vp;
}

function paginacao($quantidade, $pagina, $tipo) {
    if (( $pagina == '' || $pagina == '1' ) && $tipo == 'S') {
        return '0';
    } else if (( $pagina == '' || $pagina == '1' ) && $tipo == 'L') {
        return $quantidade;
    }
    if (( $pagina > '1' ) && $tipo == 'S') {
        return ( $pagina - 1 ) * $quantidade;
    } else if (( $pagina > '1' ) && $tipo == 'L') {
        return $quantidade * $pagina;
    }
}

function tiraVP($vp) {
    $vp = str_replace(".", "", $vp);
    $vp = str_replace(",", ".", $vp);
    return $vp;
}

function convPV($vp) {
    $vp = str_replace(",", ".", $vp);
    return $vp;
}

function convVP($vp) {
    $vp = str_replace(".", ",", $vp);
    return $vp;
}

function tiraTudo($vpt) {
    $vpt = str_replace(".", "", $vpt);
    $vpt = str_replace(",", "", $vpt);
    $vpt = str_replace("/", "", $vpt);
    $vpt = str_replace("-", "", $vpt);
    $vpt = str_replace("(", "", $vpt);
    $vpt = str_replace(")", "", $vpt);
    $vpt = str_replace("*", "", $vpt);
    $vpt = str_replace(",", "", $vpt);
    $vpt = str_replace("+", "", $vpt);
    return $vpt;
}

function legendaFoto($vpt) {
    $doc = new DOMDocument();
    $doc->loadHTML($vpt);
    $xml = simplexml_import_dom($doc); // just to make xpath more simple
    $images = $xml->xpath('//img');
    $texto = $vpt;
    foreach ($images as $img) {
        $foto = explode('/', $img['src']);
        $total = count($foto);
        $sql = mysql_query("SELECT * FROM midia WHERE link LIKE '%" . $foto[$total - 1] . "%'");
        $row_foto = mysql_fetch_object($sql);
        if ($row_foto->comentario != '') {
            $float = explode('float:', $img['style']);
            $width = explode('width: ', $img['style']);
            $width = explode('px;', $width[1]);
            $mgl = explode('margin-left: ', $img['style']);
            $mgl = explode('px;', $mgl[1]);
            $mgr = explode('margin-right: ', $img['style']);
            $mgr = explode('px;', $mgr[1]);
            $bdr = explode('border-right-width: ', $img['style']);
            $bdr = explode('px;', $bdr[1]);
            $bdl = explode('border-left-width: ', $img['style']);
            $bdl = explode('px;', $bdl[1]);
            $tamanho = $width[0] + $mgl[0] + $mgr[0] + $bdr[0] + $bdl[0];
            $texto = str_replace('<img alt="' . $img['alt'] . '" src="' . $img['src'] . '" style="' . $img['style'] . '" />', '<div class="noticiaFotoDestaque2" style="border-left-width:' . $bdl[0] . 'px; border-right-width:' . $bdr[0] . 'px; margin-left:' . $mgl[0] . 'px; margin-right:' . $mgr[0] . 'px; max-width:' . $tamanho . 'px; float:' . $float[1] . '"><img alt="' . $img['alt'] . '" src="' . $img['src'] . '" style="' . $img['style'] . '" /> <div class="noticiaFotoLegenda2"> ' . $row_foto->comentario . '</div><div class="noticiaFotoDireito2">Foto:' . $row_foto->direito_img . '</div></div>', $texto);
        }
    }
    return $texto;
}

function convTelefone($vp) {
    if (strlen($vp) == 10) {
        $vp = "(" . substr($vp, 0, 2) . ")" . substr($vp, 2, 4) . "-" . substr($vp, 6, 4);
    } else if (strlen($vp) == 11) {
        $vp = "(" . substr($vp, 0, 2) . ")" . substr($vp, 2, 5) . "-" . substr($vp, 7, 4);
    }
    return $vp;
}

function mascaraCpfCnpj($vp) {
    if (strlen($vp) == 11) {
        $vp = substr($vp, 0, 3) . "." . substr($vp, 3, 3) . "." . substr($vp, 6, 3) . "-" . substr($vp, 9, 2);
    } else if (strlen($vp) == 14) {
        $vp = substr($vp, 0, 2) . "." . substr($vp, 2, 3) . "." . substr($vp, 5, 3) . "/" . substr($vp, 8, 4) . "-" . substr($vp, 12, 2);
    }
    return $vp;
}

function convCep($vp) {
    $vp = substr($vp, 0, 2) . "." . substr($vp, 2, 3) . "-" . substr($vp, 5, 3);
    return $vp;
}

function verificaCpfCnpj($vp) {
    $vp = tiraTudo($vp);
    if (strlen($vp) == 11) {
        echo validaCPF($vp);
    } else if (strlen($vp) == 14) {
        echo validaCNPJ($vp);
    } else {
        echo 0;
    }
}

function validaCPF($cpf) {
    // Verifiva se o n??mero digitado cont??m todos os digitos
    $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

    // Verifica se nenhuma das sequ??ncias abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
        return 0;
    } else {   // Calcula os n??meros para verificar se o CPF ?? verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return 0;
            }
        }
        return 1;
    }
}

function validaCNPJ($CampoNumero) {
    $RecebeCNPJ = ${"CampoNumero"};

    $s = "";
    for ($x = 1; $x <= strlen($RecebeCNPJ); $x = $x + 1) {
        $ch = substr($RecebeCNPJ, $x - 1, 1);
        if (ord($ch) >= 48 && ord($ch) <= 57) {
            $s = $s . $ch;
        }
    }

    $RecebeCNPJ = $s;
    if (strlen($RecebeCNPJ) != 14) {
        return 0;
    } else
    if ($RecebeCNPJ == "00000000000000") {
        $then;
        return 0;
    } else {
        $Numero[1] = intval(substr($RecebeCNPJ, 1 - 1, 1));
        $Numero[2] = intval(substr($RecebeCNPJ, 2 - 1, 1));
        $Numero[3] = intval(substr($RecebeCNPJ, 3 - 1, 1));
        $Numero[4] = intval(substr($RecebeCNPJ, 4 - 1, 1));
        $Numero[5] = intval(substr($RecebeCNPJ, 5 - 1, 1));
        $Numero[6] = intval(substr($RecebeCNPJ, 6 - 1, 1));
        $Numero[7] = intval(substr($RecebeCNPJ, 7 - 1, 1));
        $Numero[8] = intval(substr($RecebeCNPJ, 8 - 1, 1));
        $Numero[9] = intval(substr($RecebeCNPJ, 9 - 1, 1));
        $Numero[10] = intval(substr($RecebeCNPJ, 10 - 1, 1));
        $Numero[11] = intval(substr($RecebeCNPJ, 11 - 1, 1));
        $Numero[12] = intval(substr($RecebeCNPJ, 12 - 1, 1));
        $Numero[13] = intval(substr($RecebeCNPJ, 13 - 1, 1));
        $Numero[14] = intval(substr($RecebeCNPJ, 14 - 1, 1));

        $soma = $Numero[1] * 5 + $Numero[2] * 4 + $Numero[3] * 3 + $Numero[4] * 2 + $Numero[5] * 9 + $Numero[6] * 8 + $Numero[7] * 7 +
                $Numero[8] * 6 + $Numero[9] * 5 + $Numero[10] * 4 + $Numero[11] * 3 + $Numero[12] * 2;

        $soma = $soma - (11 * (intval($soma / 11)));

        if ($soma == 0 || $soma == 1) {
            $resultado1 = 0;
        } else {
            $resultado1 = 11 - $soma;
        }
        if ($resultado1 == $Numero[13]) {
            $soma = $Numero[1] * 6 + $Numero[2] * 5 + $Numero[3] * 4 + $Numero[4] * 3 + $Numero[5] * 2 + $Numero[6] * 9 +
                    $Numero[7] * 8 + $Numero[8] * 7 + $Numero[9] * 6 + $Numero[10] * 5 + $Numero[11] * 4 + $Numero[12] * 3 + $Numero[13] * 2;
            $soma = $soma - (11 * (intval($soma / 11)));
            if ($soma == 0 || $soma == 1) {
                $resultado2 = 0;
            } else {
                $resultado2 = 11 - $soma;
            }
            if ($resultado2 == $Numero[14]) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}

function formata_valor($valor = '', $casas = 2) {
    $valor = number_format($valor, $casas, ',', '.');
    return $valor;
}

function crypto($senha) {
    $tSenha = strlen($senha);

    for ($i = 0; $i < $tSenha; $i++) {

        switch ($senha[$i]) {
            case "a":
                $senha[$i] = str_replace("a", "w", $senha[$i]);
                break;
            case "A":
                $senha[$i] = str_replace("A", "W", $senha[$i]);
                break;
            case "b":
                $senha[$i] = str_replace("b", "y", $senha[$i]);
                break;
            case "B":
                $senha[$i] = str_replace("B", "Y", $senha[$i]);
                break;
            case "c":
                $senha[$i] = str_replace("c", "k", $senha[$i]);
                break;
            case "C":
                $senha[$i] = str_replace("C", "K", $senha[$i]);
                break;
            case "d":
                $senha[$i] = str_replace("d", "v", $senha[$i]);
                break;
            case "D":
                $senha[$i] = str_replace("D", "V", $senha[$i]);
                break;
            case "e":
                $senha[$i] = str_replace("e", "u", $senha[$i]);
                break;
            case "E":
                $senha[$i] = str_replace("E", "U", $senha[$i]);
                break;
            case "f":
                $senha[$i] = str_replace("f", "t", $senha[$i]);
                break;
            case "F":
                $senha[$i] = str_replace("F", "T", $senha[$i]);
                break;
            case "g":
                $senha[$i] = str_replace("g", "s", $senha[$i]);
                break;
            case "G":
                $senha[$i] = str_replace("G", "S", $senha[$i]);
                break;
            case "h":
                $senha[$i] = str_replace("h", "r", $senha[$i]);
                break;
            case "H":
                $senha[$i] = str_replace("H", "R", $senha[$i]);
                break;
            case "i":
                $senha[$i] = str_replace("i", "q", $senha[$i]);
                break;
            case "I":
                $senha[$i] = str_replace("I", "Q", $senha[$i]);
                break;
            case "j":
                $senha[$i] = str_replace("j", "p", $senha[$i]);
                break;
            case "J":
                $senha[$i] = str_replace("J", "P", $senha[$i]);
                break;
            case "l":
                $senha[$i] = str_replace("l", "o", $senha[$i]);
                break;
            case "L":
                $senha[$i] = str_replace("L", "O", $senha[$i]);
                break;
            case "m":
                $senha[$i] = str_replace("m", "n", $senha[$i]);
                break;
            case "M":
                $senha[$i] = str_replace("M", "N", $senha[$i]);
                break;
            case "n":
                $senha[$i] = str_replace("n", "a", $senha[$i]);
                break;
            case "N":
                $senha[$i] = str_replace("N", "A", $senha[$i]);
                break;
            case "o":
                $senha[$i] = str_replace("o", "b", $senha[$i]);
                break;
            case "O":
                $senha[$i] = str_replace("O", "B", $senha[$i]);
                break;
            case "p":
                $senha[$i] = str_replace("p", "c", $senha[$i]);
                break;
            case "P":
                $senha[$i] = str_replace("P", "C", $senha[$i]);
                break;
            case "q":
                $senha[$i] = str_replace("q", "d", $senha[$i]);
                break;
            case "Q":
                $senha[$i] = str_replace("Q", "D", $senha[$i]);
                break;
            case "r":
                $senha[$i] = str_replace("r", "e", $senha[$i]);
                break;
            case "R":
                $senha[$i] = str_replace("R", "E", $senha[$i]);
                break;
            case "s":
                $senha[$i] = str_replace("s", "f", $senha[$i]);
                break;
            case "S":
                $senha[$i] = str_replace("S", "F", $senha[$i]);
                break;
            case "t":
                $senha[$i] = str_replace("t", "g", $senha[$i]);
                break;
            case "T":
                $senha[$i] = str_replace("T", "G", $senha[$i]);
                break;
            case "u":
                $senha[$i] = str_replace("u", "h", $senha[$i]);
                break;
            case "U":
                $senha[$i] = str_replace("U", "H", $senha[$i]);
                break;
            case "v":
                $senha[$i] = str_replace("v", "i", $senha[$i]);
                break;
            case "V":
                $senha[$i] = str_replace("V", "I", $senha[$i]);
                break;
            case "x":
                $senha[$i] = str_replace("x", "z", $senha[$i]);
                break;
            case "X":
                $senha[$i] = str_replace("X", "Z", $senha[$i]);
                break;
            case "z":
                $senha[$i] = str_replace("z", "x", $senha[$i]);
                break;
            case "Z":
                $senha[$i] = str_replace("Z", "X", $senha[$i]);
                break;
            case "k":
                $senha[$i] = str_replace("k", "j", $senha[$i]);
                break;
            case "K":
                $senha[$i] = str_replace("K", "J", $senha[$i]);
                break;
            case "y":
                $senha[$i] = str_replace("y", "l", $senha[$i]);
                break;
            case "Y":
                $senha[$i] = str_replace("Y", "L", $senha[$i]);
                break;
            case "w":
                $senha[$i] = str_replace("w", "m", $senha[$i]);
                break;
            case "W":
                $senha[$i] = str_replace("W", "M", $senha[$i]);
                break;
            case "0":
                $senha[$i] = str_replace("0", "5", $senha[$i]);
                break;
            case "1":
                $senha[$i] = str_replace("1", "0", $senha[$i]);
                break;
            case "2":
                $senha[$i] = str_replace("2", "9", $senha[$i]);
                break;
            case "3":
                $senha[$i] = str_replace("3", "8", $senha[$i]);
                break;
            case "4":
                $senha[$i] = str_replace("4", "7", $senha[$i]);
                break;
            case "5":
                $senha[$i] = str_replace("5", "6", $senha[$i]);
                break;
            case "6":
                $senha[$i] = str_replace("6", "1", $senha[$i]);
                break;
            case "7":
                $senha[$i] = str_replace("7", "2", $senha[$i]);
                break;
            case "8":
                $senha[$i] = str_replace("8", "3", $senha[$i]);
                break;
            case "9":
                $senha[$i] = str_replace("9", "4", $senha[$i]);
                break;
            case "=":
                $senha[$i] = str_replace("=", ")", $senha[$i]);
                break;
        }
    }

    return $senha;
}

function decrypto($senha) {
    $tSenha = strlen($senha);

    for ($i = 0; $i < $tSenha; $i++) {
        switch ($senha[$i]) {
            case "w":
                $senha[$i] = str_replace("w", "a", $senha[$i]);
                break;
            case "W":
                $senha[$i] = str_replace("W", "A", $senha[$i]);
                break;
            case "y":
                $senha[$i] = str_replace("y", "b", $senha[$i]);
                break;
            case "Y":
                $senha[$i] = str_replace("Y", "B", $senha[$i]);
                break;
            case "k":
                $senha[$i] = str_replace("k", "c", $senha[$i]);
                break;
            case "K":
                $senha[$i] = str_replace("K", "C", $senha[$i]);
                break;
            case "v":
                $senha[$i] = str_replace("v", "d", $senha[$i]);
                break;
            case "V":
                $senha[$i] = str_replace("V", "D", $senha[$i]);
                break;
            case "u":
                $senha[$i] = str_replace("u", "e", $senha[$i]);
                break;
            case "U":
                $senha[$i] = str_replace("U", "E", $senha[$i]);
                break;
            case "t":
                $senha[$i] = str_replace("t", "f", $senha[$i]);
                break;
            case "T":
                $senha[$i] = str_replace("T", "F", $senha[$i]);
                break;
            case "s":
                $senha[$i] = str_replace("s", "g", $senha[$i]);
                break;
            case "S":
                $senha[$i] = str_replace("S", "G", $senha[$i]);
                break;
            case "r":
                $senha[$i] = str_replace("r", "h", $senha[$i]);
                break;
            case "R":
                $senha[$i] = str_replace("R", "H", $senha[$i]);
                break;
            case "q":
                $senha[$i] = str_replace("q", "i", $senha[$i]);
                break;
            case "Q":
                $senha[$i] = str_replace("Q", "I", $senha[$i]);
                break;
            case "p":
                $senha[$i] = str_replace("p", "j", $senha[$i]);
                break;
            case "P":
                $senha[$i] = str_replace("P", "J", $senha[$i]);
                break;
            case "o":
                $senha[$i] = str_replace("o", "l", $senha[$i]);
                break;
            case "O":
                $senha[$i] = str_replace("O", "L", $senha[$i]);
                break;
            case "n":
                $senha[$i] = str_replace("n", "m", $senha[$i]);
                break;
            case "N":
                $senha[$i] = str_replace("N", "M", $senha[$i]);
                break;
            case "a":
                $senha[$i] = str_replace("a", "n", $senha[$i]);
                break;
            case "A":
                $senha[$i] = str_replace("A", "N", $senha[$i]);
                break;
            case "b":
                $senha[$i] = str_replace("b", "o", $senha[$i]);
                break;
            case "B":
                $senha[$i] = str_replace("B", "O", $senha[$i]);
                break;
            case "c":
                $senha[$i] = str_replace("c", "p", $senha[$i]);
                break;
            case "C":
                $senha[$i] = str_replace("C", "P", $senha[$i]);
                break;
            case "d":
                $senha[$i] = str_replace("d", "q", $senha[$i]);
                break;
            case "D":
                $senha[$i] = str_replace("D", "Q", $senha[$i]);
                break;
            case "e":
                $senha[$i] = str_replace("e", "r", $senha[$i]);
                break;
            case "E":
                $senha[$i] = str_replace("E", "R", $senha[$i]);
                break;
            case "f":
                $senha[$i] = str_replace("f", "s", $senha[$i]);
                break;
            case "F":
                $senha[$i] = str_replace("F", "S", $senha[$i]);
                break;
            case "g":
                $senha[$i] = str_replace("g", "t", $senha[$i]);
                break;
            case "G":
                $senha[$i] = str_replace("G", "T", $senha[$i]);
                break;
            case "h":
                $senha[$i] = str_replace("h", "u", $senha[$i]);
                break;
            case "H":
                $senha[$i] = str_replace("H", "U", $senha[$i]);
                break;
            case "i":
                $senha[$i] = str_replace("i", "v", $senha[$i]);
                break;
            case "I":
                $senha[$i] = str_replace("I", "V", $senha[$i]);
                break;
            case "z":
                $senha[$i] = str_replace("z", "x", $senha[$i]);
                break;
            case "Z":
                $senha[$i] = str_replace("Z", "X", $senha[$i]);
                break;
            case "x":
                $senha[$i] = str_replace("x", "z", $senha[$i]);
                break;
            case "X":
                $senha[$i] = str_replace("X", "Z", $senha[$i]);
                break;
            case "j":
                $senha[$i] = str_replace("j", "k", $senha[$i]);
                break;
            case "J":
                $senha[$i] = str_replace("J", "K", $senha[$i]);
                break;
            case "l":
                $senha[$i] = str_replace("l", "y", $senha[$i]);
                break;
            case "L":
                $senha[$i] = str_replace("L", "Y", $senha[$i]);
                break;
            case "m":
                $senha[$i] = str_replace("m", "w", $senha[$i]);
                break;
            case "M":
                $senha[$i] = str_replace("M", "W", $senha[$i]);
                break;
            case "5":
                $senha[$i] = str_replace("5", "0", $senha[$i]);
                break;
            case "0":
                $senha[$i] = str_replace("0", "1", $senha[$i]);
                break;
            case "9":
                $senha[$i] = str_replace("9", "2", $senha[$i]);
                break;
            case "8":
                $senha[$i] = str_replace("8", "3", $senha[$i]);
                break;
            case "7":
                $senha[$i] = str_replace("7", "4", $senha[$i]);
                break;
            case "6":
                $senha[$i] = str_replace("6", "5", $senha[$i]);
                break;
            case "1":
                $senha[$i] = str_replace("1", "6", $senha[$i]);
                break;
            case "2":
                $senha[$i] = str_replace("2", "7", $senha[$i]);
                break;
            case "3":
                $senha[$i] = str_replace("3", "8", $senha[$i]);
                break;
            case "4":
                $senha[$i] = str_replace("4", "9", $senha[$i]);
                break;
            case "+":
                $senha[$i] = str_replace(")", "=", $senha[$i]);
                break;
        }
    }

    return $senha;
}

//function to encrypt the string
function encode5t($str) {
    for ($i = 0; $i < 1; $i++) {
        $str = crypto(base64_encode($str)); //apply base64 first and then reverse the string
    }
    return $str;
}

//function to decrypt the string
function decode5t($str) {
    for ($i = 0; $i < 1; $i++) {
        $str = base64_decode(decrypto($str)); //apply base64 first and then reverse the string}
    }
    return $str;
}

function anti_injection($str) {
    $substituir = array();
    $substituir[0] = '/from/';
    $substituir[1] = '/select/';
    $substituir[2] = '/insert/';
    $substituir[3] = '/delete/';
    $substituir[4] = '/where/';
    $substituir[5] = '/drop table/';
    $substituir[6] = '/show tables/';
    $str = trim($str);
    $str = strip_tags($str);
    $str = preg_replace($substituir, "", $str);
    $str = (get_magic_quotes_gpc()) ? $str : addslashes($str);
    return $str;
}

function valida_data($data) {
    $data = explode("/", $data);
    if (!checkdate($data[1], $data[0], $data[2]) and !checkdate($data[1], $data[2], $data[0])) {
        return false;
    }
    return true;
}

function converte_data($data) {
    if (valida_data($data)) {
        return implode(!strstr($data, '/') ? "/" : "-", array_reverse(explode(!strstr($data, '/') ? "-" : "/", $data)));
    }
}

function converte_dateTime($data) {
    $data1 = substr($data,0, 10);
    $time = substr($data,11, 8);
    //echo $time;
    //echo $data1;
    if (valida_data($data1)) {
        $dataValida = implode(!strstr($data1, '/') ? "/" : "-", array_reverse(explode(!strstr($data1, '/') ? "-" : "/", $data1)));
    }
    echo $dataValida. " " . $time;
    return $dataValida. " " . $time;
}

function converte_dataPg($data) {
    return substr($date, 0, 4) . "-" . substr($date, 5, 2) . "-" . substr($date, 8, 2) . " " . substr($date, 11, 2) . ":" . substr($date, 14, 2) . ":" . substr($date, 17, 2);
}

function convdata($date) {
    $bra = substr($date, 8, 2) . "/" . substr($date, 5, 2) . "/" . substr($date, 0, 4);
    return $bra;
}

function validaEmail($email) {

    if (preg_match ('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
        echo 'ok';
        return true;
    } else {
        echo 'errado';
        return false;
    }
}

/**
 * @param $to email que receber� a mensagem;
 * @param $subject Assunto do email;
 * @param $from Nome de quem est� enviando o email;
 * @param $emailRementente Remetente precisa ser uma caixa postal do mesmo dominio da hospedagem;
 * @param $message Mensagem a ser enviada;
 * @property Return-Path: Precisa ser uma caixa postal do mesmo dominio da hospedagem;
 */
function enviaEmail($to, $subject, $from, $emailRementente, $message) {
    $headers = "MIME-Version: 1.1\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
    $headers .= 'From: ' . $from . ' <' . $emailRementente . '>' . "\n";
    $headers .= "Return-Path: '.$from.' <'.$emailRementente.'>\n";

    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}
?>