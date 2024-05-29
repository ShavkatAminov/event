<?php

namespace app\service;

use app\models\Event;
use app\models\EventOrganization;
use Yii;
use yii\helpers\ArrayHelper;

class EventService
{
    public function saveWithTransaction(Event $event)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $event->save();
            $organizations = ArrayHelper::map(EventOrganization::findAll(['event_id' => $event->id]), 'organization_id', 'organization_id');
            if ($event->organizationIds) {
                foreach ($event->organizationIds as $organizationId) {
                    if (!isset($organizations[$organizationId])) {
                        $model = new EventOrganization();
                        $model->event_id = $event->id;
                        $model->organization_id = $organizationId;
                        if (!$model->save()) {
                            $transaction->rollBack();
                            return false;
                        }
                    } else {
                        $organizations[$organizationId] = -1;
                    }
                }
            }
            $deleteIds = [];
            foreach ($organizations as $organizationId => $value) {
                if ($value != -1) {
                    $deleteIds [] = $organizationId;
                }
            }
            EventOrganization::deleteAll(['event_id' => $event->id, 'organization_id' => $deleteIds]);
            $transaction->commit();
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            return false;
        }
        return true;
    }
}
