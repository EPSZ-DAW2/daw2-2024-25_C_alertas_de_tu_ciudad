<?php
namespace app\models;

use Yii;

class Ubicacion extends \yii\db\ActiveRecord
{
    /**
     * Devuelve el nombre de la tabla asociada con el modelo.
     * @return string Nombre de la tabla.
     */
    public static function tableName()
    {
        return 'ubicacion';
    }

    /**
     * Define las reglas de validación para los atributos del modelo.
     * @return array Reglas de validación.
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
            [['ub_code_padre'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::class, 'targetAttribute' => ['ub_code_padre' => 'id']],
        ];
    }

    /**
     * Define las etiquetas de los atributos para su presentación en formularios.
     * @return array Etiquetas de los atributos.
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
     * Obtiene las alertas asociadas a la ubicación.
     * @return \yii\db\ActiveQuery Relación con las alertas.
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id_ubicacion' => 'id']);
    }

    /**
     * Obtiene la ubicación padre de esta ubicación.
     * @return \yii\db\ActiveQuery Relación con la ubicación padre.
     */
    public function getUbCodePadre()
    {
        return $this->hasOne(Ubicacion::class, ['id' => 'ub_code_padre']);
    }

    /**
     * Obtiene las ubicaciones hijas de esta ubicación.
     * @return \yii\db\ActiveQuery Relación con las ubicaciones hijas.
     */
    public function getUbicacions()
    {
        return $this->hasMany(Ubicacion::class, ['ub_code_padre' => 'id']);
    }

    /**
     * Obtiene todos los IDs de las ubicaciones descendientes de una ubicación dada.
     * @param int $idUbicacion ID de la ubicación principal.
     * @return array Lista de IDs de ubicaciones descendientes.
     */
    public static function obtenerIdsDescendientes($idUbicacion)
    {
        $ids = [$idUbicacion];
        $children = self::find()->where(['ub_code_padre' => $idUbicacion])->all();

        foreach ($children as $child) {
            $ids = array_merge($ids, self::obtenerIdsDescendientes($child->id));
        }

        return $ids;
    }

    /**
     * Obtiene todas las ubicaciones que no están siendo usadas como ubicaciones padre.
     * @return \app\models\Ubicacion[] Lista de ubicaciones libres.
     */
    public static function obtenerUbicacionesLibres()
    {
        return self::find()
            ->where(['not in', 'id', Ubicacion::find()->select('ub_code_padre')->where('ub_code_padre IS NOT NULL')])
            ->all();
    }
}

