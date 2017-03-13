<?php

namespace OpenCFP\Http\Controller;

use Spot\Locator;

class PagesController extends BaseController
{
    public function showHomepage()
    {
        return $this->render('home.twig', $this->getContextWithTalksCount());
    }

    public function showSpeakerPackage()
    {
        return $this->render('package.twig', $this->getContextWithTalksCount());
    }

    public function showTalkIdeas()
    {
        return $this->render('ideas.twig', $this->getContextWithTalksCount());
    }

    private function getContextWithTalksCount()
    {
        /* @var Locator $spot */
        $spot = $this->service('spot');

        $numberOfTalks = $spot->mapper(\OpenCFP\Domain\Entity\Talk::class)->all()->count();

        return [
            'number_of_talks' => $numberOfTalks,
            'talkCategories' => $this->getTalkCategories(),
        ];
    }

    private function getTalkCategories()
    {
        $categories = $this->app->config('talk.categories');

        if ($categories === null) {
            $categories = [
                'api' => 'APIs (REST, SOAP, etc.)',
                'continuousdelivery'=> 'Continuous Delivery',
                'database'=> 'Database',
                'development'=> 'Development',
                'devops' => 'Devops',
                'framework' => 'Framework',
                'ibmi' => 'IBMi',
                'javascript' => 'JavaScript',
                'security' => 'Security',
                'testing' => 'Testing',
                'uiux' => 'UI/UX',
                'other' => 'Other',
            ];
        }

        return $categories;
    }

}
