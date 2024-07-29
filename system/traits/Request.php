<?php

declare(strict_types=1);

namespace System\traits;

trait Request
{
    /**
     * @return array
     */
    public function getBodyParams(): array
    {
        $json_data = file_get_contents("php://input");
        $dataJson = json_decode($json_data, true);

        if (is_array($dataJson)) {
            return $dataJson;
        }

        return array_map(function ($item) {
            if (is_array($item)) {
                // Se o item é um array (por exemplo, multi-select), sanitiza cada valor
                return array_map(function ($subItem) {
                    return htmlspecialchars($subItem, ENT_QUOTES, 'UTF-8');
                }, $item);
            } else {
                // Sanitiza valor simples
                return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            }
        }, $_POST);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return array_map(function ($item) {
            return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
        }, $_GET);
    }

    /**
     * @return array
     */
    public function getInput(string $input): string
    {
        $all = [];

        array_push($all, $this->getBodyParams(), $this->getParams());

        return $all[$input] ?? "";
    }

    /**
     * @param int $index
     * @return string
     */
    public function getUri(int $index): string
    {
        $currentUri = explode('/', $_SERVER['REQUEST_URI']);
        return $currentUri[$index] ?? "";
    }
}
