<?php

namespace app\service;

use app\models\organization;
use app\models\EventOrganization;
use Yii;
use yii\helpers\ArrayHelper;

class OrganizationService
{
    public function saveWithTransaction(Organization $organization)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $organization->save();
            $events = ArrayHelper::map(EventOrganization::findAll(['organization_id' => $organization->id]), 'event_id', 'event_id');
            if ($organization->eventIds) {
                foreach ($organization->eventIds as $eventId) {
                    if (!isset($events[$eventId])) {
                        $model = new EventOrganization();
                        $model->organization_id = $organization->id;
                        $model->event_id = $eventId;
                        if (!$model->save()) {
                            $transaction->rollBack();
                            return false;
                        }
                    } else {
                        $events[$eventId] = -1;
                    }
                }
            }
            $deleteIds = [];
            foreach ($events as $eventId => $value) {
                if ($value != -1) {
                    $deleteIds [] = $eventId;
                }
            }
            EventOrganization::deleteAll(['organization_id' => $organization->id, 'event_id' => $deleteIds]);
            $transaction->commit();
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            return false;
        }
        return true;
    }
}
