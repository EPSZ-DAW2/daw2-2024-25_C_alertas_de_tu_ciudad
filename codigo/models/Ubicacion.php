<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ubicacion".
 *
 * @property int $id Unique identifier for the location
 * @property int $ub_code Location class code: 1=Continent, 2=Country, 3=Region, 4=Province, 6=City, 7=District/Zone
 * @property string $nombre Name of the location
 * @property string|null $code_iso International country/state code if applicable
 * @property int|null $ub_code_padre ID of the parent location in the hierarchy
 *
 * @property Alerta[] $alertas
 * @property Ubicacion $ubCodePadre
 * @property Ubicacion[] $ubicacions
 */
class Ubicacion extends \yii\db\ActiveRecord
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
            [['ub_code', 'nombre'], 'required'],
            [['ub_code', 'ub_code_padre'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['code_iso'], 'string', 'max' => 10],
            [['ub_code_padre'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::class, 'targetAttribute' => ['ub_code_padre' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ub_code' => 'Ub Code',
            'nombre' => 'Name',
            'code_iso' => 'ISO Code',
            'ub_code_padre' => 'Parent Ub Code',
        ];
    }

    /**
     * Gets query for [[Alertas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id_ubicacion' => 'id']);
    }

    /**
     * Gets query for [[UbCodePadre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUbCodePadre()
    {
        return $this->hasOne(Ubicacion::class, ['id' => 'ub_code_padre']);
    }

    /**
     * Gets query for [[Ubicacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacions()
    {
        return $this->hasMany(Ubicacion::class, ['ub_code_padre' => 'id']);
    }

    /**
     * Recursively retrieves all descendant location IDs.
     *
     * @param int $idUbicacion ID of the parent location.
     * @return array List of IDs including descendants.
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
}
