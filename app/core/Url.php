<?php

/**
 * Pega o paramentro usando URL amigaveis
 * @example URL::baseUrl(1) Pega o primeiro paramentro da URL
 */
class Url {

    private static $url = NULL;
    private static $baseUrl = NULL;

    public static function getURL($id) {
        if (self::$url == NULL) {
            // Verifica se a lista de URL já foi preenchida
            self::getURLList();
        }

        // Valida se existe o ID informado e retorna.
        if (isset(self::$url[$id])) {
            return self::$url[$id];
        }

        // Caso não exista o ID, retorna nulo
        return NULL;
    }

    public static function getBase() {
        if (self::$baseUrl != NULL) {
            return self::$baseUrl;
        }

        $startUrl = strlen(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'));
        $excludeUrl = substr(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME'), $startUrl, -9);

        if ($excludeUrl[0] == "/") {
            self::$baseUrl = $excludeUrl;
        } else {
            self::$baseUrl = "/" . $excludeUrl;
        }

        return self::$baseUrl;
    }

    private static function getURLList() {
        // Primeiro traz todos as pastas abaixo do index.php
        $startUrl = strlen(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')) - 1;
        $excludeUrl = substr(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME'), $startUrl, -10);

        // a variável$request possui toda a string da URL após o domínio.
        $request = filter_input(INPUT_SERVER, 'REQUEST_URI');

        // Agora retira toda as pastas abaixo da pasta raiz
        $request = substr($request, strlen($excludeUrl));

        // Explode a URL para pegar retirar tudo após o ?
        $urlTmp = explode("?", $request);
        $request = $urlTmp[0];

        // Explode a URL para pegar cada uma das partes da URL
        $urlExplodida = explode("/", $request);

        $retorna = array();

        for ($a = 0; $a <= count($urlExplodida); $a ++) {
            if (isset($urlExplodida[$a]) AND $urlExplodida[$a] != "") {
                array_push($retorna, $urlExplodida[$a]);
            }
        }
        self::$url = $retorna;
    }

}
