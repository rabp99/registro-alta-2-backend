<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Grupos Ocupacionales seed.
 */
class GruposOcupacionalesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                "descripcion" => utf8_decode("MEDICO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TECNOLOGO MEDICO EN TERAPIA FIS.Y REHAB."),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("ENFERMERA(O)"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Vigilancia"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TECNICO DE ENFERMERIA"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TECNOLOGO MEDICO DE LABORATORIO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Limpieza"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TECNICO DE SERVICIO ASISTENCIAL"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Chofer Asistencial"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TECNOLOGO MEDICO DE RADIOLOGIA"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("ENFERMERA"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TRABAJADOR(A) SOCIAL"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Mantenimiento Electromecanico"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TECNOLOGO MEDICO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("QUIMICO FARMACEUTICO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("DIGITADOR ASISTENCIAL"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("OBSTETRIZ"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Mantenimiento Infraestructura"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("BIOLOGO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("NUTRICIONISTA"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("ODONTOLOGO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("ADMINISTRACION"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("tecnico enfermeria"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("RESIDENTE MEDICO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("tec enfermera"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("QUMICO FARMACEUTICO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("PSICOLOGO"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Biomedico"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("operario"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TRABAJADORA SOCIAL"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("OFIC. RELACIONES INSTITUCIONALES"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("Biomédico Hemodialisis"),
                "flag_show" => "1"
            ], [
                "descripcion" => utf8_decode("TEC FARMACIA"),
                "flag_show" => "1"
            ]
        ];
        
        $table = $this->table('grupos_ocupacionales');
        $table->insert($data)->save();
    }
}
