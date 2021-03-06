<?php

namespace IO\Services\ItemLoader\Loaders;

use IO\Services\ItemLoader\Contracts\ItemLoaderContract;
use IO\Services\ItemLoader\Contracts\ItemLoaderPaginationContract;
use IO\Services\SessionStorageService;
use IO\Builder\Sorting\SortingBuilder;
use IO\Services\ItemLoader\Contracts\ItemLoaderSortingContract;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Processor\DocumentProcessor;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Query\Type\TypeInterface;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Search\Document\DocumentSearch;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Search\SearchInterface;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Sorting\SortingInterface;
use Plenty\Modules\Item\Search\Filter\ClientFilter;
use Plenty\Modules\Item\Search\Filter\VariationBaseFilter;
use Plenty\Modules\Item\Search\Filter\SearchFilter;
use Plenty\Plugin\Application;
use Plenty\Modules\Cloud\ElasticSearch\Lib\ElasticSearch;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Sorting\SingleSorting;

class SearchItems implements ItemLoaderContract, ItemLoaderPaginationContract, ItemLoaderSortingContract
{
    /**
     * @return SearchInterface
     */
    public function getSearch()
    {
        $documentProcessor = pluginApp(DocumentProcessor::class);
        return pluginApp(DocumentSearch::class, [$documentProcessor]);
    }
    
    /**
     * @return array
     */
    public function getAggregations()
    {
        return [];
    }
    
    /**
     * @param array $options
     *
     * @return TypeInterface[]
     */
    public function getFilterStack($options = [])
    {
        /**
         * @var SessionStorageService $sessionStorage
         */
        $sessionStorage = pluginApp(SessionStorageService::class);
        $lang = $sessionStorage->getLang();
        
        /** @var ClientFilter $clientFilter */
        $clientFilter = pluginApp(ClientFilter::class);
        $clientFilter->isVisibleForClient(pluginApp(Application::class)->getPlentyId());
        
        /** @var VariationBaseFilter $variationFilter */
        $variationFilter = pluginApp(VariationBaseFilter::class);
        $variationFilter->isActive();
    
        /**
         * @var SearchFilter $searchFilter
         */
        $searchFilter = pluginApp(SearchFilter::class);
        
        if(array_key_exists('query', $options) && strlen($options['query']))
        {
            $searchType = ElasticSearch::SEARCH_TYPE_FUZZY;
            if(array_key_exists('autocomplete', $options) && $options['autocomplete'] === true)
            {
                $searchFilter->setNamesString($options['query'], $lang);
            }
            else
            {
                $searchFilter->setSearchString($options['query'], $lang, $searchType);
            }
        }
        
        return [
            $clientFilter,
            $variationFilter,
            $searchFilter
        ];
    }
    
    /**
     * @param array $options
     * @return int
     */
    public function getCurrentPage($options = [])
    {
        return (INT)$options['page'];
    }
    
    /**
     * @param array $options
     * @return int
     */
    public function getItemsPerPage($options = [])
    {
        return (INT)$options['items'];
    }
    
    public function getSorting($options = [])
    {
        $sortingInterface = null;
        
        if(isset($options['sorting']) && strlen($options['sorting']))
        {
            $sorting = SortingBuilder::buildSorting($options['sorting']);
            $sortingInterface = pluginApp(SingleSorting::class, [$sorting['path'], $sorting['order']]);
        }
        
        return $sortingInterface;
    }
}