<?php

echo $this->extend("layout/master");

echo $this->section("content");



$table = new \CodeIgniter\View\Table();
$table->setHeading("Název", "Rok vydání");
foreach ($data as $row) {
    $radek = array($row->nazev, $row->rok_vydani);
    $table->addRow($radek);
}

$template = [
    'table_open' => '<table class="table table-striped">',
    'thead_open' => '<thead>',
    'thead_close' => '</thead>',
    'heading_row_start' => '<tr>',
    'heading_row_end' => '</tr>',
    'heading_cell_start' => '<th>',
    'heading_cell_end' => '</th>',
    'tfoot_open' => '<tfoot>',
    'tfoot_close' => '</tfoot>',
    'footing_row_start' => '<tr>',
    'footing_row_end' => '</tr>',
    'footing_cell_start' => '<td>',
    'footing_cell_end' => '</td>',
    'tbody_open' => '<tbody>',
    'tbody_close' => '</tbody>',
    'row_start' => '<tr>',
    'row_end' => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
];

$table->setTemplate($template);
echo "<div class=col-md-6>";
echo $table->generate();
echo "</div>";


echo $this->endSection();
