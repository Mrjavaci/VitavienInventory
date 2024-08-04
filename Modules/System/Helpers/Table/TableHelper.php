<?php

namespace Modules\System\Helpers\Table;

use Modules\System\Traits\HasMake;

class TableHelper
{
    use HasMake;

    protected array $mainData;

    protected array $headers;

    public function generate(): string
    {
        $columnWidths = collect($this->mainData)->reduce(function ($widths, $row) {
            foreach ($row as $key => $value) {
                $widths[$key] = max($widths[$key] ?? 0, strlen($value), strlen(ucfirst($key)));
            }

            return $widths;
        }, []);

        $separatorLine = '+-'.collect($columnWidths)->map(fn($width) => str_repeat('-', $width))->implode('-+-').'-+';

        $headerRow = '| '.collect($this->headers)->map(function ($header, $index) use ($columnWidths) {
                $key = strtolower($header);

                return str_pad($header, $columnWidths[$key]);
            })->implode(' | ').' |';

        $dataRows = collect($this->mainData)->map(fn($row) => '| '.collect($row)->map(fn($value, $key) => str_pad($value, $columnWidths[$key]))->implode(' | ').' |')->implode("\n");

        return $separatorLine."\n".$headerRow."\n".$separatorLine."\n".$dataRows."\n".$separatorLine;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getMainData(): array
    {
        return $this->mainData;
    }

    public function setHeaders(array $headers): TableHelper
    {
        $this->headers = $headers;

        return $this;
    }

    public function setMainData(array $mainData): TableHelper
    {
        $this->mainData = $mainData;

        return $this;
    }
}
