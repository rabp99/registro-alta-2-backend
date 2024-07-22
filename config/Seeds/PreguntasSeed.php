<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Trabajadores seed.
 */
class PreguntasSeed extends AbstractSeed
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
            // Grupo 1
            [
                'nro' => 1,
                'descripcion' => utf8_decode('Ingrese a zona de desinfección.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 1,
                'estado_id' => 1
            ], [
                'nro' => 2,
                'descripcion' => utf8_decode('Si su mandil es reusable, retírese y colóquelo en contenedor de lavandería.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 1,
                'estado_id' => 1
            ],
            [
                'nro' => 3,
                'descripcion' => utf8_decode('Si porta visor ubíquese en una de las áreas de retiro del EPP y prepare su contenedor con la primera bolsa roja. (SINO PORTA VISOR, PASE AL ÍTEM 6)'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 1,
                'estado_id' => 1
            ],
            [
                'nro' => 4,
                'descripcion' => utf8_decode('Retírese la mascarilla con visor/casco de atrás hacia adelante y colóquela en el recipiente asignado. Si fuera de material desechable colocar en la bolsa roja.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 1,
                'estado_id' => 1
            ],
            [
                'nro' => 5,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 1,
                'estado_id' => 1
            ], // ...
            // Grupo 2
            [
                'nro' => 6,
                'descripcion' => utf8_decode('a. Rompa las tiras del cuello y del cinturón, y lleve el mandilón hacia adelante, no toque la parte delantera.<br>
                    b. Retire cada manga junto con el guante externo.<br>
                    c. Enrolle hacia adelante cogiéndolo por la parte interna hasta tener un paquete.<br>
                    d. Deseche todo en el contenedor sin generar aerosoles.'),
                'si_Case' => utf8_decode('EPP 8'),
                'grupo_id' => 2,
                'estado_id' => 1
            ],
            [
                'nro' => 7,
                'descripcion' => utf8_decode('a. Lleve la cabeza hacia atrás, y habrá el cierre del mameluco (NO TOQUE LA PIEL).<br>
                b.	Quítese la capucha del mameluco cogiendo desde la parte trasera (SIN TOCAR LA PARTE INTERNA).<br>
                c.	Quítese el mameluco desde arriba, retire un hombro cogiendo y jalando hacia afuera la parte externa con una mano, luego retire el otro hombro, deslice hasta debajo de los codos, llévelos hacia adelante y retire manga por manga junto con el segundo par de guantes, enrollando y cogiendo por la parte interna, hasta llegar a la altura de las pantorrillas.<br>
                d.	Tome asiento en una silla y retire las mangas de las piernas con los zapatos y los cubre calzados de cada miembro inferior, siga enrollando, cogiendo por la parte interna hasta tener un paquete.<br>
                e.	Retire y coloque el paquete dentro de la bolsa roja.'),
                'si_Case' => utf8_decode('EPP 8'),
                'grupo_id' => 3,
                'estado_id' => 1
            ],
            [
                'nro' => 8,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 3,
                'estado_id' => 1
            ],
            [
                'nro' => 9,
                'descripcion' => utf8_decode('Retire las botas de tela o botas descartables.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 3,
                'estado_id' => 1
            ],
            [
                'nro' => 10,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 3,
                'estado_id' => 1
            ],
            [
                'nro' => 11,
                'descripcion' => utf8_decode('Retire el gorro quirúrgico y deséchelo en el contenedor sin generar aerosoles.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 3,
                'estado_id' => 1
            ],
            [
                'nro' => 12,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 3,
                'estado_id' => 1
            ],
            [
                'nro' => 13,
                'descripcion' => utf8_decode('a.  Aplique hipoclorito de sodio al 1% al interior de la bolsa.<br>
                b.	Cierre la bolsa roja enrollado los bordes y haciendo un nudo técnica caramelo. <br>
                c.	Aplique hipoclorito de sodio al 1% al exterior de la bolsa. <br>
                d.	Coloque la bolsa roja en el contenedor principal de la sala.'),
                'si_Case' => utf8_decode('EPP 8'),
                'grupo_id' => 4,
                'estado_id' => 1
            ], // ...
            [
                'nro' => 14,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 4,
                'estado_id' => 1
            ],[
                'nro' => 15,
                'descripcion' => utf8_decode('Si usa lentes de protección, retírelos, cogiéndolos de los brazos o la parte posterior del elástico (según modelo) y colóquelo en la mesa destinada sobre toalla de papel.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 4,
                'estado_id' => 1
            ],
            [
                'nro' => 16,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 4,
                'estado_id' => 1
            ],
            [
                'nro' => 17,
                'descripcion' => utf8_decode('a. Jale el elástico /en caso de ELASTOMÉRICO, desconecte el engrape postero-inferior del respirador y llévelo hacia adelante de la cabeza y déjelo colgando; luego retire el correspondiente de la parte superior llevándolo hacia adelante y colóquelo en la mesa destinada sobre toalla de papel.<br>
                b.	Si es respirador desechable:<br>
                •	Sujete el elástico postero-inferior del respirador y llévelo hacia adelante de la cabeza y déjelo colgando; luego retire el correspondiente de la parte superior llevándolo hacia adelante.<br>
                •	Se colocará en una bolsa de papel. Ciérrela y no maltrate el respirador.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 5,
                'estado_id' => 1
            ],
            [
                'nro' => 18,
                'descripcion' => utf8_decode('El celador le colocará una mascarilla quirúrgica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 5,
                'estado_id' => 1
            ],
            [
                'nro' => 19,
                'descripcion' => utf8_decode('Retire los guantes con la técnica apropiada y colóquese unos guantes nuevos.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 5,
                'estado_id' => 1
            ],
            [
                'nro' => 20,
                'descripcion' => utf8_decode('Diríjase a la puerta de salida e introduzca sus botas o zapatos en el contenedor de desinfección de calzado, el celador puede rociar las caña de las botas.'),               
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 5,
                'estado_id' => 1
            ],
            [
                'nro' => 21,
                'descripcion' => utf8_decode('Si tiene respirador elastomérico y lentes reusables, llévelos en toalla de papel hacia la zona donde se encuentran las mesas individuales para limpieza y desinfección de respiradores.<br>
                Si tiene respirador N95 en su bolsa de papel, llévelo a su zona de almacén en ambiente ventilado, No pegue las bolsas de papel entre sí.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 5,
                'estado_id' => 1
            ],
            [
                'nro' => 22,
                'descripcion' => utf8_decode('a.  Use guantes y mascarilla quirúrgica.<br>
                b.	Coja la carcasa por los bordes, con la zona de engranaje hacia arriba. La cara externa del filtro debe mirar hacia abajo.<br>
                c.	Limpiar los filtros de manera superficial.<br>
                d.	Con una hoja de papel toalla embebida en alcohol Isopropílico (solución desinfectante) limpie la carcasa desde la zona menos contaminada a la zona más contaminada,<br>
                e.	No toque la parte interna del filtro ni el engranaje.<br>
                f.	Repita con la otra carcasa o cápsula.<br>
                g.	Colóquelas en una bolsa de plástico.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 6,
                'estado_id' => 1
            ],
            [
                'nro' => 23,
                'descripcion' => utf8_decode('Higienice las manos con solución alcohólica.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 6,
                'estado_id' => 1
            ],
            [
                'nro' => 24,
                'descripcion' => utf8_decode('Limpieza provisional<br>
                a.	Use guantes y mascarilla quirúrgica.<br>
                b.	Separe los filtros de la máscara elastomerica colocando la cara externa del filtro mirando hacia abajo.<br>  
                c.	Con una hoja de papel toalla embebida en DETERGENTE ENZIMATICO limpie la máscara y el arnés desde la zona menos contaminada a la zona más contaminada hasta que esté visiblemente húmedo, deje 1 minuto.<br>
                d.	Elimine el DETERGENTE residual con un papel toalla humedecido en agua y seque al aire o seque a mano antes del siguiente uso en una zona no contaminada.<br>
                e.	Con una una hoja de papel toalla embebida en ALCOHOL ISOPROPILICO limpie la máscara (REPITE ITEM C).<br>
                f.	REPETIR ITEM “D” para eliminar todos los residuos.<br>
                g.	Inspeccione y vuelva a armar el respirador.<br>
                h.	Colóquela en una bolsa de plástico.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 7,
                'estado_id' => 1
            ],
            [
                'nro' => 25,
                'descripcion' => utf8_decode('Lave sus manos con la técnica apropiada.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 7,
                'estado_id' => 1
            ],
            [
                'nro' => 26,
                'descripcion' => utf8_decode('Se dirige a las duchas para tomar un baño.'),
                'si_Case' => utf8_decode('EPP 5,EPP 8'),
                'grupo_id' => 7,
                'estado_id' => 1
            ],
        ];
        
        $table = $this->table('preguntas');
        $table->insert($data)->save();
    }
}
