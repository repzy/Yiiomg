<?php

class ServiceUserIdentity extends CBaseUserIdentity {

    const ERROR_NOT_AUTHENTICATED = 3;

    protected $service;
    protected $id;
    protected $name;

    public function __construct($service) {
        $this->service = $service;
    }

    public function authenticate() {
        $serviceModel = Service::model()->findByPk($this->service->id);
        /* Если в таблице tbl_service нет записи с таким id,
        значит сервис не привязан к аккаунту. */
        if($serviceModel === null){
            if ($this->service->isAuthenticated) {
                $this->id = $this->service->id;
                $this->name = $this->service->getAttribute('name');

                $this->setState('service', $this->service->serviceName);

                $this->errorCode = self::ERROR_NONE;
            }
            else {
                $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
            }
        }
        /* Если запись есть, то используем данные из
        таблицы tbl_users, используя связь в модели Service */
        else {
            $this->id = $serviceModel->user->id;
            $this->name = $serviceModel->user->username;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}