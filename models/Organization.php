<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 *
 * @property Event[] $events
 */
class Organization extends \yii\db\ActiveRecord
{
    public $eventIds = null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['eventIds', 'each', 'rule' => ['integer']],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->eventIds = ArrayHelper::map(EventOrganization::findAll(['organization_id' => $this->id]), 'event_id', 'event_id');
    }

    /**
     * Gets query for [[EventOrganizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])
            ->viaTable('organization_event', ['organization_id' => 'id']);
    }
}
