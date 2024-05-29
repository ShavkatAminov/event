<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name
 * @property string|null $date
 * @property string|null $description
 *
 * @property Organization[] $organizations
 */
class Event extends \yii\db\ActiveRecord
{
    public $organizationIds = null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date', 'organizationIds'], 'safe'],
            ['organizationIds', 'each', 'rule' => ['integer']],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date' => 'Date',
            'description' => 'Description',
            'organizationIds' => 'Organizations',
        ];
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->organizationIds = ArrayHelper::map(EventOrganization::findAll(['event_id' => $this->id]), 'organization_id', 'organization_id');
    }

    /**
     * Gets query for [[EventOrganizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::class, ['id' => 'organization_id'])
            ->viaTable('event_organization', ['event_id' => 'id']);

    }
}
