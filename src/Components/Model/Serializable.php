<?php
/**
 * This file is part of the "audiorama" Project.
 * Created by avanzu on 08.09.18.
 */

namespace Components\Model;


interface Serializable  {
    /**
     * @return array
     */
    public function serialize();
}