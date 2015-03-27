<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2015 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 */

namespace oat\taoRandomCat\model;

use oat\taoCat\model\routing\simple;
use oat\taoCat\model\routing\Plan;

class RandomRoute extends Route {
    
    private $itemIndex;
    
    public function __construct(Plan $plan, $itemIndex)
    {
        parent::__construct($plan);
        $this->setItemIndex($itemIndex);
    }
    
    public function getNextItem($sessionId, $candidateId, $lastItemId = '', $lastItemResponse = '', $lastItemScore = '') {
         $poolSize = $this->getPlan()->getItemCount();
         $currentIndex = $this->getCurrentIndex();
         $nextIndex = $currentIndex + 1;
         
         return ($nextIndex === $poolSize) ? '' : strval($nextIndex);
    }
    
    public function getItemIndex()
    {
        return $this->itemIndex;
    }
    
    protected function setItemIndex($itemIndex)
    {
        $this->itemIndex = $itemIndex;
    }
}