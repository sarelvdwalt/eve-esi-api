<?php

namespace sarelvdwalt\eveESI;

class TokenEnvelope
{
    protected $access_token;
    protected $refresh_token;

    /** @var $expires_at \DateTime */
    protected $expires_at;

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * @param \DateTime $expires_at
     * @return TokenEnvelope
     */
    public function setExpiresAt(\DateTime $expires_at)
    {
        $this->expires_at = $expires_at;
        return $this;
    }

    /**
     * @param mixed $access_token
     * @return TokenEnvelope
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * @param mixed $refresh_token
     * @return TokenEnvelope
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;
        return $this;
    }
}