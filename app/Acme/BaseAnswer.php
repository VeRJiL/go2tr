<?php

namespace App\Acme;

use App\Acme\Contracts\ToJson;
use App\Acme\Contracts\ToArray;
use App\Acme\Contracts\ToObject;

class BaseAnswer implements ToArray, ToJson, ToObject
{
    private $exception_type = null;
    private $success = false;
    private $messages = [];
    private $errors = [];
    private $fields = [];
    private $status_code;
    private $data;

    public static $instance = null;

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * sets the <message> property and <fields['message']> at the same
     * time to the passed value
     *
     * @param array|string $messages
     * @return BaseAnswer
     */
    public function setMessage($messages = '')
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                if ($message !== '') {
                    array_push($this->messages, $message);
                }
            }
        } else {
            if ($messages !== '') {
                array_push($this->messages, $messages);
            }
        }

        $this->fields['messages'] = $this->messages;
        return $this;
    }

    /**
     * sets the <data> property and <fields['data']> at the same
     * time to the passed value
     *
     * @param $data
     * @return BaseAnswer
     */
    public function setData($data = null)
    {
        $this->data = $this->fields['data'] = $data;
        return $this;
    }

    /**
     * sets the <success> property and <fields['success']> at the same
     * time to the passed value
     *
     * @param bool $success
     * @return BaseAnswer
     */
    public function setSuccess(bool $success = true)
    {
        $this->success = $this->fields['success'] = $success;
        return $this;
    }

    /**
     * sets errors property
     * @param array|string $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        if (is_array($errors) || is_object($errors)) {
            foreach ($errors as $index => $error) {
                if ($error !== '') {
                    $this->errors[$index] = $error;
                }
            }
        } else {
            if ($errors !== '') {
                array_push($this->errors, $errors);
            }
        }

        $this->fields['errors'] = $this->errors;
        return $this;
    }

    public function setExceptionType($exceptionType)
    {
        $this->exception_type = $this->fields['exception_type'] = $exceptionType;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->status_code = $this->fields['status_code'] = $statusCode;
        return $this;
    }

    /**
     * return the <message> property of the class
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * return the first <message> property of the class
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->messages[0] ?? '';
    }

    /**
     * return the <data> property of the class
     *
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * return the <success> property of the class
     *
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * returns errors property
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getExceptionType()
    {
        return $this->exception_type;
    }

    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * Returns all the properties of this class as an array.
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Checks if the given format is compatible with baseAnswer or not.
     * @param $data
     * @return bool
     */
    public function checkFormat($data)
    {
        if (!is_object($data)) {
            return false;
        }

        if (!property_exists($data, 'success')) {
            return false;
        }

        return true;
    }

    /**
     * Checks for the requested property in the class and
     * if there is not such a property in the class, it
     * will returns the property that exists in the
     * <fields> property and if there is no such
     * index in the <fields> property, It will
     * return null with an error message.
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );

        return null;
    }

    /**
     * returns The whole properties in array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->createCleanObject()->getFields();
    }

    /**
     * Returns this object in a json format
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->createCleanObject()->getFields());
    }

    /**
     * returns The whole properties in object.
     *
     * @return object
     * @example $this->message, $this->success, $this->data
     */
    public function toObject(): object
    {
        return $this->createCleanObject();
    }

    private function createCleanObject()
    {
        $newObject = new self();

        if (count($this->messages)) {
            $newObject->setMessage($this->getMessages());
        }

        if (count($this->errors)) {
            $newObject->setErrors($this->getErrors());
        }

        if (!is_null($this->data)) {
            $newObject->setData($this->getData());
        }

        if (!is_null($this->exception_type)) {
            $newObject->setExceptionType($this->getExceptionType());
        }

        if (!is_null($this->status_code)) {
            $newObject->setStatusCode($this->getStatusCode());
        }

        $newObject->setSuccess($this->getSuccess());

        return $newObject;
    }
}
