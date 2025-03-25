<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Ubicacion
 *
 * Representa una ubicación geográfica en el sistema
 *
 * @property int $id Identificador único
 * @property int $ub_code Tipo de ubicación (1=Continente, 2=País, 3=Comunidad Autónoma, 4=Provincia, 6=Localidad, 7=Barrio/Zona)
 * @property string $nombre Nombre de la ubicación
 * @property string|null $code_iso Código ISO para países/regiones
 * @property int $ub_code_padre ID de la ubicación padre
 * @property float|null $latitud Coordenada de latitud
 * @property float|null $longitud Coordenada de longitud
 * @property string $fecha_creacion Fecha de creación del registro
 * @property bool $is_revisada Indica si la ubicación ha sido revisada
 */
class Ubicacion extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ubicacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ub_code', 'nombre', 'ub_code_padre'], 'required'],
            [['ub_code', 'ub_code_padre'], 'integer'],
            [['latitud', 'longitud'], 'number'],
            [['nombre'], 'string', 'max' => 50],
            [['code_iso'], 'string', 'max' => 10],
            [['fecha_creacion'], 'safe'],
            [['is_revisada'], 'boolean'],
            [['ub_code_padre'], 'exist',
                'skipOnError' => true,
                'targetClass' => self::class,
                'targetAttribute' => ['ub_code_padre' => 'id'],
                'filter' => function($query) {
                    $query->andWhere(['NOT', ['id' => $this->id]]); // Previene autoreferencia
                }
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ub_code' => 'Tipo de Ubicación',
            'nombre' => 'Nombre',
            'code_iso' => 'Código ISO',
            'ub_code_padre' => 'Ubicación Padre',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
            'fecha_creacion' => 'Fecha de Creación',
            'is_revisada' => 'Revisada',
        ];
    }

    /**
     * Obtiene las alertas asociadas a esta ubicación
     * @return \yii\db\ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id_ubicacion' => 'id']);
    }

    /**
     * Obtiene la ubicación padre jerárquica
     * @return \yii\db\ActiveQuery
     */
    public function getUbCodePadre()
    {
        return $this->hasOne(self::class, ['id' => 'ub_code_padre']);
    }

    /**
     * Obtiene las ubicaciones hijas directas
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacions()
    {
        return $this->hasMany(self::class, ['ub_code_padre' => 'id']);
    }

    /**
     * Obtiene todas las ubicaciones que no tienen alertas asociadas
     * @return Ubicacion[] Listado de ubicaciones libres
     */
    public static function obtenerUbicacionesLibres()
    {
        return self::find()
            ->leftJoin('alertas', 'ubicacion.id = alertas.id_ubicacion')
            ->where(['IS', 'alertas.id_ubicacion', null])
            ->all();
    }

    /**
     * Obtiene recursivamente todos los IDs de las ubicaciones descendientes
     * @param int $idUbicacion ID de la ubicación padre
     * @return array Lista de IDs descendientes
     */
    public static function obtenerIdsDescendientes($idUbicacion)
    {
        $ids = [$idUbicacion];
        $children = self::find()
            ->where(['ub_code_padre' => $idUbicacion])
            ->all();

        foreach ($children as $child) {
            $ids = array_merge($ids, self::obtenerIdsDescendientes($child->id));
        }

        return $ids;
    }
}