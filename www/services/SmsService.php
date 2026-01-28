<?php

namespace app\services;

use Throwable;
use yiidreamteam\smspilot\Api;
use Yii;

/**
 * Сервис отправки SMS через SMSPilot.
 */
class SmsService
{
    private static function client(): Api
    {
        return new Api(Yii::$app->params['smspilotApiKey']);
    }

    /**
     * Отправляет SMS.
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public static function send(string $phone, string $message): bool
    {
        try {
            self::client()->send($phone, $message);

            Yii::info(
                sprintf(
                    'SMS отправлено. Телефон: %s, текст: "%s"',
                    $phone,
                    $message
                ),
                'sms'
            );

            return true;
        } catch (Throwable $e) {

            Yii::error(
                [
                    'message' => 'Ошибка отправки SMS',
                    'phone' => $phone,
                    'text' => $message,
                    'error' => $e->getMessage(),
                ],
                'sms'
            );

            return false;
        }
    }
}
