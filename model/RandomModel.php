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

use \taoTests_models_classes_TestModel;
use \tao_models_classes_service_FileStorage;

class RandomModel extends taoTests_models_classes_TestModel
{
    /**
     * A file name pattern (name + extension) for files aiming at containing
     * a serialized Item Runner ServiceCall representation. The 'X' character
     * in the constant will be replaced by a unique identifier corresponding
     * to the item to be called by the ServiceCall.
     *
     * The extension name is .ird, meaning Item Runner Data.
     *
     * @var string
     */
    const ASSEMBLY_ITEMRUNNERS_FILENAME = 'X.ird';
    
    /**
     * The folder name to be used to contain '.ird' files within the test
     * compilation directory.
     *
     * @var string
     */
    const ASSEMBLY_ITEMRUNNERS_DIRNAME = 'itemrunners';
    
    public function createRoutingPlan(array $items, tao_models_classes_service_FileStorage $storage)
    {
        $private = $storage->spawnDirectory();
        
        // #1. Create and store the items runners in a persistent way, for
        // a later retrieval at delivery time.
        $this->storeItemRunners($items, $private);
        
        return $this->instantiateRoutingPlan($private);
    }
    
    /**
     * Store Item Runner service calls in the given $directory, for a later retrieval at delivery time.
     *
     * @param array $items An array describing the Items of the Test and their associated Service Call.
     * @param tao_models_classes_service_StorageDirectory $directory An access to the persistent directory where data can be stored and used at test delivery time.
     */
    protected function storeItemRunners(array $items, tao_models_classes_service_StorageDirectory $directory)
    {
        $itemRunnersDir = $directory->getPath() . self::ASSEMBLY_ITEMRUNNERS_DIRNAME;
        mkdir($itemRunnersDir);
        $itemRunnersDir .= DIRECTORY_SEPARATOR;
        
        $i = 0;
    
        foreach ($items as $item) {
            // Serialize the Item Runner ServiceCalls to a separate file. In this way
            // Item Runner ServiceCalls can be exploited in an atomic way.
            $fileName = $itemRunnersDir . str_replace('X', $i, self::ASSEMBLY_ITEMRUNNERS_FILENAME);
            $strServiceCall = $item['call']->serializeToString();
            file_put_contents($fileName, $strServiceCall);
            $i++;
        }
    }
}
