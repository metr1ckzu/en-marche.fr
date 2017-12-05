<?php

namespace AppBundle\Search;

use AppBundle\CitizenProject\CitizenProjectManager;
use AppBundle\Repository\CitizenProjectRepository;

class CitizenProjectSearchResultsProvider implements SearchResultsProviderInterface
{
    private $citizenProjectRepository;
    private $citizenProjectManager;

    public function __construct(CitizenProjectRepository $citizenProjectRepository, CitizenProjectManager $citizenProjectManager)
    {
        $this->citizenProjectRepository = $citizenProjectRepository;
        $this->citizenProjectManager = $citizenProjectManager;
    }

    public function find(SearchParametersFilter $search): array
    {
        $result = $this->citizenProjectRepository->searchAll($search);

        foreach ($result as $citizenProject) {
            $citizenProject->setCreator($this->citizenProjectManager->getCitizenProjectCreator($citizenProject));
        }

        return $result;
    }

    public function getSupportedTypeOfSearch(): string
    {
        return SearchParametersFilter::TYPE_CITIZEN_PROJECTS;
    }
}
