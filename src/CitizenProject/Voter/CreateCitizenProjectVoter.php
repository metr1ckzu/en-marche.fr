<?php

namespace AppBundle\CitizenProject\Voter;

use AppBundle\CitizenProject\CitizenProjectManager;
use AppBundle\CitizenProject\CitizenProjectPermissions;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\CitizenProject;

class CreateCitizenProjectVoter extends AbstractCitizenProjectVoter
{
    private $manager;

    public function __construct(CitizenProjectManager $manager)
    {
        $this->manager = $manager;
    }

    protected function supports($attribute, $subject)
    {
        return CitizenProjectPermissions::CREATE === $attribute;
    }

    protected function doVoteOnAttribute(string $attribute, Adherent $adherent, ?CitizenProject $citizenProject): bool
    {
        if ($this->manager->isCitizenProjectAdministrator($adherent)) {
            return false;
        }

        if ($this->manager->hasCitizenProjectInStatus($adherent, CitizenProjectManager::STATUS_NOT_ALLOWED_TO_CREATE)) {
            return false;
        }

        return true;
    }
}
