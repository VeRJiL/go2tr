<?php

use App\Acme\BaseAnswer;

/**
 * @param bool $singleTon
 * @return BaseAnswer
 */
function baseAnswer($singleTon = false)
{
    if ($singleTon) {
        return BaseAnswer::getInstance();
    }

    return new BaseAnswer();
}

/**
 * @param null $data
 * @param array|string $message
 * @param null $errors = null
 * @return BaseAnswer
 */
function successAnswer($data = null, $message = '', $errors = null): BaseAnswer
{
    $baseAnswer = baseAnswer()
        ->setData($data)
        ->setMessage($message)
        ->setSuccess(true);

    if ($errors) {
        $baseAnswer->setErrors($errors);
    }

    return $baseAnswer;
}

/**
 * @param string $errors
 * @param null $data
 * @return BaseAnswer
 */
function failAnswer($errors = '', $data = null): BaseAnswer
{
    return baseAnswer()
        ->setErrors($errors)
        ->setData($data)
        ->setSuccess(false);
}
