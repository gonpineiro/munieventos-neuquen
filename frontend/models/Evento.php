<?php

namespace frontend\models;

use common\models\SolicitudAval;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "evento".
 *
 * @property int $idEvento
 * @property int $idUsuario
 * @property int $idCategoriaEvento
 * @property int $idEstadoEvento
 * @property int $idModalidadEvento
 * @property string $secretariaEvento
 * @property string $nombreEvento
 * @property string $nombreCortoEvento
 * @property string $descripcionEvento
 * @property string $lugar
 * @property string $fechaInicioEvento
 * @property string $horaInicioEvento
 * @property string $fechaFinEvento
 * @property string $horaFinEvento
 * @property string|null $imgFlyer
 * @property string|null $imgLogo
 * @property int $capacidad
 * @property int $preInscripcion
 * @property int $req_incripcion
 * @property string $fechaLimiteInscripcion
 * @property string|null $codigoAcreditacion
 * @property string $fechaCreacionEvento
 * @property int $avalado
 *
 * @property CategoriaEvento $idCategoriaEvento0
 * @property EstadoEvento $idEstadoEvento0
 * @property ModalidadEvento $idModalidadEvento0
 * @property Usuario $idUsuario0
 * @property Inscripcion[] $inscripcions
 * @property Presentacion[] $presentacions
 */
class Evento extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    public function behaviors()
    {
        return [
            [
                "class" => SluggableBehavior::className(),
                "attribute" => "nombreCortoEvento",
                "slugAttribute" => "nombreCortoEvento",
                "immutable" => true,
                "ensureUnique" => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'secretariaEvento', 'nombreEvento', 'nombreCortoEvento', 'descripcionEvento', 'lugar', 'fechaInicioEvento', 'fechaFinEvento', 'req_incripcion'], 'required'],
            [['idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'capacidad', 'preInscripcion', 'req_incripcion'], 'integer'],
            [['fechaInicioEvento', 'fechaFinEvento', 'fechaLimiteInscripcion', 'fechaCreacionEvento', 'idSecretariaEvento'], 'safe'],
            [['nombreEvento', 'lugar', 'imgFlyer', 'imgLogo'], 'string', 'max' => 200],
            ['fechaFinEvento', 'compare', 'compareAttribute' => 'fechaInicioEvento', 'operator' => '>='],
            [['nombreCortoEvento', 'codigoAcreditacion'], 'string', 'max' => 100],
            //['nombreCortoEvento', 'match', 'pattern' => '/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'message' => 'El campo contiene caracteres inv??lidos'],
            ['nombreCortoEvento', 'unique', 'message' => 'El nombre corto ya fue registrado.'],
            ['nombreEvento', 'unique', 'message' => 'El nombre del evento ya se encuentra registrado'],
            [['descripcionEvento'], 'string', 'max' => 2000],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idCategoriaEvento'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaEvento::className(), 'targetAttribute' => ['idCategoriaEvento' => 'idCategoriaEvento']],
            [['idModalidadEvento'], 'exist', 'skipOnError' => true, 'targetClass' => ModalidadEvento::className(), 'targetAttribute' => ['idModalidadEvento' => 'idModalidadEvento']],
            [['idEstadoEvento'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEvento::className(), 'targetAttribute' => ['idEstadoEvento' => 'idEstadoEvento']],
            ['fechaFinEvento', 'compare', 'compareAttribute' => 'fechaInicioEvento', 'operator' => '>='],
            ['fechaLimiteInscripcion', 'compare', 'compareAttribute' => 'fechaFinEvento', 'operator' => '<='],
            ['nombreCortoEvento', 'match', 'pattern' => "/^[A-Z|a-z|0-9-_]+$/", "message" => "El campo contiene caracteres inv??lidos"],
            ['horaInicioEvento', 'match', 'pattern' => "/([01]?[0-9]{1}|2[0-3]{1})[:.][0-5]{1}[0-9]{1}/", "message" => "Formato hora HH:MM"],
            ['horaFinEvento', 'match', 'pattern' => "/([01]?[0-9]{1}|2[0-3]{1})[:.][0-5]{1}[0-9]{1}/", "message" => "Formato hora HH:MM"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEvento' => 'Id Evento',
            'idUsuario' => 'Id Usuario',
            'idCategoriaEvento' => 'Categoria',
            'idEstadoEvento' => 'Estado',
            'idModalidadEvento' => 'Modalidad',
            'secretariaEvento' => 'Secretaria',
            'nombreEvento' => 'Nombre Evento',
            'nombreCortoEvento' => 'Nombre Corto Evento',
            'descripcionEvento' => 'Descripci??n',
            'lugar' => 'Lugar',
            'fechaInicioEvento' => 'Fecha Inicio Evento',
            'fechaFinEvento' => 'Fecha Fin Evento',
            'imgFlyer' => 'Img Flyer',
            'imgLogo' => 'Img Logo',
            'capacidad' => 'Capacidad',
            'preInscripcion' => 'Preinscripci??n',
            'req_incripcion' => 'Require Incripci??n',
            'fechaLimiteInscripcion' => 'Fecha Limite de Preinscripci??n',
            'codigoAcreditacion' => 'C??digo Asistencia',
            'fechaCreacionEvento' => 'Fecha Creaci??n Evento',
        ];
    }

    /**
     * Gets query for [[IdCategoriaEvento0]].
     *
     * @return ActiveQuery
     */
    public function getIdCategoriaEvento0()
    {
        return $this->hasOne(CategoriaEvento::className(), ['idCategoriaEvento' => 'idCategoriaEvento']);
    }

    /**
     * Gets query for [[IdEstadoEvento0]].
     *
     * @return ActiveQuery
     */
    public function getIdEstadoEvento0()
    {
        return $this->hasOne(EstadoEvento::className(), ['idEstadoEvento' => 'idEstadoEvento']);
    }

    /**
     * Gets query for [[IdModalidadEvento0]].
     *
     * @return ActiveQuery
     */
    public function getIdModalidadEvento0()
    {
        return $this->hasOne(ModalidadEvento::className(), ['idModalidadEvento' => 'idModalidadEvento']);
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Inscripcions]].
     *
     * @return ActiveQuery
     */
    public function getInscripcions()
    {
        return $this->hasMany(Inscripcion::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[Presentacions]].
     *
     * @return ActiveQuery
     */
    public function getPresentacions()
    {
        return $this->hasMany(Presentacion::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[SolicitudAval]].
     *
     * @return ActiveQuery
     */
    public function getSolicitudAval()
    {
        return $this->hasOne(SolicitudAval::className(), ['idEvento' => 'idEvento']);
    }
}
