<?php

namespace sarelvdwalt\eveESI\response;

class getStatusOK extends BaseResponse
{
    protected $start_time;
    protected $players;
    protected $server_version;
    protected $vip;

    public function __construct($rawPayload)
    {
        parent::__construct($rawPayload);

        $this->setPlayers($rawPayload->players);
        $this->setServerVersion($rawPayload->server_version);
        $this->setStartTime($rawPayload->start_time);
        $this->setVip($rawPayload->vip);
    }


    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     * @return getStatusOK
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param mixed $players
     * @return getStatusOK
     */
    public function setPlayers($players)
    {
        $this->players = $players;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServerVersion()
    {
        return $this->server_version;
    }

    /**
     * @param mixed $server_version
     * @return getStatusOK
     */
    public function setServerVersion($server_version)
    {
        $this->server_version = $server_version;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVip()
    {
        return $this->vip;
    }

    /**
     * @param mixed $vip
     * @return getStatusOK
     */
    public function setVip($vip)
    {
        $this->vip = $vip;
        return $this;
    }


}