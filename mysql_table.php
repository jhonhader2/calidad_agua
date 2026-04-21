<?php

require_once "librerias/fpdf184/fpdf.php";

class PdfMySqlTable extends FPDF
{
    protected $processingTable = false;
    protected $columns = [];
    protected $tableX;
    protected $headerColor;
    protected $rowColors;
    protected $colorIndex;

    public function Header()
    {
        if ($this->processingTable) {
            $this->tableHeader();
        }
    }

    public function tableHeader()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetX($this->tableX);
        $fill = !empty($this->headerColor);
        if ($fill) {
            $this->SetFillColor($this->headerColor[0], $this->headerColor[1], $this->headerColor[2]);
        }

        foreach ($this->columns as $col) {
            $this->Cell($col['w'], 6, $col['c'], 1, 0, 'C', $fill);
        }

        $this->Ln();
    }

    public function row($data)
    {
        $this->SetX($this->tableX);
        $currentIndex = $this->colorIndex;
        $fill = !empty($this->rowColors[$currentIndex]);
        if ($fill) {
            $this->SetFillColor(
                $this->rowColors[$currentIndex][0],
                $this->rowColors[$currentIndex][1],
                $this->rowColors[$currentIndex][2]
            );
        }

        foreach ($this->columns as $col) {
            $this->Cell($col['w'], 5, $data[$col['f']], 1, 0, $col['a'], $fill);
        }

        $this->Ln();
        $this->colorIndex = 1 - $currentIndex;
    }

    public function calcWidths($width, $align)
    {
        $tableWidth = 0;

        foreach ($this->columns as $i => $col) {
            $columnWidth = $col['w'];
            if ($columnWidth == -1) {
                $columnWidth = $width / count($this->columns);
            } elseif (substr($columnWidth, -1) == '%') {
                $columnWidth = $columnWidth / 100 * $width;
            }

            $this->columns[$i]['w'] = $columnWidth;
            $tableWidth += $columnWidth;
        }

        if ($align == 'C') {
            $this->tableX = max(($this->w - $tableWidth) / 2, 0);
        } elseif ($align == 'R') {
            $this->tableX = max($this->w - $this->rMargin - $tableWidth, 0);
        } else {
            $this->tableX = $this->lMargin;
        }
    }

    public function addCol($field = -1, $width = -1, $caption = '', $align = 'L')
    {
        if ($field == -1) {
            $field = count($this->columns);
        }

        $this->columns[] = ['f' => $field, 'c' => $caption, 'w' => $width, 'a' => $align];
    }

    public function table($link, $query, $prop = [])
    {
        $result = mysqli_query($link, $query) or die('Error: ' . mysqli_error($link) . "<br>Query: $query");
        $originalMargin = $this->cMargin;

        $this->initializeColumns($result);
        $this->resolveColumnCaptions($result);
        $prop = $this->normalizeProps($prop);
        $this->applyTableStyle($prop);

        $this->calcWidths($prop['width'], $prop['align']);
        $this->tableHeader();
        $this->printRows($result);

        $this->cMargin = $originalMargin;
        $this->columns = [];
    }

    protected function initializeColumns($result)
    {
        if (count($this->columns) !== 0) {
            return;
        }

        $fieldCount = mysqli_num_fields($result);
        for ($i = 0; $i < $fieldCount; $i++) {
            $this->addCol();
        }
    }

    protected function resolveColumnCaptions($result)
    {
        foreach ($this->columns as $i => $col) {
            if ($col['c'] !== '') {
                continue;
            }

            if (is_string($col['f'])) {
                $this->columns[$i]['c'] = ucfirst($col['f']);
                continue;
            }

            $field = mysqli_fetch_field_direct($result, $col['f']);
            $this->columns[$i]['c'] = ucfirst($field->name);
        }
    }

    protected function normalizeProps($prop)
    {
        if (!isset($prop['width']) || $prop['width'] == 0) {
            $prop['width'] = $this->w - $this->lMargin - $this->rMargin;
        }

        if (!isset($prop['align'])) {
            $prop['align'] = 'C';
        }

        if (!isset($prop['padding'])) {
            $prop['padding'] = $this->cMargin;
        }

        if (!isset($prop['HeaderColor'])) {
            $prop['HeaderColor'] = [];
        }

        if (!isset($prop['color1'])) {
            $prop['color1'] = [];
        }

        if (!isset($prop['color2'])) {
            $prop['color2'] = [];
        }

        return $prop;
    }

    protected function applyTableStyle($prop)
    {
        $this->cMargin = $prop['padding'];
        $this->headerColor = $prop['HeaderColor'];
        $this->rowColors = [$prop['color1'], $prop['color2']];
    }

    protected function printRows($result)
    {
        $this->SetFont('Arial', '', 11);
        $this->colorIndex = 0;
        $this->processingTable = true;

        while ($row = mysqli_fetch_array($result)) {
            $this->row($row);
        }

        $this->processingTable = false;
    }
}

class_alias('PdfMySqlTable', 'PDF_MySQL_Table');
