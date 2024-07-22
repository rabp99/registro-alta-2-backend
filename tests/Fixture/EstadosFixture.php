<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstadosFixture
 */
class EstadosFixture extends TestFixture
{
    public $import = ['table' => 'estados'];
    
    public $records = [
        [
            "descripcion" => "Activo"
        ], [
            "descripcion" => "Solicitado"
        ], [
            "descripcion" => "Entregado"
        ], [
            "descripcion" => "Entrada"
        ], [
            "descripcion" => "Salida"
        ], [
            "descripcion" => "Disponible"
        ], [
            "descripcion" => "Ocupada"
        ], [
            "descripcion" => "Devuelto"
        ], [
            "descripcion" => "Break Inicio"
        ], [
            "descripcion" => "Break Fin"
        ], [
            "descripcion" => "En Vestidores"
        ], [
            "descripcion" => "En Lavandería"
        ]
    ];
}
